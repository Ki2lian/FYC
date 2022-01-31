<?php

namespace App\Controller\API;

use App\Form\EditAccountType;
use App\Repository\UserRepository;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/user')]
class UserController extends AbstractController
{
    #[Route('s/{token}/{skip}/{fetch}', name: 'api_users_all_params', methods: ['GET'])]
    #[Route('s/{token}/{skip}', name: 'api_users_skip_param', methods: ['GET'])]
    #[Route('s/{token}', name: 'api_users_no_params', methods: ['GET'])]
    public function users(UserRepository $ur, string $token, $skip = 0, $fetch = 10): Response
    {
        if ($skip < 0 || $fetch <= 0) return $this->json(["code" => 400, "message" => "Bad request"], 400);
        if ($token === $_ENV['API_TOKEN']) return $this->json($ur->findBy(array(), array('id' => 'DESC'), $fetch, $skip), 200, [], ['groups' => "data-user"]);
        return $this->json(["code" => 403, "message" => "Access Denied"], 403);
    }

    #[Route('/{token}/{id}', name: 'api_user', methods: ['GET'])]
    public function user(UserRepository $ur, string $token, $id = 0): Response
    {
        if ($token !== $_ENV['API_TOKEN']) return $this->json(["code" => 403, "message" => "Access Denied"], 403);
        $user = $ur->find($id);
        return $user === null ? $this->json(["code" => 404, "message" => "L'utilisateur n'a pas été trouvé"]) : $this->json($user, 200, [], ['groups' => "data-user"]);
    }

    #[Route('', name: 'api_edit_user', methods: ['PUT'])]
    public function editUser(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager, UserRepository $ur): Response
    {
        $isAjax = $request->isXMLHttpRequest();
        if (!$isAjax) return new Response('', 404);

        // $user = $this->getUser();

        // pour postman
        // $user = $ur->find(1);
        $user = $this->getUser();
        $form = $this->createForm(EditAccountType::class, $user, array('method' => 'PUT'));
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $match = $userPasswordHasher->isPasswordValid($user, $form->get('plainPassword')->getData());
            if($match){
                $user->setUpdatedAt(new \DateTime());
                try{
                    $entityManager->flush();
                }catch(UniqueConstraintViolationException $e){
                    return $this->json(array(
                        "code" => 200,
                        "errors" => array(
                            array(
                                "message" => "Il y a déjà un compte avec ce pseudo"
                            )
                        ),
                    ),200);
                }
                return $this->json(array(
                    "code" => 200,
                    "message" => "Vos informations ont été modifié",
                    "info" => array(
                        'pseudo' => $user->getPseudo(),
                    )
                ),200);
            }
            return $this->json(array(
                "code" => 200,
                "errors" => array(
                    array(
                        "message" => "Mot de passe incorrect"
                    )
                )
            ),200);
        }

        return $this->json(array(
            "code" => 200,
            "errors" => $form->getErrors()
        ),200);
    }
}