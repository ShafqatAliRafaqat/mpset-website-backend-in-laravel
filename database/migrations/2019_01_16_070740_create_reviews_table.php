<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReviewsTable extends Migration {
    
    /**
     * Run the migrations.
     *
     * @return void
     */

    public function up() {
        Schema::create('reviews', function (Blueprint $table) {
            
            $table->increments('id');

            $table->float('rating');
            
            $table->text('comment')->nullable();

            $table->integer('event_id')->default(0);
            $table->integer('location_id')->default(0);
            $table->integer('reviewer_id');

            $table->integer('user_id');
            $table->boolean('asHost');
            $table->integer('host_event_id');

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
        Schema::dropIfExists('reviews');
    }
}
