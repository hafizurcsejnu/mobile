$( function() {

  $('[data-toggle="tooltip"]').tooltip();

  $( document ).ready(function() {
    getFoldersList();
    getFoldersFiles();
  });

  /**
   * event to sort folder order
   */
  $( "#sortableContainer" ).sortable({
    stop: function (event, ui) {
      var folderOrder = $('#sortableContainer').sortable("toArray");
      let newOrder = [];
      let i = 1;
      folderOrder.map(folder => {
        newOrder.push({
          id: folder,
          order: i++
        })
      });
      $.ajax({
        type: 'POST',
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: `${APP_URL}/sorting-folder`,
        data: {
          order: JSON.stringify(newOrder)
        },
        success: function (data) {
          if (data.success == 'success') {
            console.log('Folder sorted successfully');
          } else {
            swal(window.I18n.trans(window.translations.documents.errorMessage.error), window.I18n.trans(window.translations.documents.errorMessage.sorting), "error");
          }
        }
      });
    }
  });
  $( "#sortableContainer" ).disableSelection();


  /**
   * event to delete folder
   */
  $("#delete-folder").click(function() {

    if (!selectedFolder) {
        swal(window.I18n.trans(window.translations.documents.errorMessage.error), window.I18n.trans(window.translations.documents.warningMessage.folder_selection), "error");
    } else {
      $.ajax({
        url: APP_URL + '/check-file-exist/'+ selectedFolder,
        success:function(response){
          swal({
            title: window.I18n.trans(window.translations.documents.warningMessage.warning),
            text: response.message,
            icon: "warning",
            buttons: true,
            dangerMode: true,
            confirmButtonText: window.I18n.trans(window.translations.documents.warningMessage.delete_it)
          })
          .then((willDelete) => {
            if (willDelete) {
              $.ajax({
                type: 'DELETE',
                headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: `${APP_URL}/delete-folder/${selectedFolder}`,
                beforeSend: function (res) {
                  // loader code here
                },
                success: function (data) {
                  if (data.success == 'success') {
                    $(`#${selectedFolder}`).remove();
                    $(`#folderId option[value='${selectedFolder}']`).remove();
                    selectedFolder = 0;
                    getFoldersFiles();
                    $("#delete-folder").prop("disabled", true);
                    $("#rename-folder").prop("disabled", true);
                    swal(window.I18n.trans(window.translations.documents.successMessage.good_job), data.message, "success");
                    $("#display-folder").html($('#sortableContainer li').length);
                  } else {
                    swal(window.I18n.trans(window.translations.documents.errorMessage.error), data.message, "error");
                  }
                },
                error: function (errorData) {
                  swal(window.I18n.trans(window.translations.documents.errorMessage.error), errorData.message, "error");
                }
              });
            }
          });
        }
      });
    }
  });

  /**
   * event to get details of selected folder
   */
  $("#rename-folder").click(function() {
    if (!selectedFolder) {
        swal(window.I18n.trans(window.translations.documents.successMessage.success), window.I18n.trans(window.translations.documents.warningMessage.rename_selection), "error");
    } else {
      $.ajax({
        type: 'GET',
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: `${APP_URL}/get-folder-by-id/${selectedFolder}`,
        beforeSend: function (res) {
          // loader code here
        },
        success: function (data) {
          $('#folderName').val(data.data.name);
          $('#sideFolderId').val(data.data.id);
          $("#createFolderModalLabel").html("Rename Folder");
          $('#createFolder').modal('toggle');
        },
        error: function (errorData) {
          swal(window.I18n.trans(window.translations.documents.errorMessage.error), errorData.message, "error");
        }
      });
    }
  });

  /**
   * get clicked event of folder list
   */
  $(document).on("click", ".folder-list-item", function(){
    if ($(this).hasClass('folder-active')) {
      $(`#${selectedFolder}`).removeClass('folder-active');
      selectedFolder = 0;
      $("#delete-folder").prop("disabled", true);
      $("#rename-folder").prop("disabled", true);
      $("#folderId").val($("#folderId option:first").val());
    } else {
      $(`#${selectedFolder}`).removeClass('folder-active');
      $(this).addClass('folder-active');
      selectedFolder = $(this).attr('id');
      $("#delete-folder").prop("disabled", false);
      $("#rename-folder").prop("disabled", false);
      $("#folderId").val(selectedFolder);
    }
    getFoldersFiles(type, selectedFolder);
  });

  /**
   * event to create or rename a folder
   */
  $("#create-new-folder").click(function() {
    let folderName = $("#folderName").val();
    let folderId = $("#sideFolderId").val();
    let apiUrl = APP_URL+'/create-folder';
    let requestData = {
      folderName: folderName,
      userId: userId
    }

    if (folderId) {
      apiUrl = APP_URL+'/rename-folder';
      requestData.id = folderId;
      requestData.userId = userId;
    }

    if (folderName.trim() == '') {
      swal(window.I18n.trans(window.translations.documents.errorMessage.error), window.I18n.trans(window.translations.documents.warningMessage.folder_name), "error");
    } else if (folderName.length > 100) {
      swal(window.I18n.trans(window.translations.documents.errorMessage.error), window.I18n.trans(window.translations.documents.warningMessage.folder_name_max), "error");
    } else {
      $.ajax({
        type: 'POST',
        url: apiUrl,
        data: requestData,
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        beforeSend: function (res) {
          // loader code here
        },
        success: function (data) {
          if (data.success == "error") {
            swal(window.I18n.trans(window.translations.documents.errorMessage.error), errorData.message, "error");
          } else {
            if (!folderId) {
              $("#sortableContainer").append(`<li class="list-group-item folder-list-item" id="${data.data.id}"><img class="mr-1" width="30px" src="${folderImageUrl}">${data.data.name}</li>`);
              $('#folderId').append(new Option(data.data.name, data.data.id));
            } else {
              $(`#folderId option[value='${folderId}']`).remove();
              $(`#${folderId}`).html(`<img class="mr-1" width="30px" src="${folderImageUrl}">${folderName}`);
              $('#folderId').append(new Option(folderName, folderId));
              $('#folderId').val(folderId);
            }
            $("#folderName").val('');
            $("#sideFolderId").val('');
            $('#createFolder').modal('toggle');
            swal(window.I18n.trans(window.translations.documents.successMessage.good_job), data.message, "success");
          }
          $("#display-folder").html($('#sortableContainer li').length);
        },
        error: function (errorData) {
          swal(window.I18n.trans(window.translations.documents.errorMessage.error), errorData.responseJSON.errors.folderName[0], "error");
        }
      });
    }
  });

  $( ".fileTypes" ).click( function () {
    type = $(this).data("type");
    getFoldersFiles(type, selectedFolder);
  });

  $(document).on('click', '#deleteFile', function(event) {
      swal({
        title: window.I18n.trans(window.translations.documents.warningMessage.warning),
        text: window.I18n.trans(window.translations.documents.warningMessage.file_deleted),
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
          let id = $(this).attr("data-id");
          $.ajax({
            type: 'DELETE',
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: `${APP_URL}/delete-file/${id}`,
            beforeSend: function (res) {
              // loader code here
            },
            success: function (data) {
              swal(window.I18n.trans(window.translations.documents.successMessage.good_job), data.message, "success");
              getFoldersFiles(type, selectedFolder);
            },
            error: function (errorData) {
              swal(window.I18n.trans(window.translations.documents.errorMessage.error), errorData.message, "error");
            }
          });
        }
      });
  });

  $(document).on('click', '#editFile', function(event) {
    var fileId = $(this).attr("data-id");
    $.ajax({
      type: 'GET',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      url: `${APP_URL}/get-file-by-id/${fileId}`,
      beforeSend: function (res) {
        // loader code here
      },
      success: function (data) {
        var getExtExpression = /(?:\.([^.]+))?$/;
        let fileName = data.data.name.split('.').slice(0, -1).join('.');
        let fileExt = getExtExpression.exec(data.data.name)[1];
        $("#fileName").val(fileName);
        $("#fileExt").val(fileExt);
        $("#fileId").val(data.data.id);
        $("#renameFile").modal('toggle');
      },
      error: function (errorData) {
        swal(window.I18n.trans(window.translations.documents.errorMessage.error), errorData.message, "error");
      }
    });
  });

  $(document).on('click', '#copyFile', function(event) {
    var fileId = $(this).attr("data-id");
    $.ajax({
      type: 'POST',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      url: `${APP_URL}/copy-file`,
      data: {
        fileId: fileId
      },
      beforeSend: function (res) {
        // loader code here
      },
      success: function (data) {
        swal(window.I18n.trans(window.translations.documents.successMessage.good_job), data.message, "success");
        getFoldersFiles(type, selectedFolder);
      },
      error: function (errorData) {
        swal(window.I18n.trans(window.translations.documents.errorMessage.error), errorData.message, "error");
      }
    });
  });

  $("#rename-file").click(function () {
    let fileName = $("#fileName").val();
    let fileExt = $("#fileExt").val();
    let fileId = $("#fileId").val();
    let apiUrl = APP_URL+'/rename-file';
    let requestData = {
      fileName: `${fileName}.${fileExt}`,
      fileId: fileId
    };
    if (fileName.trim() == '') {
      swal(window.I18n.trans(window.translations.documents.errorMessage.error), window.I18n.trans(window.translations.documents.warningMessage.file_name), "error");
    } else if (fileName.length > 100) {
      swal(window.I18n.trans(window.translations.documents.errorMessage.error), window.I18n.trans(window.translations.documents.warningMessage.file_name_max), "error");
    } else {
      $.ajax({
        type: 'POST',
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: apiUrl,
        data: requestData,
        beforeSend: function (res) {
          // loader code here
        },
        success: function (data) {
          swal(window.I18n.trans(window.translations.documents.successMessage.good_job), data.message, "success");
          $("#fileName").val('');
          $("#fileId").val('');

          $(`#file_title_${fileId}`).html(`${fileName.substring(0, 5)}...${fileExt}`);
          $(`#file_title_${fileId}`).prop('title', fileName);
          $("#renameFile").modal('toggle');
          fileId = null;
        },
        error: function (errorData) {
          if (typeof errorData.responseJSON.errors=='undefined') {
            swal(window.I18n.trans(window.translations.documents.errorMessage.error), errorData.responseJSON.message , "error");
          } else {
            swal(window.I18n.trans(window.translations.documents.errorMessage.error), errorData.responseJSON.errors.fileName[0] , "error");
          }

        }
      });
    }
  });
});

/**
 * function to reset folder listing
 */
function getFoldersList () {
  $.ajax({
    type: 'GET',
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    url: `${APP_URL}/get-tree-data`,
    beforeSend: function (res) {
      // loader code here
    },
    success: function (data) {
      let folders = data.data;
      let html = '';
      let select = '';
      folders.map(folder => {
        html += `<li class="list-group-item folder-list-item" id="${folder.id}"><img class="mr-1" width="30px" src="${folderImageUrl}">${folder.name}</li>`;
        select += `<option value="${folder.id}">${folder.name}</option>`;
      });
      $( "#sortableContainer" ).html(html);
      $( "#folderId" ).append(select);
      $('#display-folder').html(data.count);
    },
    error: function (errorData) {
      swal(window.I18n.trans(window.translations.documents.errorMessage.error), errorData.message, "error");
    }
  });
}

function getFoldersFiles (type = 0, getFoldersFiles = 0) {
  $.ajax({
    type: 'GET',
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    url: `${APP_URL}/get-folder-files/${type}/${getFoldersFiles}`,
    beforeSend: function (res) {
      // loader code here
    },
    success: function (data) {
      let files = data.data;
      let html = '';
      if (files.length > 0) {
        files.map(file => {

          // get file URL
          let uploadFileUrl = ``;
          if (file.file_type == 1) {
            uploadFileUrl = `${storageUrl}user_${file.user_id}/folder_${file.folder_id}/${file.name}`;
            viewFileUrl = `${APP_URL}/storage/user_${file.user_id}/folder_${file.folder_id}/${file.name}`;
          } else if (file.file_type == 2) {
            uploadFileUrl = fileUrl;
            viewFileUrl = `${APP_URL}/storage/user_${file.user_id}/folder_${file.folder_id}/${file.name}`;
          } else {
            uploadFileUrl = docUrl;
            viewFileUrl = `${APP_URL}/storage/user_${file.user_id}/folder_${file.folder_id}/${file.name}`;
          }

          //get file Ext
          var getExtExpression = /(?:\.([^.]+))?$/;
          var fileExt = getExtExpression.exec(file.name)[1];
          html += `<div class="col-lg-3 col-md-4 col-6 mb-3 text-center fileItem" id="file_${file.id}">
            <div class="pos-rel image-sec d-style radius-1 shadow-sm overflow-hidden pb-1">
              <img alt="${file.name}" src="${uploadFileUrl}" class="p-1" />
              <h6 class="card-title docs-card-body-title renameFile p-2" id="file_title_${file.id}" data-toggle="tooltip" data-placement="auto" title="${file.name}">${file.name.substring(0, 5)}...${fileExt}</h6>
              <p class="card-text docs-card-body-text created-date pl-2">Created: ${file.created_at}</p>
              <div class="v-hover position-center h-100 w-100 mt-2 ml-1 text-center">
                <a class="btn btn-primary btn-sm m-1" id="editFile" data-id="${file.id}" data-toggle="tooltip" data-placement="auto" title="Edit File"><i class="fa fa-pencil-alt"></i></a>
                <a class="btn btn-info btn-sm m-1" id="downloadFile" data-id="${file.id}" href="${APP_URL}/download/${file.id}" data-toggle="tooltip" data-placement="auto" title="Download File"><i class="fa fa-download"></i></a>
                <a class="btn btn-light btn-sm m-1" id="copyFile" data-id="${file.id}" data-toggle="tooltip" data-placement="auto" title="Clone File"><i class="fa fa-clone"></i></a>
                <a class="btn btn-danger btn-sm m-1" id="deleteFile" data-id="${file.id}" data-toggle="tooltip" data-placement="auto" title="Delete File"><i class="fa fa-trash"></i></a>`;
                if (file.file_type == 1 || file.file_type == 2) {
                  html += `<a class="btn btn-info btn-sm m-1" id="viewFile" data-id="${file.id}" data-view-type="${file.file_type}" data-url="${viewFileUrl}" data-title="${file.name}" data-toggle="tooltip" data-placement="auto" title="View File"><i class="fa fa-eye"></i></a>`;
                }
              html += `</div>
            </div>
          </div>`;
        });
      } else {
        html += '<span>'+window.I18n.trans(window.translations.documents.warningMessage.file_not_found)+'</span>'
      }
      $( "#display-file" ).html(data.visibleFileCount);
      $( "#allowed-file" ).html(data.totalCount);
      $( "#userFiles" ).html(html);
    },
    error: function (errorData) {
      swal(window.I18n.trans(window.translations.documents.errorMessage.error), errorData.message, "error");
    }
  });
}

$(document).on('click', '#viewFile', function(event) {
  event.preventDefault();
  let url = $(this).data("url");
  let type = $(this).data("view-type");
  let title = $(this).data("title");
  $(".file-title").html(title);

  if (type == 1) {
    $("#image-view").attr('src', url);
    $("#image-view").removeClass('d-none');
    $("#pdf-view").addClass('d-none');
    $("#docx-view").addClass('d-none');
  } else if (type == 2) {
    $("#pdf-view").attr('src', url);
    $("#pdf-view").removeClass('d-none');
    $("#image-view").addClass('d-none');
    $("#docx-view").addClass('d-none');
  } else {
    $("#docx-view").attr('src', `https://docs.google.com/gview?url=${url}&embedded=true`);
    $("#docx-view").removeClass('d-none');
    $("#pdf-view").addClass('d-none');
    $("#image-view").addClass('d-none');
  }
  $('#viewDoc').modal('toggle');
});

$(document).on('click', '#fileUpload button[type="reset"]', function(event) {
  event.preventDefault();
  $('#fileUpload').modal('hide');
});

$("#create-folder-btn").click(function () {
  $("#folderName").val('');
  $("#sideFolderId").val('');
})