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
        // Sorry, needed to get the quantities in fast. Too lazy to update FE for it
        // For the question why I didn't use the model: I don't believe in using models as a dependency in migrations.
        \Illuminate\Support\Facades\DB::table('tires')->update([
            'quantity' => 7
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
