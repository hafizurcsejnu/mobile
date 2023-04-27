<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Folder;
use App\Models\File;
use App\Models\User;
use App\Services\FolderServices;
use App\Http\Requests\FolderRequest;
use App\Http\Requests\EditFolderRequest;
use Response;

class FolderController extends Controller
{
	/**
	 * This function will pick folder in priority order
	 */
	public function index () {
		return view('my_documents');
	}

	/**
	 * This function will create the folder .
	 * @param  FolderRequest $folderRequest
	 * @return [json]
	 */
    public function create(FolderRequest $folderRequest){
		try{
			$order = FolderServices::getFolderOrder(session('user_id'));
			$response = Folder::saveFolder($folderRequest->folderName, session('user_id'), $order);
			$count = Folder::where('user_id', session('user_id'))->count();
			if ($response) {
				return Response::json(array('data' => $response, 'success' => 'success', 'message' => __('documents.successMessage.folder_created')), 200);
			}
			}catch(Exception $ex){
				return Response::json(array('success' => 'error', 'message' => __('documents.errorMessage.folder_created')), 500);
			}
    }

    /**
     * This function will sorting folder orders
     * @param Request $sortingRequest
     * @return [json]
     */
    public function sorting(Request $sortingRequest){
		try {
			$order = $sortingRequest->order;
			$response = Folder::saveSortingOrder(json_decode($order),session('user_id'));
			if ($response) {
				return Response::json(array('success' => 'success', 'message' => __('documents.successMessage.folder_ordering')), 200);
			}
		} catch (Exception $ex) {
			return Response::json(array('success' => 'error', 'message' => $ex->getMessage()), 500);
		}
    }
    /**
     * This function will rename folder
     * @param  Request $folderRequest
     * @return [json]
     */
    public function renameFolder(EditFolderRequest $folderRequest){
    	try {
    		$response = Folder::renameFolder($folderRequest->all(),session('user_id'));
			if ($response) {
				return Response::json(array('success' => 'success', 'message' => __('documents.successMessage.folder_updated')), 200);
			}
    	} catch (Exception $e) {
    		return Response::json(array('success' => 'error', 'message' => __('documents.errorMessage.folder_updated')), 500);
    	}
    }
    /**
     * This function will delete folder
     * @param  [int] $folderId
     * @return [json]
     */
    public function deleteFolder($folderId){
    	try {
			$count = Folder::where('user_id',session('user_id'))->count();
    		if ($count == 1) {
    			return Response::json(array('success' => 'error', 'message' => __('documents.warningMessage.folder_deleted_max_count')));
    		}
			
    		FolderServices::deleteFolderFile($folderId);
    		$response = Folder::deleteFolder($folderId,session('user_id'));
    	    if ($response) {
    		 	return Response::json(array('success' => 'success', 'message' => __('documents.successMessage.folder_deleted')), 200);
    	    }
    	} catch (Exception $e) {
    		return Response::json(array('success' => 'error', 'message' => __('documents.errorMessage.folder_deleted')), 500);
    	}
    }
    /**
     * This function will return information of given folder id
     * @param  [int] $folderId
     * @return [json]
     */
	public function getFolderById ($folderId) {
		try {
			$response = Folder::findOrFail($folderId);
		    if ($response) {
			    return Response::json(array('data' => $response, 'success' => 'success', 'message' => __('documents.successMessage.data_returned')), 200);
		    }
		} catch (Exception $e) {
			return Response::json(array('success' => 'error', 'message' => __('documents.errorMessage.data_returned')), 500);
		}
	}
	/**
	 * This function will get folderdata
	 * @return [json]
	 */
	public function getTreeData () {
		try {
			$folders = Folder::with(['folders'])
        	->where('user_id', session('user_id'))->orderBy('priority_order','ASC')->get()->toArray();
			$count = Folder::where('user_id', session('user_id'))->count();
		    if ($folders) {
			    return Response::json(array('data' => $folders, 'count' => $count,'success' => 'success', 'message' => __('documents.successMessage.data_returned')), 200);
		    }
		} catch (Exception $e) {
			return Response::json(array('success' => 'error', 'message' => __('documents.errorMessage.data_returned')), 500);
		}
	}
	/**
	 * This function will check file count in selected folder
	 * @param  [int] $folderId
	 * @return [json]
	 */
	public function checkFileExist($folderId){
		$count = File::where('folder_id',$folderId)->count();
		if ($count) {
			return Response::json(array('data' => $count, 'success' => 'success', 'message' => __('documents.warningMessage.folder_deleted_file')), 200);
		}
		return Response::json(array('data' => $count,'success' => 'success', 'message' => __('documents.warningMessage.folder_deleted')), 200);
	}
}
