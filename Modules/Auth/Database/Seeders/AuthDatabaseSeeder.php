<?php

namespace Modules\Auth\Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Modules\Auth\Entities\Admin;
use Modules\Auth\Entities\User;

class AuthDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Admin::create([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'email_verified_at' => Carbon::now(),
            'password' => bcrypt('gz3uvN3O7@7@'),
        ]);

        User::create([
            'name' => 'ahmed tarek',
            'email' => 'aa.tarek@gmail.com',
            'status' => 1,
            'email_verified_at' => Carbon::now(),
            'password' => bcrypt('Mm01011093385@'),
        ]);
    }
}
