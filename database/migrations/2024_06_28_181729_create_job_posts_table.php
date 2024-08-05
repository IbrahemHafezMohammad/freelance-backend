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
            $table->integer('application_count')->default(0);
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
