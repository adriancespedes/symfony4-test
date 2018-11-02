<?php

declare(strict_types=1);

namespace App\Letgo\Domain;

final class Tweet
{
    private $text;

    public function __construct(string $text)
    {
        $this->text = $text;
    }

    public function shout(): string
    {
        $shout = strtoupper($this->getText());
        $shout = $this->removeLastDotIfExists($shout);
        $shout = $this->addExclamationMarkIfMissing($shout);
        return $shout;
    }

    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @param $shout
     * @return bool|string
     */
    public function removeLastDotIfExists($shout)
    {
        if ($shout[strlen($shout) - 1] === '.') {
            $shout = substr($shout, 0, -1);
        }
        return $shout;
    }

    /**
     * @param $shout
     * @return string
     */
    public function addExclamationMarkIfMissing($shout): string
    {
        if (substr($shout, -1) !== '!') {
            $shout .= '!';
        }
        return $shout;
    }
}
