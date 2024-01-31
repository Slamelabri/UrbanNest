<?php

namespace App\Controller;

use App\Entity\RealEstateAnnoucementCandidates;
use App\Entity\RealEstateAnnoucementCandidatesDocuments;
use App\Entity\RealEstateAnnoucementPictures;
use App\Entity\RealEstateAnnouncements;
use App\Entity\User;
use App\Service\CloudinaryService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/announcements', name: 'app_announcements_')]
class AnnouncementsController extends AbstractController
{
    #[Route('/filter', name: 'filter')]
    public function filter(): Response
    {
        return $this->render('announcements/filter.html.twig');
    }

    #[Route(
        '/{type}/{postalCode}/list',
        name: 'list',
        requirements: [
            'type' => 'location|sale',
        ],
    )]
    public function list(EntityManagerInterface $entityManager, Request $request, string $type = "", int $postalCode = 69000): Response
    {
        $city = $request->get("city");
        $property['type'] = $request->get('propertyType');

        $queryBuilder = $entityManager->getRepository(RealEstateAnnouncements::class)->createQueryBuilder('a');

        $queryBuilder->andWhere('a.type = :type');
        $queryBuilder->setParameter('type', $type);

        $queryBuilder->andWhere('a.postalCode = :postalCode');
        $queryBuilder->setParameter('postalCode', $postalCode);

        if(!empty($city)){
            $queryBuilder->andWhere('a.city = :city');
            $queryBuilder->setParameter('city', $city);
        }

        if(!empty($property['type'])){
            $queryBuilder->andWhere('a.property_type = :propertyType');
            $queryBuilder->setParameter('propertyType', $property['type']);
        }

        return $this->render('announcements/list.html.twig', [
            'announces' => $queryBuilder->orderBy('a.price', 'asc')->getQuery()->getResult(),
            'type' => $type,
            'query' => [
                'postalCode' => $postalCode,
                'type' => $type,
                'city' => $city,
                'property' => [
                    'type' => $property['type'],
                ]
            ],
        ]);
    }

    #[Route('/{id}/postule', name: 'postule')]
    public function postule(EntityManagerInterface $entityManager, Request $request, CloudinaryService $Cloudinary, int $id): Response
    {
        $client = $this->getUser();
        $announce = $entityManager->getRepository(RealEstateAnnouncements::class)->find($id);
        if (!$announce) {
            throw $this->createNotFoundException();
        }

        if ($request->isMethod("POST")) {
            $postuleForm = $request->get("postule");
            $postule = new RealEstateAnnoucementCandidates();
            $postule->setAnnounce($announce);
            $postule->setUser($entityManager->getRepository(User::class)->find(1));
            $postule->setStatus(1);
            $postule->setApplicationDate(new \DateTimeImmutable());
            $postule->setMessage($postuleForm['client']['commentaire']);

            $client->setAdress($postuleForm['client']['adress']);
            $client->setCity($postuleForm['client']['city']);
            $client->setPostalCode($postuleForm['client']['postalCode']);
            $client->setState($postuleForm['client']['state']);
            $client->setPhone($postuleForm['client']['phone']);

            $entityManager->persist($client);

            //Files
            $files = $request->files->get('files');
            foreach ($files as $key => $file) {
                if ($file) {
                    $doc = $Cloudinary->upload($file->getRealPath(), [
                        'folder' => 'urban-nest/postules',
                        'public_id' => $key . '-' . uniqid(),
                    ]);
                    if (isset($doc['secure_url'])) {
                        $Doc = new RealEstateAnnoucementCandidatesDocuments();
                        $Doc->setDocumentName($key);
                        $Doc->setDocumentUrl($doc['secure_url']);
                        $Doc->setApplication($postule);
                        $Doc->setAuthor($entityManager->getRepository(User::class)->find(1));
                        $entityManager->persist($Doc);
                    }
                }
            }
            $entityManager->persist($postule);
            $entityManager->flush();

            $this->addFlash("success", "Votre candidature a bien été envoyée");
            return $this->redirectToRoute('app_home');
        }

        return $this->render('announcements/postule.html.twig', [
            'announce' => $announce,
            'client' => $client,
        ]);
    }
}
