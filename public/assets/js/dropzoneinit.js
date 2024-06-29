$('.dropzone').hide();

$('.addocsbtn').click(function(){
  $('.dropzone').show();
});

var maxFilesizeVal = 20;
var maxFilesVal = 10;

var docid = $('#docid').val();
var filetype = $('#filetype').val();

Dropzone.options.myDragAndDropUploader = { // The camelized version of the ID of the form element

// The configuration we've talked about above

paramName:"file",
    method: 'POST',
    autoProcessQueue: false,
    uploadMultiple: true,
    parallelUploads: 100,
    maxFilesize: maxFilesizeVal, // MB
    maxFiles: maxFilesVal,
    resizeQuality: 1.0,
    acceptedFiles: ".jpeg,.jpg,.png,.webp,.pdf,.webp,.doc,.docx,.xlx,.xlsx,.ppt",
    addRemoveLinks: true,
    dictRemoveFile: '<button class="closebtn">X</button>',
    timeout: 60000,
    dictDefaultMessage: "Drop your files here or click to upload",
    dictFallbackMessage: "Your browser doesn't support drag and drop file uploads.",
    dictFileTooBig: "File is too big. Max filesize: "+maxFilesizeVal+"MB.",
    dictInvalidFileType: "Invalid file type. Only JPG, JPEG, PNG and webp files are allowed.",
    dictMaxFilesExceeded: "You can only upload up to "+maxFilesVal+" files.",
    maxfilesexceeded: function(file) {
        this.removeFile(file);
        // this.removeAllFiles(); 
    },

    sending: function(file, xhr, formData) {
    formData.append("docid", docid);
    formData.append("filetype", filetype); 


},

// The setting up of the dropzone
init: function() {
  var myDropzone = this;

  // First change the button to actually tell Dropzone to process the queue.
  this.element.querySelector("button[type=submit]").addEventListener("click", function(e) {
    // Make sure that the form isn't actually being sent.
    e.preventDefault();
    e.stopPropagation();
    myDropzone.processQueue();
  });

  // Listen to the sendingmultiple event. In this case, it's the sendingmultiple event instead
  // of the sending event because uploadMultiple is set to true.
  this.on("sendingmultiple", function() {
    $('#message').text('Image Uploading...');

  });
  this.on("successmultiple", function(files, response) {
    $('#message').parent().html(response.message);
    $('#liveToastBtn').click();
    $('#document-tab').click();
    $('#reload-docs').click();
    
    setTimeout(function () {
      $('.btn-close').click();
  }, 1500);

    this.removeAllFiles(); 

  });
  this.on("errormultiple", function(files, response) {
    $('#message').text('Something Went Wrong! '+response);
        return false;
  });
}

}