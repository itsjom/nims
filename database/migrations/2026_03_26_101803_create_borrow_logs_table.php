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
        Schema::create('borrow_logs', function (Blueprint $table) {
            $table->id('borrow_id'); // Mapped to BOR-XX in model
            $table->date('date_borrowed')->useCurrent();
            $table->string('student_name');
            $table->string('clinical_instructor');
            $table->string('procedure');
            $table->string('equipment');
            $table->integer('quantity');
            $table->string('status')->default('Pending');
            $table->date('expected_returned_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('borrow_logs');
    }
};
