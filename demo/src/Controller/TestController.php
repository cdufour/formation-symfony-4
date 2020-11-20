<?php

// généré par la commande: php bin/console make:controller

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

// Aliasing de la classe App\Utils\Student
// afin d'éviter un conflit de noms
use App\Utils\Student as StudentUtil;
use App\Entity\Student;
use App\Entity\Training;
use App\Entity\Country;
use App\Event\TestEvent;
use App\Event\TestEventSubscriber;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Form\StudentType;

use App\Service\CalculatorService;
use App\Service\StudentManagerService;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class TestController extends AbstractController
{
    private $calculator;

    public function __construct(CalculatorService $calculator)
    {
        // Injection de dépendances (DI)
        //$this->calculator = new CalculatorService();

        // ou, variante syntaxique en apssant par un paramètre de la méthode;
        $this->calculator = $calculator;
    }

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
        // afin de transmettre des données (tableau assoc) au template
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
        // Idem que demo16, la variable $students est ici un
        // tableau d'objets. La template twig fonctionne de manière identique
        $s1 = new StudentUtil("Chris", "teacher");
        $s2 = new StudentUtil("Niakalé", "student");
        $s3 = new StudentUtil("Karine", "student");
        $students = array($s1, $s2, $s3);

        $res = $this->render("demo16.html.twig", array(
            "students" => $students,
            "title" => "Demo 16 - TWIG"
        ));
        return $res;
    }

    /**
    * @Route("/demo18")
    */
    public function demo18()
    {
        $res = $this->render("demo18.html.twig");
        return $res;
    }

    /**
    * @Route("/demo19")
    */
    public function demo19()
    {
        $res = $this->render("demo19.html.twig", [
            "header" => true,
            "title" => "demo 19 template",
            "fruits" => ["orange", "pomme", "poire"]
        ]);
        return $res;
    }

    /**
    * @Route("/demo20")
    */
    public function demo20()
    {
        // Relation entre la couche C et la couche M du modèle MVC

        // instanciation de la classe App\Entity\Student
        $student = new Student();
        $student->setName("Chris");
        $student->setStatus("teacher");

        // entity manager de doctrine
        $em = $this->getDoctrine()->getManager();

        // mise en attente de la requête
        $em->persist($student);

        $em->flush(); // exécution de la requête SQL

        return new Response($student->getId());
    }

    /**
    * @Route("/demo21")
    */
    public function demo21(Request $request)
    {
        // Relations entre les couches C, M et V

        $name = "";
        $status = "";
        $method = $request->getMethod();

        // Repo d'interrogation des pays
        $repo = $this->getDoctrine()->getRepository(Country::class);
        $countries = $repo->findAll();

        // Repo d'interrogation des formations
        $repoTraining = $this->getDoctrine()->getRepository(Training::class);

        if ($method == "POST") {
            // récupération des données postées via le formulaire
            $name           =   $request->request->get("name");
            $status         =   $request->request->get("status");
            $countryId      =   intval($request->request->get("country"));

            // ToDO: validation des inputs

            $student = new Student($name, $status);

            // Lien entre l'étudiant et le pays choisi dans le formulaire
            $country = $repo->find($countryId); // retourne une instance Country
            $student->setCountry($country);

            // Lien avec les formations suivies
            $trainingIds = [1,2];
            $training1 = $repoTraining->find(1);
            $training2 = $repoTraining->find(2);
            $student->addTraining($training1);
            $student->addTraining($training2);

            $em = $this->getDoctrine()->getManager();
            $em->persist($student);
            $em->flush();

            // Retour de fonction possible ici
            // return new Response(
            //     "Nouvel étudiant enregistré: " . $student->getId());
        }

        $res = $this->render("demo21.html.twig", [
            "method" => $method,
            "postData" => [$name, $status],
            "countries" => $countries
        ]);

        // Paramètrage du statusCode dans le cas d'un ajout d'étudiant
        if ($method == "POST") $res->setStatusCode(201); // 201: création de ressource

        return $res;
    }

    /**
    * @Route("/demo22", name="student_list")
    */
    public function demo22(Request $request)
    {
        // Récupération des étudiants enregistrés en DB

        // Instanciation du Repository
        $repo = $this->getDoctrine()->getRepository(Student::class);
        $students = $repo->findAll();

        // Tranmission des données au template
        $res = $this->render("demo22.html.twig", [
            "students" => $students
        ]);
        return $res;
    }

    /**
    * @Route("/demo23/{id}/delete")
    */
    public function demo23($id)
    {
        // Suppresion d'un étudiant en DB

        $repo = $this->getDoctrine()->getRepository(Student::class);
        $student = $repo->find($id); // objet étudiant à supprimer

        $em = $this->getDoctrine()->getManager();
        $em->remove($student);
        $em->flush();

        // redirection
        return $this->redirectToRoute("student_list");
    }

    /**
    * @Route("/demo24/{id}/delete", methods={"DELETE"})
    */
    public function demo24($id)
    {
        // Suppresion d'un étudiant en DB

        $repo = $this->getDoctrine()->getRepository(Student::class);
        $student = $repo->find($id); // objet étudiant à supprimer

        $em = $this->getDoctrine()->getManager();
        $em->remove($student);
        $em->flush();

        return new Response("ok");
    }

    /**
    * @Route("/demo25")
    */
    public function demo25(Request $request)
    {
        // Construction d'un formulaire

        $training = new Training();
        $training->setTitle("");
        $training->setLevel(1);
        $training->setDuration(3);

        $form = $this->createFormBuilder($training)
            ->add("title", TextType::class, ["label" => "Intitulé"])
            ->add("level", TextType::class, ["label" => "Niveau"])
            ->add("duration", TextType::class, ["label" => "Nombre de jours"])
            ->add("save", SubmitType::class, ["label" => "Enregistrer"])
            ->getForm();

        // connexion entre le formulaire et la requête
        $form->handleRequest($request);

        // détection de la soumission du formulaire
        // équivalent à $request->getMethod() == "POST"
        if ($form->isSubmitted()) {
            $training = $form->getData();

            // insertion en DB
            $em = $this->getDoctrine()->getManager();
            $em->persist($training);
            $em->flush();

            return $this->redirectToRoute("student_list");
        }


        $res = $this->render("demo25.html.twig", [
            "form" => $form->createView()
        ]);

        return $res;
    }

    /**
    * @Route("/demo26/student/{id}", methods={"GET"})
    */
    public function demo26($id)
    {
        // Affiche une page de détails pour l'étudiant identifié

        $repoStudent = $this->getDoctrine()->getRepository(Student::class);
        $student = $repoStudent->find(intval($id));

        $res = $this->render("demo26.html.twig", [
            "student" => $student
        ]);

        return $res;
    }

    /**
    * @Route("/demo27")
    */
    public function demo27(Request $req)
    {
        // Utilisation d'une classe de formulaire
        $student = new Student();
        $form = $this->createForm(StudentType::class, $student);

        $form->handleRequest($req);

        if ($form->isSubmitted()) {
            $student = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($student);
            $em->flush();
        }
  
        $res = $this->render("demo27.html.twig", [
            "form" => $form->createView()
        ]);

        return $res;
    }

    /**
    * @Route("/demo28/calc/{num}")
    */
    public function demo28($num)
    {
        $result = [
            "num" => $num,
            "square" => $this->calculator->square($num),
            "cube" => $this->calculator->cube($num)
        ];

        // la méthode est un raccourci pour new JsonResponse()
        return $this->json($result);
    }

    /**
    * @Route("/demo29")
    */
    public function demo29(StudentManagerService $studentManager)
    {
        // Utilisation d'un service instanciant lui-même un autre service (EntityManager)
        $student = new Student("Zoé", "élève");
        $studentManager->insert($student);
        return $this->redirectToRoute("student_list");
    }

     /**
    * @Route("/demo30")
    */
    public function demo30()
    {
        // Accès à un paramètre du fichier services.yaml
        $default_student = $this->getParameter("default_student");
        return new Response($default_student);
    }

    /**
    * @Route("/demo31")
    */
    public function demo31()
    {
        // 
        $repo = $this->getDoctrine()->getRepository(Student::class);
        
        /*
        $students = $repo->findBy(
            ["status" => "élève"], // criteria
            //["country" => "Belgique"], // Pas possible avec ->findBy()
            ["name" => "ASC"], // orderby
            5, // limit
            1 // offset
        );
        */
        

        // https://www.doctrine-project.org/projects/doctrine-orm/en/current/reference/query-builder.html
        //$students = $repo->findByExampleField("éléve");
        //$students = $repo->findByCountry("Belgique");
        //$students = $repo->findTeachers();
        $students = $repo->findByTraining("Symfony 4");
        
        $res = $this->render("demo31.html.twig", [
            "students" => $students
        ]);
        
        return $res;
    }

    /**
    * @Route("/demo32")
    */
    public function demo32(EventDispatcherInterface $dispatcher)
    {
        $e = new TestEvent("Success");
        $dispatcher->dispatch($e, TestEvent::NAME);
        return $this->render("demo32.html.twig");
    }

    /**
    * @Route("/demo33")
    */
    public function demo33()
    {
        $repo = $this->getDoctrine()->getRepository(Student::class);
        $students = $repo->findAll();

        $res = $this->render("demo33.html.twig", [
            "students" => $students
        ]);

        $res->setPublic(); // rend accessible aux proxy le dossier var/cache
        $res->setMaxAge(60 * 10); // 10 minutes en cache

        return $res;
    }

     /**
    * @Route("/demo34")
    * ESI: https://symfony.com/doc/4.4/http_cache/esi.html
    */
    public function demo34()
    {
        $res = $this->render("demo34.html.twig");
        return $res;
    }
    

}
