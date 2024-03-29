<?php

namespace App\Controller;

use App\Repository\RealEstateAnnouncementsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(RealEstateAnnouncementsRepository $announcementsRepository): Response
    {
        return $this->render('home/index.html.twig', [
            'latestAnnouncements' => $announcementsRepository->findLatest(3),
        ]);
    }
}
