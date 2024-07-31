<?php

use App\Constants\SeekerConstants;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use App\Constants\JobApplicationConstants;
use App\Constants\JobPostConstants;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(JobApplicationConstants::TABLE_NAME, function (Blueprint $table) {
            $table->id();
            $table->foreignId('seeker_id')->constrained(SeekerConstants::TABLE_NAME);
            $table->foreignId('job_post_id')->constrained(JobPostConstants::TABLE_NAME);
            $table->text('resume');
            $table->text('message')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(JobApplicationConstants::TABLE_NAME);
    }
};
