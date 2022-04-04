<?php

namespace App\DataFixtures;

use App\DataFixtures\CommentFixtures as DataFixturesCommentFixtures;
use App\Entity\Comment;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class CommentFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {

        $dataComments = [
            ['content' => 'Si vous vous êtes fait une image mentale de la chose, vous aurez remarqué qu’il reste une inconnue : de quel côté de la planche mettre son pied arrière ? Les deux sont possibles et dépendent de deux facteurs : votre préférence et l’inclinaison de la pente', 'trick' => 'trick1', 'user' => 'user1'],

            ['content' => 'Sur le plat, utilisez le côté avec lequel vous êtes le plus à l’aise. Personnellement, je préfère avoir mon pied libre du côté de ma carre backside, mais certains préfère l’avoir côté frontside.', 'trick' => 'trick5', 'user' => 'user5'],

            ['content' => 'Sur le plat, utilisez le côté avec lequel vous êtes le plus à l’aise. Personnellement, je préfère avoir mon pied libre du côté de ma carre backside, mais certains préfère l’avoir côté frontside.', 'trick' => 'trick5', 'user' => 'user3'],

            ['content' => 'Répétez le mouvement, puis petit à petit vous allez commencer à prendre de l’assurance et parvenir à enchainer les poussées sur votre pied arrière pour prendre plus de vitesse.', 'trick' => 'trick4', 'user' => 'user7'],

            ['content' => 'Vous pouvez vous promener un moment comme cela pour sentir la glisse à basse vitesse et vous y habituer. Prenez un peu de vitesse, puis ramenez votre pied arrière sur la planche jusqu’à suffisament ralentir ou vous arrêter, puis recommencez.', 'trick' => 'trick4', 'user' => 'user10'],

            ['content' => 'Votre corps doit également être perpendiculaire à la pente. Si vous vous penchez en arrière quand la pente augmente, ce qui est un réflexe naturel, vous n’êtes plus centré sur votre planche et vous allez avoir beaucoup de difficultés à la faire pivoter.', 'trick' => 'trick2', 'user' => 'user1'],

        ];

        foreach ($dataComments as $dataComment) {
            $comment = new Comment();

            $comment->setUser($this->getReference($dataComment['user']))
                ->setContent($dataComment['content'])
                ->setTrick($this->getReference($dataComment['trick']))
                ->setCreatedAt(new \DateTimeImmutable());

            $manager->persist($comment);
        }

        $manager->flush();

        // $comment1 = new Comment();

        // $comment1->setUser($this->getReference('user' . rand(1, 5)))
        //     ->setContent("Si vous vous êtes fait une image mentale de la chose, vous aurez remarqué qu’il reste une inconnue : de quel côté de la planche mettre son pied arrière ? Les deux sont possibles et dépendent de deux facteurs : votre préférence et l’inclinaison de la pente.")
        //     ->setTrick($this->getReference('trick1'))
        //     ->setCreatedAt(new \DateTimeImmutable());

        // $manager->persist($comment1);
        // $manager->flush();

        // $comment2 = new Comment();
        // $comment2->setUser($this->getReference('user' . rand(1, 5)))
        //     ->setContent("Sur le plat, utilisez le côté avec lequel vous êtes le plus à l’aise. Personnellement, je préfère avoir mon pied libre du côté de ma carre backside, mais certains préfère l’avoir côté frontside.")
        //     ->setTrick($this->getReference('trick5'))
        //     ->setCreatedAt(new \DateTimeImmutable());
        // $manager->persist($comment2);
        // $manager->flush();

        // $comment2 = new Comment();
        // $comment2->setUser($this->getReference('user' . rand(1, 5)))
        //     ->setContent("Sur le plat, utilisez le côté avec lequel vous êtes le plus à l’aise. Personnellement, je préfère avoir mon pied libre du côté de ma carre backside, mais certains préfère l’avoir côté frontside.")
        //     ->setTrick($this->getReference('trick5'))
        //     ->setCreatedAt(new \DateTimeImmutable());
        // $manager->persist($comment2);
        // $manager->flush();

        // $comment3 = new Comment();
        // $comment3->setUser($this->getReference('user' . rand(1, 5)))
        //     ->setContent("Répétez le mouvement, puis petit à petit vous allez commencer à prendre de l’assurance et parvenir à enchainer les poussées sur votre pied arrière pour prendre plus de vitesse. ")
        //     ->setTrick($this->getReference('trick4'))
        //     ->setCreatedAt(new \DateTimeImmutable());
        // $manager->persist($comment3);
        // $manager->flush();

        // $comment3 = new Comment();
        // $comment3->setUser($this->getReference('user' . rand(1, 5)))
        //     ->setContent("Vous pouvez vous promener un moment comme cela pour sentir la glisse à basse vitesse et vous y habituer. Prenez un peu de vitesse, puis ramenez votre pied arrière sur la planche jusqu’à suffisament ralentir ou vous arrêter, puis recommencez.")
        //     ->setTrick($this->getReference('trick4'))
        //     ->setCreatedAt(new \DateTimeImmutable());
        // $manager->persist($comment3);
        // $manager->flush();

        //     $comment4 = new Comment();
        //     $comment4->setUser($this->getReference('user' . rand(1, 5)))
        //         ->setContent("Votre corps doit également être perpendiculaire à la pente. Si vous vous penchez en arrière quand la pente augmente, ce qui est un réflexe naturel, vous n’êtes plus centré sur votre planche et vous allez avoir beaucoup de difficultés à la faire pivoter.")
        //         ->setTrick($this->getReference('trick2'))
        //         ->setCreatedAt(new \DateTimeImmutable());
        //     $manager->persist($comment4);
        //     $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            GroupeFixtures::class,
            VideoFixtures::class,
            UserFixtures::class,

        ];
    }
}
