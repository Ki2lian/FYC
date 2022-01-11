<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api')]
class APIController extends AbstractController
{
    #[Route('/users/{token}/{skip}/{fetch}', name: 'api_users_all_params', methods: ['GET'])]
    #[Route('/users/{token}/{skip}', name: 'api_users_skip_param', methods: ['GET'])]
    #[Route('/users/{token}', name: 'api_users_no_params', methods: ['GET'])]
    public function users(UserRepository $ur, string $token, $skip = 0, $fetch = 10): Response
    {
        if ($skip < 0 || $fetch <= 0) return $this->json(["code" => 400, "message" => "Bad request"], 400);
        if ($token === $_ENV['API_TOKEN']) return $this->json($ur->findBy(array(), array('id' => 'DESC'), $fetch, $skip), 200, [], ['groups' => "data-user"]);
        return $this->json(["code" => 403, "message" => "Access Denied"], 403);
    }

    #[Route('/user/{token}/{id}', name: 'api_user', methods: ['GET'])]
    public function user(UserRepository $ur, string $token, $id = 0): Response
    {
        if ($token !== $_ENV['API_TOKEN']) return $this->json(["code" => 403, "message" => "Access Denied"], 403);
        $user = $ur->find($id);
        return $user === null ? $this->json(["code" => 404, "message" => "User not found"]) : $this->json($user, 200, [], ['groups' => "data-user"]);
    }
}
