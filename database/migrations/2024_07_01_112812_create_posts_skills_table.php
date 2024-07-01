<?php

use App\Constants\SkillConstants;
use App\Constants\JobPostConstants;
use App\Constants\PostSkillConstants;
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
        Schema::create(PostSkillConstants::TABLE_NAME, function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_post_id')->constrained(JobPostConstants::TABLE_NAME);
            $table->foreignId('skill_id')->constrained(SkillConstants::TABLE_NAME);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(PostSkillConstants::TABLE_NAME);
    }
};
