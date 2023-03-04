<?php

namespace App\Repository;

use App\Entity\Profesor;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @method Profesor|null find($id, $lockMode = null, $lockVersion = null)
 * @method Profesor|null findOneBy(array $criteria, array $orderBy = null)
 * @method Profesor[]    findAll()
 * @method Profesor[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProfesorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, EntityManagerInterface $manager )
    {
        parent::__construct($registry, Profesor::class);
        $this->manager = $manager;
    }

    
    
    public function saveProfesor(Profesor $profesor): Profesor
    {
        $this->manager->persist($profesor);
        $this->manager->flush();

        return $profesor;
    }
    
    public function updateProfesor(Profesor $profesor): Profesor
    {
        $this->manager->persist($profesor);
        $this->manager->flush();

        return $profesor;
    }


    public function removeProfesor(Profesor $profesor)
    {
        $this->manager->remove($profesor);
        $this->manager->flush();
    }
    
    // /**
    //  * @return Profesor[] Returns an array of Profesor objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Profesor
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
