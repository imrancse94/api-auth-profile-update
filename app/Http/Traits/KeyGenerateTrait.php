<?php

namespace App\Http\Traits;

use Illuminate\Support\Facades\Cache;

trait KeyGenerateTrait{

    public function getSecretKey($length = 20) {

        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        return $randomString;
    }

    public function generateRandomDigit(){
        return random_int(100000, 999999);
    }

    public function generatePinAndCacheByUniqueKey($unique_key,$lifetime){
        $pin = $this->generateRandomDigit();
        Cache::put('user_otp_'.$unique_key,$pin ,$lifetime*60);
        return $pin;
    }

    public function getOTP($key){
        return Cache::get('user_otp_'.$key);
    }
}