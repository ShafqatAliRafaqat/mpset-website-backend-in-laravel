<?php
use App\Event;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Faker\Factory;

class EventTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $users = 100;

        $faker = Factory::create();

        for( $j = 1; $j<=$users; $j++ ) {
            Event::create([
                'host_id' => 1,
                'name' => $input['name'],
                'game_profile' => $input['game_profile'],
                'game_type' => $input['game_type'],
                'isPrivate' => $input['isPrivate'],
                'max_players' => $input['max_players'],
                'min_players' => $input['min_players'],
                'table_rules' => $input['table_rules'],
                'game_date' => Carbon::createFromTimestamp($input['game_date']),
                'purchase_amount' => $input['purchase_amount'],
                're_buyins' => $input['re_buyins'],
                'small_blind' => $input['small_blind'],
                'big_blind' => $input['big_blind'],
                'max_buyins' => $input['max_buyins'],
                'min_buyins' => $input['min_buyins'],
                'valid_start_date' =>  Carbon::parse($input['valid_start_date']) ,
                'valid_end_date' =>  Carbon::parse($input['valid_end_date']),
            ]);
        }
    }
}
