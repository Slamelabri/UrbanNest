<?php

namespace App\Controller;

use App\Entity\RealEstateAnnoucementCandidates;
use App\Entity\RealEstateAnnouncements;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class DashboardController extends AbstractController
{
    public function __construct(private AuthorizationCheckerInterface $authorizationChecker)
    {
    }

    #[Route('/app/dashboard', name: 'app_dashboard')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $recaps = [];
        if($this->authorizationChecker->isGranted('ROLE_REA')){
            $recaps[] = [
                'title' => "Nombre d'annonces",
                'value' => $entityManager->getRepository(RealEstateAnnouncements::class)->createQueryBuilder('a')
                    ->select('COUNT(a.id)')
                    ->getQuery()
                    ->getSingleScalarResult(),
            ];
            $recaps[] = [
                'title' => "Nombre de candidats",
                'value' => $entityManager->getRepository(RealEstateAnnoucementCandidates::class)->createQueryBuilder('c')
                    ->select('COUNT(c.id)')
                    ->getQuery()
                    ->getSingleScalarResult(),
            ];
        } elseif ($this->authorizationChecker->isGranted("ROLE_CUSTOMER")) {
            $recaps[] = [
                'title' => 'Candidatures envoyee',
                'value' => $entityManager->getRepository(RealEstateAnnoucementCandidates::class)->createQueryBuilder('c')
                    ->select('COUNT(c.id)')
                    ->where('c.user = :customer')
                    ->setParameter('customer', $this->getUser())
                    ->getQuery()
                    ->getSingleScalarResult(),
            ];
        }


        return $this->render('dashboard/index.html.twig', [
            'recaps' => $recaps,
        ]);
    }
}
