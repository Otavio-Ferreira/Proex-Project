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
        Schema::create('extension_actions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('response_forms_id');
            $table->text('title_action')->nullable();
            $table->boolean('its_for_public_schools')->nullable();
            $table->text('international_description')->nullable();
            $table->foreign('response_forms_id')->references('id')->on('forms_responses')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('extension_actions');
    }
};
