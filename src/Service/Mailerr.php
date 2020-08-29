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

    public function sendConfirmationMessage()
    {
        $email = (new Email())
            ->from('katenok-nastja@mail.ru')
            ->to('katenok-nastja@mail.ru')
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject('45345345Time for Symfony Mailer!')
            ->text('234234234Sending emails is fun again!')
            ->html('<p>See Twig integration for better HTML integration!</p>');
        try {
            $this->mailer->send($email);
        } catch (TransportExceptionInterface $e) {
           echo $e->getDebug();
        }

        // ...
    }
	}
