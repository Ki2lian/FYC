<?php

namespace App\Controller\API;

use App\Repository\TipRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/tip')]
class TipController extends AbstractController
{
    #[Route('s/{token}/{skip}/{fetch}', name: 'api_tips_all_params', methods: ['GET'])]
    #[Route('s/{token}/{skip}', name: 'api_tips_skip_param', methods: ['GET'])]
    #[Route('s/{token}', name: 'api_tips_no_params', methods: ['GET'])]
    public function tips(TipRepository $tr, string $token, $skip = 0, $fetch = 10): Response
    {
        if ($skip < 0 || $fetch <= 0) return $this->json(["code" => 400, "message" => "Bad request"], 400);
        if ($token === $_ENV['API_TOKEN']) return $this->json($tr->findBy(array(), array('id' => 'DESC'), $fetch, $skip), 200, [], ['groups' => "data-tip"]);
        return $this->json(["code" => 403, "message" => "Access Denied"], 403);
    }

    #[Route('/{token}/{id}', name: 'api_tip', methods: ['GET'])]
    public function tip(TipRepository $tr, string $token, $id = 0): Response
    {
        if ($token !== $_ENV['API_TOKEN']) return $this->json(["code" => 403, "message" => "Access Denied"], 403);
        $tip = $tr->find($id);
        return $tip === null ? $this->json(["code" => 404, "message" => "L'astuce n'a pas été trouvé"]) : $this->json($tip, 200, [], ['groups' => "data-tip"]);
    }
}