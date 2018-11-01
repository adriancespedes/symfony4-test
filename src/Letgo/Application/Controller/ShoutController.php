<?php

namespace App\Letgo\Application\Controller;

use App\Letgo\Infrastructure\TweetRepositoryInMemory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

final class ShoutController extends AbstractController
{
    public function index(TweetRepositoryInMemory $repo, Request $request, $twitterName)
    {
        return JsonResponse::create();
    }
}
