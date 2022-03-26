<?php

namespace App\DataFixtures;

use App\Entity\Groupe;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class GroupeFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        //Categories ----------------
        $groupe1 = (new Groupe());
        $groupe1->setName('Rotations');
        $manager->persist($groupe1);
        $manager->flush();

        $groupe2 = (new Groupe());
        $groupe2->setName('Grabs');
        $manager->persist($groupe2);
        $manager->flush();

        $groupe3 = (new Groupe());
        $groupe3->setName('Flips');
        $manager->persist($groupe3);
        $manager->flush();

        $groupe4 = (new Groupe());
        $groupe4->setName('Old school');
        $manager->persist($groupe4);
        $manager->flush();

        $groupe5 = (new Groupe());
        $groupe5->setName('One foot');
        $manager->persist($groupe5);
        $manager->flush();

        $groupe6 = (new Groupe());
        $groupe6->setName('Slides');
        $manager->persist($groupe6);
        $manager->flush();

        $groupe7 = (new Groupe());
        $groupe7->setName('Rotation désaxé');
        $manager->persist($groupe7);
        $manager->flush();


        //addingReference
        $this->addReference('Groupe1', $groupe1);
        $this->addReference('Groupe2', $groupe2);
        $this->addReference('Groupe3', $groupe3);
        $this->addReference('Groupe4', $groupe4);
        $this->addReference('Groupe5', $groupe5);
        $this->addReference('Groupe6', $groupe6);
        $this->addReference('Groupe7', $groupe7);
    }
}
