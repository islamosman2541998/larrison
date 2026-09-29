<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('page_sections', function (Blueprint $table) {
            $table->id();
            // Which page the section belongs to, e.g. "contact".
            $table->string('page')->index();
            // Section identifier inside that page, e.g. "side".
            $table->string('key');
            $table->timestamps();

            $table->unique(['page', 'key']);
        });

        Schema::create('page_section_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('page_section_id');
            $table->string('locale')->index();
            // Field name => text. Kept as JSON so a new editable text is one
            // line in config/page_sections.php, never a migration.
            $table->json('values')->nullable();
            $table->timestamps();

            $table->unique(['page_section_id', 'locale']);
            $table->foreign('page_section_id')
                ->references('id')->on('page_sections')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('page_section_translations');
        Schema::dropIfExists('page_sections');
    }
};
