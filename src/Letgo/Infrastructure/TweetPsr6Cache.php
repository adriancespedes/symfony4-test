<?php

declare(strict_types=1);

namespace App\Letgo\Infrastructure;

use App\Letgo\Domain\Tweet;
use App\Letgo\Domain\TweetCache;
use App\Letgo\Domain\Tweets;
use Symfony\Component\Cache\Simple\FilesystemCache;
use Symfony\Component\Cache\Simple\Psr6Cache;

final class TweetPsr6Cache  extends Psr6Cache implements TweetCache
{
    /**
     * @param string $username
     * @param int $limit
     * @return Tweets
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function searchByUserName(string $username, int $limit): Tweets
    {
        $cache = new FilesystemCache('', (int) getenv('CACHE_LIFETIME'));
        if (!$cache->has($username)) {
            $tweetRepository = new TweetRepositoryInMemory();
            $tweets = $tweetRepository->searchByUserName($username, $limit);
            $cache->set($username, $tweets);
            return $tweets;
        }

        return $cache->get($username);
    }


    public function get($key, $default = null)
    {
        $item = parent::get($key, $default);
        $tweets = [];
        foreach ($item as $tweet) {
            $tweets[] = new Tweet($tweet);
        }
        return new Tweets($tweets);
    }
}
