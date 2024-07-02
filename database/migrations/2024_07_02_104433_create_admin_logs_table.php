<?php

use App\Constants\UserConstants;
use App\Constants\AdminLogConstants;
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
        Schema::create(AdminLogConstants::TABLE_NAME, function (Blueprint $table) {
            $table->id();
            $table->text('change');
            $table->string('ip');
            $table->foreignId('actor_id')->nullable()->constrained(UserConstants::TABLE_NAME)->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(AdminLogConstants::TABLE_NAME);
    }
};
