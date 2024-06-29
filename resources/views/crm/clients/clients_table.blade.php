
              <table class="table table-striped table-bordered fs--1 mb-0" id="example">
                <thead class="bg-200 text-900">
                  <tr>
                    <th class="sort" data-sort="name">Client No</th>
                    <th class="sort" data-sort="name">Name</th>
                    <th class="sort" data-sort="telephone">Telephone</th>
                    <th class="sort" data-sort="email">Email</th>
                    <th class="sort" data-sort="email">Country of Origin</th>
                 
                  </tr>
                </thead>
                <tbody class="list">

                    @foreach ($clients as $client)
                  <tr>
                    <td class="name"><a href="{{route('crm.clients.show', $client)}}" style="font-weight:bold;" class="name">{{ $client->number }}</a><br>
                    <i>{{ $client->clientType->description }}</i></td>
                    <td class="">{{ $client->clientname() }}</td>
                    <td class="">
                      @if(!empty($client->currentclientProfile()->currentProfileTel()))
                      {{ $client->currentclientProfile()->currentProfileTel() }}
                    @endif</td>
                    <td class="">
                      @if(!empty($client->currentclientProfile()->currentProfileEmail()))
                      {{ $client->currentclientProfile()->currentProfileEmail() }}
                    @endif</td>
                    <td class="">{{ $client->currentclientProfile()->nation->name }}</td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
           