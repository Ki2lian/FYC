<?php

namespace App\Controller\API;

use App\Entity\Comment;
use App\Form\CommentType;
use App\Repository\CommentRepository;
use App\Repository\TipRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/comment')]
class CommentController extends AbstractController
{
    #[Route('s/{token}/{skip}/{fetch}', name: 'api_comments_all_params', methods: ['GET'])]
    #[Route('s/{token}/{skip}', name: 'api_comments_skip_param', methods: ['GET'])]
    #[Route('s/{token}', name: 'api_comments_no_params', methods: ['GET'])]
    public function comments(CommentRepository $cr, string $token, $skip = 0, $fetch = 10): Response
    {
        if ($skip < 0 || $fetch <= 0) return $this->json(["code" => 400, "message" => "Bad request"], 400);
        if ($token === $_ENV['API_TOKEN']) return $this->json($cr->findBy(array(), array('id' => 'DESC'), $fetch, $skip), 200, [], ['groups' => "data-comment"]);
        return $this->json(["code" => 403, "message" => "Access Denied"], 403);
    }

    #[Route('/{token}/{id}', name: 'api_comment', methods: ['GET'])]
    public function comment(CommentRepository $cr, string $token, $id = 0): Response
    {
        if ($token !== $_ENV['API_TOKEN']) return $this->json(["code" => 403, "message" => "Access Denied"], 403);
        $comment = $cr->find($id);
        return $comment === null ? $this->json(["code" => 404, "message" => "Le commentaire n'a pas été trouvé"]) : $this->json($comment, 200, [], ['groups' => "data-comment"]);
    }

    #[Route('', name: 'api_add_comment', methods: ['POST'])]
    public function addComment(EntityManagerInterface $entityManager, Request $request, TipRepository $tipr, UserRepository $ur): Response
    {
        // $isAjax = $request->isXMLHttpRequest();
        // if (!$isAjax) return new Response('', 404);

        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $tip = $tipr->find($request->get("id"));
            if($tip == null) {
                return $this->json(array(
                    "code" => 404,
                    "errors" => "Le commentaire n'a pas été ajouté car l'astuce n'existe pas ou n'existe plus"
                ),404); 
            }
            $comment->setTip($tip);
            $comment->setUser($this->getUser());

            $comment->setUser($ur->find($request->get('id_user')));


            $entityManager->persist($comment);
            $entityManager->flush();
            return $this->json([
                "code" => 200, 
                "message" => "Commentaire ajouté",
                "info" => array(
                    "id" => $comment->getId(),
                    "content" => $comment->getContent(),
                    "createdAt" => $comment->getCreatedAt()
                )
            ], 200);
        }
        return $this->json(array(
            "code" => 200,
            "errors" => $form->getErrors()
        ),200);
    }

    #[Route('', name: 'api_edit_comment', methods: ['PUT'])]
    public function editComment(EntityManagerInterface $entityManager, Request $request, CommentRepository $cr): Response
    {
        $isAjax = $request->isXMLHttpRequest();
        if (!$isAjax) return new Response('', 404);
        $comment = $cr->find($request->get('id'));

        if($comment === null){
            return $this->json([
                "code" => 404,
                "message" => "Commentaire non trouvé, id manquant ou id inexistant"
            ], 404);
        }

        $form = $this->createForm(CommentType::class, $comment, array('method' => 'PUT'));
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $comment->setUpdatedAt(new \DateTime());
            $entityManager->flush();
            return $this->json([
                "code" => 200,
                "message" => "Commentaire modifié",
                "info" => array(
                    "content" => $comment->getContent(),
                    "updatedAt" => $comment->getUpdatedAt()
                )
            ], 200);
        }
        return $this->json(array(
            "code" => 200,
            "errors" => $form->getErrors()
        ),200);
    }

    #[Route('', name: 'api_delete_comment', methods: ['DELETE'])]
    public function deleteComment(EntityManagerInterface $entityManager, Request $request, CommentRepository $cr): Response
    {
        $isAjax = $request->isXMLHttpRequest();
        if (!$isAjax) return new Response('', 404);

        $comment = $cr->find($request->get('id'));
        if($comment === null){
            return $this->json([
                "code" => 404,
                "message" => "Commentaire non trouvé, id manquant ou id inexistant"
            ], 404);
        }
        $entityManager->remove($comment);
        $entityManager->flush();
        return $this->json([
            "code" => 200,
            "message" => "Commentaire supprimé"
        ], 200);
    }
}