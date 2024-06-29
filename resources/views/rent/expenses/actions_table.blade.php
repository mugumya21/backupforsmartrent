
              <table class="table table-striped table-bordered fs--1 mb-0" id="example">
                <thead class="bg-200 text-900">
                  <tr>
                    <th class="sort" data-sort="name">Date</th>
                    <th class="sort" data-sort="name">Status</th>
                    <th class="sort" data-sort="name">DoneBy</th>
                  

                  
                 
                  </tr>
                </thead>
                <tbody class="list">
                    @foreach ($expense->actions as $action)
                  <tr>
            
                    <td>{{$action->date()}}</td>
                    <td>{{$action->expenseStatus->name}}</td>
                    <td>{{$action->createdBy->employee->full_name()}}</td>
        
                    
                  </tr>
                  @endforeach
                </tbody>
              </table>
           