<?php

namespace App\Controller\API;

use App\Repository\TipRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/search')]
class SearchController extends AbstractController
{
    #[Route('', name: 'api_search', methods: ['GET'])]
    public function search(Request $request, TipRepository $tr): Response
    {
        $isAjax = $request->isXMLHttpRequest();
        if (!$isAjax) return new Response('', 404);
        $q = $request->get('q');
        $tips = json_decode($this->json($tr->search($q), 200 , [], ['groups' => "data-astuces-search"])->getContent(), true);

        return $this->json(["code" => 200, "astuces" => $tips],200);
    }

    #[Route('/filter', name: 'api_search_filter', methods: ['GET'])]
    public function searchFilter(Request $request, TipRepository $tr): Response
    {
        // $isAjax = $request->isXMLHttpRequest();
        // if (!$isAjax) return new Response('', 404);

        $listTags = explode(",", $request->get("tags"));
        $skip = $request->get("skip");
        $fetch = $request->get("fetch");
        $tips = json_decode($this->json($tr->tipByTag($listTags, $skip, $fetch), 200 , [], ['groups' => "data-astuces-search-filter"])->getContent(), true);
        return $this->json(["code" => 200, "astuces" => $tips],200);
    }
}