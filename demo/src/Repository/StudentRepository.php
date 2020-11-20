<?php

namespace App\Repository;

use App\Entity\Student;
use App\Entity\Country;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Student|null find($id, $lockMode = null, $lockVersion = null)
 * @method Student|null findOneBy(array $criteria, array $orderBy = null)
 * @method Student[]    findAll()
 * @method Student[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StudentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Student::class);
    }

    /**
    * @return Student[] Returns an array of Student objects
    */
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->where('s.status = :val')
            ->setParameter('val', $value)
            ->orderBy('s.name', 'ASC')
            ->setMaxResults(5) // limit
            ->setFirstResult(1) // offset
            ->getQuery()
            ->getResult()
        ;
    }

    /**
    * @return Student[] Returns an array of Student objects
    */
    public function findByCountry($countryName)
    {
        return $this->createQueryBuilder('s')
            ->join('s.country', 'c', 'country_id')
            ->where('c.name = :countryName')
            ->setParameter('countryName', $countryName)
            ->orderBy('s.name', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    /**
    * @return Student[] Returns an array of Student objects
    * Syntaxe DQL
    */
    public function findTeachers()
    {
        $em = $this->getEntityManager();

        $query = $em->createQuery(
            'SELECT s FROM App\Entity\Student s
                WHERE s.status = :status
                ORDER BY s.name ASC
            '
        );

        $query->setParameter("status", "teacher");

        return $query->getResult();
    }

        /**
    * @return Student[] Returns an array of Student objects
    * Syntaxe DQL
    * https://www.doctrine-project.org/projects/doctrine-orm/en/current/reference/dql-doctrine-query-language.html
    */
    public function findByTraining($trainingTitle)
    {
        $em = $this->getEntityManager();

        $query = $em->createQuery(
            'SELECT s FROM App\Entity\Student s
                LEFT JOIN s.training t
                WHERE t.title = :trainingTitle
                ORDER BY s.name ASC
            '
        );

        $query->setParameter("trainingTitle", $trainingTitle);

        return $query->getResult();
    }
    
}
