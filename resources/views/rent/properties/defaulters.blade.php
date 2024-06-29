
<table class="table table-striped table-bordered fs--1 mb-0" id="defaulters">
    <thead class="bg-200 text-900">
      <tr>
        <th class="sort" data-sort="name">Tenant Name</th>
        <th class="sort" data-sort="name">Telephone</th>
        <th class="sort" data-sort="name">Email</th>
       

      
     
      </tr>
    </thead>
    <tbody class="list">
        @foreach ($tenants as  $tenant)

        @if($tenant->count >0)
      
      <tr>
       <td>{{$tenant->clientname()}}</td>
       
       <td>@if(!empty($tenant->currentclientProfile()->currentProfileTel())){{$tenant->currentclientProfile()->currentProfileTel()->value}}@endif</td>
       <td>@if(!empty($tenant->currentclientProfile()->currentProfileEmail())) {{$tenant->currentclientProfile()->currentProfileEmail()->value}} @endif</td>        
      </tr>
      @endif

      @endforeach
    </tbody>
  </table>
