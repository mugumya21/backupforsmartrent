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
        Schema::create('invoices', function (Blueprint $table) {
            $table->increments('id');
            $table->string('number')->unique();
            $table->date('date');
            $table->date('due_date');
            $table->integer('amount');
            $table->integer('balance');
            $table->text('address')->nullable();
            $table->text('terms')->nullable();
            $table->text('description')->nullable();
            $table->boolean('is_billed')->default(false);

            $table->integer('invoice_type_id')->unsigned();
            $table->foreign('invoice_type_id')->references('id')->on('invoice_types');

            $table->integer('invoice_status_id')->unsigned();
            $table->foreign('invoice_status_id')->references('id')->on('invoice_statuses');

            $table->integer('currency_id')->unsigned();
            $table->foreign('currency_id')->references('id')->on('currencies');

            $table->integer('unit_id')->unsigned();
            $table->foreign('unit_id')->references('id')->on('units');
            
            $table->integer('tenant_unit_id')->unsigned();
            $table->foreign('tenant_unit_id')->references('id')->on('tenant_units');

            $table->integer('tax_id')->unsigned();
            $table->foreign('tax_id')->references('id')->on('taxes');

            $table->integer('tenant_id')->unsigned();
            $table->foreign('tenant_id')->references('id')->on('clients');

            $table->integer('done_by')->unsigned();
            $table->foreign('done_by')->references('id')->on('employees');

            $table->integer('supervisor')->unsigned();
            $table->foreign('supervisor')->references('id')->on('employees');

            $table->integer('property_id')->unsigned();
            $table->foreign('property_id')->references('id')->on('properties');

            $table->integer('account_id')->unsigned();
            $table->foreign('account_id')->references('id')->on('accounts');

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
        Schema::dropIfExists('invoices');
    }
};
