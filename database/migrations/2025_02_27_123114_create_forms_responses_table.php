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
        Schema::create('forms_responses', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('forms_id');
            $table->uuid('user_id');
            $table->uuid('title_action')->nullable();
            $table->text('type_action')->nullable();
            $table->text('action_modality')->nullable();
            $table->text('coordinator_name')->nullable();
            $table->text('coordinator_profile')->nullable();
            $table->text('coordinator_siape')->nullable();
            $table->uuid('coordinator_course')->nullable();
            $table->bigInteger('qtd_internal_audience')->nullable();
            $table->bigInteger('qtd_external_audience')->nullable();
            $table->text('advances_extensionist_action')->nullable();
            $table->text('social_technology_development')->nullable();
            $table->text('instrument_avaliation')->nullable();
            $table->foreign('forms_id')->references('id')->on('forms')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->boolean('was_finished')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('forms_responses');
    }
};
