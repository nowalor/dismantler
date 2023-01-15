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
            // Delivery questions
            [
                'question_category' => Faq::CATEGORY_DELIVERY,
                'question' => 'How long does the delivery take?',
                'answer' => 'The delivery time is 1-3 working days. If you order before 12:00, we will ship the same day. If you order after 12:00, we will ship the next day. If you order on a weekend or a holiday, we will ship the next working day.',
            ],
            [
                'question_category' => Faq::CATEGORY_DELIVERY,
                'question' => "I don't see my country in the list of countries. Can I still get a delivery?",
                'answer' => 'Yes! Please contact us at service@autoteile.dk and we will find a solution.',
            ],
            [
                'question_category' => Faq::CATEGORY_DELIVERY,
                'question' => 'I did not receive my order. What should I do?',
                'answer' => 'Please contact us at service@autoteile.dk and we will find a solution.',
            ],

            // Payment questions
            [
                'question_category' => Faq::CATEGORY_PAYMENT,
                'question' => 'How do I pay?',
                'answer' => 'You can pay with Dankort, Visa, Mastercard, MobilePay, PayPal, or bank transfer.',
            ],
            [
                'question_category' => Faq::CATEGORY_PAYMENT,
                'question' => 'Can I pay with invoice?',
                'answer' => 'Yes, you can pay with invoice. Please contact us at',
            ],
            [
                'question_category' => Faq::CATEGORY_PAYMENT,
                'question' => 'Can I pay with cash?',
                'answer' => 'No, we do not accept cash payments.',
            ],

            // Return questions
            [
                'question_category' => Faq::CATEGORY_RETURN,
                'question' => 'Can I return my order?',
                'answer' => 'Yes, you can return your order. Please contact us at',
            ],
            [
                'question_category' => Faq::CATEGORY_RETURN,
                'question' => 'How long do I have to return my order?',
                'answer' => 'You have 14 days to return your order.',
            ],
            [
                'question_category' => Faq::CATEGORY_RETURN,
                'question' => 'How do I return my order?',
                'answer' => 'Please contact us at',
            ],
        ];

        Faq::insert($questions);
    }
}
