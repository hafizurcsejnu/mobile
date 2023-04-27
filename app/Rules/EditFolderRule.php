<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\Folder;

class EditFolderRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    private $userId,$id;
    public function __construct($userId,$id)
    {
        $this->userId = $userId;
        $this->id = $id;
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
        $response = Folder::where(['user_id'=>$this->userId,'name'=>$value])
        ->where('id','!=',$this->id)->exists();
        if ($response) {
            return false;
        }
        return true;
    }
    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Folder name already exists.';
    }
}
