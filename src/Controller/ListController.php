<?php
declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Form\ListType;
use App\Repository\UserRepository;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;


class ListController extends AbstractController
{
	    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @Route("/list", name="list")
     */
    public function index(Request $request)
    {
        $form = $this->createForm(ListType::class);
        $form->handleRequest($request);
		return $this->render('list/index.html.twig', ['form' => $form->createView(), 'users' => $this->userRepository->findAll(),]);
    }
	
	public function processRequestAndCheckLogout(Request $request)
	{		
		$needRedirectToLogin=false;
		foreach($_POST['checkbox'] as $email) {
		    $this->checkRequestTypeAndDo($email);
            $needRedirectToLogin = $needRedirectToLogin || $this->checkAndLogout($request);
		}				
		return $needRedirectToLogin;
	}
	
	public function checkRequestTypeAndDo(string $email)
	{		
		$user = $this->userRepository->findOneBy(['email' => $email]);		
		if(isset($_POST['unblock'])) $this->userRepository->unblockUser($user);				
		else if(isset($_POST['delete'])) $this->userRepository->deleteUser($user);
		else if(isset($_POST['block'])) $this->userRepository->blockUser($user); 					
	}
	
	public function checkAndLogout(Request $request)
	{	
        if(!$this->userRepository->findOneBy(['email' => $request->getSession()->get(Security::LAST_USERNAME, '')])->IsActive()) {
			echo $request->getSession()->get(Security::LAST_USERNAME, '');
		    $this->container->get('security.token_storage')->setToken(null);
		    return true;
	    }	
		else return false;
	}	
}

