<?php

// Généré par la commande: php bin/console make:controller --no-template

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\CalculatorService;

class ExampleController extends AbstractController
{
    /**
     * @Route("/calc/{num}")
     */
    public function calc($num, CalculatorService $calculator): Response
    {
        $result = [
            "num" => $num,
            "square" => $calculator->square($num),
            "cube" => $calculator->cube($num),
            "square2" => $calculator->square2(),
            "default_email" => $calculator->getDefaultEmail()
        ];

        // la méthode est un raccourci pour new JsonResponse()
        return $this->json($result);
    }
}
