<?php

declare(strict_types=1);

namespace App\Letgo\Domain;

use ArrayIterator;
use IteratorAggregate;

class Tweets implements IteratorAggregate
{
    private $tweets;

    public function __construct(array $tweets)
    {
        $this->tweets = $tweets;
    }

    public function getIterator()
    {
        return new ArrayIterator($this->tweets);
    }

    public function shoutAllTweets()
    {
        $tweetsShouted = [];
        foreach ($this->tweets as $tweet) {
            /* @var $tweet Tweet */
            $tweetsShouted[] = $tweet->shout();
        }
        return new ArrayIterator($tweetsShouted);
    }
}
