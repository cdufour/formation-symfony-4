<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends AbstractController
{
    /**
     * @Route("/test", name="test")
     */
    public function index(): Response
    {
        return $this->render('test/index.html.twig', [
            'controller_name' => 'TestController',
        ]);
    }

    /**
     * @Route("/demo1")
     */
    public function demo1()
    {
        $html = "<html><head><title>Demo 1</title></head>";
        $html .= "<body><h1>coucou</h1></body></html>";
        $res = new Response($html);
        return $res;
    }

    /**
     * @Route("/demo2")
     */
    public function demo2(Request $request)
    {
        // accès à la QueryString
        $color = $request->query->get("color");
        $shade = $request->query->get("shade");

        if ($shade == "true") {
            $html = "La vie est une ombre";
        } else {
            $html = "Couleur: " . $color;
        }

        $res = new Response($html);
        return $res;
    }

     /**
     * @Route("/demo3")
     */
    public function demo3(Request $request)
    {
        // accès aux entêtes de la requête
        $token = $request->headers->get("X-Token");

        if ($token) {
            $html = "Token présent dans la requête";
        } else {
            $html = "Token non trouvé dans la requête";
        }

        $res = new Response($html);
        return $res;
    }

    
     /**
     * @Route("/demo4")
     */
    public function demo4(Request $request)
    {
        // accès à la méthode HTTP utilisé par le client
        $method = $request->getMethod();
        $res = new Response();
        $res->setContent("Méthode HTTP utilisée par le client: " . $method);
        return $res;
    }

    /**
     * @Route("/demo5")
     */
    public function demo5()
    {
        // Forger les entêtes de la réponse ainsi que le status code
        $res = new Response();
        $res->headers->set("X-Token", "my_secret");
        $res->setContent("Demo 5");
        $res->setStatusCode(Response::HTTP_NOT_FOUND); // == 404
        return $res;
    }

    /**
     * @Route("/demo6")
     */
    public function demo6()
    {
        // Envoi d'un fichier statique
        //$file = "file.txt";
        $file = "images/loup.jpg";
        $res = new BinaryFileResponse($file);
        return $res;
    }

}
