<?php

use App\User;
use Illuminate\Database\Seeder;

class MotorcyclesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::get();

        foreach ($users as $user) {
            factory(\App\Motorcycle::class, rand(1, 10))->create([
                'user_id' => $user->id
            ]);
        }
    }
}
