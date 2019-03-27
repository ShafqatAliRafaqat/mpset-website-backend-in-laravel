<?php

use App\User;
use Carbon\Carbon;
use Faker\Factory;
use App\UserDetail;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {

        $users = 10;

        $faker = Factory::create();

        for( $j = 1; $j<=$users; $j++ ) {

           $user = User::create([
                'nick_name' => $faker->name,
                'first_name' => $faker->firstName,
                'last_name' => $faker->LastName,
                'email' => ($j==1) ? "admin@admin.com": $faker->email,
                'role' => ($j==1) ? 0: 1,
                'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
                'email_verified_at' => Carbon::now()
           ]);

           UserDetail::create([
                'user_id' => $user->id,
                'phone' => $faker->phoneNumber,
                'gender' => "Male",
                'address' => $faker->address,
                'country' => $faker->country,
                'country_code' => $faker->countryCode
           ]);

        }
    }
}
