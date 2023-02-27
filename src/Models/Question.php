<?php

namespace Quiz\Models;

class Question
{
    private int $id;

    private string $title;

    private string $type;

    private string $hint;

    private array $answers = [];

    public static function createFromArray(array $data): self
    {
        $question = new self();
        $question->id = $data['id'];
        $question->title = $data['title'];
        $question->type = $data['type'];
        $question->hint = $data['hint'] ?? '';

        return $question;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function addAnswer(Answer $answer)
    {
        $this->answers[] = $answer;
    }

    public function getAnswers()
    {
        return $this->answers;
    }

    public function isSingleType(): bool
    {
        return $this->type === 'single';
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getHint(): string
    {
        return $this->hint;
    }
}
