<?php

namespace App\Controller\API;

use App\Repository\CommentRepository;
use App\Repository\TagRepository;
use App\Repository\TipRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/backoffice')]
class BackofficeController extends AbstractController
{
    #[Route('', name: 'api_user_nb_all', methods: ['GET'])]
    public function backofficeData(UserRepository $ur, TipRepository $tr, TagRepository $tagr, CommentRepository $cr): Response
    {
        $lastUsers = $this->forward('App\Controller\API\UserController::users', [
            'token' => $_ENV['API_TOKEN'],
            'skip' => 0,
            'fetch' => 10
        ]);
        $tipsMonth = $tr->getTipsPostedByMonth();
        $temp = [];
        for ($i=0; $i < 12; $i++) {
            $temp[$i]["MONTH"] = $i+1;
            $temp[$i]["COUNT"] = 0;
        }
        foreach ($tipsMonth as $key => $tip) {
            $temp[$tip["MONTH"] - 1]["COUNT"] = $tip["COUNT"];
        }
        $tipsMonth = $temp;

        return $this->json(
            array(
                "users" => array(
                    "nb_users" => $ur->count([]),
                    "nb_owner_tips" => $tr->getNbOfOwnerTip(),
                    "last_users" => json_decode($lastUsers->getContent(), true),
                    
                ),
                "tips" => array(
                    "nb_tips" => $tr->count([]),
                    "nb_tips_valid" => $tr->count(['isValid' => true]),
                    "nb_tips_invalid" => $tr->count(['isValid' => false]),
                    "tips_posted_by_month" => $tipsMonth,
                    
                ),
                "tags" => array(
                    "nb_tags" => $tagr->count([]),
                ),
                "comments" => array(
                    "nb_comments" => $cr->count([]),
                )
            ),
            200,[]
        );
    }

    #[Route('/valid_tip', name: 'api_valid_tip', methods: ['POST'])]
    public function validTip(Request $request, TipRepository $tr, EntityManagerInterface $em): Response
    {
        $isAjax = $request->isXMLHttpRequest();
        if (!$isAjax) return new Response('', 404);
        
        $tip = $tr->find($request->get('id'));
        $isValid = filter_var($request->get('isValid'), FILTER_VALIDATE_BOOLEAN);

        $message = "Astuce validée";

        if($tip === null){
            return $this->json([
                "code" => 404,
                "message" => "Astuce non trouvée, id manquant ou id inexistant"
            ], 404);
        }
        $tip->setIsValid($isValid);
        $em->flush();

        if(!$isValid) $message = "Astuce invalidée";

        return $this->json([
            "code" => 200,
            "message" => $message,
            "info" => array(
                "title" => $tip->getTitle()
            )
        ], 200);
    }
}