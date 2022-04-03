<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Faker\Factory;

class AccountController extends AbstractController
{
    #[Route('/login', name: 'login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('account/login.html.twig', [
            'last_username' => $lastUsername,
            'error'         => $error,
        ]);
    }

    #[Route('/account', name: 'account')]
    public function account(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager, AuthenticationUtils $authenticationUtils): Response
    {
        if(!$this->getUser()){
            $user = new User();
            $form = $this->createForm(RegistrationFormType::class, $user);
            $form->handleRequest($request);

            $faker = Factory::create('fr_FR');
            $pseudo = $faker->userName();
            $password = $faker->password(8);
            $registrationForm = $this->renderView('form/register.html.twig', [
                'form' => $form->createView(),
                'pseudo' => $pseudo,
                'email' => "$pseudo@fyc.fr",
                'password' => $password
            ]);

    
            // get the login error if there is one
            $error = $authenticationUtils->getLastAuthenticationError();
    
            // last username entered by the user
            $lastUsername = $authenticationUtils->getLastUsername();
            if ($form->isSubmitted() && $form->isValid()) {
                // encode the plain password
                $user->setPassword(
                $userPasswordHasher->hashPassword(
                        $user,
                        $form->get('plainPassword')->getData()
                    )
                );
    
                $entityManager->persist($user);
                $entityManager->flush();
                // do anything else you need here, like send an email
    
                return $this->redirectToRoute('account');
            }
    
            return $this->render('account/account_not_logged.html.twig', [
                'registrationForm' => $registrationForm,
                'last_username' => $lastUsername,
                'error'         => $error,
                'email' => "$pseudo@fyc.fr",
                'password' => $password
            ]);
        }
        return $this->render('account/account_logged.html.twig', [
        ]);
    }

    #[Route('/logout', name: 'logout', methods: ['GET'])]
    public function logout()
    {
        // controller can be blank: it will never be called!
        throw new \Exception('Don\'t forget to activate logout in security.yaml');
    }
}
