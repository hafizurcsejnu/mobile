<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\FileRequest;
use App\Http\Requests\EditFileRequest;
use App\Models\File;
use Response;
use App\Services\FileServices;
use Storage;

class FileController extends Controller
{
	/**
	 * This function will create file bulk upload
	 * @param  FileRequest $fileRequest
	 * @return [json]
	 */
	public function create(FileRequest $fileRequest)
	{
		try{
            $status = FileServices::validateMaxCount(count($fileRequest->file));
            if (!$status) {
                return Response::json(array('success' => 'error', 'message' => __('documents.warningMessage.max_file')), 422);
            }
            if($fileRequest->file('file')){
            	$folderId = $fileRequest->folderId;
            	$files = $fileRequest->file('file');
                $fileArr = FileServices::saveFile($files,$folderId);
                File::insert($fileArr);
            }
            return Response::json(array('success' => 'success', 'message' => __('documents.successMessage.file_created')), 200);
        }
        catch (Exception $ex) {
            return Response::json(array('success' => 'error', 'message' => __('documents.errorMessage.file_created')), 500);
        }
	}
	/**
	 * This function will rename the file name
	 * @param  Request $request
	 * @return [json]
	 */
    public function renameFile(EditFileRequest $request){
		try {
			$file = File::findOrFail($request->fileId);
			if ($request->fileName != $file->name) {
				$moved = FileServices::moveRenamedFile($file,$request->fileName);
				if ($moved) {
					$response = File::renameFile($request->fileId,$request->fileName);
					if ($response) {
						return Response::json(array('success' => 'success', 'message' => __('documents.successMessage.file_renamed')), 200);
					}
				}
			}
			return Response::json(array('success' => 'success', 'message' => __('documents.warningMessage.file_renamed')), 422);

		} catch (Exception $e) {
			return Response::json(array('success' => 'error', 'message' => __('documents.errorMessage.file_renamed')), 500);
		}
    }
    /**
     * This function will get file by folder id
     * @param  [int] $type
     * @param  [int] $folderId
     * @return [json]
     */
	public function getFolderFiles ($type, $folderId) {
		try {
			$files = File::select('*')
				->where('user_id', session('user_id'))
				->when($type, function ($query) use ($type) {
					return $query->where('file_type', $type);
				})
				->when($folderId, function ($query) use ($folderId) {
					return $query->where('folder_id', $folderId);
				})
				->get()
				->toArray();
				$totalCount = File::select('*')->where('user_id', session('user_id'))->count();

			if ($files) {
				return Response::json(array('data' => $files, 'success' => 'success', 'totalCount' => $totalCount, 'visibleFileCount' => count($files)), 200);
			} else {
				return Response::json(array('data' => $files, 'success' => 'success', 'totalCount' => $totalCount, 'visibleFileCount' => count($files)), 200);
			}
		} catch (Exception $e) {
			return Response::json(array('success' => 'false', 'message' => __('documents.errorMessage.data_returned')), 500);
		}
	}
    /**
     * This function will delete the file
     * @param  [type] $fileId
     * @return [json]
     */
	public function deleteFile($fileId){
		try {
			$response = File::findOrFail($fileId);
			FileServices::unlinkFile($response->name,$response->folder_id);
			$response->delete();
			return Response::json(array('success' => 'success', 'message' => __('documents.successMessage.file_deleted')), 200);
		} catch (Exception $e) {
			return Response::json(array('success' => 'error', 'message' => __('documents.errorMessage.file_deleted')), 500);
		}
	}

	/**
	 * This function will get file details
	 * @param  [int] $fileId
	 * @return [json]
	 */
	public function getFileById ($fileId) {
		try {
			$response = File::findOrFail($fileId);
			if ($response) {
				return Response::json(array('data' => $response, 'success' => 'success', 'message' => __('documents.successMessage.data_returned')), 200);
			}
		} catch (Exception $e) {
			return Response::json(array('success' => 'error', 'message' => __('documents.errorMessage.data_returned')), 500);
		}
	}
	/**
	 * This function will copy file
	 * @param  Request $request
	 * @return [json]
	 */
	public function copyFile (Request $request) {
		try {
			$file = File::findOrFail($request->fileId);
		    if ($file) {
			    $insertArr = FileServices::moveCopiedFile($file);
			    $file = File::copyFile($insertArr);
			    if ($file) {
				    return Response::json(array('success' => 'success', 'message' => __('documents.successMessage.file_copied')), 200);
			    }
		    }
		} catch (Exception $e) {
			return Response::json(array('success' => 'error', 'message' => __('documents.errorMessage.file_copied')), 500);
		}
	}
	/**
	 * This function will download the file
	 * @param  [int] $fileId
	 * @return [type]
	 */
	public function download($fileId)
	{
		$file = File::findOrFail($fileId);
		$path = "user_" . $file->user_id . "/folder_" . $file->folder_id . "/" . $file->name;
		return Storage::download($path);
	}
}
