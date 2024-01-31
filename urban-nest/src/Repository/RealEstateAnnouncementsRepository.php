<?php

namespace App\Repository;

use App\Entity\RealEstateAnnouncements;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<RealEstateAnnouncements>
 *
 * @method RealEstateAnnouncements|null find($id, $lockMode = null, $lockVersion = null)
 * @method RealEstateAnnouncements|null findOneBy(array $criteria, array $orderBy = null)
 * @method RealEstateAnnouncements[]    findAll()
 * @method RealEstateAnnouncements[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RealEstateAnnouncementsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RealEstateAnnouncements::class);
    }

    public function findLatest($pageSize = 3): array
    {
        return $this
            ->createQueryBuilder('a')
            ->addOrderBy('a.publish_date', 'DESC')
            ->setMaxResults($pageSize)
            ->getQuery()
            ->execute();
    }

//    /**
//     * @return RealEstateAnnouncements[] Returns an array of RealEstateAnnouncements objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('r.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?RealEstateAnnouncements
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
