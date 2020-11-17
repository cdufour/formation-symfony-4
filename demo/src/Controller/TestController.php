<?php

// généré par la commande: php bin/console make:controller

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use App\Utils\Student;


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

    /**
     * @Route("/demo7")
     */
    public function demo7()
    {
        // Envoi de json méthode 1
        $students = array(
            "student1" => "Niakalé",
            "student2" => "Karine"
        );
        return new Response(json_encode($students));
    }

    /**
     * @Route("/demo8")
     */
    public function demo8()
    {
        // Envoi de json méthode 2
        // JsonResponse encode les données passées au constructeur
        // ajoute l'entête "Content-Type: application/json" à la réponse
        $students = array(
            "student1" => "Niakalé",
            "student2" => "Karine"
        );
        return new JsonResponse($students);
    }

    /**
     * Pas besoin d'annotation @Route()
     * cette route est définie dans config/routes.yaml
     */
    public function demo9()
    {
        return new Response("demo 9");
    }

    /**
     * @Route("/demo10/{num}")
     */
    public function demo10($num)
    {
        // Route avec paramètre d'URL
        return new Response($num * $num);
    }

    /**
     * @Route("/demo11", methods={"POST"})
     */
    public function demo11()
    {
        // Restriction sur les méthodes HTTP autorisées
        // curl -X POST http://35.180.3.33:8000/demo11
        return new Response("demo 11");
    }

    /**
    * @Route("/demo12/{num}", requirements={"num"="\d+"})
    */
   public function demo12($num)
   {
       // Route avec paramètre d'URL et validation
       // ici le paramètre num doit être valeur numérique (1 et plus)
       return new Response($num * $num);
   }

   public function demo13($num)
   {
       // Idem demo12 mais par config/routes.yaml
       return new Response($num * $num);
   }

    /**
    * @Route("/demo14")
    */
   public function demo14()
   {
       // render() retourne un objet de type Response
       // par défaut, render recherche dans le dossier templates/
       $res = $this->render("demo14.html.twig");
       return $res;
   }

    /**
    * @Route("/demo15")
    */
    public function demo15()
    {
        // Utilisation du deuxième paramètre de render()
        // afin de transmettre des données (tableau) au template
        $students = array("Chris", "Niakalé", "Karine");

        $res = $this->render("demo15.html.twig", array(
            "students" => $students,
            "title" => "Demo 15 - TWIG"
        ));
        return $res;
    }

    /**
    * @Route("/demo16")
    */
    public function demo16()
    {
        // Utilisation du deuxième paramètre de render()
        // afin de transmettre des données (tableau) au template
        $students = array(
            array("name" => "Chris", "status" => "teacher"),
            array("name" => "Niakalé", "status" => "student"),
            array("name" => "Karine", "status" => "student")
        );

        $res = $this->render("demo16.html.twig", array(
            "students" => $students,
            "title" => "Demo 16 - TWIG"
        ));
        return $res;
    }

    /**
    * @Route("/demo17")
    */
    public function demo17()
    {
        // Utilisation du deuxième paramètre de render()
        // afin de transmettre des données (tableau) au template
        $s1 = new Student("Chris", "teacher");
        $s2 = new Student("Niakalé", "student");
        $s3 = new Student("Karine", "student");
        $students = array($s1, $s2, $s3);

        $res = $this->render("demo16.html.twig", array(
            "students" => $students,
            "title" => "Demo 16 - TWIG"
        ));
        return $res;
    }

}
