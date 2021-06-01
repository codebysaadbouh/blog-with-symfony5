<?php

namespace App\Controller;

use App\Form\RegisterType;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    private $manager;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @Route("/register", name="security_register")
     */
    public function register(Request $request, UserPasswordEncoderInterface $encoder): Response
    {
        $user = new User();
        $form = $this->createForm(RegisterType::class, $user);

        //Analyse de la requête par le formulaire
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $this->addFlash('success', 'Vous êtes enregister avec succès !');
            //Traitement des données recues du formulaire &  Hashage du password
            $password_hash = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($password_hash);
            $this->manager->persist($user);
            $this->manager->flush();
            return $this->redirectToRoute('login_user');
        }

        return $this->render('security/index.html.twig', [
            'controller_name' => 'Inscription',
            'form'=>$form->createView()
        ]);
    }

    /**
     * @Route("/login", name="login_user")
     */
    public function login(AuthenticationUtils $authenticationUtils) : Response {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUserName = $authenticationUtils->getLastUsername();

        if($this->isGranted('ROLE_USER') == true ) {
            return $this->redirectToRoute('home');
        }else {
            return $this->render('security/login.html.twig', [
                'error' => $error, 'lastUserName' => $lastUserName
            ]);
        }
    }

    /**
     * @Route("/logout", name="logout_user")
     */
    public function logout(){
    }
}
