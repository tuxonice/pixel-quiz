<?php

namespace Quiz\Models;

class Quiz
{
    private array $categories = [];

    
    public function addCategory(Category $category): self
    {
        $this->categories[$category->getId()] = $category;

        return $this;
    }

    /**
     * @return Category[]
     */
    public function getCategories(): array
    {
        return $this->categories;
    }

    public function getTotalCategories(): int
    {
        return count($this->categories);
    }

    public function getCategoryById(int $id): ?Category
    {
        foreach($this->categories as $category) {
            if($category->getId() === $id) {
                return $category;
            }
        }

        return null;
    }
}
