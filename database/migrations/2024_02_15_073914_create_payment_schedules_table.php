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
        Schema::create('payment_schedules', function (Blueprint $table) {
            $table->increments('id');
            $table->date('from_date');
            $table->date('to_date');
            $table->integer('discount_amount');
            $table->integer('converted_discount_amount');
            $table->integer('foreign_discount_amount');
            $table->integer('base_discount_amount');

            $table->integer('paid')->nullable();
            $table->integer('converted_paid');
            $table->integer('foreign_paid');
            $table->integer('base_paid');

            $table->integer('balance')->nullable();
            $table->integer('converted_balance');
            $table->integer('foreign_balance');
            $table->integer('base_balance');

            $table->integer('payment_terms_amount');
            $table->integer('converted_payment_terms_amount');
            $table->integer('foreign_payment_terms_amount');
            $table->integer('base_payment_terms_amount');

            $table->integer('balance_c_forward')->nullable();
            
            $table->text('description')->nullable();

            $table->integer('unit_id')->unsigned();
            $table->foreign('unit_id')->references('id')->on('units');

            $table->integer('tenant_id')->unsigned();
            $table->foreign('tenant_id')->references('id')->on('clients');

            $table->integer('tenant_unit_id')->unsigned();
            $table->foreign('tenant_unit_id')->references('id')->on('tenant_units');
            
  

            $table->integer('schedule_id')->unsigned();
            $table->foreign('schedule_id')->references('id')->on('periods');

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
        Schema::dropIfExists('payment_schedules');
    }
};
