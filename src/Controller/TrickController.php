<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Image;
use App\Entity\Trick;
use App\Entity\Video;
use DateTimeImmutable;
use App\Entity\Comment;
use App\Form\TrickType;
use App\Form\VideoType;
use App\Form\CommentType;
use App\Form\Type\TaskType;
use App\Service\ImageUploader;
use App\Service\VideoValidator;
use Doctrine\ORM\EntityManager;
use App\Repository\UserRepository;
use App\Repository\ImageRepository;
use App\Repository\TrickRepository;
use App\Repository\CommentRepository;
use Doctrine\ORM\Query\AST\UpdateItem;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Routing\Annotation\Route;
use phpDocumentor\Reflection\PseudoTypes\False_;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\Security\Http\Util\TargetPathTrait;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

final class TrickController extends AbstractController
{

    use TargetPathTrait;
    public function __construct(private SluggerInterface $slugger)
    {
    }


    /**
     * @Route("/", name="show_tricks")
     * @paramConverter(name="trick", Class="MyBundle:Trick")
     */
    public function showTricks(EntityManagerInterface $entity, ManagerRegistry $doctrine,  Trick $trick = null)
    {

        $repo = $entity->getRepository(Trick::class);


        $manager = $doctrine->getManager();

        $tricks = $repo->findAll();
        foreach ($tricks as $trick) {

            $image = $trick->getImage();
        }
        foreach ($image as $imageMain) {
        }
        if (count($image) > 0 && $imageMain->getMain() === false) {
            $main = $image[0];
            $main->setMain(true);
            $manager->flush();
        }


        return $this->render('Home/trick.html.twig', [
            'tricks' => $repo->findAll(['createdAt' => 'DESC']),
        ]);
    }

    /**
     * @Route("/tricks/{slug}", name="trick")
     *@param string $slug
     */

    public function showOneTrick(Request $request, ManagerRegistry $doctrine, TrickRepository $trickRepo, $slug, CommentRepository $commentReo): Response
    {
        $trick = $trickRepo->findOneBy(['slug' => $slug]);

        if (!$trick) {
            //return $this->redirectToRoute('show_tricks');
            throw $this->createNotFoundException('Le trick que vous recherchez n\'existe pas !');
        }

        $user = $this->getUser();

        $manager = $doctrine->getManager();
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $comment->setTrick($trick)
                ->setUser($user)
                ->setCreatedAt(new \DateTimeImmutable());
            $manager->persist($comment);
            $manager->flush();
            $this->addFlash('success', 'Votre commentaire a été bien ajouté !');
            return $this->redirectToRoute('trick', ['slug' => $trick->getSlug()]);
        }

        $comments = $commentReo->findBy(['trick' => $trick->getId()], ['id' => 'DESC']);

        return $this->render('Home/showTrick.html.twig', [
            'trickDetails' => $trick,
            'form' => $form->createView(),
            'comments' => $comments,
        ]);
    }

    /**
     *@Route("/nouveau/trick", name = "create_trick")
     *@Route("/modification/trick/{slug}", name = "edit_trick")
     *@param string $slug
     */
    public function createTrick(Request $request, ManagerRegistry $doctrine, UserRepository $userRepo, ImageUploader $uploader, VideoValidator $validUrl, Trick $trick = null, $slug = null, TrickRepository $trickRepo): Response
    {
        if (!$trick) {
            $trick = new Trick();
        }
        if (!$this->getUser() || $this->getUser()->getActived() === false) {
            return $this->redirectToRoute('show_tricks');
        }


        $user = $this->getUser();
        $updateTrick = $trickRepo->findOneBy(['slug' => $slug]);



        if (!$trick) {
            //return $this->redirectToRoute('show_tricks');
            throw $this->createNotFoundException('Le trick que vous recherchez n\'existe pas !');
        }

        $entityManager = $doctrine->getManager();

        $form = $this->createForm(TrickType::class, $trick);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $images = $form->get('image')->getData();
            $videos = $form->get('videos')->getData();

            //get le groupe pour renvoyer une erreur  

            $uploader->uploadImage($trick, $images);
            foreach ($videos as $video) {

                $validUrl->getYoutubeUrl($video, $trick);
                $video->setTrick($trick);
            }
            $trick->setUser($user);
            if ($trick->getId()) {
                $trick->setUpdatedAt(new \DateTimeImmutable());
            } else {
                $trick->setCreatedAt(new \DateTimeImmutable());
            }
            $trick->setSlug($this->slugger->slug($trick->getName())->lower());

            $entityManager->persist($trick);

            $entityManager->flush();

            if (!empty($images) && count($images) > 1) {
                return $this->redirectToRoute('image_main', ['slug' => $trick->getSlug()]);
            }



            return $this->redirectToRoute('trick', ['slug' => $trick->getSlug()]);
            $this->addFlash('success', 'Votre Trick a été ajouté !');
        }

        return $this->render(
            'Tricks/addTricks.html.twig',
            [
                'formTrick' => $form->createView(),
                'editMode' => $trick->getId() !== null,
                'trick' => $updateTrick,
            ]
        );
    }

    /**
     * @Route("/tricks/choisir-image-main/{slug}", name="image_main")
     * @param string $slug
     * 
     */

    public function imageMain(Request $request, Trick $trick = null,  ManagerRegistry $doctrine, TrickRepository $trickRepo, $slug = null): Response
    {
        $entityManager = $doctrine->getManager();
        $trick = $trickRepo->findOneBy(['slug' => $slug]);
        if (!$trick) {
            $trick = new Trick();
        }
        if (!$this->getUser() || $this->getUser()->getActived() === false) {
            return $this->redirectToRoute('show_tricks');
        }

        $imageExist = $trick->getImage();
        foreach ($imageExist as $image) {
            if ($image->getMain() === true) {
                return $this->redirectToRoute('show_tricks');
            }
        }


        if ($request->get('imageMain')) {
            $imageMain = $request->get('imageMain');

            $images = $entityManager->getRepository(Image::class)->find($imageMain);

            $images->setMain(true);
            $entityManager->flush();


            $this->addFlash('success', 'Votre Trick a été ajouté ainsi que votre image de couverture !');

            return $this->redirectToRoute('show_tricks');
        }

        //$imageMain = $entityManager->getRepository(Image::class)->findOneBy(['id_trick' => $trick->getId()]);


        $tricks = $trickRepo->findOneBy(['slug' => $slug]);
        if (!$trick) {
            return $this->redirectToRoute('show_tricks');
        }



        return $this->render(
            'Tricks/imageMain.html.twig',
            [
                'imageMain' => $tricks->getImage(),
            ]
        );
    }

    #[Route('/delete/trick/{id}', methods: ['POST'], name: 'delete_trick')]

    public function deleteTrick(Request $request, EntityManagerInterface $entityManager, Trick $trick)
    {
        if (!$this->getUser() || $this->getUser()->getActived() === false) {
            return $this->redirectToRoute('show_tricks');
        }

        if (!$this->isCsrfTokenValid('delete', $request->request->get('token'))) {
            return $this->redirectToRoute('show_tricks');
        }
        $entityManager->remove($trick);
        $entityManager->flush();
        $this->addFlash('success', 'Votre Trick a été supprimé !');
        return $this->redirectToRoute('show_tricks');
    }

    #[Route('/delete/trick/image/{id}', methods: ['POST'], name: 'delete_image')]


    public function deleteImage(EntityManagerInterface $entityManager, int $id, Trick $trick = null,): Response
    {

        if (!$trick) {
            $trick = new Trick();
        }
        if (!$this->getUser() || $this->getUser()->getActived() === false) {
            return $this->redirectToRoute('show_tricks');
        }

        $images = $entityManager->getRepository(Image::class)->find($id);

        $entityManager->remove($images);
        $entityManager->flush();
        $this->addFlash('success', 'Votre image a été supprimée !');

        return $this->redirectToRoute('show_tricks');
    }


    #[Route('/delete/trick/video/{id}', methods: ['POST'], name: 'delete_video')]

    public function deleteVideo(EntityManagerInterface $entityManager, int $id, Trick $trick = null,): Response
    {

        if (!$trick) {
            $trick = new Trick();
        }
        if (!$this->getUser() || $this->getUser()->getActived() === false) {
            return $this->redirectToRoute('show_tricks');
        }

        $video = $entityManager->getRepository(Video::class)->find($id);

        $entityManager->remove($video);
        $entityManager->flush();
        $this->addFlash('success', 'Votre vodéo a été supprimé !');

        return $this->redirectToRoute('show_tricks');
    }
}
