<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Exception;

class MaxFileSize implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $fileName)
    {
        $extension = $fileName->getClientOriginalExtension();
        $fileSize = $fileName->getSize();
        
        try{
            if ($extension == "pdf") {
                if ($fileSize > 1000000) {
                    return false;
                }
            }
            if ($extension == "jpeg" || $extension == "jpg" || $extension == "doc" || $extension == "docx") {
                if ($fileSize > 200000) {
                    return false;
                }
            }
            return true;
        }
        catch(Exception $e){
            return false;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The file size is to large.';
    }
}
