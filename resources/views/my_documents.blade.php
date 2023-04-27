
@extends('layouts.master')
@section('main_content')
@push('in-page-style')
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="stylesheet" type="text/css" href="{{asset('assets/js/jqtree/jqtree.css')}}">
  <link rel="stylesheet" type="text/css" href="{{asset('assets/js/dropzone/dist/dropzone.css')}}">
  <link rel="stylesheet" type="text/css" href="{{asset('assets/dist/css/lightbox.min.css')}}">
  <link rel="stylesheet" type="text/css" href="{{asset('assets/js/documents/my-documents.css')}}">
@endpush
<div class="page-content container container-plus">
  <div class="page-header pb-2">
    <h1 class="page-title text-primary-d2 text-150">
      {{__('documents.header')}}
    </h1>
  </div>
  <!-- Left side card -->
  <div class="row mt-475">
    <div class="col-12 col-sm-4 cards-container">
      <div class="card ccard">
        <div class="card-body p-4">
          <h6 class="card-title">
            {{__('documents.label.show')}}
          </h6>
          <ul class="nav nav-tabs bgc-default-l5 nav-tabs-simple nav-tabs-scroll is-scrollable nav-tabs-static nav-tabs-faded border-1 brc-default-l1 mx-n3 mx-md-0 px-3 pb-2px mb-3" role="tablist">
            <li class="nav-item mr-3 fileTypes">
              <a class="active btn btn-outline-secondary bgc-transparent btn-brc-tp btn-bold btn-h-outline-secondary btn-a-outline-primary btn-a-text-dark py-25 px-15 border-none border-b-3 radius-0" data-toggle="tab" href="#home17" role="tab" aria-selected="true">
                {{__('documents.label.all')}}
              </a>
            </li>
            <li class="nav-item mr-3 fileTypes" data-type="2">
              <a class="btn btn-outline-secondary bgc-transparent btn-brc-tp btn-bold btn-h-outline-secondary btn-a-outline-primary btn-a-text-dark py-25 px-15 border-none border-b-3 radius-0" data-toggle="tab" href="#profile17" role="tab" aria-selected="false">
                {{__('documents.label.pdf')}}
              </a>
            </li>
            <li class="nav-item mr-3 fileTypes" data-type="3">
              <a class="btn btn-outline-secondary bgc-transparent btn-brc-tp btn-bold btn-h-outline-secondary btn-a-outline-primary btn-a-text-dark py-25 px-15 border-none border-b-3 radius-0" data-toggle="tab" href="#more17" role="tab" aria-selected="false">
                {{__('documents.label.doc')}}
              </a>
            </li>
            <li class="nav-item mr-3 fileTypes" data-type="1">
              <a class="btn btn-outline-secondary bgc-transparent btn-brc-tp btn-bold btn-h-outline-secondary btn-a-outline-primary btn-a-text-dark py-25 px-15 border-none border-b-3 radius-0" data-toggle="tab" href="#more17" role="tab" aria-selected="false">
                {{__('documents.label.images')}}
              </a>
            </li>
          </ul>
          <button type="button" class="btn px-4 btn-primary mb-1 upload-files-btn" data-toggle="modal" data-target="#fileUpload">{{__('documents.buttons.upload_file')}}</button>
          <h6 class="card-title mt-3">
            {{__('documents.label.folders')}}
          </h6>
          <ul class="list-group mb-3" id="sortableContainer">
            <!-- replace folders name -->
          </ul>
          <!-- using jqtree -->
          <div class="folder-action-btn">
            <button type="button" class="btn btn-sm btn-outline-primary px-4 mb-1" id="create-folder-btn" data-toggle="modal" data-target="#createFolder">{{__('documents.buttons.create_folder')}}</button>
            <div>
              <button class="btn btn-danger btn-sm mb-1" id="delete-folder" data-toggle="tooltip" data-placement="auto" title="Delete Folder" disabled><i class="fa fa-times"></i></button>
              <button class="btn btn-info btn-sm mb-1 mr-1" id="rename-folder" data-toggle="tooltip" data-placement="auto" title="Edit Folder" disabled><i class="fa fa-pencil-alt"></i></button>
            </div>
          </div>
        </div>
        <div class="ml-3"><span id="display-folder">0</span> {{__('documents.label.of')}} <span id="allowed-folder">10</span> {{__('documents.buttons.folders')}}</div>
      </div>
    </div>
    <div class="col-12 col-sm-8 cards-container">
      <div id="gallery">
        <div class="row">
          <div class="col-12">
            <div class="row mx-0 justify-content-center" id="userFiles">
              <!-- file content goes here -->
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="ml-3 float-right"><span id="display-file">0</span> {{__('documents.label.of')}} <span id="allowed-file">0</span> {{__('documents.buttons.files')}}</div>
</div>
<!-- Create file modal box -->
<div class="modal fade" id="fileUpload" data-backdrop-bg="bgc-grey-tp4" data-blur="true" tabindex="-1" role="dialog" aria-labelledby="exampleModal2Label" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content border-0 shadow radius-1">
      <div class="modal-body modal-scroll">
        <div class="row">
          <div class="col-12">
            <form id="imageUploadForm">
              <div id="imageUpload" class="dropzone text-center mb-3">
                <div class="dz-message" data-dz-message>
                  <i class="upload-icon fas fa-cloud-upload-alt text-blue-m1 fa-3x mt-4"></i>
                  </br>
                  <span>{{__('documents.label.file_label')}}</span>
                </div>
              </div>
              <select class="ace-select text-dark-m1 bgc-default-l5 bgc-h-warning-l3 brc-default-m3 brc-h-warning-m1" name="folderId" id="folderId" required>
              </select>
              <div class="mt-5 border-t-1 bgc-secondary-l4 brc-secondary-l2 py-35 mx-n25">
                <div class="offset-md-3 col-md-9 text-nowrap">
                  <button id="uploaderBtn" class="btn btn-info btn-bold" type="button">
                    <i class="fa fa-check mr-1"></i>
                    {{__('documents.buttons.submit')}}
                  </button>
                  <button class="btn btn-outline-lightgrey btn-bgc-white btn-bold" type="reset">
                    <i class="fa fa-undo mr-1"></i>
                    {{__('documents.buttons.reset')}}
                  </button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- create folder modal box -->
<div class="modal fade" id="createFolder" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog " role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-primary-d3" id="createFolderModalLabel">
          {{__('documents.label.create_folder')}}
        </h5>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <div class="form-group row">
          <div class="col-sm-3 col-form-label text-sm-right pr-0">
            <label for="id-form-field-focus-1" class="mb-0">
              {{__('documents.label.folder_name')}}
            </label>
          </div>

          <div class="col-sm-9">
            <input type="text" class="form-control brc-on-focus brc-success-m1" id="folderName" />
            <input type="hidden" class="form-control brc-on-focus brc-success-m1" id="sideFolderId" />
          </div>
        </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary px-4" data-dismiss="modal">
          {{__('documents.buttons.close')}}
        </button>

        <button type="button" class="btn btn-primary" id="create-new-folder">
          {{__('documents.buttons.save_changes')}}
        </button>
      </div>
    </div>
  </div>
</div>
<!-- rename file modal box-->
<div class="modal fade" id="renameFile" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog " role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-primary-d3" id="createFolderModalLabel">
          {{__('documents.label.rename_file')}}
        </h5>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <div class="form-group row">
          <div class="col-sm-3 col-form-label text-sm-right pr-0">
            <label for="id-form-field-focus-1" class="mb-0">
              {{__('documents.label.file_name')}}
            </label>
          </div>

          <div class="col-sm-9">
            <input type="text" class="form-control brc-on-focus brc-success-m1" id="fileName" />
            <input type="hidden" class="form-control brc-on-focus brc-success-m1" id="fileId" />
            <input type="hidden" class="form-control brc-on-focus brc-success-m1" id="fileExt" />
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary px-4" data-dismiss="modal">
          {{__('documents.buttons.close')}}
        </button>
        <button type="button" class="btn btn-primary" id="rename-file">
          {{__('documents.buttons.save_changes')}}
        </button>
      </div>
    </div>
  </div>
</div>
<!-- view docs modal box-->
<div class="modal fade" id="viewDoc" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-primary-d3 file-title" id="createFolderModalLabel">
          Document
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="text-align: center;">
        <img class="d-none" id="image-view" src="" alt="">
        <embed class="d-none" id="pdf-view" src="" type="application/pdf"   height="700px" width="450">
        <iframe class="d-none" id="docx-view" src="" height="700px" width="450"></iframe>
      </div>
    </div>
  </div>
</div>
@endsection
@push('in-page-scripts')
<script src="{{ asset('assets/js/I18n.js') }}"></script>
  @translations
  <script>
    var userId = {{ session('user_id') }};
    var selectedFolder = 0;
    var fileId = null;
    var type = 0;
    var folderImageUrl = "{{ asset('assets/assets/image/file-folder-vector-icon.jpg') }}";
    var fileUrl = "{{ asset('assets/assets/image/dummy-pdf-placeholder.jpg') }}";
    let docUrl = "{{ asset('assets/assets/image/dummy-word-placeholder.jpg') }}";
  </script>
  <script src="{{asset('assets/js/dropzone/dist/dropzone.js')}}"></script>
  <script src="{{asset('assets/js/documents/documents-script.js')}}"></script>
  <script src="{{asset('assets/js/dropzone/dist/@page-script.js')}}"></script>
  <script src="{{asset('assets/js/dropzone/dist/lightbox.min.js')}}" integrity="sha512-k2GFCTbp9rQU412BStrcD/rlwv1PYec9SNrkbQlo6RZCf75l6KcC3UwDY8H5n5hl4v77IDtIPwOk9Dqjs/mMBQ==" crossorigin="anonymous"></script>
@endpush