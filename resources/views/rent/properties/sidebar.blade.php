<div class="col-lg-3 ps-lg-2">
                <div class="card mb-3">
                  <div class="card-header bg-light">
                    <h5 class="mb-0">Un Paid Rent</h5>
                  </div>
                  <div class="card-body fs--1">

                    <b>Total:</b> <span class="curr">{{ FrontEndHelper::baseCurrency()->code }}</span>  {{$property->unpaidrent()}}

                    {{-- @include('rent.properties.unpaid-rent-table') --}}


                  </div>
                </div>

                <div class="card mb-3">
                  <div class="card-header bg-light">
                    <h5 class="mb-0">Monthly Collections</h5>
                  </div>
                  <div class="card-body fs--1">

                  <b>Total:</b> <span class="curr">{{ FrontEndHelper::baseCurrency()->code }}</span>   {{$property->monthlycollectionsDisp()}}

                  </div>
                </div>


                <div class="card mb-3">
                  <div class="card-header bg-light">
                    <h5 class="mb-0">Occupancy</h5>
                  </div>
                  <div class="card-body fs--1">

                   <b> Total Units:</b>  {{$property->totalunits()}}<div style="clear: both"></div>
                   <b> Occupied:</b> {{$property->occupiedunits()->count()}} ({{$property->occupiedunitspercentage()}}%) <div style="clear: both"></div>
                   <b> Available:</b>  {{$property->availableunits()->count()}} ({{$property->availableunitspercentage()}}%)

                  </div>
                </div>


                <div class="card mb-3">
                  <div class="card-header bg-light">
                    <h5 class="mb-0">Defaulters</h5>
                  </div>
                  <div class="card-body fs--1">
                    {{-- @include('rent.properties.defaulters')

                      --}}

                  </div>
                </div>

               <div class="card mb-3">
                  <div class="card-header bg-light">
                    <h5 class="mb-0">Managers</h5>
                  </div>
                  <div class="card-body fs--1">
                    {{-- @include('rent.properties.managers')

                      --}}

                  </div>
                </div>

            </div>
