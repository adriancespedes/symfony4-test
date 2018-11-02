<?php

declare(strict_types=1);

namespace App\Tests\Letgo\Application\Search;

use App\Letgo\Application\Search\TweetCommand;
use App\Letgo\Application\Search\TweetCommandHandler;
use App\Letgo\Domain\Tweet;
use App\Letgo\Domain\TweetSearcher;
use App\Letgo\Infrastructure\TweetRepositoryInMemory;
use App\Tests\Letgo\LetgoUnitTestCase;

final class TweetCommandHandlerTest extends LetgoUnitTestCase
{
    /** @var TweetCommandHandler $tweetCommandHandler */
    private $tweetCommandHandler;

    private $tweetSearcher;

    private $mockTweetRepository;

    CONST TWEET_LIMIT = 10;

    protected function setUp(): void
    {
        $this->mockTweetRepository = new TweetRepositoryInMemory();
        $this->tweetSearcher = new TweetSearcher($this->mockTweetRepository);
        $this->tweetCommandHandler = new TweetCommandHandler($this->tweetSearcher);
    }

    /**
     * @test
     */
    public function should_return_error_if_tweet_number_is_greater_than_limit()
    {
        $this->expectException('\InvalidArgumentException');
        $this->expectExceptionMessage(sprintf('limit must be between 1 and %d', self::TWEET_LIMIT));
        $tweetCommand = new TweetCommand('adria', 11, self::TWEET_LIMIT);
        $this->tweetCommandHandler->__invoke($tweetCommand);
    }

    /**
     * @test
     */
    public function should_return_error_if_tweet_number_is_lower_than_limit()
    {
        $this->expectException('\InvalidArgumentException');
        $this->expectExceptionMessage(sprintf('limit must be between 1 and %d', self::TWEET_LIMIT));
        $tweetCommand = new TweetCommand('adria', 0, self::TWEET_LIMIT);
        $this->tweetCommandHandler->__invoke($tweetCommand);
    }

    /**
     * @test
     */
    public function should_return_one_tweet_when_tweet_number_is_one()
    {
        $tweetCommand = new TweetCommand('adria', 1, self::TWEET_LIMIT);
        /** @var \ArrayIterator $tweets */
        $tweets = $this->tweetCommandHandler->__invoke($tweetCommand);

        $this->assertCount(1, $tweets);
    }

    /**
     * @test
     */
    public function should_return_same_number_of_tweets_as_tweet_number()
    {
        for ($tweetNumber = 1; $tweetNumber <= self::TWEET_LIMIT; $tweetNumber++) {
            $tweetCommand = new TweetCommand('adria', $tweetNumber, self::TWEET_LIMIT);
            /** @var \ArrayIterator $tweets */
            $tweets = $this->tweetCommandHandler->__invoke($tweetCommand);

            $this->assertCount($tweetNumber, $tweets);
        }
    }

    /**
     * @test
     */
    public function should_return_tweets_shout()
    {
        for ($tweetNumber = 1; $tweetNumber <= self::TWEET_LIMIT; $tweetNumber++) {
            $tweetCommand = new TweetCommand('adria', $tweetNumber, self::TWEET_LIMIT);
            /** @var \ArrayIterator $tweets */
            $tweets = $this->tweetCommandHandler->__invoke($tweetCommand);

            while ($tweets->valid()) {
                /** @var Tweet $tweet */
                $tweet = $tweets->current();
                $this->assertSame(strtoupper($tweet), $tweet);
                $this->assertStringEndsWith('!', $tweet);
                $tweets->next();
            }
        }
    }
}
