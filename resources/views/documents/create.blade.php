







@extends('layouts.app')

@section('title', 'Properties')

@section('head-css')
<link href="{{ asset('vendors/flatpickr/flatpickr.min.css') }}" rel="stylesheet">
<link href="{{ asset('vendors/prism/prism-okaidia.css') }}" rel="stylesheet">

<link rel="stylesheet" href="{{ asset('assets/css/dropzone.min.css') }}">


@endsection

@section('content')


<div class="card mb-3 col-md-8">
  <div class="card-header bg-light">
    <div class="row flex-between-end">
      <div class="col-auto align-self-center">
        <h5 class="mb-0" data-anchor="data-anchor" id="example">Upload Documents<a class="anchorjs-link " aria-label="Anchor" data-anchorjs-icon="#" href="#example" style="padding-left: 0.375em;"></a></h5>
      </div>
      
    </div>
    
  </div>
  <div class="card-body text-justify">
    <label>Drag and Drop Multiple Images (JPG, JPEG, PNG, .webp)</label>

 
    @include('rent.documents.form')  
    </div>          

  </div>
  
</div>



@endsection




@section('include-js')

<script src="{{ asset('assets/js/dropzone.min.js') }}"></script>


<script src="{{ asset('assets/js/cleave.js') }}"></script>
<script src="{{ asset('assets/js/main.js') }}"></script>


<script type="text/javascript">

var maxFilesizeVal = 12;
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
    acceptedFiles: ".jpeg,.jpg,.png,.webp",
    addRemoveLinks: true,
    dictRemoveFile: "<img src='http://127.0.0.1:8000/assets/img/icons/close.png'>",
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
    $('#message').text(response.message);
    $('#liveToastBtn').click();
        this.removeAllFiles(); 
  });
  this.on("errormultiple", function(files, response) {
    $('#message').text('Something Went Wrong! '+response);
        return false;
  });
}

}
</script>

      
<script src="{{ asset('assets/js/flatpickr.js') }}"></script>
<script src="{{ asset('vendors/prism/prism.js') }}"></script>


@endsection

