 
        
        <table class="table table-striped table-bordered fs--1 mb-0" id="floors_tbl">
        <thead class="bg-200 text-900">
          <tr>
            <th class="sort" data-sort="name">Name</th>
        
            <th class="sort" data-sort="name">Description</th>
           
    
          
         
          </tr>
        </thead>
        <tbody class="list">
            @foreach ($floors as $floor)
          <tr>
            <td>{{$floor->name}}</td>

            <td>{{$floor->description}}</td>
          
            
          </tr>
          @endforeach
        </tbody>
      </table>
    
    
      <script>
        $('#floors_tbl').DataTable();
          </script>
    