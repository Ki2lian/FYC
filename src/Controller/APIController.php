<?php

namespace App\Controller;

use App\Repository\CommentRepository;
use App\Repository\RatingRepository;
use App\Repository\TagRepository;
use App\Repository\TipRepository;
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
        return $user === null ? $this->json(["code" => 404, "message" => "L'utilisateur n'a pas été trouvé"]) : $this->json($user, 200, [], ['groups' => "data-user"]);
    }

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
