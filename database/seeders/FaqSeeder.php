<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    public function run(): void
    {
        $faqs = [
            [
                'category' => 'Orders',
                'question' => 'How do I track my order?',
                'answer' => 'You can track your order by logging into your account and navigating to "My Orders". Click on any order to view its current status and tracking information.',
                'display_order' => 1,
            ],
            [
                'category' => 'Orders',
                'question' => 'Can I cancel my order?',
                'answer' => 'Yes, you can cancel your order if it is still in "Pending" or "Processing" status. Once shipped, orders cannot be cancelled.',
                'display_order' => 2,
            ],
            [
                'category' => 'Shipping',
                'question' => 'What are the shipping costs?',
                'answer' => 'We offer free shipping on orders over $100. For orders under $100, a flat shipping fee of $10 applies.',
                'display_order' => 3,
            ],
            [
                'category' => 'Shipping',
                'question' => 'How long does shipping take?',
                'answer' => 'Standard shipping typically takes 3-5 business days. Express shipping (1-2 business days) is available for an additional fee.',
                'display_order' => 4,
            ],
            [
                'category' => 'Returns',
                'question' => 'What is your return policy?',
                'answer' => 'We accept returns within 30 days of delivery. Items must be unused and in original packaging. Please contact customer support to initiate a return.',
                'display_order' => 5,
            ],
            [
                'category' => 'Returns',
                'question' => 'How do I return an item?',
                'answer' => 'Contact our support team via the "Report Issue" page or email us at support@ecommerce.com. We will provide you with return instructions and a return label.',
                'display_order' => 6,
            ],
            [
                'category' => 'Payment',
                'question' => 'What payment methods do you accept?',
                'answer' => 'We accept credit/debit cards and cash on delivery. All online payments are processed securely.',
                'display_order' => 7,
            ],
            [
                'category' => 'Payment',
                'question' => 'Is my payment information secure?',
                'answer' => 'Yes, all payment information is encrypted and processed through secure payment gateways. We never store your full payment details.',
                'display_order' => 8,
            ],
            [
                'category' => 'Account',
                'question' => 'How do I reset my password?',
                'answer' => 'Click on "Forgot Password" on the login page and follow the instructions sent to your email to reset your password.',
                'display_order' => 9,
            ],
            [
                'category' => 'Account',
                'question' => 'Can I change my email address?',
                'answer' => 'Yes, you can update your email address in the "Account Settings" section of your profile.',
                'display_order' => 10,
            ],
            [
                'category' => 'Products',
                'question' => 'Are all products authentic?',
                'answer' => 'Yes, we guarantee all products sold on our platform are 100% authentic and sourced directly from authorized distributors.',
                'display_order' => 11,
            ],
            [
                'category' => 'Products',
                'question' => 'How do I know if a product is in stock?',
                'answer' => 'Product availability is displayed on each product page. If a product shows "In Stock", it is available for immediate purchase.',
                'display_order' => 12,
            ],
        ];
        
        foreach ($faqs as $faq) {
            Faq::create($faq);
        }
    }
}
