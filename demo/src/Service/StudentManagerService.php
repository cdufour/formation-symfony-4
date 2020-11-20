<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Student;

class StudentManagerService
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function insert(Student $student)
    {
        $this->em->persist($student);
        $this->em->flush();
    }
}