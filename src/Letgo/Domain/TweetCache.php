<?php

declare(strict_types=1);

namespace App\Letgo\Domain;

use Psr\SimpleCache\CacheInterface;
use Symfony\Component\Cache\PruneableInterface;
use Symfony\Component\Cache\ResettableInterface;

interface TweetCache extends TweetRepository, CacheInterface, PruneableInterface, ResettableInterface
{
    public function searchByUserName(string $username, int $limit): Tweets;

}
