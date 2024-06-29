
<table class="table table-striped table-bordered fs--1 mb-0 example">
    <thead class="bg-200 text-900">
      <tr>
        <th class="sort" data-sort="name">Name</th>

     
      </tr>
    </thead>
    <tbody class="list">
        @foreach ($roles as $role)
      <tr>
       <td>{{$role}}</td>
      </tr>
      @endforeach
    </tbody>
  </table>