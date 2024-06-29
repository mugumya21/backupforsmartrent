

{{ html()->form('POST')->route('main.upload')->acceptsFiles()->class('dropzone')->id('myDragAndDropUploader')->novalidate()->open() }}

<button class="btn btn-secondary btn-sm closezonebtn" type="button">Cancel</button>
<button class="btn btn-primary btn-sm zonebtn" type="submit">Upload</button>

{{ html()->form()->close() }}

 <div> <h5 id="message"></h5></div>


  
<input id="filetype" name="filetype" type="hidden" value="{{$filetype}}" >
<input id="docid" name="docid"  type="hidden"  value="{{$docid}}" >