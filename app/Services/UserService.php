<?php

namespace App\Services;

use App\Models\User;

use App\Http\Traits\FileUploadTrait;
use App\Http\Traits\SendEmailTrait;
use App\Http\Traits\KeyGenerateTrait;
//use Carbon\Carbon;

class UserService extends Service{
    
    use FileUploadTrait,
        SendEmailTrait,
        KeyGenerateTrait;

    private $user;

    public function __construct()
    {
        $this->user = new User;
    }
    public function userRegistration($inputData, $user_role = 1){ // user type user = 2, admin=1 
        $result = [];
        \DB::beginTransaction();
        try{
            // Image upload if exists
            if(!empty($inputData['avatar'])){
                $inputData['avatar'] = $this->uploadFile($inputData['avatar']);
            }
            
            $inputData['user_role'] = $user_role;
            if(isset($inputData['registered_at']) && !empty($inputData['registered_at'])){
                $inputData['registered_at'] = getSysCurrentDateTime();
            }

            // insert data
            if($data = $this->user->addUser($inputData)){
                $result['id'] = $data->id;
                $result['name'] = $data->name;
                $result['username'] = $data->user_name;
                $result['email'] = $data->email;
                $result['user_role'] = $data->user_role;
            } 
            \DB::commit();
        }catch(\Exception $ex){
            \DB::rollback();
            //dd($ex->getMessage());
        }
        
        return $result;
    }

    public function updateUserInfo($inputData,$id)
    {
       try{
            if(isset($inputData['password']) && !empty($inputData['password'])){
                $inputData['password'] = bcrypt($inputData['password']);
            }

            if(isset($inputData['registered_at']) && !empty($inputData['registered_at'])){
                $inputData['registered_at'] = getSysCurrentDateTime();
            }
            return $this->user->where('id',$id)->update($inputData);
       }catch(\Exception $ex){
            dd($ex->getMessage());
       }
       
       return false;
    }

    public function getUserByUniqueKey($unique_key,$user_role){
        try{
            return $this->user
                    ->where('unique_key',$unique_key)
                    ->where('user_role',$user_role)
                    ->first();
        }catch(\Exception $ex){
            dd($ex->getMessage());
        }
        
        return null;
    }
}