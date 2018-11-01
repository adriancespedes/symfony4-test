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
    public function should_return_same_number_of_tweets()
    {
        $tweetCommand = new TweetCommand('adria', 10);
        /** @var \ArrayIterator $tweets */
        $tweets = $this->tweetCommandHandler->handle($tweetCommand);

        $this->assertCount(10, $tweets);
    }

    /**
     * @test
     */
    public function should_return_tweets_shout()
    {
        $tweetCommand = new TweetCommand('adria', 10);
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
