<?php

declare(strict_types=1);

namespace App\Letgo\Domain;

interface TweetRepository
{
    public function searchByUserName(string $username, int $limit): Tweets;
}
