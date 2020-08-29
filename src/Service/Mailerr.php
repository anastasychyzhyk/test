<?php
declare(strict_types=1);

namespace App\Service;

use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;


class Mailerr
{
	  private MailerInterface $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer=$mailer;
    }

    public function sendConfirmationMessage(string $sendTo, string $subject, User $user)
    {
        $email = (new Email())
            ->from('katenok-nastja@mail.ru')
            ->to($sendTo)
            ->subject($subject)
			->htmlTemplate('email/confirmation.html.twig', ['user'=>$user]);
        try {
            $this->mailer->send($email);
        } catch (TransportExceptionInterface $e) {
           echo $e->getDebug();
        }

        // ...
    }
	}
