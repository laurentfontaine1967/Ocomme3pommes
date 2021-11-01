<?php

namespace App\Doctrine\Listener;

use App\Entity\User;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;


class CreateUserListener
{
    protected $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function prePersist(User $entity)
    {

        $email = (new TemplatedEmail())
            ->from($entity->getEmail())
            ->to($entity->getEmail())
            ->subject('Merci pour votre inscription')
            ->htmlTemplate('email/bienvenue.html.twig')
            ->context([
                'user' => $entity
            ]);

        $this->mailer->send($email);
    }
}