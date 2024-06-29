 
        
        <table class="table table-striped table-bordered fs--1 mb-0" id="tenantunits_tbl">
        <thead class="bg-200 text-900">
          <tr>
            <th class="sort" data-sort="name">ID</th>
            <th class="sort" data-sort="name">Tenant</th>
            <th class="sort" data-sort="name" style="width:12%">Unit Name/ No</th>
            <th class="sort" data-sort="name">Period</th>
            <th class="sort" data-sort="name">Terms</th>
            <th class="sort" data-sort="name">start</th>
            <th class="sort" data-sort="name">To</th>
            <th class="sort" data-sort="name">Amount</th>
          
         
          </tr>
        </thead>
        <tbody class="list">
            @foreach ($tenantunits as $tenantunit)
          <tr>
            <td>{{$tenantunit->id}}</td>
            <td>
            <a href="{{route('rent.tenantUnits.show',$tenantunit)}}">{{$tenantunit->tenant->clientname()}}</a>              
            </td>
            <td>{{$tenantunit->unit->name}}</td>
            <td>{{$tenantunit->period->name}}</td>
            <td class="text-center">{{$tenantunit->terms}}</td>
            <td>{{$tenantunit->fromDate()}}</td>
            <td>{{$tenantunit->toDate()}}</td>
            <td><span class="curr">{{ $tenantunit->currency->code }}</span> {{$tenantunit->amountDisp()}}</td>
         
        
            
          </tr>
          @endforeach
        </tbody>
      </table>
    
    
      <script>
          main.initAjax();
        $('#tenantunits_tbl').DataTable({
          order: [[0, 'desc']],
          columnDefs: [
        {
            target: 0,
            visible: false,
        }
    ]
        });
          </script>
    