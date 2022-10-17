<?php

namespace Quiz;

use Quiz\Models\Answer;
use Quiz\Models\Category;
use Quiz\Models\Quiz;
use Quiz\Models\Question;

class Boot 
{

    private Quiz $quiz;

    private Category $currentCategory;

    public function init()
    {
        $this->quiz = $this->readData();

        $currentCategoryId = $_POST['category-id'] ?? 1;

        if (isset($_POST['next']) && $currentCategoryId < $this->quiz->getTotalCategories()) {
            $currentCategoryId++;
            $this->currentCategory = $this->quiz->getCategoryById($currentCategoryId);

            return;
        }

        if (isset($_POST['previous']) && $currentCategoryId > 1) {
            $currentCategoryId--;
            $this->currentCategory = $this->quiz->getCategoryById($currentCategoryId);

            return;
        }

        $this->currentCategory = $this->quiz->getCategoryById($currentCategoryId);
    }

    public function getCurrentCategory(): Category
    {
        return $this->currentCategory;
    }

    public function getQuiz(): Quiz
    {
        return $this->quiz;
    }

    private function readData()
    {
        $jsonFile = file_get_contents(dirname(__DIR__) . '/data/data.json');

        $data = json_decode($jsonFile, true);


        $quiz = new Quiz();
        foreach($data['categories'] as $categoryKey => $categoryData) {
            $categoryId = $categoryKey+1;
            $category = new Category();
            $category
                ->setTitle($categoryData['title'])
                ->setId($categoryId);
            
            foreach($categoryData['questions'] as $questionKey => $questionData) {
                $questionData['id'] = $questionKey + 1;
                $question = Question::createFromArray($questionData);

                foreach($questionData['correct_answers'] as $correctAnswers) {
                    $answer = Answer::createFromArray(
                        [
                            'title' => $correctAnswers,
                            'is_correct' => true,
                        ]
                    );
                    $question->addAnswer($answer);
                }

                foreach($questionData['incorrect_answers'] as $incorrectAnswers) {
                    $answer = Answer::createFromArray(
                        [
                            'title' => $incorrectAnswers,
                            'is_correct' => false,
                        ]
                    );
                    $question->addAnswer($answer);
                }

                $category->addQuestion($question);
                
            }

            $quiz->addCategory($category);

        }

        return $quiz;

    }


    public function getTotalCategories(): int
    {
        return $this->quiz->getTotalCategories();
    }
}
