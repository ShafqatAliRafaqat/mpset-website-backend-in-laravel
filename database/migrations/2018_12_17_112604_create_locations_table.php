<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {

        Schema::create('locations', function (Blueprint $table) {
            
            $table->increments('id');
            
            $table->string('address')->nullable();
            
            $table->string('lat');
            $table->string('lng');

            $table->unsignedInteger('location_user_id')->unsigned();
            $table->unsignedInteger('user_id')->unsigned();

            $table->timestamps();
        });
        
//        Schema::table('locations', function($table){
//            $table->foreign('location_user_id')->references('id')->on('users')->onDelete('cascade');
//        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('locations');
    }
}
