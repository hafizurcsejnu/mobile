<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;
    /**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
	    'name','user_id','file_type','folder_id'
	];
    /**
     * Get the food's file path.
     *
     * @param  string  $value
     * @return string
     */
    protected $casts = [
        'created_at' => 'date:M d, Y',
    ];
    // /**
    //  * Set the user's first name.
    //  *
    //  * @param  string  $value
    //  * @return void
    //  */
    // public function setFileTypeAttribute($value)
    // {
    //     $this->attributes['file_type'] = (($value=="jpg")?1:($value=="pdf")?2:3);
    // }
    /**
     * This function will rename file
     * @param  [int] $fileId   
     * @param  [string] $fileName 
     * @return [type]           
     */
    public static function renameFile($fileId, $fileName){
        return self::where('id',$fileId)->update([
            'name' => $fileName,
        ]);
    }
    /**
     * This function will copy the selected file
     * @param  [array] $insertArr 
     * @return [type]            
     */
    public static function copyFile ($insertArr) {
    	return self::create($insertArr);
    }
}
