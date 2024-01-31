<?php

namespace App\DataFixtures;

use App\Entity\ApiUser;
use App\Entity\RealEstateAnnoucementCandidates;
use App\Entity\RealEstateAnnouncements;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $passwordHasher)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $propertyTypes = ['house', 'apartment', 'commercial'];
        $rues = [' Route de paris', ' Route de Lyon', ' Saint paylin', ' Rue des claquettes', ' Rue appolittes'];
        $cities = ['Paris', 'Lyon', 'Marseille', 'Toulouse'];
        $types = ['location', 'sale'];

        //Create User
        $usersREA = [];
        $firstNames = ['Julien', 'Paul', 'Marie', 'Luc'];
        $lastNames = ['Dufour', 'Dumartin', 'Duclaude', 'Dubrilon'];

        for ($i = 0; $i < 5; $i++) {
            $firstName = $firstNames[rand(0, count($firstNames) - 1)];
            $lastName = $lastNames[rand(0, count($lastNames) - 1)];

            $User = new User();
            $User->setFirstName($firstName);
            $User->setSurname($lastName);
            $User->setEmail(strtolower($firstName . '.' . $lastName . $i . '@urban-nest.com'));
            $User->setRoles(['ROLE_REA']);
            $User->setAdress(rand(1, 100) . $rues[rand(0, count($rues) - 1)]);
            $User->setPostalCode(rand(69000, 69500));
            $User->setCity($cities[rand(0, count($cities) - 1)]);
            $User->setPhone('0123456789');
            $User->setState('France');
            //Password
            $User->setPassword($this->passwordHasher->hashPassword(
                $User,
                'UrbanNest69'
            ));
            $manager->persist($User);

            $usersREA[] = $User;
        }

        $usersCUSTOMER = [];
        for ($i = 0; $i < 5; $i++) {
            $firstName = $firstNames[rand(0, count($firstNames) - 1)];
            $lastName = $lastNames[rand(0, count($lastNames) - 1)];

            $User = new User();
            $User->setFirstName($firstName);
            $User->setSurname($lastName);
            $User->setEmail(strtolower($firstName . '.' . $lastName . $i . '@me.com'));
            $User->setRoles(['ROLE_CUSTOMER']);
            $User->setAdress(rand(1, 100) . $rues[rand(0, count($rues) - 1)]);
            $User->setPostalCode(rand(69000, 69500));
            $User->setCity($cities[rand(0, count($cities) - 1)]);
            $User->setPhone('0123456789');
            $User->setState('France');
            //Password
            $User->setPassword($this->passwordHasher->hashPassword(
                $User,
                'UrbanNest69'
            ));
            $manager->persist($User);

            $usersCUSTOMER[] = $User;
        }

        //Annonces
        for ($i = 0; $i < 10; $i++) {
            $announce = new RealEstateAnnouncements();
            $announce->setAuthor($usersREA[rand(0, count($usersREA) - 1)]);
            $announce->setTitle('Annonce ' . $i);
            $announce->setDescription('Description de l\'annonce ' . $i);
            $announce->setArea(rand(50, 500));
            $announce->setBathrooms(rand(1, 5));
            $announce->setBedrooms(rand(3, 15));
            $announce->setPrice($announce->getBedrooms() * $announce->getArea());
            $announce->setLocation(rand(1, 100) . $rues[rand(0, count($rues) - 1)]);
            $announce->setPostalCode(rand(69000, 69500));
            $announce->setCity($cities[rand(0, count($cities) - 1)]);
            $announce->setPropertyType($propertyTypes[rand(0, count($propertyTypes) - 1)]);
            $announce->setPublishDate(new \DateTime());
            $announce->setStatus(rand(1, 3));
            $announce->setType($types[rand(1, count($types) - 1)]);
            $manager->persist($announce);

            //Ajouter des candidats
            for ($j = 0; $j < rand(1, 5); $j++) {
                $Candidate = new RealEstateAnnoucementCandidates();
                $Candidate->setUser($usersCUSTOMER[rand(0, count($usersCUSTOMER) - 1)]);
                $Candidate->setStatus(rand(1, 3));
                $Candidate->setAnnounce($announce);
                $Candidate->setApplicationDate(new \DateTime());
                $Candidate->setMessage('Message du candidat ' . $j);
                $manager->persist($Candidate);
            }
        }

        //Ajout d'utilisateur API
        for ($i = 0; $i < 5; $i++) {
            $firstName = $firstNames[rand(0, count($firstNames) - 1)];
            $lastName = $lastNames[rand(0, count($lastNames) - 1)];

            $ApiUser = new ApiUser();
            $ApiUser->setUsername(strtolower($firstName . '.' . $lastName . $i));
            //Password
            $ApiUser->setPassword($this->passwordHasher->hashPassword(
                $ApiUser,
                'UrbanNest69'
            ));
            $manager->persist($ApiUser);
        }

        $manager->flush();
    }
}
