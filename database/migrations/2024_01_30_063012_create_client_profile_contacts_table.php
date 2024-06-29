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
        Schema::create('client_profile_contacts', function (Blueprint $table) {
             $table->increments('id');

            $table->string('value');
            $table->text('description')->nullable();

            $table->integer('contact_type_id')->unsigned();
            $table->foreign('contact_type_id')->references('id')->on('contact_types');

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
        Schema::dropIfExists('client_profile_contacts');
    }
};
