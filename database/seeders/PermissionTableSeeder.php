<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'role-list',
            'role-create',
            'role-edit',
            'role-delete',

            'department-list', 
            'department-create', 
            'department-edit', 
            'department-delete',

            'project-list', 
            'project-create', 
            'project-edit', 
            'project-delete',

            'task-list', 
            'task-create', 
            'task-edit', 
            'task-delete',

            'status-list', 
            'status-create', 
            'status-edit', 
            'status-delete', 

            'user-list', 
            'user-create', 
            'user-edit', 
            'user-delete',

            'permission-list', 
            'permission-create', 
            'permission-edit', 
            'permission-delete',

            'setting-list', 
            'setting-create', 
            'setting-edit', 
            'setting-delete'
         ];
      
         foreach ($permissions as $permission) {
              Permission::create(['name' => $permission]);
         }
    }
}
