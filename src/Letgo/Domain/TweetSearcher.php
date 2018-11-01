<?php

declare(strict_types=1);

namespace App\Letgo\Domain;

class TweetSearcher
{
    private $repository;

    public function __construct(TweetRepository $repository)
    {
        $this->repository = $repository;
    }

    public function searchByUserName(string $username, int $limit): Tweets
    {
        $tweets = $this->repository->searchByUserName($username, $limit);

        return $tweets;
    }
}