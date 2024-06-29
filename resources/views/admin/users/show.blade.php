@extends('layouts.app')

@section('title', 'User')
@section('head-css')
<link rel="stylesheet" href="{{ asset('assets/css/dropzone.min.css') }}">


<link href="{{ asset('assets/DataTables/datatables.min.css')}}" rel="stylesheet">
<link href="{{ asset('vendors/flatpickr/flatpickr.min.css') }}" rel="stylesheet">
<link href="{{ asset('vendors/choices/choices.min.css') }}" rel="stylesheet">

<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.css"/>
<link href="{{ asset('assets/css/cropavatar.css') }}" rel="stylesheet">

@section('content')

<div class="card mb-3">
  <div class="card-header position-relative min-vh-25">
    <div id="profilepic-loader">
    <div class="bg-holder rounded-3 rounded-bottom-0" style="background-image:url(../../assets/img/generic/4.jpg);">
    </div></div>
    <!--/.bg-holder-->


 
  </div>
  <div class="card-body">
    <div class="row">
    <div class="col-md-3">
    <form enctype="multipart/form-data" action="{{route('employeeavatarupload')}}" method="POST" class="avatar-upload">
      <div class="avatar-edit">
          <input type='file' id="imageUpload" accept=".png, .jpg, .jpeg" name="imageUpload" class=" imageUpload" />
          <input type="hidden" name="docid" value="{{$docid}}">
          <input type="hidden" name="base64image" name="base64image" id="base64image">
          <label for="imageUpload"></label>
      </div>
      <div class="avatar-preview container2">
          @php
              if(!empty($image->name) ){
                $imagename =$image->name;
              }else{
                $imagename = 'default.png';
              }
           
                
          @endphp
<div id="imagePreview" style="background-image:url('{{ asset('uploads/employeeavatars/'.$imagename) }}');">
              <input type="hidden" name="_token" value="{{csrf_token()}}">
              <input style="margin-top: 12px;" type="submit" class="btn btn-success px-3 ms-2 cropbtn ">  
          </div>
      </div>
  </form>
  <div class="modal fade bd-example-modal-lg imagecrop" id="model" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Crop Image</h5>
              <button type="button" class="ms-2 btn-close dismisbtn" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div class="modal-body">
              <div class="img-container">
                  <div class="row" style="margin-left: 0px !important;">
                      <div class="col-md-11">
                          <img id="image" src="https://avatars0.githubusercontent.com/u/3456749">
                      </div>
                  </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary dismisbtn" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary crop initcropbtn" id="crop">Crop</button>
            </div>
        </div>
      </div>
    </div>
    </div>

    <div class="col-md-3">
      <div class="col ps-2 ps-lg-3"><a class="d-flex align-items-center mb-2" href="#">
          <div class="flex-1">
            <h6 class="mb-0">{{ $user->employee->full_name() }}</h6>
          </div>
        </a>
        
        <a class="d-flex align-items-center mb-2" href="#">
          <div class="flex-1">
            <h6 class="mb-0"> {{$user->email}} </h6>
          </div>
        </a>

        <a class="d-flex align-items-center mb-2" href="#">
          <div class="flex-1">
            <h6 class="mb-0">   
              {{ $user->employee->present_address }}
            </h6>
          </div>
        </a>
     
        </div>
    </div>
  
  
    <div class="col-md-5">
      <div class="col ps-2 ps-lg-3">

    @if(Auth::user()->hasAnyDirectPermission(['sysadmin']))

    @if($user->is_active >0)
    <a  href="" id="deactivatebtn"  class="btn btn-primary btn-sm active" type="button" ><i class="fas fa-lock"></i> De-Activate User</a>

    @else 

    <a  href="" id="activatebtn"  class="btn btn-primary btn-sm active" type="button" ><i class="fas fa-lock-open"></i> Activate User</a>

    @endif
    @endif
    

  <a class="btn btn-primary btn-sm active" href="{{ route('admin.user.changepassword',Auth::user()->id) }}" data-ajax="false" >
      <i class="fas fa-key"></i>  Change Password
  </a>

    </div></div>
    
    
    </div>
  </div>
  <div style="clear:both;"></div>
</div>





<div class="row g-0">
  <div class="col-lg-8 pe-lg-2">
    <div class="card mb-3">
      <div class="card-header bg-light">
        <div class="row flex-between-end">
          <div class="col-auto align-self-center">
            <h5 class="mb-0" data-anchor="data-anchor">Roles<a class="anchorjs-link " aria-label="Anchor" data-anchorjs-icon="#" href="#example" style="padding-left: 0.375em;"></a></h5>
          </div>
          <div class="col-auto ms-auto">
            <div class="nav nav-pills nav-pills-falcon flex-grow-1" role="tablist">
              @if(Auth::user()->hasAnyDirectPermission(['sysadmin']))
              <a href="{{route('admin.user.assignrole', $user)}}" class="btn btn-sm active" aria-selected="true"><i class="fas fa-plus"></i> Assign User New Role</a>
              @endif
             
            </div>
          </div>
        </div>
        
      </div>
      
      <div class="card-body text-justify">
        
        @include('admin.users.user-roles') 
      
      </div>
    
    </div>



    <div class="card mb-3">
      <div class="card-header bg-light">
        <div class="row flex-between-end">
          <div class="col-auto align-self-center">
            <h5 class="mb-0" data-anchor="data-anchor">Permissions<a class="anchorjs-link " aria-label="Anchor" data-anchorjs-icon="#" href="#example" style="padding-left: 0.375em;"></a></h5>
          </div>
          <div class="col-auto ms-auto">
            <div class="nav nav-pills nav-pills-falcon flex-grow-1" role="tablist">
              @if(Auth::user()->hasAnyDirectPermission(['sysadmin']))
              <a href="{{route('admin.user.assignpermission', $user)}}" class="btn btn-sm active" aria-selected="true"><i class="fas fa-plus"></i> Assign Permissions</a>
              @endif
             
            </div>
          </div>
        </div>
        
      </div>
      
      <div class="card-body text-justify">
        
        @include('admin.users.user-permissions') 
      
      </div>
    
    </div>
  
    
    <div class="card mb-3">
      <div class="card-header bg-light">
        <div class="row flex-between-end">
          <div class="col-auto align-self-center">
            <h5 class="mb-0" data-anchor="data-anchor" id="example">Attachments<a class="anchorjs-link " aria-label="Anchor" data-anchorjs-icon="#" href="#example" style="padding-left: 0.375em;"></a></h5>
          </div>
          <div class="col-auto ms-auto">
            <div class="nav nav-pills nav-pills-falcon flex-grow-1" role="tablist">
              <button class="btn btn-sm active addocsbtn"   type="button" > <i class="fas fa-plus"></i> Add Attachments</button>
              
            </div>
          </div>
        </div>
        
      </div>
  <div class="card-body">
    <div class="tab-content">
      <div class="tab-pane preview-tab-pane active" role="tabpanel" aria-labelledby="tab-dom-e3fa9060-f9ed-4350-8e72-500aa658cea9" id="dom-e3fa9060-f9ed-4350-8e72-500aa658cea9">
      
        @include('documents.form') 
        <div id="documents-tab-loader"></div>
      </div>
    
    </div>
  </div>
</div>

  </div>
  @include('admin.users.sidebar')
</div>

@endsection
@section('include-js')



<script src="{{ asset('assets/js/sweetalert2@11.js') }}"></script>

<script src="{{ asset('assets/js/main.js') }}"></script>
<script src="{{ asset('assets/js/dropzone.min.js') }}"></script>
<script src="{{ asset('assets/DataTables/datatables.min.js')}}"></script>
<script src="{{ asset('assets/js/dropzoneinit.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.js"></script>

<script src="{{ asset('assets/js/select2.min.js') }}"></script>
<script src="{{ asset('assets/js/form-advanced.init.js') }}"></script>


<script>
main.initAjax();
$('.example').DataTable();



$('.cropbtn').hide();

let paymenturl = "{{route('main.documents.list', [$user,$user->documenttype()->id])}}";
main.loadRemote(paymenturl, '#documents-tab-loader');
$('.dropzone').hide();
$('#message').hide();

$('.closezonebtn').click(function(){
$('.dropzone').hide();
});

$('.initcropbtn').click(function(){
$('.cropbtn').show();
$('.close').click();

});

$('.dismisbtn').click(function(){
$('.modal').modal('hide');
$('.modal').html('');

});



        var $modal = $('.imagecrop');
        var image = document.getElementById('image');
        var cropper;
        $("body").on("change", ".imageUpload", function(e){
            var files = e.target.files;
            var done = function(url) {
                image.src = url;
                $modal.modal('show');
            };
            var reader;
            var file;
            var url;
            if (files && files.length > 0) {
                file = files[0];
                if (URL) {
                    done(URL.createObjectURL(file));
                } else if (FileReader) {
                    reader = new FileReader();
                    reader.onload = function(e) {
                        done(reader.result);
                    };
                    reader.readAsDataURL(file);
                }
            }
        });
        $modal.on('shown.bs.modal', function() {
            cropper = new Cropper(image, {
                aspectRatio: 1,
                viewMode: 1,
            });
        }).on('hidden.bs.modal', function() {
            cropper.destroy();
            cropper = null;
        });
        $("body").on("click", "#crop", function() {
            canvas = cropper.getCroppedCanvas({
                width: 160,
                height: 160,
            });
            canvas.toBlob(function(blob) {
                url = URL.createObjectURL(blob);
                var reader = new FileReader();
                reader.readAsDataURL(blob);
                reader.onloadend = function() {
                     var base64data = reader.result;
                     $('#base64image').val(base64data);
                     document.getElementById('imagePreview').style.backgroundImage = "url("+base64data+")";
                     $modal.modal('hide');
                }
            });
        })


  $('#activatebtn').click(function(e){
  e.preventDefault();
  Swal.fire({
  title: "",
  icon: "info",
  html: `Are you sure you want to activate this User?`,
  showCloseButton: true,
  showCancelButton: true,
  focusConfirm: false,
  confirmButtonText: `<a href="{{route('admin.user.activate',$user)}}"><i class="fa fa-thumbs-up"></i> Proceed
  </a>`,
  confirmButtonLink:"",
  cancelButtonText: `Cancel
  `,
  cancelButtonAriaLabel: "Thumbs down"
});
});



$('#deactivatebtn').click(function(e){
  e.preventDefault();
  Swal.fire({
  title: "",
  icon: "info",
  html: `Are you sure you want to deactivate this User?`,
  showCloseButton: true,
  showCancelButton: true,
  focusConfirm: false,
  confirmButtonText: `<a href="{{route('admin.user.deactivate',$user)}}"><i class="fa fa-thumbs-up"></i> Proceed
  </a>`,
  confirmButtonLink:"",
  cancelButtonText: `Cancel
  `,
  cancelButtonAriaLabel: "Thumbs down"
});
});

    </script>

@endsection




