<?php

namespace Database\Seeders;

use App\Models\Bank;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $banks = [
            [
                'name' => 'BCA'
            ],
            [
                'name' => 'BRI'
            ],
            [
                'name' => 'BNI'
            ],
            [
                'name' => 'Mandiri'
            ]
        ];

        foreach ($banks as $bank) {
            Bank::create($bank);
        }
    }
}
