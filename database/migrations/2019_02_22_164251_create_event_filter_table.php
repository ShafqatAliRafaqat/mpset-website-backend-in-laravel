<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventFilterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_filter', function (Blueprint $table) {
        
            $table->increments('id');
            $table->string('min_distance')->nullable();
            $table->string('max_distance')->nullable();
            $table->string('game_profile');
            $table->string('game_type');
            $table->dateTime('start_date')->nullable();
            $table->dateTime('end_date')->nullable();
            $table->integer('min_buyins')->default(0);
            $table->integer('max_buyins')->default(0);
            $table->unsignedInteger('user_id')->unsigned();
            $table->float('rating');

            $table->timestamps();
        });
        
       Schema::table('event_filter', function($table){
           $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
       });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('event_filter');
    }
}
