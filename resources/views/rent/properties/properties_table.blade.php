
              <table class="table table-striped table-bordered fs--1 mb-0" id="example">
                <thead class="bg-200 text-900">
                  <tr>
                    <th class="sort" data-sort="name">Property No</th>
                    <th class="sort" data-sort="name">Name</th>
                    <th class="sort" data-sort="name">Location</th>
                    <th class="sort" data-sort="name">Square Meters</th>
                    <th class="sort" data-sort="name">Type</th>
                    <th class="sort" data-sort="name">Date Added</th>

                  
                 
                  </tr>
                </thead>
                <tbody class="list">
                    @foreach ($properties as $property)
                  <tr>
                    <td><a href="{{route('rent.properties.show', $property)}}" style="font-weight:bold;" class="name">{{$property->number}}</a></td>

                    <td><a href="{{route('rent.properties.show', $property)}}" style="font-weight:bold;" class="name">{{$property->name}}</a></td>
                   
                    <td>{{$property->location}}</td>
                    <td>{{$property->square_meters}}</td>
                    <td>{{$property->propertyType->code}}</td>
                    <td>{{$property->createdDate()}}</td>
                    
                  </tr>
                  @endforeach
                </tbody>
              </table>
           