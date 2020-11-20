<?php
namespace App\Command;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use App\Entity\Student;
use App\Entity\User;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class CreateUserCommand extends Command
{
    protected static $defaultName = "app:user:create";
    private $em;
    private $passwordEncoder;

    public function __construct(
        EntityManagerInterface $em,
        UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->em = $em;
        $this->passwordEncoder = $passwordEncoder;
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setHelp("Cette commande permet de créer un utilisateur...")
            ->addArgument("email", InputArgument::REQUIRED, "Email")
            ->addArgument("password", InputArgument::REQUIRED, "Password")
        ;
    }

    protected function execute(
        InputInterface $input, OutputInterface $output)
    {
        $output->writeln("*********");
        $output->writeln(["Création d'un utilisateur", "**********"]);

        $email = $input->getArgument("email");
        $password = $input->getArgument("password");

        $output->writeln(["Email: ".$email, "Password: ".$password]);

        $user = new User();
        $user->setEmail($email);
        $user->setPassword($this->passwordEncoder->encodePassword(
            $user,
            $password
        ));
        $user->setRoles(["ROLE_USER", "ROLE_ADMIN"]);

        $this->em->persist($user);
        $this->em->flush();
        
        return 0; // en SF5 Command::SUCCESS
    }

}