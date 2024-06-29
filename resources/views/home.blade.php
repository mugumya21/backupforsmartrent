@extends('layouts.app')

@section('title', 'Home')

@section('content')




<div class="row g-3 mb-3">
  <div class="row g-2 col-md-4 col-xxl-3">
            <div class="col-md-12 col-xxl-3">
              <div class="card h-md-100 ecommerce-card-min-width">
                <div class="card-header pb-0">
                  <h6 class="mb-0 mt-2 d-flex align-items-center">Overview</h6>
                </div>
                
                <div class="card-body d-flex flex-column justify-content-end">
                  <div class="row">
                    <div class="col-md-6 text-center border-lg-end">
                      <p class=" lh-1 mb-1 fs-4 align-items-center text-center boldfigures">{{$totalproperties}}</p><b>Properties</b>
                    </div>
                  
                    <div class="col-md-6 text-center">
                      <p class=" lh-1 mb-1 fs-4 align-items-center text-center boldfigures">{{$totaltenants}}</p><b>Tenants</b></span>
                    </div>
                    
                    <div class="col-auto ps-0">
                      <div class="echart-bar-weekly-sales h-100"></div>
                    </div>
                  </div>

                  
                  </div>


                  <div class="row" style="    margin: 10px;background: #f0f3f9;padding: 15px;border-radius: 5px;">
                    <div class="col-lg-4 border-lg-end border-bottom border-lg-0 pb-3 pb-lg-0">
                    
  <div class="col-md-12 text-center">
    <p class=" lh-1 mb-1 fs-4 align-items-center text-center boldfigures">{{$totalunits}}</p><b>Units</b></span>
  </div>
                    </div>
                    <div class="col-lg-4 border-lg-end border-bottom border-lg-0 py-3 py-lg-0">
                      <div class="col-md-12 text-center">
                        <p class=" lh-1 mb-1 fs-4 align-items-center text-center boldfigures">{{$totalvacantunits}}</p><b style="color: #ff7a21">Vacant</b></span>
                      </div>

                    </div>
                    <div class="col-lg-4 pt-3 pt-lg-0">
                      
                      <div class="col-md-12 text-center">
                        <p class=" lh-1 mb-1 fs-4 align-items-center text-center boldfigures">{{$totaloccupiedunits}}</p><b style="color: green">Occupied</b></span>
                      </div>
                      
                    </div>
                  </div>

              </div>
            </div>


            <div class="col-md-12 col-xxl-3" style="    margin-top: 15px;">
              <div class="card h-md-100 ecommerce-card-min-width">
                <div class="card-header pb-0" style="padding-right: 2px;margin-top: 5px;">
                  <h6 class="mb-0 mt-2 d-flex align-items-center" style="float:left">Rent Collections</h6>

                  
</div>
{{-- 
<div class="row" style="    padding: 15px; padding-top: 0px;"> 
<div class="col-6"> <select class="form-select form-select-sm select-month me-2">

  <option value="">Filter By Date</option>

  <option value="{{$thismonth}}">This month</option>
  <option value="{{$lastmonth}}">Last month</option>
              
  @foreach($dates as $date)
  <option value="{{$date}}"> {{ Carbon\Carbon::parse($date)->format('F y') }}</option>
  @endforeach
      
</select></div>   <div class="col-6"> <select class="form-select form-select-sm select-month me-2">

  <option value="">All properties</option>
              
  @foreach($properties as $property)
  <option value="{{$property->id}}"> {{$property->name}}</option>
  @endforeach
  
</select></div></div> --}}



 
<div class="row" style="margin: 10px;padding: 15px;">
  <div class="col-lg-6 border-lg-end border-bottom border-lg-0 pb-3 pb-lg-0" style="    padding-left: 0px;">
  
<div class="col-md-12 text-left">
<p class=" lh-1 mb-1 fs-4 align-items-center text-left boldfigures" style="color: green">UGX {{number_format($paymentstotal) }}</p><b>Collected rent</b></span>
</div>
  </div>

  <div class="col-lg-6 pt-3 pt-lg-0">
    
    <div class="col-md-12 text-left">
      <p class=" lh-1 mb-1 fs-4 align-items-center text-left boldfigures" style="color: red"> UGX {{number_format($totalbalance)}}</p><b>Un-Collected Rent</b></span>
    </div>
    
  </div>
</div>

              </div>
              
            </div>

            
  </div>


            <div class="col-md-8 col-xxl-3">
              <div class="card h-md-100">
                <div class="card-header pb-0">
                  <h6 class="mb-0 mt-2">Property Revenue</h6>
                </div>
                <div class="card-body d-flex flex-column justify-content-end">
                  <div class="row justify-content-between">
                 
                    <div class="col-md-9 col-xxl-3">
                        <div id="revenuechart" style="min-height: 350px;" data-echart-responsive="true"></div>
                    </div>

                    <div class="col-md-3 col-xxl-3">
                    <div class="border border-1 border-300 rounded-2 p-3 ask-analytics-item position-relative mb-3" style="border:1px solid #2f38a5">
                      <div class=""><p class=" lh-1 mb-1 fs-4 align-items-center text-left boldfigures" style="color: black; font-size:16px !important; color:#2f38a5">UGX {{number_format($paymentstotal) }}</p>
                        <div style="clear:both;"></div>
                        
                        <table><tr><td style="vertical-align: middle"><b>Money In</b></td> <td style="vertical-align: middle"><i class="far fa-arrow-alt-circle-left" style="color:#2eb079;margin-left: 7px;    font-size: 18px;"></i></td></tr></table>
                      </div>
                      <h5 class="fs--1 text-800"></h5>
                    </div>


                    <div class="border border-1 border-300 rounded-2 p-3 ask-analytics-item position-relative mb-3" style="border:1px solid #ff7a21">
                      <div class=""><p class=" lh-1 mb-1 fs-4 align-items-center text-left boldfigures" style="color: #ff7a21; font-size:16px !important; color:#ff7a21">UGX {{number_format($totalexpenses) }}</p>
                        <div style="clear:both;"></div>

                        <table><tr><td style="vertical-align: middle"><b>Money Out</b></td> <td style="vertical-align: middle"><i class="far fa-arrow-alt-circle-right" style="color:#ff7a21;margin-left: 7px;    font-size: 18px;"></i></td></tr></table>

                       </div>
                      <h5 class="fs--1 text-800"></h5>
                    </div>


                    </div>

           
                  </div>
                </div>
              </div>
            </div>

</div>







<div class="row g-3 mb-3">
  <div class="row g-2 col-md-4 col-xxl-3">
   <div class="col-md-12 col-xxl-3">
              <div class="card h-md-100 ecommerce-card-min-width">
                <div class="card-header pb-0" style="padding-right: 2px;margin-top: 5px;">
                  <h6 class="mb-0 mt-2 d-flex align-items-center" style="float:left">Un-paid Rent</h6>

                  
</div>

{{-- <div class="row" style="    padding: 15px; padding-top: 0px;"> 
<div class="col-6"> <select class="form-select form-select-sm select-month me-2">

  <option value="">Filter By Date</option>

  <option value="{{$thismonth}}">This month</option>
  <option value="{{$lastmonth}}">Last month</option>
              
  @foreach($dates as $date)
  <option value="{{$date}}"> {{ Carbon\Carbon::parse($date)->format('F y') }}</option>
  @endforeach
      
</select></div>   <div class="col-6"> <select class="form-select form-select-sm select-month me-2">

  <option value="">All properties</option>
              
  @foreach($properties as $property)
  <option value="{{$property->id}}"> {{$property->name}}</option>
  @endforeach
  
</select></div></div> --}}



<div class="row" style="margin: 10px;padding: 15px;margin-top: 0px !important;
">
  <div class="col-lg-12 border-bottom border-lg-0 pb-3 pb-lg-0" style="padding-left: 0px">
  
<div class="col-md-12 text-left">
<p class=" lh-1 mb-1 fs-4 align-items-center text-left boldfigures" style="color: red">UGX {{number_format($totalbalance) }}</p><b>Pending</b></span>
</div>


<img src="{{ asset('assets/img/icons/unpaidrent.png')}}" style="    float: left;
height: 100px;
margin-top: 20px;">
      

  </div>
</div>
                



              </div>
            </div>

            
  </div>


            <div class="col-md-4 col-xxl-3">
              <div class="card h-md-100">
                <div class="card-header pb-0">
                  <h6 class="mb-0 mt-2">Expiring Leases</h6>
                </div>
                <div class="card-body">
                  <div class="row justify-content-between">
                 
                    <div id="echart_piehome" style="min-height: 300px;"></div>
           
                  </div>
                </div>
              </div>
            </div>





            <div class="col-md-4 col-xxl-3">
              <div class="card h-md-100">
                <div class="card-header pb-0">
                  <h6 class="mb-0 mt-2">Expenses</h6>
                </div>
                <div class="card-body">
                  <div class="row justify-content-between">
                 
           
{{--                     
  <div class="row" style="    padding: 15px; padding-top: 0px;"> 
    <div class="col-6"> <select class="form-select form-select-sm select-month me-2">
  
      <option value="">Filter By Date</option>
  
      <option value="{{$thismonth}}">This month</option>
      <option value="{{$lastmonth}}">Last month</option>
                  
      @foreach($dates as $date)
      <option value="{{$date}}"> {{ Carbon\Carbon::parse($date)->format('F y') }}</option>
      @endforeach
          
    </select></div>   <div class="col-6"> <select class="form-select form-select-sm select-month me-2">
  
      <option value="">All properties</option>
                  
      @foreach($properties as $property)
      <option value="{{$property->id}}"> {{$property->name}}</option>
      @endforeach
      
    </select></div></div>
                     --}}
                    
                    <div class="row" style="margin: 10px;padding: 15px;margin-top: 0px !important;
                  ">
                    <div class="col-lg-12 border-bottom border-lg-0 pb-3 pb-lg-0" style="padding-left: 0px">
                    
  <div class="col-md-12 text-left">
    <p class=" lh-1 mb-1 fs-4 align-items-center text-left boldfigures" style="color: black">UGX  {{number_format($totalexpenses) }}</p><b></b></span>
  </div>

  
<img src="{{ asset('assets/img/icons/expenses.png')}}" style="    float: left;
height: 100px;
margin-top: 20px;">
      


                    </div>
                  </div>


                  </div>
                </div>
              </div>
            </div>


</div>





@endsection

@section('include-js')
  <!-- ===============================================-->
    <!--    JavaScripts-->
    <!-- ===============================================-->
    <script type="text/javascript" src="assets/js/echarts/echarts.min.js"></script>
<script src="{{ asset('assets/js/main.js') }}"></script>
<script type="text/javascript">
main.init();



var dom = document.getElementById('revenuechart');
    var myChart = echarts.init(dom, null, {
      renderer: 'canvas',
      useDirtyRect: false
    });
    var app = {};
    
    var option;

    option = {
  title: {
    text: '',
  },
  tooltip: {
    trigger: 'axis'
  },
  legend: {
    data: ['Expenses', 'Income']
  },
  toolbox: {
    show: true,
    feature: {
      dataView: { show: true, readOnly: false },
      magicType: { show: true, type: ['line', 'bar'] },
      restore: { show: true },
      saveAsImage: { show: true }
    }
  },
  calculable: true,
  xAxis: [
    {
      type: 'category',
      // prettier-ignore
      data: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
    }
  ],
  yAxis: [
    {
      type: 'value'
    }
  ],
  series: [
    {
      name: 'Expenses',
      type: 'bar',
      color: ['#ff7a21'],
      data: [
        @foreach($revenue as $data){{ $loop->first ? '' : ', ' }} {{$data}} @endforeach
      ],
      markPoint: {
        data: [
          { type: 'max', name: 'Max' },
          { type: 'min', name: 'Min' }
        ]
      },
      markLine: {
        data: [{ type: 'average', name: 'Avg' }]
      }
    },
    {
      name: 'Income',
      type: 'bar',
      color: ['#0863f7'],
      data: [
        @foreach($payments as $payment){{ $loop->first ? '' : ', ' }} {{$payment}} @endforeach
      ],
      markPoint: {
        data: [
          { name: 'Max', value: 182.2, xAxis: 7, yAxis: 183 },
          { name: 'Min', value: 2.3, xAxis: 11, yAxis: 3 }
        ]
      },
      markLine: {
        data: [{ type: 'average', name: 'Avg' }]
      }
    }
  ]
};

    if (option && typeof option === 'object') {
      myChart.setOption(option);
    }

    window.addEventListener('resize', myChart.resize);


// var dom = document.getElementById('echart_piehome');
//     var myChart = echarts.init(dom, null, {
//       renderer: 'canvas',
//       useDirtyRect: false
//     });
//     var app = {};
    
//     var option;

//     // This example requires ECharts v5.5.0 or later
// option = {
//   tooltip: {
//     trigger: 'item'
//   },
//   legend: {
//     top: '5%',
//     left: 'center'
//   },
//   series: [
//     {
//       name: 'Access From',
//       type: 'pie',
//       radius: ['40%', '70%'],
//       center: ['50%', '70%'],
//       // adjust the start and end angle
//       startAngle: 180,
//       endAngle: 360,
//       color: ['#ff545d','#ff8528','#4850b2'],
//       data: [
//         { value: {{$lease30}}, name: '<30 days' },
//         { value: {{$lease30to60}}, name: '30-60 days' },
//         { value: {{$lease60to90}}, name: '60-90 days' }
//       ]
//     }
//   ]
// };

//     if (option && typeof option === 'object') {
//       myChart.setOption(option);
//     }

//     window.addEventListener('resize', myChart.resize);


// let overviewurl = "{{route('reports.overview')}}";
// main.loadRemote(overviewurl, '#overviewcard');

// let revenueurl = "{{route('reports.revenue')}}";
// main.loadRemote(revenueurl, '#revenuecard');


var dom = document.getElementById('echart_piehome');
    var myChart = echarts.init(dom, null, {
      renderer: 'canvas',
      useDirtyRect: false
    });
    var app = {};
    
    var option;

    option = {
  title: {
    text: '',
    subtext: '',
    left: 'center'
  },
  tooltip: {
    trigger: 'item'
  },
  legend: {
    orient: 'horizontal',
    top: '5%',
    left: 'center'
  },
  series: [
    {
      name: 'Access From',
      type: 'pie',
      radius: '50%',
      color: ['#d50202','#ff8528','#78b55b'],
      data: [
        { value: {{$lease30}}, name: '<30 days' },
        { value: {{$lease30to60}}, name: '30-60 days' },
        { value: {{$lease60to90}}, name: '60-90 days' }
      ],
      emphasis: {
        itemStyle: {
          shadowBlur: 10,
          shadowOffsetX: 0,
          shadowColor: 'rgba(0, 0, 0, 0.5)'
        }
      }
    }
  ]
};

    if (option && typeof option === 'object') {
      myChart.setOption(option);
    }

    window.addEventListener('resize', myChart.resize);

  </script>

@endsection

