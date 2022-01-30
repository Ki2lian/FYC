<?php

namespace App\Controller\API;

use App\Entity\Rating;
use App\Entity\Tip;
use App\Form\RatingType;
use App\Repository\RatingRepository;
use App\Repository\TipRepository;
use App\Repository\UserRepository;
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

    #[Route('', name: 'api_add_rate', methods: ['POST'])]
    public function addRate(EntityManagerInterface $entityManager, Request $request, TipRepository $tipr, UserRepository $ur): Response
    {
        
        
        // $isAjax = $request->isXMLHttpRequest();
        // if (!$isAjax) return new Response('', 404);

        $rate = new Rating();
        $form = $this->createForm(RatingType::class, $rate);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $tip = $tipr->find($request->get("id"));
            if($tip == null) {
                return $this->json(array(
                    "code" => 404,
                    "errors" => "La note n'a pas été ajouté car l'astuce n'existe pas ou n'existe plus"
                ),404); 
            }
            $rate->setTip($tip);
            //$rate->setUser($this->getUser());

            //Pour postman:
            $rate->setUser($ur->find($request->get('id_user')));
            
            $note = $tip->getRatings();
            foreach($note as $n){
                $user = $n->getUser();
                if($ur->find($request->get('id_user') == $user->getId())){
                    return $this->json(array(
                        "code" => 404,
                        "errors" => "La note n'a pas été ajouté car l'utilisateur à déjà noté cette astuce'"
                    ),404); 
                }
            }

            $entityManager->persist($rate);
            $entityManager->flush();
            return $this->json([
                "code" => 200, 
                "message" => "Note ajouté",
                "info" => array(
                    "id" => $rate->getId(),
                    "value" => $rate->getValue(),
                    "createdAt" => $rate->getCreatedAt()
                )
            ], 200);
        }
        return $this->json(array(
            "code" => 200,
            "errors" => $form->getErrors()
        ),200);
    }
}