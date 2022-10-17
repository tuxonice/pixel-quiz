<?php

namespace Quiz\Models;

class Category
{
    private int $id;

    private array $questions;

    private string $title;

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return Question[]
     */
    public function getQuestions(): array
    {
        return $this->questions;
    }

    public function addQuestion(Question $question): self
    {
        $this->questions[] = $question;

        return $this;
    }

    public function getTotalQuestions(): int
    {
        return count($this->questions);
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getId(): int
    {
        return $this->id;
    }
}
