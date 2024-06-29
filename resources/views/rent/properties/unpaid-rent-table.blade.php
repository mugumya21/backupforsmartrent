
<table class="table table-striped table-bordered fs--1 mb-0" id="unpaidrent">
    <thead class="bg-200 text-900">
      <tr>
        <th class="sort" data-sort="name">Tenant Unit</th>
        <th class="sort" data-sort="name">Period</th>
        <th class="sort" data-sort="name">Paid</th>
        <th class="sort" data-sort="name">Bal</th>
       

      
     
      </tr>
    </thead>
    <tbody class="list">
        @foreach ($property->tenantunits as  $unit)

        @if($unit->arrearsbalance() >0)
      
      <tr>
       <td>{{$unit->unit->name}}</td>
       <td>@foreach($unit->arrearsdates() as $date)
      
        {{$date->shortFromDate()}}  - {{$date->shortToDate()}}
      
      @endforeach
      </td>
       <td>{{$unit->arrearspaid()}}</td>
       <td>{{$unit->arrearsbalance()}}</td>
        
      </tr>
      @endif
      @endforeach
    </tbody>
  </table>
