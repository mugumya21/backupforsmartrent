<div class="mb-3" style="">
            <div class="card-header">
              <div class="row flex-between-end">
                <div class="col-auto align-self-center" style="padding-left: 0px;">
                  <h5 class="mb-0" data-anchor="data-anchor"><b>Gallery</b></h5>
                </div>
            
              </div>
            </div>
              <div class="tab-content">
                <div class="tab-pane preview-tab-pane active" role="tabpanel" aria-labelledby="tab-dom-0551cc02-cbb9-4668-ae90-425f96789e80" id="dom-0551cc02-cbb9-4668-ae90-425f96789e80">
                  <div class="row align-items-center">

                    @foreach($images as $image)

                    <div class="col-auto">
                        <div class="avatar avatar-4xl" style="margin-bottom: 20px;">
                          <img class="rounded-soft" src="{{ asset("uploads/documents/{$image->temp_key}") }}" alt="" />
<input type="radio" name="featured" class="setfeatured" value="{{$image->id}}" @if($image->is_featured > 0) checked @endif style="float: right;margin-top: -21px;right: 8px;position: absolute;-ms-transform: scale(1.5); -webkit-transform: scale(1.5); transform: scale(1.5);}">               
  
                        </div>
                      </div>

                    @endforeach


                  </div>
                </div>
            
              </div>
         
          </div>


<script>
$('.setfeatured').click(function(){
var value = $(this).val();
var key = '{{$id}}';
var type = '{{$filetype}}';
  
$.ajax({
type:'get',
url:'{{ route('main.documents.setfeaturedimage') }}',
data:{'id':value, 'key':key, 'type':type},
success:function(data){

let profilepicurl = "{{route('crm.clientprofilepic', $client)}}";
main.loadRemote(profilepicurl, ' #profilepic-loader')

  $('#liveToastBtn').click();
},
error:function(){
}

});

});

          </script>
          