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
                'translation_key' => 'how_long_does_delivery_take',
                'translation_value' => 'that_delivery_time_is_1_3_working_days'
            ],
            [
                'question_category' => Faq::CATEGORY_DELIVERY,
                'question' => "I don't see my country in the list of countries. Can I still get a delivery?",
                'answer' => 'Yes! Please contact us at service@autoteile.da and we will find a solution.',
                'translation_key' => 'country_not_in_list_can_i_still_get_delivery',
                'translation_value' => 'please_contact_us_if_your_country_is_not_in_list'
            ],
            [
                'question_category' => Faq::CATEGORY_DELIVERY,
                'question' => 'I did not receive my order. What should I do?',
                'answer' => 'Please contact us at service@autoteile.da and we will find a solution.',
                'translation_key' => 'did_not_receive_order_what_should_i_do',
                'translation_value' => 'please_contact_us_if_you_did_not_receive_order'
            ],

            // Payment questions
            [
                'question_category' => Faq::CATEGORY_PAYMENT,
                'question' => 'How do I pay?',
                'answer' => 'You can pay with Dankort, Visa, Mastercard, MobilePay, PayPal, or bank transfer.',
                'translation_key' => 'how_do_i_pay',
                'translation_value' => 'you_can_pay_with_various_methods'
            ],
            [
                'question_category' => Faq::CATEGORY_PAYMENT,
                'question' => 'Can I pay with invoice?',
                'answer' => 'Yes, you can pay with invoice. Please contact us at',
                'translation_key' => 'can_i_pay_with_invoice',
                'translation_value' => 'yes_you_can_pay_with_invoice'
            ],
            [
                'question_category' => Faq::CATEGORY_PAYMENT,
                'question' => 'Can I pay with cash?',
                'answer' => 'No, we do not accept cash payments.',
                'translation_key' => 'can_i_pay_with_cash',
                'translation_value' => 'no_we_do_not_accept_cash'
            ],

            // Return questions
            [
                'question_category' => Faq::CATEGORY_RETURN,
                'question' => 'Can I return my order?',
                'answer' => 'Yes, you can return your order. Please contact us at',
                'translation_key' => 'can_i_return_my_order',
                'translation_value' => 'yes_you_can_return_your_order'
            ],
            [
                'question_category' => Faq::CATEGORY_RETURN,
                'question' => 'How long do I have to return my order?',
                'answer' => 'You have 14 days to return your order.',
                'translation_key' => 'how_long_to_return_my_order',
                'translation_value' => 'you_have_14_days_to_return_your_order'
            ],
            [
                'question_category' => Faq::CATEGORY_RETURN,
                'question' => 'How do I return my order?',
                'answer' => 'Please contact us at',
                'translation_key' => 'how_do_i_return_my_order',
                'translation_value' => 'please_contact_us_to_return_your_order'
            ],
        ];

        Faq::insert($questions);
    }
}
