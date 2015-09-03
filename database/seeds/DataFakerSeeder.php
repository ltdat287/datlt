<?php

use Illuminate\Database\Seeder;
use App\User as Users;
use Faker\Factory as Faker;

class DataFakerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $faker = Faker::create();
        $boss_id = 0;
        for ($i = 0; $i < 10; $i++) {
            $user = new Users;
            $user->name         = $faker->name;
            $user->email        = $faker->email;
            $user->password     = bcrypt('123456789');
            $user->kana         = $faker->name;
            $user->telephone_no = $faker->phoneNumber;
            $user->birthday     = $faker->date($format = 'Y-m-d', $max = 'now');
            $user->note         = $faker->text;
            if (!empty($boss_id)) {
                $user->role     = 'boss';
            } else {
                $user->role     = 'employee';
            }
            $user->boss_id      = $boss_id;
            $user->updated_at   = $faker->dateTime($max = 'now');
            $user->created_at   = $faker->dateTime($max = $user->updated_at);
            $user->save();
        }
    }
}
