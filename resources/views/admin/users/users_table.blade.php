
              <table class="table table-bordered table-striped fs--1 mb-0" id="example">
                <thead class="bg-200 text-900">
                  <tr>
                    <th class="sort" data-sort="name">Name</th>
                    <th class="sort" data-sort="email">Email</th>
                    <th class="sort" data-sort="telephone">Telephone</th>
                    <th class="sort" data-sort="status">Status</th>
                  </tr>
                </thead>
                <tbody class="list">

                    @foreach ($users as $user)
                  <tr>
                    <td class="name"><a href="{{route('admin.users.show', $user)}}" class="name">{{ $user->name }}</a></td>
                    <td class="">{{ $user->email }}</td>
                    <td class="">{{ $user->employee->telephone }}</td>
                    <td class="">{!! $user->statusDisp() !!}</td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
           