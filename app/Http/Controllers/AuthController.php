<?php

namespace App\Http\Controllers;

use App\Http\Requests\InvitationRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\OTPRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\UserProfileRequest;
use App\Http\Requests\UserRequest;
use App\Http\Traits\KeyGenerateTrait;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Http\Traits\FileUploadTrait;
class AuthController extends Controller
{
    use KeyGenerateTrait,FileUploadTrait;

    public function login(LoginRequest $request){
        $credentials = $request->only('user_name', 'password');
        
        $data = [];
        $credentials['status'] = config('constant.USER_STATUS_ACTIVE');
        //Crean token
        try {

            if (!$token = auth()->attempt($credentials)) {
                return $this->sendError(__('Login credentials are invalid.'),[],config('constant.LOGIN_FAILED'));
            }
            $data['user_name'] = $credentials['user_name'];
            $data['access_token'] = $token;
            
        } catch (JWTException $e) {
            //dd($e->getMessage());
            return $this->sendError(__('Could not create token.'),[],config('constant.LOGIN_FAILED'));
        }

        return $this->sendResponse($data,__('Login successfully'),config('constant.LOGIN_SUCCESS'));
    }


    public function register(RegisterRequest $request){
        $inputData = $request->all();
        $data = [];
        $message = __('Registration Failed.');

        $userservice = app('UserService'); // Instance of userservice
        $data = $userservice->userRegistration($inputData);
        unset($data['id']);
        if(!empty($data)){
            $message = __('Registration Successfull.');
            return $this->sendResponse($data,$message,config('constant.REGISTER_SUCCESS'));
        }

        return $this->sendError($message,$data,config('constant.REGISTER_FAILED'));
    }


    public function sendInvitaion(InvitationRequest $request){ // send to invitaion link to user
        
        $inputData = $request->all();
        try{
            $userservice = app('UserService'); // Instance of userservice

            if($data = $userservice->userRegistration($inputData,2)){ // 2 = user
                $unique_key = $this->getSecretKey();
                $unique_key .=$data['id'];
                $userservice->updateUserInfo(['unique_key'=>$unique_key],$data['id']);

                $email_subject = __("Invitation to sign up"); // Email Subject
                $from = "test@example.com"; // From Email
                $attachment = "";
                $template = "Email.user_invitation"; // Email template

                // send email data 
                $emailData['url'] = route("user.register",$unique_key);

                // send email
                $this->sendEmail($emailData,$email_subject,$from,$attachment,$template,$inputData['email']);

                return $this->sendResponse([],__("Invitation has been sent to user email."),config('constant.USER_INVITATION_SUCCESS'));
            }
            
        }catch(\Exception $ex){
            //dd($ex->getMessage());
        }
        
        return $this->sendError(__('Invaitation failed'),[],config('constant.USER_INVITATION_FAILED'));    
    }

    public function userRegister(UserRequest $request,$unique_key)
    {
        $inputData = $request->all();
        $userservice = app('UserService'); // Instance of userservice

        if($userData = $userservice->getUserByUniqueKey($unique_key,2)){ // 2 = user
            if($userservice->updateUserInfo($inputData,$userData->id)){
                $email_subject = __("Confirmation"); // Email Subject
                $from = "test@example.com"; // From Email
                $attachment = "";
                $template = "Email.user_registration"; // Email template

                // send email data
                $emailData['lifetime'] = config('constant.OTP_TIME');
                $emailData['pin'] = $this->generatePinAndCacheByUniqueKey($unique_key,$emailData['lifetime']);
                $emailData['url'] = route("user.confirmation",$unique_key);
                
                // send email
                $this->sendEmail($emailData,$email_subject,$from,$attachment,$template,$userData->email);

                return $this->sendResponse([],__("Please check your email and confirm the code."),config('constant.REGISTER_SUCCESS'));
            }
        }
        
        return $this->sendError(__('Invalid request'),[],config('constant.INVALID_REQUEST')); 
    }

    public function userConfirmation(OTPRequest $request,$unique_key){ // user submit pin and register
        $inputData = $request->all();
        $userservice = app('UserService'); // Instance of userservice

        if($userData = $userservice->getUserByUniqueKey($unique_key,2)){ // 2 = user
            if($this->getOTP($unique_key) == $inputData['pin']){
                $updateData['status'] = 1;
                $inputData['registered_at'] = getSysCurrentDateTime();
                if($userservice->updateUserInfo($updateData,$userData->id)){
                    return $this->sendResponse([],__("Registration Successfully done."),config('constant.OTP_SUCCESS'));
                }
            }else{
                return $this->sendError(__('Pin not found or expired'),[],config('constant.OTP_FAILED')); 
            }
        } 

        return $this->sendError(__('Invalid request'),[],config('constant.INVALID_REQUEST')); 
    }

    public function profileUpdate(UserProfileRequest $request){
        $inputData = $request->all();
        $user = auth()->user();
        if(!empty($inputData['avatar'])){
            $inputData['avatar'] = $this->uploadFile($inputData['avatar'],"",$user['avatar']);
        }
        
        if($user->update($inputData)){
            return $this->sendResponse([],__("Profile update Successfully."),config('constant.PROFILE_UPDATE_SUCCESS'));
        }

        //PROFILE_UPDATE_FAILED

        return $this->sendError(__('Profile update failed.'),[],config('constant.PROFILE_UPDATE_FAILED')); 
    }

}
