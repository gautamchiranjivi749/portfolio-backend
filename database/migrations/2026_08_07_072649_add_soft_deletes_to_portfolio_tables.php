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
        Schema::table('abouts', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('skills', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('educations', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('services', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('certificates', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('social_links', function (Blueprint $table) {
            $table->softDeletes();
        });

       

        Schema::table('contacts', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
  public function down(): void

{
    Schema::table('abouts', function (Blueprint $table) {
        $table->dropSoftDeletes();
    });

    Schema::table('skills', function (Blueprint $table) {
        $table->dropSoftDeletes();
    });

    Schema::table('educations', function (Blueprint $table) {
        $table->dropSoftDeletes();
    });

    Schema::table('services', function (Blueprint $table) {
        $table->dropSoftDeletes();
    });

    Schema::table('certificates', function (Blueprint $table) {
        $table->dropSoftDeletes();
    });

    Schema::table('social_links', function (Blueprint $table) {
        $table->dropSoftDeletes();
    });

    Schema::table('contacts', function (Blueprint $table) {
        $table->dropSoftDeletes();
    });

    Schema::table('users', function (Blueprint $table) {
        $table->dropSoftDeletes();
    });
}
};
