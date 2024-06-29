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
        Schema::create('units', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->unique(['name', 'property_id']);
            $table->integer('amount');
            $table->integer('converted_amount');
            $table->integer('foreign_amount');
            $table->integer('base_amount');

            $table->boolean('is_available')->default(true);
            $table->string('square_meters')->nullable();
            $table->text('description')->nullable();

            $table->integer('unit_type')->unsigned();
            $table->foreign('unit_type')->references('id')->on('unit_types');

            $table->integer('floor_id')->unsigned();
            $table->foreign('floor_id')->references('id')->on('floors');

            $table->integer('schedule_id')->unsigned();
            $table->foreign('schedule_id')->references('id')->on('periods');

            $table->integer('property_id')->unsigned();
            $table->foreign('property_id')->references('id')->on('properties');

            $table->integer('currency_id')->unsigned();
            $table->foreign('currency_id')->references('id')->on('currencies');

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
        Schema::dropIfExists('units');
    }
};
