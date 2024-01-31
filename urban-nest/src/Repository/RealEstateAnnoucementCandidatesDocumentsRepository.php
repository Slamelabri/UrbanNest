<?php

namespace App\Repository;

use App\Entity\RealEstateAnnoucementCandidatesDocuments;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<RealEstateAnnoucementCandidatesDocuments>
 *
 * @method RealEstateAnnoucementCandidatesDocuments|null find($id, $lockMode = null, $lockVersion = null)
 * @method RealEstateAnnoucementCandidatesDocuments|null findOneBy(array $criteria, array $orderBy = null)
 * @method RealEstateAnnoucementCandidatesDocuments[]    findAll()
 * @method RealEstateAnnoucementCandidatesDocuments[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RealEstateAnnoucementCandidatesDocumentsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RealEstateAnnoucementCandidatesDocuments::class);
    }

//    /**
//     * @return RealEstateAnnoucementCandidatesDocuments[] Returns an array of RealEstateAnnoucementCandidatesDocuments objects
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

//    public function findOneBySomeField($value): ?RealEstateAnnoucementCandidatesDocuments
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
