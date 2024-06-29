
<table class="table table-striped table-bordered fs--1 mb-0" id="example">
    <thead class="bg-200 text-900">
      <tr>
        <th class="sort" data-sort="name">Name</th>
        <th class="sort" data-sort="name">Description</th>
        <th class="sort actionth" data-sort="name"><i class="fas fa-cogs"></i></th>
    

      
     
      </tr>
    </thead>
    <tbody class="list">
        @foreach ($permissions as $permission)
      <tr>
       <td>{{$permission->name}}</td>
       <td>{{$permission->description}}</td>

       <td> <a href="{{route('admin.permissions.edit',$permission)}}" data-ajax="true" class="" aria-selected="true"><i class="far fa-edit"></i></a>
        </td>

    
      </tr>
      @endforeach
    </tbody>
  </table>


  <script>
$('#example').DataTable();
main.init();
main.initAjax();
    </script>
