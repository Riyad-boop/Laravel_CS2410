<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnimalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('animals', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            //animal data
            $table->bigInteger('userid') ->unsigned(); // is the person who the animal is adopted by 
            $table->string('type');
            $table->string('name');
            $table->Date('DOB');
            $table->text('description');
            $table ->foreign('userid')->references('id')->on('users'); // a reference to the user who adopted this animal
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('animals');
    }
}
