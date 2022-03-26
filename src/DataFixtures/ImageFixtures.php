<?php

namespace App\DataFixtures;

use App\Entity\Image;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ImageFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {


        $image1 = (new Image())
            ->setFilename('TailGrab.jpg')
            ->setTrick($this->getReference('trick1'))
            ->setMain(true);
        $manager->persist($image1);
        $manager->flush();

        $image1 = (new Image())
            ->setFilename('TailGrab2.jpg')
            ->setTrick($this->getReference('trick1'))
            ->setMain(false);
        $manager->persist($image1);
        $manager->flush();


        $image2 = (new Image())
            ->setFilename('cross2.jpg')
            ->setTrick($this->getReference('trick2'))
            ->setMain(true);
        $manager->persist($image2);
        $manager->flush();

        $image2 = (new Image())
            ->setFilename('cross2')
            ->setTrick($this->getReference('trick2'))
            ->setMain(false);
        $manager->persist($image2);
        $manager->flush();

        $image3 = (new Image())
            ->setFilename('dracula.jpg')
            ->setTrick($this->getReference('trick3'))
            ->setMain(true);
        $manager->persist($image3);
        $manager->flush();

        $image3 = (new Image())
            ->setFilename('dracula2.jpg')
            ->setTrick($this->getReference('trick3'))
            ->setMain(false);
        $manager->persist($image3);
        $manager->flush();

        $image4 = (new Image())
            ->setFilename('Tamedog2.jpg')
            ->setTrick($this->getReference('trick4'))
            ->setMain(true);
        $manager->persist($image4);
        $manager->flush();

        $image4 = (new Image())
            ->setFilename('Tamedog.jpg')
            ->setTrick($this->getReference('trick4'))
            ->setMain(false);
        $manager->persist($image4);
        $manager->flush();

        $image5 = (new Image())
            ->setFilename('japan.jpg')
            ->setTrick($this->getReference('trick5'))
            ->setMain(true);
        $manager->persist($image5);
        $manager->flush();

        $image5 = (new Image())
            ->setFilename('japan2.jpg')
            ->setTrick($this->getReference('trick5'))
            ->setMain(false);
        $manager->persist($image5);
        $manager->flush();

        $image6 = (new Image())
            ->setFilename('rippey2.jpg')
            ->setTrick($this->getReference('trick6'))
            ->setMain(true);
        $manager->persist($image6);
        $manager->flush();

        $image6 = (new Image())
            ->setFilename('rippey.jpg')
            ->setTrick($this->getReference('trick6'))
            ->setMain(false);
        $manager->persist($image6);
        $manager->flush();

        $image7 = (new Image())
            ->setFilename('rodeo.jpg')
            ->setTrick($this->getReference('trick7'))
            ->setMain(true);
        $manager->persist($image7);
        $manager->flush();

        $image7 = (new Image())
            ->setFilename('rodeo2.jpg')
            ->setTrick($this->getReference('trick7'))
            ->setMain(false);
        $manager->persist($image7);
        $manager->flush();

        $image8 = (new Image())
            ->setFilename('frontside-misty2.jpg')
            ->setTrick($this->getReference('trick8'))
            ->setMain(true);
        $manager->persist($image8);
        $manager->flush();

        $image8 = (new Image())
            ->setFilename('frontside-misty.jpg')
            ->setTrick($this->getReference('trick8'))
            ->setMain(false);
        $manager->persist($image8);
        $manager->flush();

        $image9 = (new Image())
            ->setFilename('Blunt270.jpg')
            ->setTrick($this->getReference('trick9'))
            ->setMain(true);
        $manager->persist($image9);
        $manager->flush();

        $image9 = (new Image())
            ->setFilename('Blunt270-2.jpg')
            ->setTrick($this->getReference('trick9'))
            ->setMain(false);
        $manager->persist($image9);
        $manager->flush();

        $image10 = (new Image())
            ->setFilename('BoardSlide2.jpg')
            ->setTrick($this->getReference('trick10'))
            ->setMain(true);
        $manager->persist($image10);
        $manager->flush();

        $image10 = (new Image())
            ->setFilename('BoardSlide.jpg')
            ->setTrick($this->getReference('trick10'))
            ->setMain(false);
        $manager->persist($image10);
        $manager->flush();

        $image11 = (new Image())
            ->setFilename('WeddleGrab.jpg')
            ->setTrick($this->getReference('trick11'))
            ->setMain(true);
        $manager->persist($image11);
        $manager->flush();

        $image11 = (new Image())
            ->setFilename('WeddleGrab2.jpg')
            ->setTrick($this->getReference('trick11'))
            ->setMain(false);
        $manager->persist($image11);
        $manager->flush();

        $image12 = (new Image())
            ->setFilename('indy2.jpg')
            ->setTrick($this->getReference('trick12'))
            ->setMain(true);
        $manager->persist($image12);
        $manager->flush();

        $image12 = (new Image())
            ->setFilename('indy.jpg')
            ->setTrick($this->getReference('trick12'))
            ->setMain(false);
        $manager->persist($image12);
        $manager->flush();

        $image13 = (new Image())
            ->setFilename('Seatbelt.jpg')
            ->setTrick($this->getReference('trick13'))
            ->setMain(true);
        $manager->persist($image13);
        $manager->flush();

        $image13 = (new Image())
            ->setFilename('Seatbelt2.jpg')
            ->setTrick($this->getReference('trick13'))
            ->setMain(false);
        $manager->persist($image13);
        $manager->flush();

        $image14 = (new Image())
            ->setFilename('TruckDriver2.jpg')
            ->setTrick($this->getReference('trick14'))
            ->setMain(true);
        $manager->persist($image14);
        $manager->flush();

        $image14 = (new Image())
            ->setFilename('TruckDriver.jpg')
            ->setTrick($this->getReference('trick14'))
            ->setMain(false);
        $manager->persist($image14);
        $manager->flush();

        $image15 = (new Image())
            ->setFilename('Shifty.jpg')
            ->setTrick($this->getReference('trick15'))
            ->setMain(true);
        $manager->persist($image15);
        $manager->flush();

        $image15 = (new Image())
            ->setFilename('Shifty2.jpg')
            ->setTrick($this->getReference('trick15'))
            ->setMain(false);
        $manager->persist($image15);
        $manager->flush();

        $image16 = (new Image())
            ->setFilename('LipSlide.jpg')
            ->setTrick($this->getReference('trick16'))
            ->setMain(true);
        $manager->persist($image16);
        $manager->flush();

        $image16 = (new Image())
            ->setFilename('LipSlide2.jpg')
            ->setTrick($this->getReference('trick16'))
            ->setMain(false);
        $manager->persist($image16);
        $manager->flush();


        //Reference
        $this->setReference('Image1', $image1);
        $this->setReference('Image2', $image2);
        $this->setReference('Image3', $image3);
        $this->setReference('Image4', $image4);
        $this->setReference('Image5', $image5);
        $this->setReference('Image6', $image6);
        $this->setReference('Image7', $image7);
        $this->setReference('Image8', $image8);
        $this->setReference('Image9', $image9);
        $this->setReference('Image10', $image10);
        $this->setReference('Image11', $image11);
        $this->setReference('Image12', $image12);
        $this->setReference('Image13', $image13);
        $this->setReference('Image14', $image14);
        $this->setReference('Image15', $image15);
        $this->setReference('Image16', $image16);
    }

    public function getDependencies(): array
    {
        return [
            TrickFixtures::class,

        ];
    }
}
