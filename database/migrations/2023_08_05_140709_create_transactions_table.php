<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->float('paidAmount');
            $table->string('currency');
            $table->string('parentEmail');
            $table->integer('statusCode');
            $table->date('paymentDate');
            $table->string('parentIdentification');
            $table->foreign('parentEmail')->references('email')->on('clients')
              ->onUpdate('cascade')->onDelete('cascade');
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
