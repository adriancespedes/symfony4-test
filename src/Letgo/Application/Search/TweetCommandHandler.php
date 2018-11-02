<?php

declare(strict_types=1);

namespace App\Letgo\Application\Search;

use App\Letgo\Domain\TweetNotFoundException;
use App\Letgo\Domain\TweetSearcher;

class TweetCommandHandler
{
    private $tweetSearcher;

    public function __construct(TweetSearcher $tweetSearcher)
    {
        $this->tweetSearcher = $tweetSearcher;
    }

    public function __invoke(TweetCommand $tweetCommand)
    {
        $username = $tweetCommand->username();
        $numberOfTweets = $tweetCommand->numberOfTweets();
        $tweetLimit = $tweetCommand->tweetLimit();

        if ($tweetLimit < $numberOfTweets || 1 > $numberOfTweets) {
            throw new \InvalidArgumentException(sprintf('limit must be between 1 and %d', $tweetLimit));
        }

        $tweets = $this->tweetSearcher->searchByUserName($username, $numberOfTweets);

        if (null === $tweets) {
            throw new TweetNotFoundException();
        }

        return $tweets->shoutAllTweets();
    }

}