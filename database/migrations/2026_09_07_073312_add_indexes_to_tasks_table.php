<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->index(['user_id', 'status', 'created_at'], 'tasks_user_status_created_idx');
            $table->index(['user_id', 'title'], 'tasks_user_title_idx');
        });
    }

    public function down(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropIndex('tasks_user_status_created_idx');
            $table->dropIndex('tasks_user_title_idx');
        });
    }
};
