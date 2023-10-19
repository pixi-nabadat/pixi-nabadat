@extends('layouts.simple.master')

@section('title', trans('lang.dashboard'))

@section('css')

@endsection

@section('style')
    <style>
        .dashboard_icon
        {
            opacity: 0.1;
        }
    </style>
@endsection

@section('breadcrumb-title')
<h3>{{trans('lang.dashboard')}}</h3>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item">{{trans('lang.dashboard')}}</li>
<li class="breadcrumb-item active">{{trans('lang.home')}}</li>
@endsection

@section('content')
    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6 col-xl-3 col-lg-6">
                <div class="card o-hidden static-top-widget-card">
                    <div class="card-body">
                        <div class="media static-top-widget">
                            <div class="media-body">
                                <h6 class="font-roboto">{{trans('lang.users')}}</h6>
                                <h4 class="mb-0 counter">{{$users_count}}</h4>
                            </div>
                            <span class="dashboard_icon"><i class="fa fa-users fa-3x"></i></span>
                        </div>
                        <div class="progress-widget">
                            <div class="progress sm-progress-bar progress-animate">
                                <div class="progress-gradient-success" role="progressbar" style="width: 60%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"><span class="animate-circle"></span></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3 col-lg-6">
                <div class="card o-hidden">
                    <div class="card-body">
                        <div class="media static-top-widget">
                            <div class="media-body">
                                <h6 class="font-roboto">{{trans('lang.centers')}}</h6>
                                <h4 class="mb-0 counter">{{$centers_count}}</h4>
                            </div>
                            <span class="dashboard_icon"><i class="fa fa-home fa-3x"></i></span>

                        </div>
                        <div class="progress-widget">
                            <div class="progress sm-progress-bar progress-animate">
                                <div class="progress-gradient-primary" role="progressbar" style="width: 48%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"><span class="animate-circle"></span></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3 col-lg-6">
                <div class="card o-hidden">
                    <div class="card-body">
                        <div class="media static-top-widget">
                            <div class="media-body">
                                <h6 class="font-roboto">{{trans('lang.products')}}</h6>
                                <h4 class="mb-0 counter">{{$products_count}}</h4>
                            </div>
                            <span class="dashboard_icon"><i class="fa fa-cubes fa-3x"></i></span>

                        </div>
                        <div class="progress-widget">
                            <div class="progress sm-progress-bar progress-animate">
                                <div class="progress-gradient-danger" role="progressbar" style="width: 48%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"><span class="animate-circle"></span></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3 col-lg-6">
                <div class="card o-hidden static-top-widget-card">
                    <div class="card-body">
                        <div class="media static-top-widget">
                            <div class="media-body">
                                <h6 class="font-roboto">@lang('lang.earnings')</h6>
                                <h4 class="mb-0 counter">6659</h4>
                            </div>
                            <svg class="fill-secondary" width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M22.5938 14.1562V17.2278C20.9604 17.8102 19.7812 19.3566 19.7812 21.1875C19.7812 23.5138 21.6737 25.4062 24 25.4062C24.7759 25.4062 25.4062 26.0366 25.4062 26.8125C25.4062 27.5884 24.7759 28.2188 24 28.2188C23.2241 28.2188 22.5938 27.5884 22.5938 26.8125H19.7812C19.7812 28.6434 20.9604 30.1898 22.5938 30.7722V33.8438H25.4062V30.7722C27.0396 30.1898 28.2188 28.6434 28.2188 26.8125C28.2188 24.4862 26.3263 22.5938 24 22.5938C23.2241 22.5938 22.5938 21.9634 22.5938 21.1875C22.5938 20.4116 23.2241 19.7812 24 19.7812C24.7759 19.7812 25.4062 20.4116 25.4062 21.1875H28.2188C28.2188 19.3566 27.0396 17.8102 25.4062 17.2278V14.1562H22.5938Z"></path>
                                <path d="M25.4062 0V11.4859C31.2498 12.1433 35.8642 16.7579 36.5232 22.5938H48C47.2954 10.5189 37.4829 0.704531 25.4062 0Z"></path>
                                <path d="M14.1556 31.8558C12.4237 29.6903 11.3438 26.9823 11.3438 24C11.3438 17.5025 16.283 12.1958 22.5938 11.4859V0C10.0492 0.731813 0 11.2718 0 24C0 30.0952 2.39381 35.6398 6.14897 39.8624L14.1556 31.8558Z"></path>
                                <path d="M47.9977 25.4062H36.5143C35.8044 31.717 30.4977 36.6562 24.0002 36.6562C21.0179 36.6562 18.3099 35.5763 16.1444 33.8444L8.13779 41.851C12.3604 45.6062 17.905 48 24.0002 48C36.7284 48 47.2659 37.9508 47.9977 25.4062Z"></path>
                            </svg>
                        </div>
                        <div class="progress-widget">
                            <div class="progress sm-progress-bar progress-animate">
                                <div class="progress-gradient-secondary" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"><span class="animate-circle"></span></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- <div class="col-xl-6 col-md-12 box-col-12">
                <div class="card">
                    <div class="card-header">
                        <h5>@lang('lang.bar_chart')</h5>
                    </div>
                    <div class="card-body chart-block">
                        <canvas id="myBarGraph"></canvas>
                    </div>
                </div>
            </div> --}}
            {{-- <div class="col-xl-6 col-md-12 box-col-12">
                <div class="card">
                    <div class="card-header">
                        <h5>@lang('lang.line_graph')</h5>
                    </div>
                    <div class="card-body chart-block">
                        <canvas id="myGraph"></canvas>
                    </div>
                </div>
            </div> --}}
            {{-- <div class="col-xl-6 col-md-12 box-col-12">
                <div class="card">
                    <div class="card-header">
                        <h5>@lang('lang.line_chart')</h5>
                    </div>
                    <div class="card-body chart-block">
                        <canvas id="myLineCharts"></canvas>
                    </div>
                </div>
            </div> --}}
            <div class="col-xl-6 box-col-12">
                <div class="card">
                    <div class="card-header">
                        <h5>@lang('lang.due_panel')</h5>
                    </div>
                    <div class="card-body chart-block chart-vertical-center">
                        <canvas id="duePanel"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 box-col-12">
                <div class="card">
                    <div class="card-header">
                        <h5>@lang('lang.nabadat_panel')</h5>
                    </div>
                    <div class="card-body chart-block chart-vertical-center">
                        <canvas id="nabadatPanel"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 box-col-12">
                <div class="card">
                    <div class="card-header">
                        <h5>@lang('lang.dougnhut_chart_data')</h5>
                    </div>
                    <div class="card-body chart-block chart-vertical-center">
                        <canvas id="dougnhutChartData"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 box-col-12">
                <div class="card">
                    <div class="card-header">
                        <h5>@lang('lang.cancel_average')</h5>
                    </div>
                    <div class="card-body chart-block chart-vertical-center">
                        <canvas id="cancelAverageChartData"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="table">
                            <table>
                                <thead>
                                    <th>Top Selling Doctors</th>
                                </thead>
                                <body>
                                    <tr>
                                        <td>Logo</td>
                                        <td>Name</td>
                                        <td>phone</td>
                                    </tr>
                                    @foreach ($top_selling_doctors as $doctor)
                                    <tr>
                                        <td>
                                            <img class="b-r-10" width="35px" src="{{ $doctor->getImagePathAttribute() }}">
                                        </td>
                                        <td>{{ $doctor->getTranslation('name', App::getLocale()) }}</td>
                                        <td>{{ $doctor->user->phone }}</td>
                                    </tr>
                                    @endforeach
                                </body>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="table">
                            <table>
                                <thead>
                                    <th>Top Selling Products</th>
                                </thead>
                                <body>
                                    <tr>
                                        <td>Product</td>
                                        <td>Stock</td>
                                        <td>Total Sales</td>
                                    </tr>
                                    @foreach ($top_selling_products as $product)
                                    <tr>
                                        <td>{{ $product->name }}</td>
                                        <td>{{ $product->stock }}</td>
                                        <td>{{ $product->order_items_count }}</td>
                                    </tr>
                                    @endforeach
                                </body>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            {{-- start customers review --}}
            <div class="col-xs-12">
                <div class="card">
                    <div class="card-body">
                        <!-- Start Section Our Team-->
                        <section class="our_team text-center">
                            <div class="team">
                                <div class="container">
                                    <h2 class="h1">Customers Review</h2>
                                    <div class="row">
                                        @foreach ($customer_reviews as $review)
                                            
                                        <div class="col-md-4 col-sm-6">
                                            <div class="person wow pulse" data-offset="400" data-duration="1s">
                                                <img class="img-circle img-responsive" width="150" src="{{ $review->user->image }}">
                                                <h5>{{ $review->user->name }}</h5>
                                                <h4>{{ $review->ratable->name }}</h4>
                                                <p>{{ $review->comment }}</p>
                                                <div>{{ $review->rate_number }}</div>
                                                @for($i=1;$i<=5;$i++)
                                                    @if($review->rate_number >= $i)
                                                        <i class="fa fa-solid fa-star fa-2x"></i>
                                                    @else
                                                        @if($review->rate_number >($i-1) && $review->rate_number <$i)
                                                            <i class="fa fa-star-half fa-2x"></i>
                                                        @else
                                                            <i class="fa fa-light fa-star-o fa-2x"></i>
                                                        @endif
                                                    @endif

                                                @endfor
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                    
                                </div>
                            </div>
                        </section>
                        <!-- End Section Our Team-->
                    </div>
                </div>
            </div>
            {{-- end end customers review --}}

            {{-- start last customers registered --}}
            <div class="col-xs-12">
                <div class="card">
                    <div class="card-body">
                        <!-- Start Section Our Team-->
                        <section class="our_team text-center">
                            <div class="team">
                                <div class="container">
                                    <h2 class="h1">Last Customers</h2>
                                    <div class="row">
                                        @foreach ($last_customers as $customer)
                                        <div class="col-md-4 col-sm-6">
                                            <div class="person wow pulse" data-offset="400" data-duration="1s">
                                                <img class="img-circle img-responsive" width="150" src="{{ $customer->getImageAttribute() }}">
                                                <h3>{{ $customer->name }}</h3>
                                                <p>{{ $customer->email }}</p>
                                                <p>{{ $customer->phone }}</p>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                    
                                    
                                    
                                    
                                </div>
                            </div>
                        </section>
                        <!-- End Section Our Team-->
                    </div>
                </div>
            </div>
            {{-- end end last customers registered --}}

            {{-- start chat --}}
            {{-- <div class="col-lg-4 call-chat-body" style="position: fixed; right:5px; bottom:5px;; background-color:#EEE">
                <div class="card">
                  <div class="card-body p-0">
                    <div class="row chat-box">
                      <!-- Chat right side start-->
                      <div class="col pe-0 chat-cen">
                        <!-- chat start-->
                        <div class="chat">
                          <!-- chat-header start-->
                          <div class="chat-header clearfix"><img class="rounded-circle" src="https://laravel.pixelstrap.com/cuba/assets/images/user/8.jpg" alt="">
                            <div class="about">
                              <div class="name">Kori Thomas&nbsp;&nbsp;<span class="font-primary f-12">Typing...</span></div>
                              <div class="status">Last Seen 3:55 PM</div>
                            </div>
                            <ul class="list-inline float-start float-sm-end chat-menu-icons">
                              <li class="list-inline-item"><a href="#" data-bs-original-title="" title=""><i class="icon-search"></i></a></li>
                              <li class="list-inline-item"><a href="#" data-bs-original-title="" title=""><i class="icon-clip"></i></a></li>
                              <li class="list-inline-item"><a href="#" data-bs-original-title="" title=""><i class="icon-headphone-alt"></i></a></li>
                              <li class="list-inline-item"><a href="#" data-bs-original-title="" title=""><i class="icon-video-camera"></i></a></li>
                              <li class="list-inline-item toogle-bar"><a href="#" data-bs-original-title="" title=""><i class="icon-menu"></i></a></li>
                            </ul>
                          </div>
                          <!-- chat-header end-->
                          <div class="chat-history chat-msg-box custom-scrollbar">
                            <ul>
                              <li>
                                <div class="message my-message"><img class="rounded-circle float-start chat-user-img img-30" src="https://laravel.pixelstrap.com/cuba/assets/images/user/3.png" alt="">
                                  <div class="message-data text-end"><span class="message-data-time">10:12 am</span></div>                                                            Are we meeting today? Project has been already finished and I have results to show you.
                                </div>
                              </li>
                              <li class="clearfix">
                                <div class="message other-message pull-right"><img class="rounded-circle float-end chat-user-img img-30" src="https://laravel.pixelstrap.com/cuba/assets/images/user/12.png" alt="">
                                  <div class="message-data"><span class="message-data-time">10:14 am</span></div>                                                            Well I am not sure. The rest of the team is not here yet. Maybe in an hour or so?
                                </div>
                              </li>
                              <li class="clearfix">
                                <div class="message other-message pull-right"><img class="rounded-circle float-end chat-user-img img-30" src="https://laravel.pixelstrap.com/cuba/assets/images/user/12.png" alt="">
                                  <div class="message-data"><span class="message-data-time">10:14 am</span></div>                                                            Well I am not sure. The rest of the team
                                </div>
                              </li>
                              <li>
                                <div class="message my-message mb-0"><img class="rounded-circle float-start chat-user-img img-30" src="https://laravel.pixelstrap.com/cuba/assets/images/user/3.png" alt="">
                                  <div class="message-data text-end"><span class="message-data-time">10:20 am</span></div>                                                            Actually everything was fine. I'm very excited to show this to our team.
                                </div>
                              </li>
                            </ul>
                          </div>
                          <!-- end chat-history-->
                          <div class="chat-message clearfix">
                            <div class="row">
                              <div class="col-xl-12 d-flex">
                                <div class="smiley-box bg-primary">
                                  <div class="picker"><img src="https://laravel.pixelstrap.com/cuba/assets/images/smiley.png" alt=""></div>
                                </div>
                                <div class="input-group text-box">
                                  <input class="form-control input-txt-bx" id="message-to-send" type="text" name="message-to-send" placeholder="Type a message......" data-bs-original-title="" title="">
                                  <button class="input-group-text btn btn-primary" type="button" data-bs-original-title="" title="">SEND</button>
                                </div>
                              </div>
                            </div>
                          </div>
                          <!-- end chat-message-->
                          <!-- chat end-->
                          <!-- Chat right side ends-->
                        </div>
                      </div>
                      
                    </div>
                  </div>
                </div>
              </div> --}}
            {{-- end chat --}}
            
        </div>
    </div>

@endsection

@section('script')
    <script src="{{asset('assets/js/chart/chartjs/chart.min.js')}}"></script>
    <script>
        Chart.defaults.global = {
            animation: true,
            animationSteps: 60,
            animationEasing: "easeOutIn",
            showScale: true,
            scaleOverride: false,
            scaleSteps: null,
            scaleStepWidth: null,
            scaleStartValue: null,
            scaleLineColor: "#eeeeee",
            scaleLineWidth: 1,
            scaleShowLabels: true,
            scaleLabel: "<%=value%>",
            scaleIntegersOnly: true,
            scaleBeginAtZero: false,
            scaleFontSize: 12,
            scaleFontStyle: "normal",
            scaleFontColor: "#717171",
            responsive: true,
            maintainAspectRatio: true,
            showTooltips: true,
            multiTooltipTemplate: "<%= value %>",
            tooltipFillColor: "#333333",
            tooltipEvents: ["mousemove", "touchstart", "touchmove"],
            tooltipTemplate: "<%if (label){%><%=label%>: <%}%><%= value %>",
            tooltipFontSize: 14,
            tooltipFontStyle: "normal",
            tooltipFontColor: "#fff",
            tooltipTitleFontSize: 16,
            TitleFontStyle : "Raleway",
            tooltipTitleFontStyle: "bold",
            tooltipTitleFontColor: "#ffffff",
            tooltipYPadding: 10,
            tooltipXPadding: 10,
            tooltipCaretSize: 8,
            tooltipCornerRadius: 6,
            tooltipXOffset: 5,
            onAnimationProgress: function() {},
            onAnimationComplete: function() {}
        };
        
        var duePanelData = [
            {
                value: 300,
                color: CubaAdminConfig.primary ,
                highlight: CubaAdminConfig.primary ,
                label: "Centers"
            },
            {
                value: 100,
                color: "#51bb25",
                highlight: "#51bb25",
                label: "Clients"
            }
        ];
        var nabadatPanelData = [
            {
                value: 300,
                color: CubaAdminConfig.primary ,
                highlight: CubaAdminConfig.primary ,
                label: "Nabadat"
            },
            {
                value: 100,
                color: "#51bb25",
                highlight: "#51bb25",
                label: "Center"
            }
        ];
        var dougnhutChartData = [
            {
                value: 300,
                color: CubaAdminConfig.primary ,
                highlight: CubaAdminConfig.primary ,
                label: "Wait reservation"
            },
            {
                value: 100,
                color: "#51bb25",
                highlight: "#51bb25",
                label: "Done reservation"
            },
            {
                value: {{$users_count}},
                color: "#f00",
                highlight: "#f00",
                label: "Cancel reservation"
            }
        ];
        var cancelAverageChartData = [
            {
                value: 300,
                color: CubaAdminConfig.primary ,
                highlight: CubaAdminConfig.primary ,
                label: "Center"
            },
            {
                value: 100,
                color: "#51bb25",
                highlight: "#51bb25",
                label: "Client"
            },
        ];
        var doughnutOptions = {
            segmentShowStroke: true,
            segmentStrokeColor: "#fff",
            segmentStrokeWidth: 2,
            percentageInnerCutout: 50,
            animationSteps: 100,
            animationEasing: "easeOutBounce",
            animateRotate: true,
            animateScale: false,
            legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<segments.length; i++){%><li><span style=\"background-color:<%=segments[i].fillColor%>\"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>"
        };
        var duePanel = document.getElementById("duePanel").getContext("2d");
        var myDoughnutChart = new Chart(duePanel).Doughnut(duePanelData, doughnutOptions);
        var nabadatPanel = document.getElementById("nabadatPanel").getContext("2d");
        var myDoughnutChart = new Chart(nabadatPanel).Doughnut(nabadatPanelData, doughnutOptions);
        var dougnhutChart = document.getElementById("dougnhutChartData").getContext("2d");
        var myDoughnutChart = new Chart(dougnhutChart).Doughnut(dougnhutChartData, doughnutOptions);
        var cancelAverageChart = document.getElementById("cancelAverageChartData").getContext("2d");
        var myDoughnutChart = new Chart(cancelAverageChart).Doughnut(cancelAverageChartData, doughnutOptions);
        </script>
@endsection

