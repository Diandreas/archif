<?php
// database/migrations/2025_01_01_000001_create_blog_tables.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Table des catégories
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->unique();
            $table->string('slug', 100)->unique();
            $table->text('description')->nullable();
            $table->string('color', 7)->default('#007bff');
            $table->string('icon', 50)->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['is_active']);
        });

        // Table des auteurs
        Schema::create('authors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete(); // Relation avec users
            $table->string('name', 100);
            $table->string('email', 100)->unique()->nullable();
            $table->text('bio')->nullable();
            $table->string('avatar')->nullable();
            $table->json('social_links')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['is_active']);
            $table->index(['user_id']);
        });

        // Table des tags
        Schema::create('tags', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50)->unique();
            $table->string('slug', 50)->unique();
            $table->string('color', 7)->default('#6c757d');
            $table->unsignedInteger('usage_count')->default(0);
            $table->timestamps();
        });

        // Table des images
        Schema::create('images', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('original_name')->nullable();
            $table->string('path');
            $table->string('url')->nullable();
            $table->string('mime_type', 100)->nullable();
            $table->unsignedBigInteger('size')->nullable(); // Taille en bytes
            $table->unsignedInteger('width')->nullable();
            $table->unsignedInteger('height')->nullable();
            $table->string('alt_text')->nullable();
            $table->text('description')->nullable();
            $table->boolean('is_une')->default(false); // Pour "À la Une"
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['is_une']);
            $table->index(['is_active']);
            $table->index(['mime_type']);
        });

        // Table des articles
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('excerpt')->nullable();
            $table->longText('content');
            $table->string('featured_image')->nullable();
            $table->json('gallery')->nullable();
            $table->foreignId('category_id')->nullable()->constrained('categories')->nullOnDelete();
            $table->foreignId('author_id')->nullable()->constrained('authors')->nullOnDelete();

            // Statuts et visibilité
            $table->enum('status', ['draft', 'published', 'scheduled', 'archived'])->default('draft');
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_breaking')->default(false);

            // SEO et métadonnées
            $table->string('meta_title', 60)->nullable();
            $table->string('meta_description', 160)->nullable();
            $table->string('meta_keywords')->nullable();

            // Planification
            $table->timestamp('published_at')->nullable();
            $table->timestamp('scheduled_at')->nullable();

            // Statistiques
            $table->unsignedInteger('views_count')->default(0);
            $table->unsignedInteger('likes_count')->default(0);
            $table->unsignedInteger('shares_count')->default(0);

            // Paramètres d'affichage
            $table->unsignedInteger('reading_time')->nullable();
            $table->enum('difficulty_level', ['beginner', 'intermediate', 'advanced'])->nullable();

            $table->timestamps();

            // Index
            $table->index(['status', 'published_at']);
            $table->index(['category_id']);
            $table->index(['author_id']);
            $table->index(['is_featured']);
            $table->index(['slug']);
        });

        // Table de liaison articles-tags
        Schema::create('article_tags', function (Blueprint $table) {
            $table->id();
            $table->foreignId('article_id')->constrained('articles')->cascadeOnDelete();
            $table->foreignId('tag_id')->constrained('tags')->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['article_id', 'tag_id']);
        });

        // Table de liaison articles-images
        Schema::create('article_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('article_id')->constrained('articles')->cascadeOnDelete();
            $table->foreignId('image_id')->constrained('images')->cascadeOnDelete();
            $table->enum('type', ['featured', 'gallery', 'inline'])->default('gallery');
            $table->unsignedInteger('position')->default(0); // Ordre d'affichage
            $table->timestamps();

            $table->index(['article_id', 'type']);
            $table->index(['position']);
        });

        // Table des commentaires
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('article_id')->constrained('articles')->cascadeOnDelete();
            $table->foreignId('parent_id')->nullable()->constrained('comments')->cascadeOnDelete();
            $table->string('author_name', 100);
            $table->string('author_email', 100);
            $table->string('author_website')->nullable();
            $table->text('content');
            $table->enum('status', ['pending', 'approved', 'rejected', 'spam'])->default('pending');
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamps();

            $table->index(['article_id', 'status']);
            $table->index(['parent_id']);
        });

        // Table des sections/boxes promotionnelles
        Schema::create('promotional_boxes', function (Blueprint $table) {
            $table->id();
            $table->string('title', 100);
            $table->text('description');
            $table->string('category', 50);
            $table->string('category_color', 7)->default('#007bff');
            $table->string('image')->nullable();
            $table->string('link_url')->nullable();
            $table->string('link_text', 50)->nullable();
            $table->unsignedInteger('position')->default(0);
            $table->boolean('is_active')->default(true);
            $table->json('display_on')->nullable();
            $table->timestamps();

            $table->index(['is_active', 'position']);
        });

        // Table des vues d'articles
        Schema::create('article_views', function (Blueprint $table) {
            $table->id();
            $table->foreignId('article_id')->constrained('articles')->cascadeOnDelete();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->string('referer')->nullable();
            $table->timestamp('viewed_at')->useCurrent();

            $table->index(['article_id', 'viewed_at']);
        });

        // Table des articles reliés
        Schema::create('related_articles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('article_id')->constrained('articles')->cascadeOnDelete();
            $table->foreignId('related_article_id')->constrained('articles')->cascadeOnDelete();
            $table->enum('relationship_type', ['manual', 'automatic'])->default('manual');
            $table->decimal('score', 3, 2)->default(1.00);
            $table->timestamps();

            $table->unique(['article_id', 'related_article_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('related_articles');
        Schema::dropIfExists('article_views');
        Schema::dropIfExists('promotional_boxes');
        Schema::dropIfExists('comments');
        Schema::dropIfExists('article_images');
        Schema::dropIfExists('article_tags');
        Schema::dropIfExists('articles');
        Schema::dropIfExists('images');
        Schema::dropIfExists('tags');
        Schema::dropIfExists('authors');
        Schema::dropIfExists('categories');
    }
};
