<?php

namespace App\Repository;

use App\Entity\Livre;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Livre|null find($id, $lockMode = null, $lockVersion = null)
 * @method Livre|null findOneBy(array $criteria, array $orderBy = null)
 * @method Livre[]    findAll()
 * @method Livre[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LivreRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
   {
        parent::__construct($registry, Livre::class);
    }


    public function getLivres($Categorie_id= null)
    {
        
        $qb = $this->createQueryBuilder('l');
             
        if($categorie_id) 
        {
            $qb->andWhere('l.categorie = :categorie_id ')
                ->setParameter('categorie_id', $categorie_id);
        }
 
        $query = $qb->getQuery();
 
        return $query->getResult();
    
    }
}


     /**
      * @return Query
      */

     /*public function findAllQuery():Query
     {
         return $this->findAllQuery()
              ->getQuery();
     } 
       
    
    /*public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
        
   // public function findOneBySomeField($value): ?Livre
    /*{
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }/*

    public function getNomCategorie($nomCategorie){
       return $this->getEntityManager()
                    ->createQuery("SELECT * FROM App:Livre l where l.categorie.nom = '$nomCategorie'")
                    ->getResult();}
    
}
