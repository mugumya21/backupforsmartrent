 
        
        <table class="table table-striped table-bordered fs--1 mb-0" id="documents_tbl">
            <thead class="bg-200 text-900">
              <tr>
                <th class="sort" data-sort="name"> File name</th>
                <th class="sort" data-sort="name">Extension</th>
                <th class="sort" data-sort="name">Preview</th>
                <th class="sort" data-sort="name">Download</th>
             
          
              </tr>
            </thead>
            <tbody class="list">
                @foreach ($documents as $document)
              <tr>
                <td>{{$document->name}}</td>
                <td>{{$document->extension}}</td>
                <td> 
                  
                  @if($document->extension == 'pdf')
                  <div class="file-thumbnail">

          <a href="{{route('main.documents.preview',$document->id)}}" data-toggle="tooltip"
                  title="PrintPreview Document"
                  data-placement="top" >

              <img src="{{ asset($document->icon()) }}"
                   class="border h-100 w-100 fit-cover rounded-2" alt="icon"/>

          </a>
          
         
                  </div>

                  @else 

                  <div class="file-thumbnail">

                    <a href="{{route('main.documents.download',$document->id)}}" data-toggle="tooltip"
                            title="PrintPreview Document"
                            data-placement="top" >
          
                        <img src="{{ asset($document->icon()) }}"
                             class="border h-100 w-100 fit-cover rounded-2" alt="icon"/>
          
                    </a>
                    </div>

                  @endif

                  </td>
<td>
                  <a href="{{route('main.documents.download',$document->id)}}">
                    <i class="fas fa-cloud-download-alt" style="font-size: 25px;"></i>
                </a>

</td>
                
              
           
              </tr>
              @endforeach
            </tbody>
          </table>
        
        
          <script>
            $('#documents_tbl').DataTable();
          </script>
        