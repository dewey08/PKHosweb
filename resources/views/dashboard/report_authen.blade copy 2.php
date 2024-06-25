@extends('layouts.report_font')
@section('title', 'PK-OFFICER || Dashboard')


@section('content')

    <?php
        $ynow = date('Y')+543;
        $mo =  date('m');
    ?>

     <style>
        #button{
               display:block;
               margin:20px auto;
               padding:30px 30px;
               background-color:#eee;
               border:solid #ccc 1px;
               cursor: pointer;
               }
               #overlay{
               position: fixed;
               top: 0;
               z-index: 100;
               width: 100%;
               height:100%;
               display: none;
               background: rgba(0,0,0,0.6);
               }
               .cv-spinner {
               height: 100%;
               display: flex;
               justify-content: center;
               align-items: center;
               }
               .spinner {
               width: 250px;
               height: 250px;
               border: 10px #ddd solid;
               border-top: 10px rgb(212, 106, 124) solid;
               border-radius: 50%;
               animation: sp-anime 0.8s infinite linear;
               }
               @keyframes sp-anime {
               100% {
                   transform: rotate(360deg);
               }
               }
               .is-hide{
               display:none;
               }
    </style>

    <div class="container-fluid">
        <div id="preloader">
            <div id="status">
                <div class="spinner">

                </div>
            </div>
        </div>

        <div class="row">

                <div class="col-xl-6 col-md-3">
                    <div class="main-card card" >
                        {{-- <div class="grid-menu-col">
                            <div class="g-0 row">
                                <div class="col-sm-12"> --}}
                                    {{-- <div class="widget-chart widget-chart-hover" style="height: 800px;">  --}}
                                        <h5 class="card-title mt-2 ms-2">Authen Report Month OPD ปี พ.ศ.{{$ynow}}</h5>
                                        {{-- <div class="widget-chart-wrapper widget-chart-wrapper-lg opacity-10 m-0 p-2"> --}}
                                            <div style="height:auto;" class="p-2">
                                                <canvas id="Mychart"></canvas>
                                            </div>
                                        {{-- </div>  --}}
                                    {{-- </div>  --}}
                                {{-- </div>
                            </div>
                        </div> --}}
                    </div>
                </div>
                <div class="col-xl-6 col-md-3">
                    <div class="main-card card">
                        {{-- <div class="grid-menu-col">
                            <div class="g-0 row">
                                <div class="col-sm-12"> --}}
                                    <h5 class="card-title mt-2 ms-2">Authen Report Month IPD ปี พ.ศ.{{$ynow}}</h5>
                                    {{-- <div class="widget-chart-wrapper widget-chart-wrapper-lg opacity-10 ms-2 me-2 mb-2"> --}}
                                        <div style="height:auto;" class="p-2">
                                            <canvas id="Mychartipd"></canvas>
                                        </div>
                                    {{-- </div> --}}
                                {{-- </div>
                            </div>
                        </div> --}}
                    </div>
                </div>


        </div>

        <div class="row">

            <div class="col-xl-12 col-md-3">
                <div class="main-card mb-3 card p-2" >
                    <div class="grid-menu-col">
                        <div class="g-0 row">
                            <div class="col-sm-12">

                                    <h5 class="card-title mt-2 ms-2">Authen Report Month OPD ปี พ.ศ.{{$ynow}}</h5>
                                        <div style="height:450px;">
                                            <div class="row">
                                                @foreach ($data_year as $item)
                                                    <div class="col-md-6 col-lg-4">

                                                        @if ($item->month == '1')
                                                        <div class="widget-chart widget-chart2 text-start mb-3 card-btm-border card-shadow-primary border-primary card shadow-lg">
                                                        @elseif ($item->month == '2')
                                                        <div class="widget-chart widget-chart2 text-start mb-3 card-btm-border card-shadow-primary border-info card shadow-lg">
                                                        @elseif ($item->month == '3')
                                                        <div class="widget-chart widget-chart2 text-start mb-3 card-btm-border card-shadow-primary border-warning card shadow-lg">
                                                        @elseif ($item->month == '4')
                                                        <div class="widget-chart widget-chart2 text-start mb-3 card-btm-border card-shadow-primary border-danger card shadow-lg">
                                                        @elseif ($item->month == '5')
                                                        <div class="widget-chart widget-chart2 text-start mb-3 card-btm-border card-shadow-primary border-secondary card shadow-lg">
                                                        @elseif ($item->month == '6')
                                                        <div class="widget-chart widget-chart2 text-start mb-3 card-btm-border card-shadow-primary card shadow-lg" style="border-block-color: pink">
                                                        @elseif ($item->month == '7')
                                                        <div class="widget-chart widget-chart2 text-start mb-3 card-btm-border card-shadow-primary card shadow-lg" style="border-block-color: rgb(161, 84, 206)">
                                                        @elseif ($item->month == '8')
                                                        <div class="widget-chart widget-chart2 text-start mb-3 card-btm-border card-shadow-primary card shadow-lg" style="border-block-color: rgb(240, 84, 110)">
                                                        @elseif ($item->month == '9')
                                                        <div class="widget-chart widget-chart2 text-start mb-3 card-btm-border card-shadow-primary card shadow-lg" style="border-block-color: rgb(119, 109, 247)">
                                                        @elseif ($item->month == '10')
                                                        <div class="widget-chart widget-chart2 text-start mb-3 card-btm-border card-shadow-primary card shadow-lg" style="border-block-color: rgb(70, 235, 133)">
                                                        @elseif ($item->month == '11')
                                                        <div class="widget-chart widget-chart2 text-start mb-3 card-btm-border card-shadow-primary card shadow-lg" style="border-block-color: rgb(185, 221, 53)">
                                                        @else
                                                        <div class="widget-chart widget-chart2 text-start mb-3 card-btm-border card-shadow-primary card shadow-lg" style="border-block-color: rgb(248, 149, 68)">
                                                        @endif
                                                            <div class="widget-chat-wrapper-outer">
                                                                <div class="widget-chart-content">

                                                                    @if ($item->month == '1')
                                                                    <div class="widget-title opacity-5 text-uppercase">มกราคม</div>
                                                                    @elseif ($item->month == '2')
                                                                    <div class="widget-title opacity-5 text-uppercase">กุมภาพันธ์</div>
                                                                    @elseif ($item->month == '3')
                                                                    <div class="widget-title opacity-5 text-uppercase">มีนาคม</div>
                                                                    @elseif ($item->month == '4')
                                                                    <div class="widget-title opacity-5 text-uppercase">เมษายน</div>
                                                                    @elseif ($item->month == '5')
                                                                    <div class="widget-title opacity-5 text-uppercase">พฤษภาคม</div>
                                                                    @elseif ($item->month == '6')
                                                                    <div class="widget-title opacity-5 text-uppercase">มิถุนายน</div>
                                                                    @elseif ($item->month == '7')
                                                                    <div class="widget-title opacity-5 text-uppercase">กรกฎาคม</div>
                                                                    @elseif ($item->month == '8')
                                                                    <div class="widget-title opacity-5 text-uppercase">สิงหาคม</div>
                                                                    @elseif ($item->month == '9')
                                                                    <div class="widget-title opacity-5 text-uppercase">กันยายน</div>
                                                                    @elseif ($item->month == '10')
                                                                    <div class="widget-title opacity-5 text-uppercase">ตุลาคม</div>
                                                                    @elseif ($item->month == '11')
                                                                    <div class="widget-title opacity-5 text-uppercase">พฤษจิกายน</div>
                                                                    @else
                                                                    <div class="widget-title opacity-5 text-uppercase">ธันวาคม</div>
                                                                    @endif
                                                                    <div class="widget-numbers mt-2 fsize-4 mb-0 w-100">
                                                                        <div class="widget-chart-flex align-items-center">
                                                                            <div>
                                                                                <span class="opacity-10 text-success pe-2">
                                                                                    <i class="fa fa-angle-left"></i>
                                                                                </span>
                                                                                {{$item->countvn}}
                                                                                <small class="opacity-5 ps-1">Visit</small>
                                                                            </div>
                                                                            {{-- <div class="widget-title ms-auto font-size-lg text-muted"> --}}
                                                                                <div class="widget-title ms-auto font-size-lg fw-normal text-muted">
                                                                                    {{-- <div class="circle-progress circle-progress-success-sm d-inline-block">
                                                                                        <small></small>
                                                                                    </div> --}}
                                                                                    {{-- <div class="progress-bar bg-danger" role="progressbar" aria-valuenow="30"
                                                                                        aria-valuemin="30" aria-valuemax="100" style="width:30%;">
                                                                                    </div> --}}

                                                                                {{-- @if ($item->authenOPD == '0')
                                                                                <div class="progress-bar bg-danger" role="progressbar" aria-valuenow="0"
                                                                                    aria-valuemin="0" aria-valuemax="100" style="width:0%;">
                                                                                </div>
                                                                            @else
                                                                                <div class="progress-bar bg-danger" role="progressbar"
                                                                                    aria-valuenow="{{ number_format($item->authenOPD, 0) }}" aria-valuemin="0"
                                                                                    aria-valuemax="100" style="width: {{ number_format($item->authenOPD, 0) }}%;">
                                                                                </div>
                                                                            @endif --}}
                                                                                {{-- <div class="circle-progress circle-progress-gradient-alt-sm d-inline-block">
                                                                                    <small>2222</small>
                                                                                </div> --}}
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>

                                        </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- <div class="col-xl-6 col-md-3">
                <div class="main-card mb-3 card p-2">
                    <div class="grid-menu-col">
                        <div class="g-0 row">
                            <div class="col-sm-12">
                                <h5 class="card-title mt-2 ms-2">Authen Report Month IPD</h5>
                                    <div style="height:450px;">
                                        <section>
                                            <div class="flex info">
                                              <div class="info-name">minimal width shadow</div>
                                              <div class="info-code">code</div>
                                            </div>
                                            <div class="pie" data-pie='{ "percent": 75 }'></div>
                                            <div class="code">
                                              <pre>
                                                <code class="language-json">// css
                                                  [data-pie-index='2'] {
                                                    position: relative;
                                                    border-radius: 50%;
                                                    box-shadow: inset 0 0 25px 10px #a2caff;
                                                  }
                                                  // html
                                                  data-pie='{
                                                    "percent": 75
                                                  }'</code>
                                              </pre>
                                            </div>
                                          </section>
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}


    </div>



    </div>


    @endsection
    @section('footer')

    <script>
        $(document).ready(function() {
            $('#example').DataTable();
            $('#example2').DataTable();
            $('#datepicker').datepicker({
                format: 'yyyy-mm-dd'
            });
            $('#datepicker2').datepicker({
                format: 'yyyy-mm-dd'
            });

        });
    </script>
      <script>
        var ctx = document.getElementById("Mychart").getContext("2d");

            fetch("{{ route('rep.reportauthen_getbar') }}")
                .then(response => response.json())
                .then(json => {
                    const Mychart = new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: json.labels,
                                datasets: json.datasets,

                            },
                            options:{
                                scales:{
                                    y:{
                                        beginAtZero:true
                                    }
                                }
                            }
                        })
                });

    </script>
     <script>
        var ctx2 = document.getElementById("Mychartipd").getContext("2d");

            fetch("{{ route('rep.reportauthen_getbaripd') }}")
                .then(response => response.json())
                .then(json => {
                    const Mychart = new Chart(ctx2, {
                            type: 'bar',
                            // type: 'line',
                            data: {
                                labels: json.labels,
                                datasets: json.datasets,

                            },
                            options:{
                                scales:{
                                    y:{
                                        beginAtZero:true
                                        // stacked: true
                                    }
                                }
                            }
                        })
                });

    </script>

    <script>
        window.addEventListener("DOMContentLoaded", () => {
        // update circle when range change
        const pie = document.querySelectorAll("#pie");
        const range = document.querySelector('[type="range"]');

        range.addEventListener("input", (e) => {
            pie.forEach((el, index) => {
            const options = {
                index: index + 1,
                percent: e.target.value,
            };
            circle.animationTo(options);
            });
        });

        // start the animation when the element is in the page view
        const elements = [].slice.call(document.querySelectorAll("#pie"));
        const circle = new CircularProgressBar("pie");

        // circle.initial();

        if ("IntersectionObserver" in window) {
            const config = {
            root: null,
            rootMargin: "0px",
            threshold: 0.75,
            };

            const ovserver = new IntersectionObserver((entries, observer) => {
            entries.map((entry) => {
                if (entry.isIntersecting && entry.intersectionRatio >= 0.75) {
                circle.initial(entry.target);
                observer.unobserve(entry.target);
                }
            });
            }, config);

            elements.map((item) => {
            ovserver.observe(item);
            });
        } else {
            elements.map((element) => {
            circle.initial(element);
            });
        }

        setInterval(() => {
            const typeFont = [100, 200, 300, 400, 500, 600, 700];
            const colorHex = `#${Math.floor(
            (Math.random() * 0xffffff) << 0
            ).toString(16)}`;
            const options = {
            index: 17,
            percent: Math.floor(Math.random() * 100 + 1),
            colorSlice: colorHex,
            fontColor: colorHex,
            fontSize: `${Math.floor(Math.random() * (1.4 - 1 + 1) + 1)}rem`,
            fontWeight: typeFont[Math.floor(Math.random() * typeFont.length)],
            };
            circle.animationTo(options);
        }, 3000);

        // global configuration
        const globalConfig = {
            index: 58,
            speed: 30,
            animationSmooth: "1s ease-out",
            strokeBottom: 5,
            colorSlice: "#FF6D00",
            colorCircle: "#f1f1f1",
            round: true,
        };

        const global = new CircularProgressBar("global", globalConfig);
        global.initial();

        // --------------------------------------------------
        // update global example when change range
        range.addEventListener("input", (e) => {
            const options = {
            index: 58,
            percent: e.target.value,
            };
            global.animationTo(options);
        });
        });
  </script>
    @endsection
