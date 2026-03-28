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
        Schema::create('return_logs', function (Blueprint $table) {
            $table->id('return_id'); // Using standard auto-increment but mapped to RET-XX in model
            $table->date('date_returned')->useCurrent();
            $table->string('borrow_id'); // Link to original borrow log
            $table->string('equipment');
            $table->integer('quantity_returned');
            $table->string('condition');
            $table->string('received_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('return_logs');
    }
};
