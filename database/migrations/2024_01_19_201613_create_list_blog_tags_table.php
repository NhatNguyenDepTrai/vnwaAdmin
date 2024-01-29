<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('list_blog_tags', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_blog_tag')->constrained('blog_tags', 'id');
            $table->integer('id_blog');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('list_blog_tags');
    }
};
