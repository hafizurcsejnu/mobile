<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Folder extends Model
{
    use HasFactory;

    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [
        'name','user_id','priority_order'
    ];

    /**
    * This function will save folder
    * @param [string] $folderName
    * @param [int] $userId
    * @param [int] $order
    */
    public static function saveFolder($folderName, $userId, $order){
        return self::create([
            'name' => $folderName,
            'user_id' => $userId,
            'priority_order' => $order
        ]);
    }

    /**
    * This function will sorting folder order
    * @param [array] $sortingRequest
    * @param [int] $userId
    */
    public static function saveSortingOrder($order,$userId){
        $folderArray = [];
        $i = 1;
        foreach ($order as $key => $value) {
            self::updateOrCreate(
                ['id' => $value->id],
                ['priority_order' => $i++]
            );
        }

        return true;
    }

    /**
    * This function will rename folder
    * @param [array] $renameRequest
    * @param [int] $userId
    */
    public static function renameFolder($renameRequest,$userId){
        return self::where('id',$renameRequest['id'])->update([
            'name' => $renameRequest['folderName']
        ]);
    }

    /**
    * This function will delete the folder
    * @param [int] $folderId
    */
    public static function deleteFolder($folderId){
        return self::findOrFail($folderId)->delete();
    }
    /**
     * Reletionship for folder
     * @return [type] 
     */
    public function folders() {
        return $this->hasMany(Folder::class, 'id', 'user_id');
    }
}
