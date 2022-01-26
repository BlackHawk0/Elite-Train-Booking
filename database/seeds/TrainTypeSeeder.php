<?php

use App\TrainType;
use Illuminate\Database\Seeder;

class TrainTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userData = [
            [
                'type' => 'Commuter',
            ],
            [
                'type' => 'Inter-County',
            ],

        ];

        foreach ($userData as $key => $val) {
            TrainType::create($val);
        }

    }
}
