<?php

use App\Constants\SkillConstants;
use App\Constants\CategoryConstants;
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
        Schema::create(SkillConstants::TABLE_NAME, function (Blueprint $table) {
            $table->id();
            $table->string('name', '120')->unique();
            $table->unsignedInteger('active_projects_count')->default(0); // sort depending on the one that have more active projects
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(SkillConstants::TABLE_NAME);
    }
};
