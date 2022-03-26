<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Image;
use App\Entity\Trick;
use App\Entity\Video;
use DateTimeImmutable;
use App\Form\TrickType;
use App\Form\VideoType;
use App\Form\Type\TaskType;
use Doctrine\ORM\EntityManager;
use App\Repository\ImageRepository;
use App\Repository\TrickRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use phpDocumentor\Reflection\PseudoTypes\False_;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\String\Slugger\SluggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class TrickController extends AbstractController
{
    // /**
    //  * @Route("/")
    //  */

    // public function homepage()
    // {
    //     $number = random_int(0, 100);
    //     return $this->render('Home/index.html.twig', [
    //         'number' => $number,
    //     ]);
    // }



    /**
     * @Route("/", name="show_tricks")
     */
    public function showTricks(EntityManagerInterface $entity)
    {

        $repo = $entity->getRepository(Trick::class);
        $tricks = $repo->findAll();

        return $this->render('Home/trick.html.twig', [
            'tricks' => $tricks,
        ]);
    }

    /**
     * @Route("/tricks/{slug}", name="trick")
     *@param string $slug
     */

    public function showOneTrick(TrickRepository $trickRepo, $slug): Response
    {
        $trick = $trickRepo->findOneBy(['slug' => $slug]);

        if (!$trick) {
            //return $this->redirectToRoute('show_tricks');
            throw $this->createNotFoundException('Ce trick n\'existe pas !');
        }

        return $this->render('Home/showTrick.html.twig', [
            'trickDetails' => $trick
        ]);
    }

    /**
     *@Route("/Creation/Trick", name = "create_trick")
     * 
     */
    public function createTrick(Request $request, ManagerRegistry $doctrine, UserRepository $userRepo): Response
    {
        $trick = new Trick();

        $user = $userRepo->findAll();

        $userId = $user[1];

        $entityManager = $doctrine->getManager();

        $form = $this->createForm(TrickType::class, $trick);
        //$trick->getVideos()->add($video);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $images = $form->get('image')->getData();
            $videos = $form->get('videos')->getData();
            //looping for images
            foreach ($images as $image) {

                $file = md5(uniqid()) . '.' . $image->guessExtension();
                $image->move($this->getParameter('figure_directory'), $file);

                $imageUpload = new Image();
                $imageUpload->setFilename($file);
                $imageUpload->setMain(false);

                foreach ($videos as $video) {
                    $uploadVideo = new video();
                    $uploadVideo->setTrick($trick);

                    $uploadVideo->setUrl($video->getUrl());
                    $trick->addImage($imageUpload);
                }   //$trick->addVideo($uploadVideo);
                $trick->setUser($userId);
                $trick->setUpdatedAt(new \DateTimeImmutable());
                $trick->setCreatedAt(new \DateTimeImmutable());
                $trick->setSlug($trick->getName());

                $entityManager->persist($trick);
                $entityManager->persist($uploadVideo);
                $entityManager->persist($imageUpload);
            }
            $entityManager->flush();
            return $this->redirectToRoute('show_tricks');
        }
        return $this->render(
            'Tricks/addTricks.html.twig',
            [
                'formTrick' => $form->createView()
            ]
        );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Trick::class,
        ]);
    }
}
