<?php

namespace Database\Seeders;

use App\Models\ReturnReason;
use Illuminate\Database\Seeder;

class ReturnReasonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $reasons = [
            [
                'name' => 'Damaged Item',
                'description' => 'The product arrived damaged or defective',
                'is_active' => true,
            ],
            [
                'name' => 'Wrong Item Received',
                'description' => 'I received a different item than what I ordered',
                'is_active' => true,
            ],
            [
                'name' => 'Incorrect Size',
                'description' => 'The item does not fit or match the size I ordered',
                'is_active' => true,
            ],
            [
                'name' => 'Not as Described',
                'description' => 'The product does not match the description on the website',
                'is_active' => true,
            ],
            [
                'name' => 'Change of Mind',
                'description' => 'I changed my mind about this purchase',
                'is_active' => true,
            ],
            [
                'name' => 'Quality Issues',
                'description' => 'The quality of the product is not satisfactory',
                'is_active' => true,
            ],
            [
                'name' => 'Better Option Found',
                'description' => 'I found a better alternative product',
                'is_active' => true,
            ],
            [
                'name' => 'No Longer Needed',
                'description' => 'I no longer need this product',
                'is_active' => true,
            ],
        ];

        foreach ($reasons as $reason) {
            ReturnReason::updateOrCreate(
                ['name' => $reason['name']],
                $reason
            );
        }
    }
}
