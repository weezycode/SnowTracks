<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\User;
use App\Service\Token;
use App\Service\MailRegister;
use App\Form\RegistrationType;
use App\Service\ImageUploader;
use App\Service\ResetPassword;
use App\Form\PasswordResetType;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Security\Http\Util\TargetPathTrait;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class SecurityController extends AbstractController
{
    use TargetPathTrait;

    /**
     * @Route("/inscription", name ="security_register")
     */
    public function register(Request $request, UserPasswordHasherInterface $passwordHasher, Token $token, MailRegister $sendMail, UserRepository $userRepo, ImageUploader $uploader): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('show_tricks');
        }

        $user = new User();
        $form = $this->createForm(RegistrationType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $image = $form->get('avatar')->getData();
            if ($image) {
                $imageName = $uploader->uploadAvatar($image);
                $user->setAvatar($imageName);
            }
            $hashedPassword = $passwordHasher->hashPassword(
                $user,
                $user->getPassword()
            );


            $user->setPassword($hashedPassword)
                ->setActived(false)
                ->setActiveToken($token->genToken())
                ->setCreatedAt(new \DateTimeImmutable());
            $userRepo->add($user);
            $sendMail->sendToken($user);
            $this->addFlash('success', 'Votre inscription a été bien prise en compte, veuillez valider votre compte en cliquant sur le lien qui vous a été envoyé par email !');

            return $this->redirectToRoute('show_tricks');
        }

        return $this->render('security/registration.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/login", name ="security_login")
     */

    public function login(AuthenticationUtils $authenticationUtils, Request $request): Response
    {

        if ($this->getUser()) {
            return $this->redirectToRoute('show_tricks');
        }
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();


        return $this->render(
            'security/login.html.twig',
            [
                'last_username' => $lastUsername,
                'error'         => $error,
            ]
        );
    }

    /**
     * @Route("/logout", name ="security_logout")
     */

    public function logout()
    {
        throw new \Exception('This should never be reached!');
    }

    /**
     * @Route("/activation/{token}", name ="active_compte")
     * @param string $token 
     * @param UserRepository $userRepository
     */
    public function isActived(UserRepository $userRepository, string $token): Response
    {
        $user = $userRepository->findOneBy(['activeToken' => $token]);
        if (!$user) {

            $this->addFlash('error', 'Ce token n\'est pas valide !');
            return $this->redirectToRoute('show_tricks');
        }


        if ($user->getActived() === true || $user->getActiveToken() !== $token) {

            $this->addFlash('error', 'Ce token n\'est plus valide !');
            return $this->redirectToRoute('show_tricks');
        }

        $user->setActived(true)
            ->setActiveToken(null);
        $userRepository->add($user);
        // $entityManager->persist($user);
        // $entityManager->flush();
        $this->addFlash('sucess', ' Félicitaion votre compte est actif, vous pouvez vous connecter et profiter des services !');
        return $this->redirectToRoute('show_tricks');
    }

    /**
     * @Route("/reset-password", name="reset_password")
     * @param UserRepository $userRepository
     */

    public function resetPassword(Request $request, UserRepository $userRepository, Token $token, ResetPassword $sendMail): Response
    {

        $form = $this->createForm(EmailType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $email = $request->get('email');
            $user = $userRepository->findOneBy(['email' => $email]);
            if (!$user) {
                $this->addFlash('error', ' Cet adresse email n\'existe pas !');
            } else {
                $user->setForgetPassToken($token->genToken());
                $userRepository->add($user);
                // $entityManager->flush();
                $sendMail->sendTokenPassword($user);
                $this->addFlash('success', ' Un email vous a été envoyé pour renitialiser votre mot de passe !');
                return $this->redirectToRoute('show_tricks');
            }
        }


        return $this->render(
            'security/check-mail.html.twig',
            [
                'form' => $form->createView(),
            ]

        );
    }


    /**
     * @Route("/nouveau-mot-de-passe/{token}", methods={"GET","POST"}, name ="new_password")
     * @param string $token 
     * @param UserRepository $userRepository
     */
    public function newPassword(Request $request, UserRepository $userRepository, string $token, UserPasswordHasherInterface $passwordHasher): Response
    {
        $user = $userRepository->findOneBy(['forgetPassToken' => $token]);
        $form = $this->createForm(PasswordResetType::class);
        $form->handleRequest($request);
        if (!$user) {

            $this->addFlash('error', 'Ce token n\'est pas valide !');
            return $this->redirectToRoute('show_tricks');
        }
        if ($user->getForgetPassToken() !== $token) {

            $this->addFlash('error', 'Ce token n\'est plus valide !');
            return $this->redirectToRoute('show_tricks');
        }

        if ($form->isSubmitted() && $form->isValid()) {

            $user->setPassword($passwordHasher->hashPassword($user, $form->get('password')->getData()));
            $user->setForgetPassToken(null);
            $userRepository->add($user);

            $this->addFlash('sucess', ' Votre mot de passe a été modifié, vous pouvez vous connectez !');
            return $this->redirectToRoute('show_tricks');
        }

        return $this->render(
            'security/new-password.html.twig',
            [
                'form' => $form->createView(),
            ]

        );
    }

    /**
     * @Route("/delete/{id}", name ="delete_user")
     */

    public function deleteUser(ImageUploader $remover, User $users, UserRepository $userRepo): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('show_tricks');
        }
        if ($users->getAvatar() !== null) {
            $remover->removeImage($users->getAvatar());
        }
        $userRepo->remove($users);
        $session = new Session();
        $session->invalidate();
        return $this->redirectToRoute('security_logout');
        $this->addFlash('success', 'Votre compte a été supprimé !');
    }
}
