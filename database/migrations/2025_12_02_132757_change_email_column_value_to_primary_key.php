<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Check if the table has a primary key
        $hashedTable = DB::getTablePrefix() . 'password_reset_tokens';
        
        // Get current primary key information
        $primaryKey = DB::select("SHOW KEYS FROM {$hashedTable} WHERE Key_name = 'PRIMARY'");
        
        Schema::table('password_reset_tokens', function (Blueprint $table) use ($primaryKey) {
            // Only drop primary key if it exists and is NOT already on 'email'
            if (!empty($primaryKey)) {
                $currentPrimaryColumn = $primaryKey[0]->Column_name;
                
                if ($currentPrimaryColumn !== 'email') {
                    $table->dropPrimary();
                    $table->primary('email');
                }
            } else {
                // No primary key exists, just add it
                $table->primary('email');
            }
        });
    }

    public function down(): void
    {
        // Define your rollback logic here
        Schema::table('password_reset_tokens', function (Blueprint $table) {
            $table->dropPrimary(['email']);
        });
    }
};