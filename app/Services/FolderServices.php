<?php
namespace App\Services;
use App\Models\Folder;
use App\Models\File;
use Storage;

class FolderServices
{
	/**
	 * This function will save the default folders
	 * @param  [int] $userId        
	 */
	public static function saveDefaultFolders($userId){
		$defaultFolders = config('setting.defaultFolders');
            $folderArray = [];
            foreach ($defaultFolders as $key => $value) {
                $folderArray[] = [
                    'name' => $value,
                    'user_id' => $userId,
                    'priority_order' => $key
                ];
            }
        return Folder::insert($folderArray);
	}
    /**
     * This function will get new folder order
     * @param  [int] $userId
     * @return [int]        
     */
    public static function getFolderOrder($userId){
        $order = (int) Folder::select('priority_order')->where('user_id', $userId)->max('priority_order');
        $newOrder = $order + 1;
        return $newOrder;
    }
    /**
     * This function will delete file inside the given folder
     * @param  [int] $folderId 
     * @return [type]           
     */
    public static function deleteFolderFile($folderId){
        try {
            $files = File::where('folder_id',$folderId)->pluck('name')->toArray();
            foreach ($files as $key => $value) {
                $path = "user_".session('user_id')."/folder_".$folderId."/".$value;
                Storage::delete($path);
            }
            File::where('folder_id',$folderId)->delete();
        } catch (Exception $e) {
            return false;
        }
    }
}