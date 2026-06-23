<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('menus') && Schema::hasColumn('menus', 'module_id')) {
            Schema::table('menus', function (Blueprint $table) {
                $table->dropForeign(['module_id']);
                $table->dropColumn('module_id');
            });
        }

        Schema::dropIfExists('modules');
    }

    public function down(): void
    {
        Schema::create('modules', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });

        if (Schema::hasTable('menus') && !Schema::hasColumn('menus', 'module_id')) {
            Schema::table('menus', function (Blueprint $table) {
                $table->foreignId('module_id')->nullable()->constrained('modules')->onDelete('set null');
            });
        }
    }
};
