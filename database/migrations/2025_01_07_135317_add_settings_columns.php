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
        Schema::table('settings', function (Blueprint $table) {
            $table->json('hotels')->nullable();
            $table->json('tours')->nullable();
            $table->string('ad_image')->nullable();
            $table->string('ad_title_en')->nullable();
            $table->string('ad_title_ar')->nullable();
            $table->text('ad_description_en')->nullable();
            $table->text('ad_description_ar')->nullable();
            $table->string('ad2_image')->nullable();
            $table->string('ad2_title_en')->nullable();
            $table->string('ad2_title_ar')->nullable();
            $table->text('ad2_description_en')->nullable();
            $table->text('ad2_description_ar')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            //
        });
    }
};
