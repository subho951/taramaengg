<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('testimonials')) {
            DB::statement('ALTER TABLE testimonials MODIFY review TEXT NULL');
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('testimonials')) {
            DB::statement('ALTER TABLE testimonials MODIFY review VARCHAR(255) NULL');
        }
    }
};
