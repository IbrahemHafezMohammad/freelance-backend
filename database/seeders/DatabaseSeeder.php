<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use App\Models\Admin;
use Illuminate\Database\Seeder;
use App\Constants\UserConstants;
use App\Constants\GlobalConstants;
use App\Models\Skill;
use Spatie\Permission\Models\Role;
use Illuminate\Auth\Events\Registered;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $password = '1234qweR+';
        
        //add admins
        $user1 = User::create([
            'user_name' => 'ibrahem',
            'password' => $password,
            'name' => 'ibrahem',
            'phone' => '+963992861407',
            'email' => 'ibrahem.mohammad.acm.999@gmail.com',
            'gender' => UserConstants::GENDER_MALE,
            'email_verified_at' => now()->toDateTimeString(),
        ]);

        $user1->admin()->create();

        // event(new Registered($user1));

        $labels = [
            'edit-admin',
            'list-admin',
            'create-admin',
            'create-role',
            'create-category',
            'update-category',
            'view-categories',
            'toggle-category-status',
            'create-skill',
            'update-skill',
            'view-skills'
        ];

        $permissions = [];
        foreach ($labels as $permissionName) {
            $permission = Permission::create([
                'name' => $permissionName,
            ]);
            $permissions[] = $permission;
        }

        // Create admin role and sync permissions
        $role = Role::create(['name' => 'super-admin']);
        $role->syncPermissions($permissions);

        $user1->assignRole('super-admin');

        $skills = [
            'web developer',
            'network engineer',
            'software engineer',
            'UI designer',
            'php developer',
            'nodejs developer',
            'react developer'
        ];

        foreach($skills as $skill) {
            Skill::create([
                'name' => $skill, 
            ]);
        }
    }
}
