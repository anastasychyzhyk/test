<?php
declare(strict_types=1);

namespace App\Service;
use App\Entity\User;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mime\Address;

class Mailerr
{
	  private MailerInterface $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer=$mailer;
    }

    public function sendConfirmationMessage(string $sendTo, string $subject, User $user)
    {
        $email = (new TemplatedEmail())
            ->from(new Address('quiz-mailer@mail.ru', 'Quiz'))
            ->to($sendTo)
            ->subject($subject)
			->htmlTemplate('email/confirmation.html.twig', ['user'=>$user])
			->context(['user'=>$user,])
			->getHeaders()->addTextHeader('X-Auto-Response-Suppress', 'OOF, DR, RN, NRN, AutoReply');
        try {
            $this->mailer->send($email);
        } catch (TransportExceptionInterface $e) {
           echo $e->getDebug();
        }

        // ...
    }
	}
