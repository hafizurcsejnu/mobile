<?php
namespace App\Services;
use App\Models\Folder;
use Storage;
use Carbon\Carbon;

class FileServices
{
    /**
     * This function will check file max count
     * @return [boolean] 
     */
    public static function validateMaxCount($count){
        if ($count >= config('setting.maxFileUpload')) {
            return false;
        }
        return true;
    }
    /**
     * This function will save files in storage
     * @param  [type] $files 
     * @return [type]        
     */
    public static function saveFile($files,$folderId){
        $fileArr = [];
        foreach($files as $file){
            $name = $file->getClientOriginalName();
            $fileName = time() . '-' . mt_rand(111111, 999999) . '_' . $name;
            $extension = $file->getClientOriginalExtension();
            $path = "user_".session('user_id')."/folder_".$folderId;
            $file->storeAs($path,$fileName);
            if($extension=="jpg"){
                $fileType = 1;
            }elseif($extension=="pdf"){
                $fileType = 2;
            }else{
                $fileType = 3;
            }
            array_push($fileArr, [
                'name' => $fileName,
                'folder_id' => $folderId,
                'user_id' => session('user_id'),
                'file_type' => $fileType,
            ]);
        }
        return $fileArr;
    }
    /**
     * This function will create duplicate file and store it
     * @param  [type] $file 
     * @return [boolean]       
     */
    public static function moveRenamedFile($file,$fileName){
        $isStore = Storage::move("user_" . $file->user_id . "/folder_" . $file->folder_id . "/" . $file->name, "user_" . $file->user_id . "/folder_" . $file->folder_id . "/" . $fileName);
        if ($isStore) {
            return true;
        }
        return false;
    }
    /**
     * This function will move copied file
     * @param  [type] $file 
     * @return [type]       
     */
    public static function moveCopiedFile($file){
        $newFileName = Carbon::now()->timestamp . '_' . $file->name;
        $copied = Storage::copy("user_" . $file->user_id . "/folder_" . $file->folder_id . "/" . $file->name, "user_" . $file->user_id . "/folder_" . $file->folder_id . "/" . $newFileName);
        if ($copied) {
            return [
                'user_id' => $file->user_id,
                'file_type' => $file->file_type,
                'folder_id' => $file->folder_id,
                'name' => $newFileName
            ];
        }
    }
    /**
     * This function will unlink file
     * @param  [string] $fileName 
     * @param  [int] $folderId 
     * @return [type]           
     */
    public static function unlinkFile($fileName,$folderId){
        $path = "user_".session('user_id')."/folder_".$folderId."/".$fileName;
        $isDeleted = Storage::delete($path);
        if ($isDeleted) {
            return true;
        }
        return false;
    }
}