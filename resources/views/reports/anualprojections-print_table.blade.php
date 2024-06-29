@if(!empty($period))
<div class="col-md-6">
 
  <table class="table table-striped table-bordered fs--1 mb-0" id="example" style="width:100%">
      <thead class="bg-200 text-900">
        <tr>
          <th class="sort" data-sort="name">Property Name </th>
          <th style="width:20%" class="sort" data-sort="name">Amount </th>
        </tr>
      </thead>
      <tbody class="list">
    
        @php $totalamount = 0 @endphp
        @foreach ($properties as $key =>  $property)
        <tr>
        <td>{{$property->name}}</td>
        <td> {{number_format($property->total) }}</td>
        </tr>
   
        @php $totalamount += $property->total @endphp
        @endforeach

      </tbody>
  
      <tfoot>
          <tr>
            <td style="text-align:right" class="bigfont" colspan="1">TOTAL</td>
            <td class="boldtotal"><b>{{number_format($totalamount) }}</b></td>
          </tr>
        </tfoot>
  
    </table>

    @endif
  
   
  