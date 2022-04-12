<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\User;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MailRegister extends AbstractController
{
    private MailerInterface $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function sendToken(User $user)
    {

        $email = (new TemplatedEmail())
            ->From('snowtrick@contact.fr')
            ->To($user->getEmail())
            ->htmlTemplate('email/registration.html.twig')
            ->context([
                'token' => $user->getActiveToken(),
                'pseudo' => $user->getPseudo(),
            ]);


        $this->mailer->send($email);
    }
}
