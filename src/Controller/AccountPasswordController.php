<?php

namespace App\Controller;

use App\Form\ChangePasswordType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AccountPasswordController extends AbstractController
{
    private $entityManager;

    /**
     * AccountPasswordController constructor.
     * @param $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/compte/modifier-mon-mot-de-passe", name="account_password")
     */
    public function index(Request $request,UserPasswordEncoderInterface $encoder): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(ChangePasswordType::class, $user);

        $form->handleRequest($request);
        $notif = null;
        if($form->isSubmitted() && $form->isValid()){
            $oldPasswd = $form->get('old_password')->getData();
            if($encoder->isPasswordValid($user, $oldPasswd)){
                $newPasswd = $encoder->encodePassword($user, $form->get('new_password')->getData());
                $user->setPassword($newPasswd);

                $this->entityManager->persist($user);
                $this->entityManager->flush();
                $notif = "Mot de passe bien mis à jour";
            }
            else{
                $notif = "Mot de passe actuel incorrect";
            }
        }
        return $this->render('account/password.html.twig', ['form' => $form->createView(), 'notif' => $notif]);
    }
}
