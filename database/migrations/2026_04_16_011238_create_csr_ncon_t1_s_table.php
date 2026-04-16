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
        Schema::create('csr_ncon_t1s', function (Blueprint $table) {
            $table->id();
            $table->string('item_code')->unique();
            $table->string('item_name');
            $table->string('unit');
            $table->integer('ideal_stocks')->default(0);
            $table->integer('total_stock')->default(0);
            $table->integer('supply_on_hand')->default(0);
            $table->string('location');
            $table->string('item_condition');
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('csr_ncon_t1s');
    }
};
