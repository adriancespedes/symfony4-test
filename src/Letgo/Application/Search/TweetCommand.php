<?php

declare(strict_types=1);

namespace App\Letgo\Application\Search;

class TweetCommand
{
    private $username;
    private $numberOfTweets;
    private $tweetLimit;

    public function __construct($username, $numberOfTweets, $tweetLimit)
    {
        $this->username = $username;
        $this->numberOfTweets = $numberOfTweets;
        $this->tweetLimit = $tweetLimit;
    }

    public function username(): string
    {
        return $this->username;
    }

    public function numberOfTweets(): int
    {
        return $this->numberOfTweets;
    }

    public function tweetLimit(): int
    {
        return $this->tweetLimit;
    }

}