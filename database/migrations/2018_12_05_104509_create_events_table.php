<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsTable extends Migration {
    
    /**
     * Run the migrations.
     *
     * @return void
     */

    public function up()
    {
        Schema::create('events', function (Blueprint $table) {

            $table->increments('id');

            $table->string('name');
            $table->string('status');
            $table->string('game_profile');
            
            $table->string('game_type');

            $table->boolean('isPrivate');
            $table->boolean('votingEnabled')->default(0);

            $table->integer('max_players');
            $table->integer('min_players');

            $table->text('table_rules');

            //cash
            
            $table->integer('purchase_amount')->default(0);
            $table->integer('re_buyins')->default(0);
            
            // taurnament

            $table->integer('small_blind')->default(0);
            $table->integer('big_blind')->default(0);
            $table->integer('max_buyins')->default(0);
            $table->integer('min_buyins')->default(0);

            
            $table->integer('no_of_players')->default(0);

            
            $table->dateTime('game_date');

            $table->dateTime('start_time')->nullable();
            $table->dateTime('end_time')->nullable();

            $table->date('valid_start_date')->nullable();
            $table->date('valid_end_date')->nullable();

            $table->unsignedInteger('host_id')->unsigned();
            $table->unsignedInteger('location_id')->unsigned();

            $table->timestamps();
        });

        Schema::table('events', function ($table) {
            $table->foreign('host_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('events');
    }
}
