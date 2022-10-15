<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $questions = [
            [
                'question_category' => Faq::CATEGORY_DELIVERY,
                'question' => 'Question 1',
                'answer' => 'Answer 1',
            ],
            [
                'question_category' => Faq::CATEGORY_DELIVERY,
                'question' => 'Question 2',
                'answer' => 'Answer 2',
            ],
            [
                'question_category' => Faq::CATEGORY_DELIVERY,
                'question' => 'Question 3',
                'answer' => 'Answer 3',
            ],
        ];

        Faq::insert($questions);
    }
}
