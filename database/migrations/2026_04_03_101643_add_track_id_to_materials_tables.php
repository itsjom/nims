<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasColumn('fnp_materials', 'track_id')) {
            Schema::table('fnp_materials', function (Blueprint $table) {
                $table->unsignedInteger('track_id')->nullable();
            });
        }

        if (!Schema::hasColumn('ha_materials', 'track_id')) {
            Schema::table('ha_materials', function (Blueprint $table) {
                $table->unsignedInteger('track_id')->nullable();
            });
        }

        $fnp = \Illuminate\Support\Facades\DB::table('fnp_materials')->get();
        $ha = \Illuminate\Support\Facades\DB::table('ha_materials')->get();

        $combined = collect($fnp)->map(function ($item) {
            $item->table = 'fnp_materials';
            $item->pk_col = 'fnp_id';
            $item->pk_val = $item->fnp_id;
            return $item;
        })->concat(collect($ha)->map(function ($item) {
            $item->table = 'ha_materials';
            $item->pk_col = 'ha_id';
            $item->pk_val = $item->ha_id;
            return $item;
        }))->sortBy('created_at')->values();

        $trackId = 1;
        foreach ($combined as $item) {
            \Illuminate\Support\Facades\DB::table($item->table)
                ->where($item->pk_col, $item->pk_val)
                ->update(['track_id' => $trackId++]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('fnp_materials', function (Blueprint $table) {
            $table->dropColumn('track_id');
        });

        Schema::table('ha_materials', function (Blueprint $table) {
            $table->dropColumn('track_id');
        });
    }
};
