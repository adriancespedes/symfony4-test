<?php

declare(strict_types=1);

namespace App\Letgo\Domain;

class TweetNotFoundException extends \Exception
{
    public function code(): string
    {
        return 'tweets_for_username_not_found';
    }

    public function message(): string
    {
        return 'Tweets not found for provided username';
    }
}