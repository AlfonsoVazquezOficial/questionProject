<?php

namespace Database\Factories;

use App\Models\Question;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Question>
 */
class QuestionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Question::class;
    public function definition(): array
    {
        return [
            //
            'type' => $this -> faker -> randomElement(['checkbox', 'radio', 'input']),
            'questionDesc' => $this -> faker -> regexify('[A-Za-z0-9]{30}'), 
            'optionA' => $this -> faker -> regexify('[A-Za-z0-9]{10}'),
            'optionB' => $this -> faker -> regexify('[A-Za-z0-9]{10}'),
            'optionC' => $this -> faker -> regexify('[A-Za-z0-9]{10}'),
            'answer' => $this -> faker -> randomElement(['A', 'B', 'C']),
            'id_subject' => $this -> faker -> randomElement([1, 2, 3, 4, 5, 6, 7, 8, 9, 10]),

        ];
    }
}
