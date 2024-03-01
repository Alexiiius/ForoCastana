<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory(10)->create();
        \App\Models\Thread::factory(20)->create();
        \App\Models\Comment::factory(100)->create();
        
        // Crea 2 bans y marca a los usuarios como bloqueados
        \App\Models\Ban::factory(2)->create()->each(function ($ban) {
            $user = \App\Models\User::find($ban->user_id);
            $user->block();
            $user->save();
        });
        
    }
}
