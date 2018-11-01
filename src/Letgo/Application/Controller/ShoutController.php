<?php

declare(strict_types=1);

namespace App\Letgo\Application\Controller;

use App\Letgo\Application\Search\TweetCommand;
use App\Letgo\Application\Search\TweetCommandHandler;
use App\Letgo\Domain\TweetSearcher;
use App\Letgo\Infrastructure\TweetRepositoryInMemory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

final class ShoutController extends AbstractController
{
    public function index(TweetRepositoryInMemory $repo, Request $request, $twitterName)
    {
        $tweetSearcher = new TweetSearcher($repo);

        $tweetCommand = new TweetCommand($twitterName, $this->getParameter('tweet_limit'));
        $tweetCommandHandler = new TweetCommandHandler($tweetSearcher);
        $response = $tweetCommandHandler->handle($tweetCommand);

        return JsonResponse::create($response);
    }
}
