<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        DB::statement("ALTER TABLE users MODIFY role ENUM('pencari', 'pemilik', 'admin') NOT NULL DEFAULT 'pencari'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE users MODIFY role ENUM('pencari', 'pemilik') NOT NULL DEFAULT 'pencari'");
    }
};
