
<table class="table table-striped table-bordered fs--1 mb-0" id="example">
    <thead class="bg-200 text-900">
      <tr>
        <th class="sort" data-sort="name">Code </th>
        <th class="sort" data-sort="name">Date</th>
        <th class="sort" data-sort="name">Name</th>
        <th class="sort" data-sort="name">Buying</th>
        <th class="sort" data-sort="name">Selling</th>
        <th class="sort" data-sort="name"></th>
     
      </tr>
    </thead>
    <tbody class="list">
        @foreach ($currencyrates as $rate)
      <tr>
       
        <td>
            {{ $rate->currency->code }}
        </td>
        <td>
            {{ $rate->dateDisp() }}
        </td>
        <td>
            {{ $rate->currency->name }}
        </td>
        <td>
            {{ $rate->buyingDisp() }}
        </td>
        <td>
            {{ $rate->sellingDisp() }}
        </td>
        <td class="actionth">
            <a href="{{route('accounts.rates.edit',$rate)}}" data-ajax="true">
                <i class="fas fa-edit"></i>
            </a>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>


  <script>
$('#example').DataTable();
    </script>