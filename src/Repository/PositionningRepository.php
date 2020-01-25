<?php

namespace App\Repository;

use App\Entity\Positionning;
use App\Entity\User;
use App\Entity\Gift;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Positionning|null find($id, $lockMode = null, $lockVersion = null)
 * @method Positionning|null findOneBy(array $criteria, array $orderBy = null)
 * @method Positionning[]    findAll()
 * @method Positionning[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PositionningRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Positionning::class);
    }

    public function checkAssociation(Gift $gift, User $user)
    {
	$res= $this->createQueryBuilder('p')
		->andWhere('p.user = :user')
		->andWhere('p.gift = :gift')
		->setParameter('gift', $gift)
		->setParameter('user', $user)
            ->getQuery()
	    ->getOneOrNullResult() ;
	//echo (get_class($res));exit;
	return $res != null;


    }
    // /**
    //  * @return Positionning[] Returns an array of Positionning objects
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
    public function findOneBySomeField($value): ?Positionning
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
