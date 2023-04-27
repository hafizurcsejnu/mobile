Dropzone.autoDiscover = false;

myDropzone = new Dropzone('div#imageUpload', {
  addRemoveLinks: true,
  autoProcessQueue: false,
  uploadMultiple: true,
  parallelUploads: 100,
  maxFiles: 30,
  paramName: 'file',
  clickable: true,
  url: APP_URL+'/upload',
  headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  },
  init: function () {

    var myDropzone = this;
    // Update selector to match your button
    $( "#uploaderBtn" ).click(function (e) {
      e.preventDefault();
      myDropzone.processQueue();
      return false;
    });

    this.on('sending', function (file, xhr, formData) {
      // Append all form inputs to the formData Dropzone will POST
      var data = $( "#imageUploadForm" ).serializeArray();
      $.each(data, function (key, el) {
          formData.append(el.name, el.value);
      });
    });
  },
  error: function (file, response){
    console.log('response', response);
    if ($.type(response) === "string")
        var message = response; //dropzone sends it's own error messages in string
    else
        var message = response.message;
    file.previewElement.classList.add("dz-error");
    _ref = file.previewElement.querySelectorAll("[data-dz-errormessage]");
    _results = [];
    for (_i = 0, _len = _ref.length; _i < _len; _i++) {
        node = _ref[_i];
        _results.push(node.textContent = message);
    }
    swal("Error!", "Files that you are trying to upload is either too large or selected extension not allowed. \n Allowed ext: .pdf, .jpg, .docx \n Size: .doc(200KB), .pdf(1MB), .jpeg(200KB)", "error");
    return _results;
  },
  successmultiple: function (file, response) {
    console.log(file, response, "successmultiple");
    swal("Success", response.message, "success").then(()=>{
      this.removeAllFiles(true);
      $("#fileUpload").modal("hide");
      $(".dz-message").show()
      getFoldersFiles(type, selectedFolder);
    });
  },
  completemultiple: function (file, response) {
    console.log(file, response, "completemultiple");
    this.removeAllFiles(true);
    $(".dz-message").show();
    //$modal.modal("show");
  },
  reset: function () {
    console.log("resetFiles");
    this.removeAllFiles(true);
  }
});