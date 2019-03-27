<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserEventTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {

        Schema::create('user_event', function (Blueprint $table) {

            $table->increments('id');
            
            $table->integer('event_id');
            $table->integer('user_id');
            
            $table->integer('buyins')->default(0);
            $table->float('checkout')->default(0);
            
            $table->boolean('isApproved')->default(0);
            $table->boolean('isCanceled')->default(0);

            $table->integer('seat_no')->default(0);


            $table->dateTime('start_date')->nullable();
            $table->dateTime('end_date')->nullable();

            $table->timestamps();

        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_event');
    }
}
