<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('client_profile_next_of_kin', function (Blueprint $table) {
            $table->increments('id');

            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->tinyInteger('gender')->nullable();
            $table->string('address')->nullable();
            $table->string('nin')->nullable();

            $table->integer('relationship_id')->unsigned()->nullable();
            $table->foreign('relationship_id')->references('id')->on('relationships');

            $table->integer('nation_id')->nullable()->unsigned();
            $table->foreign('nation_id')->references('id')->on('nations');

            $table->integer('client_profile_id')->unsigned();
            $table->foreign('client_profile_id')->references('id')->on('client_profiles');

            $table->unsignedBigInteger('created_by')->unsigned();
            $table->foreign('created_by')->references('id')->on('users');

            $table->unsignedBigInteger('updated_by')->unsigned()->nullable();
            $table->foreign('updated_by')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_profile_next_of_kin');
    }
};
