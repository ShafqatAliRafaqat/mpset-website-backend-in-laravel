<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBlackListsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    
    public function up() {

        Schema::create('black_lists', function (Blueprint $table) {
            $table->increments('id');
            $table->string('country_code');
            $table->string('country');
            $table->boolean('all_features');
            $table->text('features');
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
        Schema::dropIfExists('black_lists');
    }
}
