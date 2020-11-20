<?php
namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{
    public function getFilters()
    {
        $twigFilter = new TwigFilter("price", [$this, "formatPrice"]);
        return [$twigFilter];
    }

    public function getFunctions()
    {
        $twigFn1 = new TwigFunction("tva", [$this, "tva"]);
        $twigFn2 = new TwigFunction("square", [$this, "square"]);
        return [$twigFn1, $twigFn2];
    }

    public function formatPrice($number, $currency)
    {
        if ($currency == "USD") {
            return trim($currency) . " " . $number;
        } else {
            return $number . " " . trim($currency);
        }
    }

    public function tva($prix_ht, $taux = 0.2)
    {
        return $prix_ht + ($prix_ht * $taux);
    }

    public function square($num)
    {
        return $num * $num;
    }
}