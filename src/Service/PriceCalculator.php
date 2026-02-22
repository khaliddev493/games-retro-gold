<?php

namespace App\Service;

class PriceCalculator
{
    // Taux de TVA par défaut (20%)
    private float $tvaRate;

    public function __construct(float $tvaRate = 0.20)
    {
        $this->tvaRate = $tvaRate;
    }

    /**
     * Retourne le prix HT à partir du prix TTC
     */
    public function getHT(string $priceTTC): float
    {
        return round((float) $priceTTC / (1 + $this->tvaRate), 2);
    }

    /**
     * Retourne le montant de la TVA
     */
    public function getTVA(string $priceTTC): float
    {
        return round((float) $priceTTC - $this->getHT($priceTTC), 2);
    }

    /**
     * Applique une remise en pourcentage sur un prix TTC
     * Ex: applyDiscount('29.99', 10) => 26.99
     */
    public function applyDiscount(string $priceTTC, float $discountPercent): float
    {
        if ($discountPercent <= 0 || $discountPercent >= 100) {
            return (float) $priceTTC;
        }

        return round((float) $priceTTC * (1 - $discountPercent / 100), 2);
    }

    /**
     * Formate un prix float en string à 2 décimales
     * Ex: 29.9 => "29.90"
     */
    public function format(float $price): string
    {
        return number_format($price, 2, '.', '');
    }
}