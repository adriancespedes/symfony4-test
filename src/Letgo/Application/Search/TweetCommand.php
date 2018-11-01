<?php

declare(strict_types=1);

namespace App\Letgo\Application\Search;

class TweetCommand
{
    private $username;
    private $numberOfTweets;

    public function __construct($username, $numberOfTweets)
    {
        $this->username = $username;
        $this->numberOfTweets = $numberOfTweets;
    }

    public function username(): string
    {
        return $this->username;
    }

    public function numberOfTweets(): int
    {
        return $this->numberOfTweets;
    }

}