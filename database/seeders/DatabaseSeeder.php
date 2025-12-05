<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Asprak account
        User::create([
            'name' => 'Asprak',
            'email' => 'asprak1@gmail.com',
            'password' => Hash::make('asprak12345'),
            'usertype' => 'asprak',
            'email_verified_at' => now(),
        ]);

        // Create Praktikan account
        User::create([
            'name' => 'Praktikan',
            'email' => 'praktikan@gmail.com',
            'password' => Hash::make('praktikan12345'),
            'usertype' => 'praktikan',
            'email_verified_at' => now(),
        ]);

        // Create Laboran account
        User::create([
            'name' => 'Laboran',
            'email' => 'laboran@gmail.com',
            'password' => Hash::make('laboran12345'),
            'usertype' => 'laboran',
            'email_verified_at' => now(),
        ]);

        // Create Dosen account
        User::create([
            'name' => 'Dosen',
            'email' => 'dosen@gmail.com',
            'password' => Hash::make('dosen12345'),
            'usertype' => 'dosen',
            'email_verified_at' => now(),
        ]);
    }
}
