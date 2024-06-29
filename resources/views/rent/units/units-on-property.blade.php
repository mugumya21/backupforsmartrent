 
        
        <table class="table table-striped table-bordered fs--1 mb-0" id="units_tbl">
        <thead class="bg-200 text-900">
          <tr>
            <th class="sort" data-sort="name">Unit Name/ No</th>
            <th class="sort" data-sort="name">Floor</th>
            <th class="sort" data-sort="name">Type</th>
            <th class="sort" data-sort="name" style="width: 6%">Sqr Mtrs</th>
            <th class="sort" data-sort="name">Period</th>
            <th class="sort" data-sort="name">Amount</th>
            <th class="sort" data-sort="name">Availability</th>
    
          
         
          </tr>
        </thead>
        <tbody class="list">
            @foreach ($units as $unit)
          <tr>
            <td><a href="{{route('rent.units.show',$unit)}}">{{$unit->name}}</a></td>
            <td>{{$unit->floor->name}}</td>
            <td>{{$unit->unitType->name}}</td>
            <td>{{$unit->square_meters}}</td>
            <td>{{$unit->period->name}}</td>
            <td><span class="curr">{{ $unit->currency->code }}</span> {{$unit->amountDisp()}}</td>
            <td>{!! $unit->availabilityDisp() !!}</td>
       
          
            
          </tr>
          @endforeach
        </tbody>
      </table>
    
    
      <script>
        $('#units_tbl').DataTable();
          </script>
    