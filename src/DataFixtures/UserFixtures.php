<?php


namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Image;
use App\Entity\Trick;
use App\Entity\Video;
use App\Entity\Groupe;
use DateTimeImmutable;
use App\Entity\Comment;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class UserFixtures extends Fixture
{
    private  $hasher;
    private $img;

    public function __construct(UserPasswordHasherInterface $hasher, private SluggerInterface $slugger)
    {
        $this->hasher = $hasher;
    }


    /**
     * Get either a Gravatar URL or complete image tag for a specified email address.
     *
     * @param string $email The email address
     * @param string $s Size in pixels, defaults to 80px [ 1 - 2048 ]
     * @param string $d Default imageset to use [ 404 | mp | identicon | monsterid | wavatar ]
     * @param string $r Maximum rating (inclusive) [ g | pg | r | x ]
     * @param boole $img True to return a complete IMG tag False for just the URL
     * @param array $atts Optional, additional key/value attributes to include in the IMG tag
     * @return String containing either just a URL or a complete image tag
     * @source https://gravatar.com/site/implement/images/php/
     */


    function randomName()
    {
        $name = [
            'Mariame',
            'Awa',
            'Amélie',
            'Juan',
            'Luis',
            'Pedro',
            'Michel',
            'Paul',
            'Sophie',
            'Sirra'

            // and so on

        ];
        return $name[rand(0, count($name) - 1)];
    }

    function randomGroupe()
    {
        $groupe = array(
            'BackFlip',
            'BackFlip360',
            '360Drift',
            // and so on

        );
        return $groupe[rand(0, count($groupe) - 1)];
    }


    function randomTitle()
    {
        $title = array(
            'Cold Edge',
            'The Dwindling Winter',
            'Gate of Heat',
            'The Snow Ice',
            'The Theft of the Touch',
            'Rings in the Butterfly'


        );
        return $title[rand(0, count($title) - 1)];
    }

    public function load(ObjectManager $manager): void
    {

        $names = [
            'Mariame',
            'Awa',
            'Amélie',
            'Juan',
            'Luis',
            'Pedro',
            'Michel',
            'Paul',
            'Sophie',
            'Sirra',
            'Isabelle',
            'Pauline',
            'Moise',
            'Kader',
            'Diawara',


            // and so on

        ];
        $users = [];


        foreach ($names as $name) {
            $user = new User();
            $password = $this->hasher->hashPassword($user, 'pass_1234');
            $user->setEmail($name . "@free.fr")
                ->setPseudo($name . "pseudo")
                ->setPassword($password)
                ->setActived(true)
                ->setActiveToken(null)
                ->setAvatar("https://picsum.photos/20" . rand(1, 10))
                ->setCreatedAt(new DateTimeImmutable());
            $users[] = $user;
            $manager->persist($user);



            $r = rand(1, 5);

            $this->setReference('user' . $r, $user);

            $manager->flush();
        }
    }
}
