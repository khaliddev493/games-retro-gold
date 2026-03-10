<?php

namespace App\Service;

use App\Entity\Cart;
use App\Entity\CartItem;
use App\Entity\Product;
use App\Entity\User;
use App\Repository\CartRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class CartService
{
    private const SESSION_CART_KEY = 'cart_id';

    public function __construct(
        private readonly EntityManagerInterface $em,
        private readonly CartRepository $cartRepository,
        private readonly RequestStack $requestStack,
        private readonly TokenStorageInterface $tokenStorage,
    ) {}

    /**
     * Récupère ou crée le panier courant (anonyme ou connecté).
     */
    public function getCurrentCart(): Cart
    {
        $user = $this->getUser();

        // Utilisateur connecté
        if ($user instanceof User) {
            $cart = $this->cartRepository->findOneBy(['user' => $user, 'checkedOut' => false]);

            if (!$cart) {
                $cart = new Cart();
                $cart->setUser($user);
                $this->em->persist($cart);

                // Fusionner le panier de session s'il existe
                $this->mergeSessionCartIntoUserCart($cart);

                $this->em->flush();
            }

            return $cart;
        }

        // Utilisateur anonyme — panier en session
        $session = $this->requestStack->getSession();
        $cartId  = $session->get(self::SESSION_CART_KEY);

        if ($cartId) {
            $cart = $this->cartRepository->find($cartId);
            if ($cart && !$cart->isCheckedOut() && $cart->getUser() === null) {
                return $cart;
            }
        }

        $cart = new Cart();
        $this->em->persist($cart);
        $this->em->flush();

        $session->set(self::SESSION_CART_KEY, $cart->getId());

        return $cart;
    }

    /**
     * Ajouter un produit au panier.
     */
    public function addItem(Product $product, int $quantity = 1): CartItem
    {
        $cart = $this->getCurrentCart();

        // Vérifier si le produit est déjà dans le panier
        foreach ($cart->getItems() as $item) {
            if ($item->getProduct()->getId() === $product->getId()) {
                $item->setQuantity($item->getQuantity() + $quantity);
                $this->em->flush();

                return $item;
            }
        }

        $item = new CartItem();
        $item->setCart($cart);
        $item->setProduct($product);
        $item->setQuantity($quantity);
        $item->setUnitPrice($product->getPrice());

        $cart->addItem($item);

        $this->em->persist($item);
        $this->em->flush();

        return $item;
    }

    /**
     * Modifier la quantité d'un article.
     */
    public function updateItemQuantity(CartItem $item, int $quantity): void
    {
        $this->assertItemBelongsToCurrentCart($item);

        if ($quantity <= 0) {
            $this->removeItem($item);
            return;
        }

        $item->setQuantity($quantity);
        $this->em->flush();
    }

    /**
     * Supprimer un article du panier.
     */
    public function removeItem(CartItem $item): void
    {
        $this->assertItemBelongsToCurrentCart($item);

        $cart = $item->getCart();
        $cart->removeItem($item);

        $this->em->remove($item);
        $this->em->flush();
    }

    /**
     * Vider le panier.
     */
    public function clearCart(): void
    {
        $cart = $this->getCurrentCart();

        foreach ($cart->getItems() as $item) {
            $this->em->remove($item);
        }

        $cart->getItems()->clear();
        $this->em->flush();
    }

    /**
     * Nombre total d'articles dans le panier.
     */
    public function getItemCount(): int
    {
        $cart = $this->getCurrentCart();

        return array_sum(
            array_map(fn(CartItem $i) => $i->getQuantity(), $cart->getItems()->toArray())
        );
    }

    /**
     * Total du panier (en centimes).
     */
    public function getTotal(): int
    {
        $cart = $this->getCurrentCart();

        return array_sum(
            array_map(
                fn(CartItem $i) => $i->getUnitPrice() * $i->getQuantity(),
                $cart->getItems()->toArray()
            )
        );
    }

    /**
     * Marquer le panier comme validé (checkout).
     */
    public function checkout(): Cart
    {
        $cart = $this->getCurrentCart();
        $cart->setCheckedOut(true);
        $cart->setCheckedOutAt(new \DateTimeImmutable());

        $this->em->flush();

        // Supprimer la référence de session
        $session = $this->requestStack->getSession();
        $session->remove(self::SESSION_CART_KEY);

        return $cart;
    }

    // -------------------------------------------------------------------------
    // Méthodes privées
    // -------------------------------------------------------------------------

    private function getUser(): ?User
    {
        $token = $this->tokenStorage->getToken();
        if ($token === null) {
            return null;
        }

        $user = $token->getUser();

        return $user instanceof User ? $user : null;
    }

    private function mergeSessionCartIntoUserCart(Cart $userCart): void
    {
        $session = $this->requestStack->getSession();
        $cartId  = $session->get(self::SESSION_CART_KEY);

        if (!$cartId) {
            return;
        }

        $sessionCart = $this->cartRepository->find($cartId);
        if (!$sessionCart || $sessionCart->isCheckedOut()) {
            return;
        }

        foreach ($sessionCart->getItems() as $sessionItem) {
            $merged = false;

            foreach ($userCart->getItems() as $userItem) {
                if ($userItem->getProduct()->getId() === $sessionItem->getProduct()->getId()) {
                    $userItem->setQuantity($userItem->getQuantity() + $sessionItem->getQuantity());
                    $merged = true;
                    break;
                }
            }

            if (!$merged) {
                $newItem = new CartItem();
                $newItem->setCart($userCart);
                $newItem->setProduct($sessionItem->getProduct());
                $newItem->setQuantity($sessionItem->getQuantity());
                $newItem->setUnitPrice($sessionItem->getUnitPrice());

                $userCart->addItem($newItem);
                $this->em->persist($newItem);
            }

            $this->em->remove($sessionItem);
        }

        $this->em->remove($sessionCart);
        $session->remove(self::SESSION_CART_KEY);
    }

    private function assertItemBelongsToCurrentCart(CartItem $item): void
    {
        $cart = $this->getCurrentCart();

        if ($item->getCart()->getId() !== $cart->getId()) {
            throw new \RuntimeException('Cet article n\'appartient pas à votre panier.');
        }
    }
}