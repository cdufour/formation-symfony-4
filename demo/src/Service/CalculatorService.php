<?php

namespace App\Service;

class CalculatorService
{
    private $num;
    private $default_email;
    private $tva_taux;

    public function __construct(
        $num = 3, 
        $default_email = "admin@test.fr",
        $tva_taux = 20
    )
    {
        $this->num = $num;
        $this->default_email = $default_email;
        $this->tva_taux = $tva_taux;
    }

    public function square(int $num)
    {
        return $num * $num;
    }

    public function cube(int $num)
    {
        return $num * $num * $num;
    }

    public function square2()
    {
        return $this->num * $this->num;
    }

    public function getDefaultEmail()
    {
        return $this->default_email;
    }

    public function tva($prix_ht)
    {
        $ttc = $prix_ht + ($prix_ht * ( $this->tva_taux/100 ));
        return $ttc;
    }
}