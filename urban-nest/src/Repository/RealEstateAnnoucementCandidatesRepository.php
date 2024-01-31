<?php

namespace App\Repository;

use App\Entity\RealEstateAnnoucementCandidates;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<RealEstateAnnoucementCandidates>
 *
 * @method RealEstateAnnoucementCandidates|null find($id, $lockMode = null, $lockVersion = null)
 * @method RealEstateAnnoucementCandidates|null findOneBy(array $criteria, array $orderBy = null)
 * @method RealEstateAnnoucementCandidates[]    findAll()
 * @method RealEstateAnnoucementCandidates[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RealEstateAnnoucementCandidatesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RealEstateAnnoucementCandidates::class);
    }

//    /**
//     * @return RealEstateAnnoucementCandidates[] Returns an array of RealEstateAnnoucementCandidates objects
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

//    public function findOneBySomeField($value): ?RealEstateAnnoucementCandidates
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
