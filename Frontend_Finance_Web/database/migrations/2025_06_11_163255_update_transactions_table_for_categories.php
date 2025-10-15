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
        Schema::table('transactions', function (Blueprint $table) {
            // Add category_id column
            $table->foreignId('category_id')
                  ->nullable()
                  ->after('type')
                  ->constrained('categories')
                  ->onDelete('set null');

            // Remove the old category string column if it exists
            if (Schema::hasColumn('transactions', 'category')) {
                $table->dropColumn('category');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            // Re-add the old category string column for rollback
            $table->string('category')->nullable()->after('type');

            // Drop the foreign key and column for rollback
            $table->dropConstrainedForeignId('category_id');
        });
    }
};
