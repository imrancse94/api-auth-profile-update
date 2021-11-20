<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ImageValidationRule implements Rule
{

    private $width,$height;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($width,$height)
    {
        $this->width = $width;
        $this->height = $height;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $image = getimagesize($value);
        $result = true;
        if($image[0] > $this->width || $image[1] > $this->height){
            $result = false;
        }

       return $result;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return "The :attribute height and width must be {$this->height}px and {$this->width}px.";
    }
}
