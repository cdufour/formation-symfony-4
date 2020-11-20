<?php
namespace App\Command;

use App\Service\StudentManagerService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use App\Entity\Student;
use App\Repository\StudentRepository;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\Question;

class ListStudentCommand extends Command
{
    protected static $defaultName = "app:student:list";
    private $repo;

    public function __construct(StudentRepository $repo)
    {
        parent::__construct();
        $this->repo = $repo;
    }

    protected function configure()
    {
        $this
            ->setHelp("Cette commande permet de lister les étudiants...")
            ;
    }

    protected function execute(
        InputInterface $input, OutputInterface $output)
    {
        $output->writeln("*********");
        $output->writeln(["Liste des étudiants", "**********"]);

        $students = $this->repo->findAll();
        foreach($students as $student) {
            $output->writeln($student->getName());
        }

        return 0;
    }

}