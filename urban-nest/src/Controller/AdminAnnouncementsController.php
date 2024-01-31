<?php

namespace App\Controller;

use App\Entity\RealEstateAnnoucementCandidates;
use App\Entity\RealEstateAnnoucementCandidatesDocuments;
use App\Entity\RealEstateAnnoucementPictures;
use App\Entity\RealEstateAnnouncements;
use App\Service\CloudinaryService;
use App\Service\PicturesService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/app/admin/announcements', name: 'app_admin_announcements_')]
class AdminAnnouncementsController extends AbstractController
{
    #[Route('/list', name: 'list')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $announces = $entityManager->getRepository(RealEstateAnnouncements::class)->findAll();
        return $this->render('admin_announcements/list.html.twig', [
            'announces' => $announces
        ]);
    }

    #[Route('/create', name: 'create')]
    public function create(EntityManagerInterface $entityManager, Request $request, CloudinaryService $Cloudinary): Response
    {
        if($request->isMethod("POST")) {
            $announce = new RealEstateAnnouncements();
            $announce->setAuthor($this->getUser());
            //Base
            $announce->setTitle($request->get("announce")['title']);
            $announce->setDescription($request->get("announce")['description']);
            $announce->setPropertyType($request->get("announce")['property']['type']);
            $announce->setArea($request->get("announce")['property']['area']);
            $announce->setBathrooms($request->get("announce")['property']['bathrooms']);
            $announce->setBedrooms($request->get("announce")['property']['bedrooms']);
            //Localisation
            $announce->setLocation($request->get("announce")['localisation']['adress']);
            $announce->setCity($request->get("announce")['localisation']['city']);
            $announce->setPostalCode($request->get("announce")['localisation']['postalCode']);
            //Tarifs
            $announce->setType($request->get("announce")['transaction']['type']);
            $announce->setPrice($request->get("announce")['transaction']['price']);

            $announce->setPublishDate(new \DateTimeImmutable());
            $announce->setStatus(1);

            //Photos
            $pictures = $request->files->get('pictures');

            if(isset($pictures['default'])){
                $picturesDefault = $pictures['default'];
                if($picturesDefault){
                    $pic = $Cloudinary->upload($picturesDefault->getRealPath(), [
                        'folder' => 'urban-nest/announcements/pictures',
                    ]);
                    if(isset($pic['secure_url'])){
                        $Pic = new RealEstateAnnoucementPictures();
                        $Pic->setPictureUrl($pic['secure_url']);
                        $Pic->setAnnounce($announce);
                        $entityManager->persist($Pic);

                        $announce->setDefaultPicture($pic['secure_url']);
                    }
                }
            }

            if(isset($pictures['addin'])){
                $picturesAddin = $pictures['addin'];
                if($picturesAddin){
                    foreach ($picturesAddin as $key => $file){
                        if($file){
                            $pic = $Cloudinary->upload($file->getRealPath(), [
                                'folder' => 'urban-nest/announcements/pictures',
                            ]);
                            if(isset($pic['secure_url'])){
                                $Pic = new RealEstateAnnoucementPictures();
                                $Pic->setPictureUrl($pic['secure_url']);
                                $Pic->setAnnounce($announce);
                                $entityManager->persist($Pic);
                            }
                        }
                    }
                }
            }

            $entityManager->persist($announce);
            $entityManager->flush();
            $this->addFlash("success", "Votre annonce a bien été crée");
            return $this->redirectToRoute('app_home');

        }

        return $this->render('admin_announcements/create.html.twig');
    }

    #[Route('/delete/{id}', name: 'delete')]
    public function delete(EntityManagerInterface $entityManager, RealEstateAnnouncements $announce): Response
    {
        //Suppression des photos
        $pictures = $entityManager->getRepository(RealEstateAnnoucementPictures::class)->findBy(['announce' => $announce]);
        foreach ($pictures as $picture){
            $entityManager->remove($picture);
        }
        //Suppression des candidates
        $candidates = $entityManager->getRepository(RealEstateAnnoucementCandidates::class)->findBy(['announce' => $announce]);
        foreach ($candidates as $candidate){
            //Suppression des documents
            $documents = $entityManager->getRepository(RealEstateAnnoucementCandidatesDocuments::class)->findBy(['application' => $candidate]);
            foreach ($documents as $document){
                $entityManager->remove($document);
            }

            $entityManager->remove($candidate);
        }

        $entityManager->remove($announce);
        $entityManager->flush();
        $this->addFlash("success", "Votre annonce a bien été supprimé");
        return $this->redirectToRoute('app_admin_announcements_list');
    }

    #[Route('/edit/{id}', name: 'edit')]
    public function edit(Request $request, EntityManagerInterface $entityManager, CloudinaryService $Cloudinary, $id): Response
    {
        $announce = $entityManager->getRepository(RealEstateAnnouncements::class)->find($id);
        if (!$announce){
            return $this->createNotFoundException();
        }

        if($request->isMethod("POST")) {
            //Base
            $announce->setTitle($request->get("announce")['title']);
            $announce->setDescription($request->get("announce")['description']);
            $announce->setPropertyType($request->get("announce")['property']['type']);
            $announce->setArea($request->get("announce")['property']['area']);
            $announce->setBathrooms($request->get("announce")['property']['bathrooms']);
            $announce->setBedrooms($request->get("announce")['property']['bedrooms']);
            //Localisation
            $announce->setLocation($request->get("announce")['localisation']['adress']);
            $announce->setCity($request->get("announce")['localisation']['city']);
            $announce->setPostalCode($request->get("announce")['localisation']['postalCode']);
            //Tarifs
            $announce->setType($request->get("announce")['transaction']['type']);
            $announce->setPrice($request->get("announce")['transaction']['price']);

            $announce->setPublishDate(new \DateTimeImmutable());
            $announce->setStatus(1);

            //Photos
            $pictures = $request->files->get('pictures');

            if(isset($pictures['default'])){
                $picturesDefault = $pictures['default'];
                if($picturesDefault){
                    $pic = $Cloudinary->upload($picturesDefault->getRealPath(), [
                        'folder' => 'urban-nest/announcements/pictures',
                    ]);
                    if(isset($pic['secure_url'])){
                        $Pic = new RealEstateAnnoucementPictures();
                        $Pic->setPictureUrl($pic['secure_url']);
                        $Pic->setAnnounce($announce);
                        $entityManager->persist($Pic);

                        $announce->setDefaultPicture($pic['secure_url']);
                    }
                }
            }

            if(isset($pictures['addin'])){
                $picturesAddin = $pictures['addin'];
                if($picturesAddin){
                    foreach ($picturesAddin as $key => $file){
                        if($file){
                            $pic = $Cloudinary->upload($file->getRealPath(), [
                                'folder' => 'urban-nest/announcements/pictures',
                            ]);
                            if(isset($pic['secure_url'])){
                                $Pic = new RealEstateAnnoucementPictures();
                                $Pic->setPictureUrl($pic['secure_url']);
                                $Pic->setAnnounce($announce);
                                $entityManager->persist($Pic);
                            }
                        }
                    }
                }
            }

            $entityManager->persist($announce);
            $entityManager->flush();
            $this->addFlash("success", "Votre annonce a bien été modifié");
            return $this->redirectToRoute('app_admin_announcements_edit', ['id' => $announce->getId()]);

        }

        return $this->render('admin_announcements/edit.html.twig', [
            'announce' => $announce
        ]);
    }

    #[Route('/pictures/{id}/delete', name: 'pictures_delete')]
    public function deletePictures(EntityManagerInterface $entityManager, int $id): Response
    {
        $picture = $entityManager->getRepository(RealEstateAnnoucementPictures::class)->find($id);
        if (!$picture) {
            return $this->createNotFoundException();
        }
        $entityManager->remove($picture);
        $entityManager->flush();
        return $this->redirectToRoute('app_admin_announcements_edit', ['id' => $picture->getAnnounce()->getId()]);
    }

    #[Route('/candidates', name: 'candidates')]
    public function candidates(EntityManagerInterface $entityManager, Request $request): Response
    {
        $candidates = $entityManager->getRepository(RealEstateAnnoucementCandidates::class)->createQueryBuilder('c')
            ->leftJoin('c.announce', 'a')
            ->leftJoin('c.user', 'u')
            ->addSelect('a')
            ->addSelect('u')
            ->addOrderBy('a.publish_date', 'DESC')
            ->addOrderBy('u.surname', 'ASC');

        if($request->get('announce')){
            $candidates->andWhere('a.id = :announce');
            $candidates->setParameter('announce', $request->get('announce'));
        }
        return $this->render('admin_announcements/candidates.html.twig', [
            'candidates' => $candidates->getQuery()->getResult()
        ]);
    }

    #[Route('/candidates/{id}/consult', name: 'candidates_consult')]
    public function consult(EntityManagerInterface $entityManager, int $id): Response
    {
        $candidate = $entityManager->getRepository(RealEstateAnnoucementCandidates::class)->find($id);
        if (!$candidate) {
            return $this->createNotFoundException();
        }
        return $this->render('admin_announcements/candidates_consult.html.twig', [
            'candidat' => $candidate,
        ]);
    }
}
