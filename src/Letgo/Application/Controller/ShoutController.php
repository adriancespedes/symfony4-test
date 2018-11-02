<?php

declare(strict_types=1);

namespace App\Letgo\Application\Controller;

use App\Letgo\Application\Search\TweetCommand;
use App\Letgo\Application\Search\TweetCommandHandler;
use App\Letgo\Domain\TweetSearcher;
use App\Letgo\Infrastructure\TweetPsr6Cache;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

final class ShoutController extends AbstractController
{

    public function index(TweetPsr6Cache $psr6Cache, Request $request, $twitterName)
    {
        $limit = (int)$request->get('limit');

        $tweetSearcher = new TweetSearcher($psr6Cache);

        $tweetCommand = new TweetCommand($twitterName, $limit, $this->getParameter('tweet_limit'));
        $tweetCommandHandler = new TweetCommandHandler($tweetSearcher);
        $response = $tweetCommandHandler->handle($tweetCommand);

        return JsonResponse::create($response);
    }
}
