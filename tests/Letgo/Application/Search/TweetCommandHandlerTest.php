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
        $limit = 10;
        $this->expectException('\InvalidArgumentException');
        $this->expectExceptionMessage(sprintf('limit must be between 0 and %d', $limit));
        $tweetCommand = new TweetCommand('adria', 11, $limit);
        /** @var \ArrayIterator $tweets */
        $tweets = $this->tweetCommandHandler->handle($tweetCommand);
    }

    /**
     * @test
     */
    public function should_return_no_tweets_when_tweet_number_is_zero()
    {
        $tweetCommand = new TweetCommand('adria', 0, 10);
        /** @var \ArrayIterator $tweets */
        $tweets = $this->tweetCommandHandler->handle($tweetCommand);

        $this->assertCount(0, $tweets);
    }

    /**
     * @test
     */
    public function should_return_one_tweet_when_tweet_number_is_one()
    {
        $tweetCommand = new TweetCommand('adria', 1, 10);
        /** @var \ArrayIterator $tweets */
        $tweets = $this->tweetCommandHandler->handle($tweetCommand);

        $this->assertCount(1, $tweets);
    }

    /**
     * @test
     */
    public function should_return_same_number_of_tweets_as_tweet_number()
    {
        for ($tweetNumber = 0; $tweetNumber <= 10; $tweetNumber++) {
            $tweetCommand = new TweetCommand('adria', $tweetNumber, 10);
            /** @var \ArrayIterator $tweets */
            $tweets = $this->tweetCommandHandler->handle($tweetCommand);

            $this->assertCount($tweetNumber, $tweets);
        }
    }

    /**
     * @test
     */
    public function should_return_tweets_shout()
    {
        for ($tweetNumber = 0; $tweetNumber <= 10; $tweetNumber++) {
            $tweetCommand = new TweetCommand('adria', $tweetNumber, 10);
            /** @var \ArrayIterator $tweets */
            $tweets = $this->tweetCommandHandler->handle($tweetCommand);

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
