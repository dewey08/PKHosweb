<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Gotowin</title>
    <!-- Bootstrap Styles-->
    <link  href="{{ asset('assets/css/bootstrap.css') }}" rel="stylesheet" />
    <!-- FontAwesome Styles-->
    <link href="{{ asset('assets/css/font-awesome.css') }}" rel="stylesheet" />
    <!-- Morris Chart Styles-->
    <link href="{{ asset('assets/js/morris/morris-0.4.3.min.css') }}" rel="stylesheet" />
    <!-- Custom Styles-->
    <link href="{{ asset('assets/css/custom-styles.css') }}" rel="stylesheet" />
    <!-- Google Fonts-->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' /> 
    <link href='https://fonts.googleapis.com/css?family=Kanit&subset=thai,latin' rel='stylesheet' type='text/css'>
   <style>
        body {
            font-family: 'Kanit', sans-serif;
            font-size: 18px;
            font-size: 1.8rem;
            }
            input {
                font-size:1.5em;

            }
          
    </style>

</head>

<body>

    <div id="wrapper">
        <nav class="navbar navbar-default top-navbar navbar-dark" role="navigation" style="background-color: #ff5500;">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="{{ url('/') }}"><i ></i> <strong>BACK OFFICE</strong></a>
            </div>

            <ul class="nav navbar-top-links navbar-right">
                
            <li>
               
            {{ Auth::user()->name }} 
            </li>
                               <!-- <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ url('about') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>-->
                                </ul>
        </nav>
        <!--/. NAV TOP  -->
        <nav class="navbar-default navbar-side" role="navigation">
		
            <div class="sidebar-collapse">
                <ul class="nav" id="main-menu">
            
                    <li>
                        <a class="active-menu text-dark" href="{{ url('person') }}"><i class="fa fa-dashboard"></i>ข้อมูลส่วนบุคคล</a>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-desktop"></i>เมนูที่2</a>
                    </li>
					<li>
                        <a href="#"><i class="fa fa-bar-chart-o"></i> เมนูที่3</a>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-qrcode"></i>เมนูที่4</a>
                    </li>
                    
                    <li>
                        <a href="#"><i class="fa fa-table"></i>เมนูที่5</a>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-edit"></i> เมนูที่6 </a>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-edit"></i> เมนูที่7 </a>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-edit"></i> เมนูที่8 </a>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-edit"></i> เมนูที่9 </a>
                    </li>
                    <li>
                    <a href="{{ url('about') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                       
                                   <i class="fa fa-edit"></i> ออกจากระบบ </a>
                                   <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                    </li>
                
                  
                </ul>

            </div>

        </nav>
        <!-- /. NAV SIDE  -->
        <div id="page-wrapper">
        @yield('content')
		
	    <div class="row">
				
				
				
       
            </div>
            <!-- /. PAGE row  -->
        </div>
        <!-- /. PAGE WRAPPER  -->
    </div>
    <!-- /. WRAPPER  -->
    <!-- JS Scripts-->
    @yield('footer')
    <!-- jQuery Js -->
 
   
    <!-- Metis Menu Js -->
    <script src="{{ asset('assets/js/jquery.metisMenu.js') }}"></script>
    <!-- Morris Chart Js -->
    <script src="{{ asset('assets/js/morris/raphael-2.1.0.min.js') }}"></script>
    <script src="{{ asset('assets/js/morris/morris.js') }}"></script>
	
	
	<script src="{{ asset('assets/js/easypiechart.js') }}"></script>
	<script src="{{ asset('assets/js/easypiechart-data.js') }}"></script>
	
	 <script src="{{ asset('assets/js/Lightweight-Chart/jquery.chart.js') }}"></script>
	
    <!-- Custom Js -->
    <script src="{{ asset('assets/js/custom-scripts.js') }}"></script>
    
</body>

</html>