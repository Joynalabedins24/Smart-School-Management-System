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
        // ১. students টেবিলে avatar_url কলাম যোগ করা হচ্ছে
        if (Schema::hasTable('students')) {
            Schema::table('students', function (Blueprint $table) {
                // RPM এর লিংক বড় হতে পারে তাই text ব্যবহার করা নিরাপদ
                $table->text('avatar_url')->nullable()->after('id');
            });
        }

        // ২. teachers টেবিলে avatar_url কলাম যোগ করা হচ্ছে
        if (Schema::hasTable('teachers')) {
            Schema::table('teachers', function (Blueprint $table) {
                $table->text('avatar_url')->nullable()->after('id');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('students')) {
            Schema::table('students', function (Blueprint $table) {
                $table->dropColumn('avatar_url');
            });
        }

        if (Schema::hasTable('teachers')) {
            Schema::table('teachers', function (Blueprint $table) {
                $table->dropColumn('avatar_url');
            });
        }
    }
};
