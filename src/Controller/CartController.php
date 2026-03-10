<?php

namespace App\Controller;

use App\Entity\CartItem;
use App\Entity\Product;
use App\Service\CartService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/cart', name: 'cart_')]
class CartController extends AbstractController
{
    public function __construct(
        private readonly CartService $cartService,
        private readonly EntityManagerInterface $em,
    ) {}

    // ── Afficher le panier
    #[Route('', name: 'index', methods: ['GET'])]
    public function index(): Response
    {
        $cart = $this->cartService->getCurrentCart();

        return $this->render('cart/index.html.twig', [
            'cart'  => $cart,
            'total' => $this->cartService->getTotal(),
        ]);
    }

    // ── Ajouter un produit
    #[Route('/add/{id}', name: 'add', methods: ['POST'])]
    public function add(Product $product, Request $request): RedirectResponse
    {
        $quantity = max(1, (int) $request->request->get('quantity', 1));
        $this->cartService->addItem($product, $quantity);

        $this->addFlash('success', sprintf('"%s" ajouté au panier.', $product->getName()));

        return $this->redirect($request->headers->get('referer') ?? $this->redirectToRoute('cart_index'));
    }

    // ── Mettre à jour un article
    #[Route('/update/{id}', name: 'update', methods: ['POST'])]
    public function update(int $id, Request $request): RedirectResponse
    {
        $cart = $this->cartService->getCurrentCart();
        $item = $cart->getItemById($id);

        if (!$item) {
            $this->addFlash('error', "Cet article n'appartient pas à votre panier.");
            return $this->redirectToRoute('cart_index');
        }

        $quantity = (int) $request->request->get('quantity', 1);
        $this->cartService->updateItemQuantity($item, $quantity);

        $this->addFlash($quantity <= 0 ? 'info' : 'success', $quantity <= 0 ? 'Article supprimé du panier.' : 'Quantité mise à jour.');

        return $this->redirectToRoute('cart_index');
    }

    // ── Supprimer un article
    #[Route('/remove/{id}', name: 'remove', methods: ['POST'])]
    public function remove(int $id): RedirectResponse
    {
        $cart = $this->cartService->getCurrentCart();
        $item = $cart->getItemById($id);

        if (!$item) {
            $this->addFlash('error', "Cet article n'appartient pas à votre panier.");
            return $this->redirectToRoute('cart_index');
        }

        $this->cartService->removeItem($item);
        $this->addFlash('info', 'Article retiré du panier.');

        return $this->redirectToRoute('cart_index');
    }

    // ── Vider le panier
    #[Route('/clear', name: 'clear', methods: ['POST'])]
    public function clear(): RedirectResponse
    {
        $this->cartService->clearCart();
        $this->addFlash('info', 'Votre panier a été vidé.');

        return $this->redirectToRoute('cart_index');
    }

    // ── Checkout
    #[Route('/checkout', name: 'checkout', methods: ['POST'])]
    public function checkout(): RedirectResponse
    {
        if ($this->cartService->getItemCount() === 0) {
            $this->addFlash('warning', 'Votre panier est vide.');
            return $this->redirectToRoute('cart_index');
        }

        $cart = $this->cartService->checkout();
        $this->addFlash('success', 'Commande validée ! Merci pour votre achat.');

        return $this->redirectToRoute('cart_confirmation', ['id' => $cart->getId()]);
    }

    // ── Page de confirmation
    #[Route('/confirmation/{id}', name: 'confirmation', methods: ['GET'])]
    public function confirmation(int $id): Response
    {
        $cart = $this->em->getRepository(\App\Entity\Cart::class)->find($id);

        if (!$cart || !$cart->isCheckedOut()) {
            throw $this->createNotFoundException('Commande introuvable.');
        }

        return $this->render('cart/confirmation.html.twig', ['cart' => $cart]);
    }
}