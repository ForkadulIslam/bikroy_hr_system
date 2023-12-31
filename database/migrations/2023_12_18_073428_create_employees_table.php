<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->string('attendance_id')->unique();
            $table->string('fathers_name');
            $table->date('date_of_birth');
            $table->string('religion');
            $table->string('gender');
            $table->string('category');
            $table->string('tin_no')->nullable();
            $table->date('date_of_joining');
            $table->date('end_of_contract_date')->nullable();
            $table->string('marital_status');
            $table->string('payment_mode');
            $table->string('vendor_code')->nullable();
            // Add other fields as needed
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('employees');
    }
};
