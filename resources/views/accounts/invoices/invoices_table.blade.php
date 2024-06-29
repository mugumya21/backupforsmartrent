
              <table class="table table-striped table-bordered fs--1 mb-0" id="example">
                <thead class="bg-200 text-900">
                  <tr>
                    <th class="sort" data-sort="name">invoice No</th>
                    <th class="sort" data-sort="name">Date</th>
                    <th class="sort" data-sort="name">Due date</th>
                    <th class="sort" data-sort="name">Unit</th>
                    <th class="sort" data-sort="name">Description</th>
                    <th class="sort" data-sort="name">Done By</th>
                    <th class="sort" data-sort="name">Supervisor</th>
                    <th class="sort" data-sort="name">Status</th>
                    <th class="sort" data-sort="name">Amount</th>
                    <th class="sort" data-sort="name">Balance</th>
                    <th class="sort" data-sort="name">Tax</th>
                    <th class="sort" data-sort="name">Total Amount</th>



                  </tr>
                </thead>
                <tbody class="list">
                    @foreach ($invoices as $invoice)
                  <tr>

                    <td> <a href="{{route('accounts.invoices.show', $invoice)}}" class="name">
                      {{$invoice->number}}
                  </a>

                 </td>
                    <td>{{$invoice->date()}}</td>
                    <td>{{$invoice->dueDate()}}</td>
                    <td>{{$invoice->unit->name}}</td>
                    <td>{{$invoice->description}}</td>
                    <td>{{$invoice->doneBy->full_name()}}</td>
                    <td>{{$invoice->supervisedBy->full_name()}}</td>
                    <td>{!! $invoice->invoiceStatusDisp() !!}</td>
                    <td>{{$invoice->amountDisp()}}</td>
                    <td>{{$invoice->balanceDisp()}}</td>
                    <td>{{$invoice->totalTaxDisp()}}</td>
                    <td>{{$invoice->TotalDisp()}}</td>

                  </tr>
                  @endforeach
                </tbody>
              </table>
