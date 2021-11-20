<?php

namespace App\Http\Traits;

use Illuminate\Support\Facades\File;

trait FileUploadTrait{

    public function uploadFile($file,$name = "",$old_file = ""){
        try{
            $fileName = time().'.'.$file->extension(); 
            if(!empty($name)){
                $fileName = $name.'.'.$file->extension(); 
            } 
            
            if(File::exists(storage_path("app/public/{$old_file}"))){
                File::delete(storage_path("app/public/{$old_file}"));
            }
            return $file->storeAs('uploads', $fileName,'public');
        }catch(\Exception $ex){
           
        }

        return null;
    }

    
}