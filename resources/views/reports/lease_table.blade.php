
<table class="table table-striped table-bordered fs--1 mb-0" id="example">
    <thead class="bg-200 text-900">
      <tr>
        <th class="sort" data-sort="name">Property </th>
        <th class="sort" data-sort="name">Unit </th>
        <th class="sort" data-sort="name">Tenant </th>
        <th class="sort" data-sort="name">Expiry Date </th>
        <th class="sort text-center" data-sort="name">Days Remaining </th>
        <th class="sort text-center" data-sort="name"> Status </th>
  
      </tr>
    </thead>
    <tbody class="list">
 
        @foreach ($tenantunits as   $tenantunit)
      <tr>
        <td>{{$tenantunit->property->name}}</td>
        <td>{{$tenantunit->unit->name}}</td>
       <td>{{$tenantunit->tenant->clientname()}}</td>
       <td>{{$tenantunit->shortToDate()}}</td>
       <td class="text-center">{{$tenantunit->expirydays()}}</td>
       <td class="text-center">{!!$tenantunit->expiryStatus()!!}</td>


      </tr>

    
      @endforeach
    </tbody>

  </table>

 
