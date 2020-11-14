<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use App\Models\Work;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        foreach (Role::AVAILABLE_ROLES as $role) {
            DB::table(Role::TABLE_NAME)->insert([
                'name'       => $role,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]);
        }
        User::factory(10)->create()
            ->each(function ($user) {
                $roles = Role::all()->random(mt_rand(1, 3))->pluck(Role::FIELD_ID);
                $user->roles()->attach($roles);
            });
        Work::factory(50)->create();

    }
}
