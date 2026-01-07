<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    public function run(): void
    {
        $faqs = [
            ['question' => 'How do I place an order?', 'answer' => 'Browse products, add items to cart, and proceed to checkout.', 'category' => 'Orders', 'display_order' => 1],
            ['question' => 'What payment methods do you accept?', 'answer' => 'We accept credit/debit cards and cash on delivery.', 'category' => 'Payments', 'display_order' => 2],
            ['question' => 'How long does shipping take?', 'answer' => 'Standard shipping typically takes 5-7 business days.', 'category' => 'Shipping', 'display_order' => 3],
            ['question' => 'Can I track my order?', 'answer' => 'Yes! Track your order from the My Orders page.', 'category' => 'Orders', 'display_order' => 4],
            ['question' => 'What is your return policy?', 'answer' => 'We offer a 30-day return policy on most items.', 'category' => 'Returns', 'display_order' => 5],
            ['question' => 'How do I create an account?', 'answer' => 'Click Register in the top menu and fill in your details.', 'category' => 'Account', 'display_order' => 6],
            ['question' => 'How can I contact customer support?', 'answer' => 'Use the Report Issue feature or email us.', 'category' => 'Support', 'display_order' => 7],
        ];

        foreach ($faqs as $faq) {
            Faq::create($faq);
        }
    }
}
