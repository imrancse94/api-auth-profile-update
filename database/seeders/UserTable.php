<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Http\Traits\KeyGenerateTrait;
use Illuminate\Support\Facades\Hash;

class UserTable extends Seeder
{
    use KeyGenerateTrait;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $userservice = app('UserService'); // userservice instance
        // Data
        $inputData['name'] = "Imran Hossain";
        $inputData['user_name'] = "imrancse94";
        $inputData['email'] = "imrancse94@gmail.com";
        $inputData['password'] = "123456";
        $inputData['user_role'] = 1; // admin user
        $inputData['status'] = 1;  // Active user
        $inputData['registered_at'] = now();
        $userservice->userRegistration($inputData); // Data insertion
       
    }
}
