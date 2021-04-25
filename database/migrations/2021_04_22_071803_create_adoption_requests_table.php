<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdoptionRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('adoption_requests', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->bigInteger('userid') ->unsigned(); // is the user this request is assoicated with
            $table ->foreign('userid')->references('id')->on('users'); // a reference to the user this request is assoicated with
            $table->bigInteger('animalid') ->unsigned(); // is the animal this request is assoicated with 
            $table ->foreign('animalid')->references('id')->on('animals'); // a reference to the animal this request is assoicated with
            $table->boolean('adopted')->nullable()->default(false);
            $table->boolean('pending')->nullable()->default(false);
            $table->boolean('denied')->nullable()->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('adoption_requests');
    }
}
