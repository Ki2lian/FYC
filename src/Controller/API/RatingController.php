<?php

namespace App\Controller\API;

use App\Repository\RatingRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/rating')]
class RatingController extends AbstractController
{
    #[Route('s/{token}/{skip}/{fetch}', name: 'api_ratings_all_params', methods: ['GET'])]
    #[Route('s/{token}/{skip}', name: 'api_ratings_skip_param', methods: ['GET'])]
    #[Route('s/{token}', name: 'api_ratings_no_params', methods: ['GET'])]
    public function ratings(RatingRepository $rr, string $token, $skip = 0, $fetch = 10): Response
    {
        if ($skip < 0 || $fetch <= 0) return $this->json(["code" => 400, "message" => "Bad request"], 400);
        if ($token === $_ENV['API_TOKEN']) return $this->json($rr->findBy(array(), array('id' => 'DESC'), $fetch, $skip), 200, [], ['groups' => "data-rating"]);
        return $this->json(["code" => 403, "message" => "Access Denied"], 403);
    }

    #[Route('/{token}/{id}', name: 'api_rating', methods: ['GET'])]
    public function rating(RatingRepository $rr, string $token, $id = 0): Response
    {
        if ($token !== $_ENV['API_TOKEN']) return $this->json(["code" => 403, "message" => "Access Denied"], 403);
        $rating = $rr->find($id);
        return $rating === null ? $this->json(["code" => 404, "message" => "La note n'a pas été trouvé"]) : $this->json($rating, 200, [], ['groups' => "data-rating"]);
    }
}