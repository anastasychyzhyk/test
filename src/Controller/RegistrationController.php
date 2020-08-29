<?php
declare(strict_types=1);

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Service\CodeGenerator;
use App\Service\Mailerr;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/registration", name="registration")
     */
    public function index(Request $request, UserPasswordEncoderInterface $passwordEncoder, CodeGenerator $codeGenerator, Mailerr $mailer)
    {
        $user = new User();
        $form = $this->createForm(RegistrationType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            $password = $passwordEncoder->encodePassword(
                $user,
                $user->getPassword()
            );
            $user->setPassword($password);
            $user->setConfirmationCode($codeGenerator->getConfirmationCode());
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            $mailer->sendConfirmationMessage('katenok-nastja@mail.ru', 'Registration', $user);
            //return $this->redirectToRoute('app_login');
        }
        return $this->render('registration/index.html.twig', [
            'controller_name' => 'RegistrationController','form' => $form->createView()
        ]);
    }
}
