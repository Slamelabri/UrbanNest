<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\RealEstateAnnouncements;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;



class OfferseedetailsController extends AbstractController
{
    #[Route('/offerseedetails/{id}', name: 'app_offerseedetails')]

    public function show(EntityManagerInterface $entityManager, Request $request, $id): Response
    {
        $offerdetails = $entityManager->getRepository(RealEstateAnnouncements::class)->findBy(['id' => $id]);
        
        $pictures = [];
        if ($offerdetails) {
            $pictures = $offerdetails[0]->getPictures();
        }

        return $this->render('offerseedetails/index.html.twig', [
            'controller_name' => 'OfferseedetailsController',
            'offerdetails' => $offerdetails,
            'pictures' => $pictures,
        ]);
    }
}







/*
class OfferseedetailsController extends AbstractController
{
    #[Route('/offerseedetails/{id}', name: 'app_offerseedetails')]

    public function show(EntityManagerInterface $entityManager, Request $request, $id): Response
    {
        $offerdetails = $entityManager->getRepository(RealEstateAnnouncements::class)->findBy(['id' => $id]);
    
        return $this->render('offerseedetails/index.html.twig', [
            'controller_name' => 'OfferseedetailsController',
            'offerdetails' => $offerdetails,
        ]);
    }
}
*/







/*
class OfferseedetailsController extends AbstractController
{
    #[Route('/offerseedetails', name: 'app_offerseedetails')]

    public function showTest(EntityManagerInterface $entityManager, Request $request): Response
    {
        $testid = 62;

        $offerdetails = $entityManager->getRepository(RealEstateAnnouncements::class)->findBy(['id' => $testid]);
    
        return $this->render('offerseedetails/index.html.twig', [
            'controller_name' => 'OfferseedetailsController',
            'offerdetails' => $offerdetails,
        ]);
    }
    
}
*/

