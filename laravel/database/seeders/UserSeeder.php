<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Profile;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roleAdmin = Role::create(['name' => 'super-admin']);
        $roleTeacher = Role::create(['name' => 'teacher']);
        $roleWriter = Role::create(['name' => 'writer']);

        $admin = User::create([
            'mobile' => '1234567890'
        ]);
        $admin->assignRole($roleAdmin);
        Profile::create([
            'user_id' => $admin->id,
            'name' => 'AdminName',
            'last_name' => 'AdminLastName',
            'bio' => 'Admin biography here.',
            'avatar' => 'images/user/1.jpg'
        ]);

        $teacher = User::create([
            'mobile' => '0987654321'
        ]);
        $teacher->assignRole($roleTeacher);
        Profile::create([
            'user_id' => $teacher->id,
            // Add profile details for teacher here
        ]);

        $writer = User::create([
            'mobile' => '1122334455'
        ]);
        $writer->assignRole($roleWriter);
        Profile::create([
            'user_id' => $writer->id,
            // Add profile details for writer here
        ]);

        Auth::login($admin);
    }
}
