<?php

use App\Enums\TireMaintenance\TireMaintenanceRequestStatusEnum;
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
        Schema::create('tire_maintenance_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('car_id')->index();
            $table->unsignedBigInteger('user_id')->nullable()->index();
            $table->enum('status', array_column(TireMaintenanceRequestStatusEnum::cases(), 'value'))
                ->default(TireMaintenanceRequestStatusEnum::PENDING->value);
            $table->date('maintenance_scheduled_at');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tire_maintenance_requests');
    }
};
