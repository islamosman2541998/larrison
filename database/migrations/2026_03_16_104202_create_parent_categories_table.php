<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('parent_categories', function (Blueprint $table) {
            $table->id();
            $table->string('image')->nullable();
            $table->integer('sort')->default(0);
            $table->boolean('feature')->default(0);
            $table->boolean('status')->default(1);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('created_by')->references('id')->on('users')->nullOnDelete();
            $table->foreign('updated_by')->references('id')->on('users')->nullOnDelete();
        });

        Schema::create('parent_category_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('parent_category_id');
            $table->string('locale')->index();
            $table->string('title');
            $table->string('slug')->nullable();
            $table->text('description')->nullable();
            $table->string('meta_title')->nullable();
            $table->text('meta_desc')->nullable();
            $table->text('meta_key')->nullable();
            $table->timestamps();

            $table->unique(['parent_category_id', 'locale']);
            $table->foreign('parent_category_id')->references('id')->on('parent_categories')->cascadeOnDelete();
        });

        // Pivot table: parent_category has many product_categories
        Schema::create('parent_category_product_category', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('parent_category_id');
            $table->unsignedBigInteger('product_category_id');
            $table->timestamps();

            $table->foreign('parent_category_id')->references('id')->on('parent_categories')->cascadeOnDelete();
            $table->foreign('product_category_id')->references('id')->on('product_categories')->cascadeOnDelete();

            $table->unique(['parent_category_id', 'product_category_id'], 'parent_product_cat_unique');
        });
    }

    public function down()
    {
        Schema::dropIfExists('parent_category_product_category');
        Schema::dropIfExists('parent_category_translations');
        Schema::dropIfExists('parent_categories');
    }
};