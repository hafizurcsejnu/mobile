<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\Folder;

class FolderRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    private $userId;
    public function __construct($userId)
    {
        $this->userId = $userId;
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
        $response = Folder::where(['user_id'=>$this->userId,'name'=>$value])->exists();
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
