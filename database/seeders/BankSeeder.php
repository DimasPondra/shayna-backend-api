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
                'name' => 'Axis Bank'
            ],
            [
                'name' => 'Deutsche Bank'
            ],
            [
                'name' => 'State Bank of Hyderabad'
            ],
            [
                'name' => 'UCO Bank'
            ]
        ];

        foreach ($banks as $bank) {
            Bank::create($bank);
        }
    }
}
