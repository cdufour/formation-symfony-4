<?php
namespace App\Command;

use App\Service\StudentManagerService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use App\Entity\Student;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\Question;

class CreateStudentCommand extends Command
{
    protected static $defaultName = "app:student:create";
    private $studentManager;

    public function __construct(StudentManagerService $studentManager)
    {
        $this->studentManager = $studentManager;
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setHelp("Cette commande permet de créer un étudiant...")
            ->addArgument("name", InputArgument::REQUIRED, "Nom de l'étudiant")
            ->addArgument("status", InputArgument::REQUIRED, "Status de l'étudiant")
        ;
    }

    protected function execute(
        InputInterface $input, OutputInterface $output)
    {
        $output->writeln("*********");
        $output->writeln(["Création d'un étudiant", "**********"]);

        $name = $input->getArgument("name");
        $status = $input->getArgument("status");

        $output->writeln(["Nom: ".$name, "Statut: ".$status]);

        $student = new Student($name, $status);
        
        $helper = $this->getHelper("question");
        //$question = new ConfirmationQuestion("On continue ?", false);
        $question = new Question("Email de l'étudiant: \n > ");
        $email = $helper->ask($input, $output, $question);

        $output->writeln("<comment>".$email."</comment>");

        $student->setEmail($email);
        $this->studentManager->insert($student);

        return 0; // en SF5 Command::SUCCESS
    }

}