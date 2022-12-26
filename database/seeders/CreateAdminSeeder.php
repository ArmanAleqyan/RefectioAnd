<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CreateAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'login' => 'admin@mail.ru',
            'name' => 'Admin',
            'active' => 2,
            'password' => Hash::make('11111111'),
            'phone' => '45454545',
            'phone_veryfi_code' => 1,
            'role_id' => Role::ADMIN_ID,
        ]);
    }
}
