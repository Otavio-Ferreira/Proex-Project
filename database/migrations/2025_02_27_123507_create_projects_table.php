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
        Schema::create('projects', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->text('title')->nullable();
            $table->text('type')->nullable();
            $table->text('modality')->nullable();
            $table->uuid('course')->nullable();
            $table->foreign('course')->references('id')->on('courses')->onDelete('cascade');
            $table->uuid('coordinator')->nullable();
            $table->foreign('coordinator')->references('id')->on('users')->onDelete('cascade');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->integer('status')->nullable();

            $table->text('id_atividade')->nullable();
            $table->text('id_projeto')->nullable();
            $table->integer('year')->nullable();
            $table->text('thematic_area')->nullable();

            $table->string('type_submit');
            $table->uuid('id_submit');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
