<?php
declare(strict_types=1);

namespace App\Service;

use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mailer\Mailer;

class Mailer
{


    public function __construct()
    {
 
    }

    public function sendConfirmationMessage()
    {
        $transport = Transport::fromDsn('smtp://localhost');
$mailer = new Mailer($transport);
        $email = (new Email())
            ->from('anastasychizhik@gmail.com')
            ->to('katenok-nastja@mail.ru')
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject('Time for Symfony Mailer!')
            ->text('Sending emails is fun again!')
            ->html('<p>See Twig integration for better HTML integration!</p>');
       $this->mailer->send($email);

      


        // ...
    }
}
