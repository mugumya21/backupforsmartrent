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
        Schema::create('tenant_units', function (Blueprint $table) {
            $table->increments('id');
            $table->date('from_date');
            $table->date('to_date');
            $table->integer('amount');
            $table->integer('converted_amount');
            $table->integer('foreign_amount');
            $table->integer('base_amount');

            $table->integer('discount_amount');
            $table->integer('converted_discount_amount');
            $table->integer('foreign_discount_amount');
            $table->integer('base_discount_amount');

            $table->integer('terms')->nullable();
            $table->integer('duration')->nullable();

            $table->integer('currency_id')->unsigned();
            $table->foreign('currency_id')->references('id')->on('currencies');

            $table->text('description')->nullable();

            $table->integer('unit_id')->unsigned();
            $table->foreign('unit_id')->references('id')->on('units');

            $table->integer('tenant_id')->unsigned();
            $table->foreign('tenant_id')->references('id')->on('clients');

            $table->integer('schedule_id')->unsigned();
            $table->foreign('schedule_id')->references('id')->on('periods');

            $table->integer('property_id')->unsigned();
            $table->foreign('property_id')->references('id')->on('properties');

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
        Schema::dropIfExists('tenant_units');
    }
};
