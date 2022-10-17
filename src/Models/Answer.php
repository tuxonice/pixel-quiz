<?php

namespace Quiz\Models;

class Answer
{
    private string $title;

    private bool $isCorrect;

    public static function createFromArray(array $data): self
    {
        $answer = new self();
        $answer->title = $data['title'];
        $answer->isCorrect = $data['is_correct'];

        return $answer;
    }


    public function setTitle(string $title): Answer
    {
        $this->title = $title;
        return $this;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setIsCorrect(bool $isCorrect): Answer
    {
        $this->isCorrect = $isCorrect;
        return $this;
    }

    public function isCorrect(): bool
    {
        return $this->isCorrect;
    }
}
