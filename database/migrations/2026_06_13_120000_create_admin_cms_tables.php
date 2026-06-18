<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('categories')) {
            Schema::create('categories', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('parent_id')->default(0);
                $table->string('category_name', 250);
                $table->string('slug', 250)->index();
                $table->string('cover_image', 250)->nullable();
                $table->string('banner_image', 250)->nullable();
                $table->longText('short_description')->nullable();
                $table->longText('description')->nullable();
                $table->boolean('is_feature')->default(false);
                $table->longText('meta_title')->nullable();
                $table->longText('meta_description')->nullable();
                $table->longText('meta_keywords')->nullable();
                $table->unsignedTinyInteger('status')->default(1);
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('products')) {
            Schema::create('products', function (Blueprint $table) {
                $table->id();
                $table->string('product_nature', 50)->default('Physical');
                $table->string('who_made_it', 250)->nullable();
                $table->string('what_is_it', 250)->nullable();
                $table->unsignedSmallInteger('manufacture_year')->nullable();
                $table->boolean('shop_produce_item')->default(false);
                $table->string('tools_used', 250)->nullable();
                $table->unsignedBigInteger('main_category')->default(0)->index();
                $table->unsignedBigInteger('sub_category')->default(0)->index();
                $table->longText('name');
                $table->longText('slug');
                $table->decimal('base_price', 10, 2)->default(0);
                $table->string('price_percentage', 250)->nullable();
                $table->decimal('markup_price', 10, 2)->default(0);
                $table->decimal('discount_amount', 10, 2)->default(0);
                $table->decimal('discounted_price', 10, 2)->default(0);
                $table->string('cover_image', 250)->nullable();
                $table->longText('short_description')->nullable();
                $table->longText('long_description')->nullable();
                $table->boolean('is_personalization')->default(false);
                $table->longText('personalization_instruction')->nullable();
                $table->string('product_sku', 250)->nullable();
                $table->integer('product_qty')->default(0);
                $table->string('product_weight', 250)->nullable();
                $table->string('product_weight_lb', 250)->nullable();
                $table->string('product_weight_oz', 250)->nullable();
                $table->string('product_length', 250)->nullable();
                $table->string('product_width', 250)->nullable();
                $table->string('product_height', 250)->nullable();
                $table->string('related_products', 250)->nullable();
                $table->boolean('is_feature')->default(false);
                $table->string('manufacturer', 250)->nullable();
                $table->string('product_video_code', 250)->nullable();
                $table->string('product_video', 250)->nullable();
                $table->longText('tags')->nullable();
                $table->longText('materials')->nullable();
                $table->unsignedBigInteger('shipping_policy_id')->default(0);
                $table->longText('shipping_info')->nullable();
                $table->string('shipping_type', 20)->default('FREE');
                $table->decimal('shipping_rate', 10, 2)->default(0);
                $table->unsignedBigInteger('return_policy_id')->default(0);
                $table->longText('meta_title')->nullable();
                $table->longText('meta_description')->nullable();
                $table->longText('meta_keywords')->nullable();
                $table->boolean('is_new')->default(false);
                $table->unsignedTinyInteger('status')->default(1);
                $table->unsignedBigInteger('created_by')->default(0);
                $table->unsignedBigInteger('updated_by')->default(0);
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('blog_categories')) {
            Schema::create('blog_categories', function (Blueprint $table) {
                $table->id();
                $table->string('name', 250);
                $table->string('slug', 250)->index();
                $table->longText('description')->nullable();
                $table->unsignedTinyInteger('status')->default(1);
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('blogs')) {
            Schema::create('blogs', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('blog_category_id')->default(0)->index();
                $table->string('title', 250);
                $table->string('slug', 250)->index();
                $table->string('blog_image', 250)->nullable();
                $table->longText('short_description')->nullable();
                $table->longText('long_description')->nullable();
                $table->date('publish_date')->nullable();
                $table->longText('meta_title')->nullable();
                $table->longText('meta_description')->nullable();
                $table->longText('meta_keywords')->nullable();
                $table->unsignedTinyInteger('status')->default(1);
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('why_us_points')) {
            Schema::create('why_us_points', function (Blueprint $table) {
                $table->id();
                $table->string('title', 250);
                $table->longText('description')->nullable();
                $table->string('icon', 100)->nullable();
                $table->integer('rank')->default(0);
                $table->unsignedTinyInteger('status')->default(1);
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('homepage_counters')) {
            Schema::create('homepage_counters', function (Blueprint $table) {
                $table->id();
                $table->string('label', 250);
                $table->unsignedBigInteger('value')->default(0);
                $table->string('suffix', 20)->nullable();
                $table->string('icon', 100)->nullable();
                $table->integer('rank')->default(0);
                $table->unsignedTinyInteger('status')->default(1);
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('career_applications')) {
            Schema::create('career_applications', function (Blueprint $table) {
                $table->id();
                $table->string('name', 250);
                $table->string('email', 250);
                $table->string('phone', 50);
                $table->string('position', 250);
                $table->string('experience', 100)->nullable();
                $table->longText('message')->nullable();
                $table->string('resume', 250)->nullable();
                $table->string('status', 30)->default('NEW')->index();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('client_logos')) {
            Schema::create('client_logos', function (Blueprint $table) {
                $table->id();
                $table->string('name', 250);
                $table->string('website_url', 500)->nullable();
                $table->string('logo', 250);
                $table->integer('rank')->default(0);
                $table->unsignedTinyInteger('status')->default(1);
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('client_logos');
        Schema::dropIfExists('career_applications');
        Schema::dropIfExists('homepage_counters');
        Schema::dropIfExists('why_us_points');
    }
};
