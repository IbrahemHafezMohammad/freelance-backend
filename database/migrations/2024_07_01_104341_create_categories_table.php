<?php

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
        Schema::create(CategoryConstants::TABLE_NAME, function (Blueprint $table) {
            $table->id();
            $table->string('name', '255');
            $table->boolean('status');
            $table->text('image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(CategoryConstants::TABLE_NAME);
    }
};
