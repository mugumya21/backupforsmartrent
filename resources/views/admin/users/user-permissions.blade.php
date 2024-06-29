
<table class="table table-striped table-bordered fs--1 mb-0 example">
    <thead class="bg-200 text-900">
      <tr>
        <th class="sort" data-sort="name">Name</th>
        <th class="sort" data-sort="created_at">Created Date</th>
     
      </tr>
    </thead>
    <tbody class="list">
        @foreach ($permissions as $permission)
      <tr>
       <td style="width: 70%">{{$permission->name}}</td>
       <td>{{$permission->created_at}}</td>
      </tr>
      @endforeach
    </tbody>
  </table>