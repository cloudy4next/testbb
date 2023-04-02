<?php

namespace Database\Seeders;

use App\Models\ActivityLog;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class UserPermissionSedder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('permissions')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        $permissions = [
            ['name' => 'Page'],
            ['name' => 'Page edit'],
            ['name' => 'Page store'],
            ['name' => 'Page delete'],
            ['name' => 'Project'],
            ['name' => 'Project store'],
            ['name' => 'Project edit'],
            ['name' => 'Project delete'],
            ['name' => 'Notice'],
            ['name' => 'Notice store'],
            ['name' => 'Notice edit'],
            ['name' => 'Notice delete'],
            ['name' => 'Category'],
            ['name' => 'Category edit'],
            ['name' => 'Category delete'],
            ['name' => 'Category store'],
            ['name' => 'Query'],
            ['name' => 'Query store'],
            ['name' => 'Query edit'],
            ['name' => 'Query delete'],
            ['name' => 'News'],
            ['name' => 'News store'],
            ['name' => 'News edit'],
            ['name' => 'News delete'],
            ['name' => 'Settings'],
            ['name' => 'Funded'],
            ['name' => 'ActivityLog'],
            ['name' => 'Notification'],
            ['name' => 'Article'],
            ['name' => 'Article store'],
            ['name' => 'Article edit'],
            ['name' => 'Article delete'],

        ];

        foreach ($permissions as $permission) {
            DB::table('permissions')->insert([
                [
                    'name' => $permission['name'],
                    'guard_name' => 'web',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ]
            ]);
        }
        $user = User::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('123123'),
        ]);

        Role::create(["name" => "Super admin"])->givePermissionTo(Permission::all());
        $user->assignRole('Super admin');

        ActivityLog::where('id', '1')->delete();
    }
}
