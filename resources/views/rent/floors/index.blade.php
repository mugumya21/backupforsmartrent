
<div class="actions showbuttons">
<a href="{{route('rent.units.create',$property->id)}}" class="btn btn-primary btn-sm" data-ajax="true"><span class="fas fa-plus me-1" data-fa-transform="shrink-3"></span>Add</a>
      
</div> <div style="clear:both;"></div>

    
    <table class="table table-striped table-bordered fs--1 mb-0" id="units_tbl">
    <thead class="bg-200 text-900">
      <tr>
        <th class="sort" data-sort="name">Name</th>
        <th class="sort" data-sort="name">Floor</th>
        <th class="sort" data-sort="name">Amount</th>
        <th class="sort" data-sort="name">Availability</th>
        <th class="sort" data-sort="name">Period</th>
        <th class="sort" data-sort="name">Unit Type</th>

      
     
      </tr>
    </thead>
    <tbody class="list">
        @foreach ($property->units as $unit)
      <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        
      </tr>
      @endforeach
    </tbody>
  </table>


  <script>
    $('#units_tbl').DataTable();
      </script>
