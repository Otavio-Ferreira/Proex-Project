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
        Schema::create('external_partners', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('response_forms_id');
            $table->text('name_partner')->nullable();
            $table->text('institution_type')->nullable();
            $table->text('partnership_type')->nullable();
            $table->foreign('response_forms_id')->references('id')->on('forms_responses')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('external_partners');
    }
};
