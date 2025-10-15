<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use App\Models\Article;

return new class extends Migration
{
    public function up()
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->string('slug')->nullable()->after('title');
        });

        // Generate slugs for existing articles
        Article::all()->each(function ($article) {
            $article->slug = Str::slug($article->title);
            $article->save();
        });

        // Now make the column unique and not nullable
        Schema::table('articles', function (Blueprint $table) {
            $table->unique('slug');
            $table->string('slug')->nullable(false)->change();
        });
    }

    public function down()
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->dropColumn('slug');
        });
    }
}; 