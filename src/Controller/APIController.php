<?php

namespace App\Controller;

use App\Entity\Tag;
use App\Form\TagType;
use App\Repository\CommentRepository;
use App\Repository\RatingRepository;
use App\Repository\TagRepository;
use App\Repository\TipRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api')]
class APIController extends AbstractController
{
    /**
     * User
     */
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
        return $user === null ? $this->json(["code" => 404, "message" => "L'utilisateur n'a pas été trouvé"]) : $this->json($user, 200, [], ['groups' => "data-user"]);
    }

    /**
     * Tip
     */
    #[Route('/tips/{token}/{skip}/{fetch}', name: 'api_tips_all_params', methods: ['GET'])]
    #[Route('/tips/{token}/{skip}', name: 'api_tips_skip_param', methods: ['GET'])]
    #[Route('/tips/{token}', name: 'api_tips_no_params', methods: ['GET'])]
    public function tips(TipRepository $tr, string $token, $skip = 0, $fetch = 10): Response
    {
        if ($skip < 0 || $fetch <= 0) return $this->json(["code" => 400, "message" => "Bad request"], 400);
        if ($token === $_ENV['API_TOKEN']) return $this->json($tr->findBy(array(), array('id' => 'DESC'), $fetch, $skip), 200, [], ['groups' => "data-tip"]);
        return $this->json(["code" => 403, "message" => "Access Denied"], 403);
    }

    #[Route('/tip/{token}/{id}', name: 'api_tip', methods: ['GET'])]
    public function tip(TipRepository $tr, string $token, $id = 0): Response
    {
        if ($token !== $_ENV['API_TOKEN']) return $this->json(["code" => 403, "message" => "Access Denied"], 403);
        $tip = $tr->find($id);
        return $tip === null ? $this->json(["code" => 404, "message" => "L'astuce n'a pas été trouvé"]) : $this->json($tip, 200, [], ['groups' => "data-tip"]);
    }

    /**
     * Tag
     */

    #[Route('/tags/{token}/{skip}/{fetch}', name: 'api_tags_all_params', methods: ['GET'])]
    #[Route('/tags/{token}/{skip}', name: 'api_tags_skip_param', methods: ['GET'])]
    #[Route('/tags/{token}', name: 'api_tags_no_params', methods: ['GET'])]
    public function tags(TagRepository $tr, string $token, $skip = 0, $fetch = 10): Response
    {
        if ($skip < 0 || $fetch <= 0) return $this->json(["code" => 400, "message" => "Bad request"], 400);
        if ($token === $_ENV['API_TOKEN']) return $this->json($tr->findBy(array(), array('id' => 'DESC'), $fetch, $skip), 200, [], ['groups' => "data-tag"]);
        return $this->json(["code" => 403, "message" => "Access Denied"], 403);
    }

    #[Route('/tag/{token}/{id}', name: 'api_tag', methods: ['GET'])]
    public function tag(TagRepository $tr, string $token, $id = 0): Response
    {
        if ($token !== $_ENV['API_TOKEN']) return $this->json(["code" => 403, "message" => "Access Denied"], 403);
        $tag = $tr->find($id);
        return $tag === null ? $this->json(["code" => 404, "message" => "L'astuce n'a pas été trouvé"]) : $this->json($tag, 200, [], ['groups' => "data-tag"]);
    }

    #[Route('/tag', name: 'api_add_tag', methods: ['POST'])]
    public function addTag(EntityManagerInterface $entityManager, Request $request): Response
    {
        $isAjax = $request->isXMLHttpRequest();
        if (!$isAjax) return new Response('', 404);
        $tag = new Tag();
        $form = $this->createForm(TagType::class, $tag);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $entityManager->persist($tag);
            $entityManager->flush();
            return $this->json([
                "code" => 200, 
                "message" => "Tag ajouté",
                "info" => array(
                    "id" => $tag->getId(),
                    "name" => $tag->getName()
                )
            ], 200);
        }
        return $this->json(array(
            "code" => 200,
            "errors" => $form->getErrors()
        ),200);
    }

    #[Route('/tag', name: 'api_edit_tag', methods: ['PUT'])]
    public function editTag(EntityManagerInterface $entityManager, Request $request, TagRepository $tr): Response
    {
        $isAjax = $request->isXMLHttpRequest();
        if (!$isAjax) return new Response('', 404);

        $tag = $tr->find($request->get('id'));
    
        $form = $this->createForm(TagType::class, $tag, array('method' => 'PUT'));
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $tag->setUpdatedAt(new \DateTime());
            $entityManager->flush();
            return $this->json([
                "code" => 200,
                "message" => "Tag modifié",
                "info" => array(
                    "name" => $tag->getName()
                )
            ], 200);
        }
        return $this->json(array(
            "code" => 200,
            "errors" => $form->getErrors()
        ),200);
    }

    #[Route('/tag', name: 'api_delete_tag', methods: ['DELETE'])]
    public function deleteTag(EntityManagerInterface $entityManager, Request $request, TagRepository $tr): Response
    {
        $isAjax = $request->isXMLHttpRequest();
        if (!$isAjax) return new Response('', 404);

        $tag = $tr->find($request->get('id'));
        if($tag === null){
            return $this->json([
                "code" => 404,
                "message" => "Tag non trouvé, id manquant ou id inexistant"
            ], 404);
        }
    

        $entityManager->remove($tag);
        $entityManager->flush();
        return $this->json([
            "code" => 200,
            "message" => "Tag supprimé"
        ], 200);
    }

    /**
     * Comment
     */

    #[Route('/comments/{token}/{skip}/{fetch}', name: 'api_comments_all_params', methods: ['GET'])]
    #[Route('/comments/{token}/{skip}', name: 'api_comments_skip_param', methods: ['GET'])]
    #[Route('/comments/{token}', name: 'api_comments_no_params', methods: ['GET'])]
    public function comments(CommentRepository $cr, string $token, $skip = 0, $fetch = 10): Response
    {
        if ($skip < 0 || $fetch <= 0) return $this->json(["code" => 400, "message" => "Bad request"], 400);
        if ($token === $_ENV['API_TOKEN']) return $this->json($cr->findBy(array(), array('id' => 'DESC'), $fetch, $skip), 200, [], ['groups' => "data-comment"]);
        return $this->json(["code" => 403, "message" => "Access Denied"], 403);
    }

    #[Route('/comment/{token}/{id}', name: 'api_comment', methods: ['GET'])]
    public function comment(CommentRepository $cr, string $token, $id = 0): Response
    {
        if ($token !== $_ENV['API_TOKEN']) return $this->json(["code" => 403, "message" => "Access Denied"], 403);
        $comment = $cr->find($id);
        return $comment === null ? $this->json(["code" => 404, "message" => "L'astuce n'a pas été trouvé"]) : $this->json($comment, 200, [], ['groups' => "data-comment"]);
    }

    /**
     * Ratings
     */

    #[Route('/ratings/{token}/{skip}/{fetch}', name: 'api_ratings_all_params', methods: ['GET'])]
    #[Route('/ratings/{token}/{skip}', name: 'api_ratings_skip_param', methods: ['GET'])]
    #[Route('/ratings/{token}', name: 'api_ratings_no_params', methods: ['GET'])]
    public function ratings(RatingRepository $rr, string $token, $skip = 0, $fetch = 10): Response
    {
        if ($skip < 0 || $fetch <= 0) return $this->json(["code" => 400, "message" => "Bad request"], 400);
        if ($token === $_ENV['API_TOKEN']) return $this->json($rr->findBy(array(), array('id' => 'DESC'), $fetch, $skip), 200, [], ['groups' => "data-rating"]);
        return $this->json(["code" => 403, "message" => "Access Denied"], 403);
    }

    #[Route('/rating/{token}/{id}', name: 'api_rating', methods: ['GET'])]
    public function rating(RatingRepository $rr, string $token, $id = 0): Response
    {
        if ($token !== $_ENV['API_TOKEN']) return $this->json(["code" => 403, "message" => "Access Denied"], 403);
        $rating = $rr->find($id);
        return $rating === null ? $this->json(["code" => 404, "message" => "L'astuce n'a pas été trouvé"]) : $this->json($rating, 200, [], ['groups' => "data-rating"]);
    }

}
