<?php

use App\Constants\EmployerConstants;
use App\Constants\GlobalConstants;
use App\Constants\JobPostConstants;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(JobPostConstants::TABLE_NAME, function (Blueprint $table) {
            $table->id();
            $table->text('desc');
            $table->foreignId('employer_id')->constrained(EmployerConstants::TABLE_NAME);
            $table->string('title', 255);
            $table->boolean('is_active');
            $table->unsignedTinyInteger('status');
            $table->text('image')->nullable();
            $table->decimal('min_rate', GlobalConstants::DECIMAL_TOTALS, GlobalConstants::DECIMAL_PRECISION);
            $table->decimal('max_rate', GlobalConstants::DECIMAL_TOTALS, GlobalConstants::DECIMAL_PRECISION);
            $table->integer('payment_type');
            $table->dateTime('start_time');
            $table->dateTime('end_time');
            $table->dateTime('bid_start_time');
            $table->dateTime('bid_end_time');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(JobPostConstants::TABLE_NAME);
    }
};
