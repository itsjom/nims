<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('fnp_materials', function (Blueprint $table) {
            $table->integer('total_quantity')->default(0);
            $table->integer('borrowed')->default(0);
            $table->integer('returned')->default(0);
            $table->enum('condition', ['Good', 'New', 'Damage'])->default('New');
            $table->string('storage_location')->nullable();
        });

        Schema::table('ha_materials', function (Blueprint $table) {
            $table->integer('total_quantity')->default(0);
            $table->integer('borrowed')->default(0);
            $table->integer('returned')->default(0);
            $table->enum('condition', ['Good', 'New', 'Damage'])->default('New');
            $table->string('storage_location')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('fnp_materials', function (Blueprint $table) {
            $table->dropColumn(['total_quantity', 'borrowed', 'returned', 'condition', 'storage_location']);
        });

        Schema::table('ha_materials', function (Blueprint $table) {
            $table->dropColumn(['total_quantity', 'borrowed', 'returned', 'condition', 'storage_location']);
        });
    }
};
