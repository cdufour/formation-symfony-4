<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\Routing\Annotation\Route;

class ExoController extends AbstractController
{
    /** @Route("exos/exo1") */
    public function exo1(Request $request)
    {
        $num = $request->query->get("num");
        return new Response($num * $num);
    }

    /** @Route("exos/exo2") */
    public function exo2()
    {
        $html = '<img src="/images/loup.jpg" alt="" />';
        $html .= '<img src="/images/loup2.jpg" alt="" />';

        return new Response($html);
    }
}