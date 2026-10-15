<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class exntends Migration
{
    public function up(): void
    {
        DB::statement ("
            CREATE TABLE items (
              id BIGINT GENERATED ALWAYS AS IDENTITY PRIMARY KEY,
              name VARCHAR(255) NOT NULL,
              quantity INT NOT NULL DEFAULT 0 CHECK (QUANTITY >=0),
              deleted_at TIMESTAMP WITH TIME ZONE NULL,
              created_at TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP,
              updated_at TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP
            )
        ");
    }

    public function down(): void
    {
        DB::statement("DROP TABLE items");
    }
}