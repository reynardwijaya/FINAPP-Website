<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('financial_analyses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('analysis_type', ['monthly', 'yearly']);
            $table->date('analysis_date');
            $table->json('financial_metrics');
            $table->text('analysis_summary');
            $table->json('recommendations');
            $table->json('related_resources'); // Store article IDs and video links
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('financial_analyses');
    }
}; 