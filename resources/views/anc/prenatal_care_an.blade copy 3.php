@extends('layouts.anc')
@section('title', 'PK-OFFICER || ANC')

<!-- Bootstrap CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

<script src="https://code.jquery.com/jquery-3.5.1.min.js"
integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
crossorigin="anonymous"></script>
@section('content')
    <script>
        function TypeAdmin() {
            window.location.href = '{{ route('index') }}';
        }
    </script>

    <?php
    if (Auth::check()) {
        $type = Auth::user()->type;
        $iduser = Auth::user()->id;
        $tel_ = Auth::user()->tel;
        $debsubsub = Auth::user()->dep_subsubtrueid;
    } else {
        echo "<body onload=\"TypeAdmin()\"></body>";
        exit();
    }
    $url = Request::url();
    $pos = strrpos($url, '/') + 1;
    
    $datenow = date('Y-m-d');
    $y = date('Y') + 544;
    use Illuminate\Support\Facades\DB;
    use App\Http\Controllers\SoteController;
    $refnumber = SoteController::refnumber();
    ?>
    {{-- <style>
        body {
            font-family: sans-serif;
            font: normal;
            font-style: normal;
        }

        #button {
            display: block;
            margin: 20px auto;
            padding: 30px 30px;
            background-color: #eee;
            border: solid #ccc 1px;
            cursor: pointer;
        }

        #overlay {
            position: fixed;
            top: 0;
            z-index: 100;
            width: 100%;
            height: 100%;
            display: none;
            background: rgba(0, 0, 0, 0.6);
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
            border: 5px #ddd solid;
            border-top: 10px #12c6fd solid;
            border-radius: 50%;
            animation: sp-anime 0.8s infinite linear;
        }

        @keyframes sp-anime {
            100% {
                transform: rotate(360deg);
            }
        }

        .is-hide {
            display: none;
        }
    </style> --}}
    <style>
        /*left right modal*/
        .modal.left_modal,
        .modal.right_modal {
            position: fixed;
            z-index: 99999;
        }

        .modal.left_modal .modal-dialog,
        .modal.right_modal .modal-dialog {
            position: fixed;
            margin: auto;
            width: 32%;
            height: 100%;
            -webkit-transform: translate3d(0%, 0, 0);
            -ms-transform: translate3d(0%, 0, 0);
            -o-transform: translate3d(0%, 0, 0);
            transform: translate3d(0%, 0, 0);
        }

        .modal-dialog {
            /* max-width: 100%; */
            margin: 1.75rem auto;
        }

        @media (min-width: 576px) {
            .left_modal .modal-dialog {
                max-width: 100%;
            }

            .right_modal .modal-dialog {
                max-width: 100%;
            }
        }

        .modal.left_modal .modal-content,
        .modal.right_modal .modal-content {
            /*overflow-y: auto;
            overflow-x: hidden;*/
            height: 100vh !important;
        }

        .modal.left_modal .modal-body,
        .modal.right_modal .modal-body {
            padding: 15px 15px 30px;
        }

        /*.modal.left_modal  {
            pointer-events: none;
            background: transparent;
        }*/

        .modal-backdrop {
            display: none;
        }

        /*Left*/
        .modal.left_modal.fade .modal-dialog {
            left: -50%;
            -webkit-transition: opacity 0.3s linear, left 0.3s ease-out;
            -moz-transition: opacity 0.3s linear, left 0.3s ease-out;
            -o-transition: opacity 0.3s linear, left 0.3s ease-out;
            transition: opacity 0.3s linear, left 0.3s ease-out;
        }

        .modal.left_modal.fade.show .modal-dialog {
            left: 0;
            box-shadow: 0px 0px 19px rgba(0, 0, 0, .5);
        }

        /*Right*/
        .modal.right_modal.fade .modal-dialog {
            right: -50%;
            -webkit-transition: opacity 0.3s linear, right 0.3s ease-out;
            -moz-transition: opacity 0.3s linear, right 0.3s ease-out;
            -o-transition: opacity 0.3s linear, right 0.3s ease-out;
            transition: opacity 0.3s linear, right 0.3s ease-out;
        }



        .modal.right_modal.fade.show .modal-dialog {
            right: 0;
            box-shadow: 0px 0px 19px rgba(0, 0, 0, .5);
        }

        /* ----- MODAL STYLE ----- */
        .modal-content {
            border-radius: 0;
            border: none;
        }



        .modal-header.left_modal,
        .modal-header.right_modal {

            padding: 10px 15px;
            border-bottom-color: #EEEEEE;
            background-color: #FAFAFA;
        }

        .modal_outer .modal-body {
            /*height:90%;*/
            overflow-y: auto;
            overflow-x: hidden;
            height: 91vh;
        }
    </style>
    <div class="tabs-animation">
        <div id="preloader">
            <div id="status">
                <div class="spinner">

                </div>
            </div>
        </div>

        {{-- <div class="row ">
                <div class="col-md-3">
                    <h4 class="card-title">รายละเอียดข้อมูล </h4>
                  
                </div>
                <div class="col"></div>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ModalSlide"> ModalSlide</button>

            </div> --}}
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <button class="btn  btn-primary  mt-3" id="modal_view_left" data-toggle="modal"
                        data-target="#get_quote_modal">Open left modal</button>

                    <button class="btn  btn-success  mt-3" id="modal_view_right" data-toggle="modal"
                        data-target="#information_modal">Open right modal</button>
                </div>
            </div>
        </div>

        <!-- left modal -->
        <div class="modal modal_outer left_modal fade" id="get_quote_modal" tabindex="-1" role="dialog"
            aria-labelledby="myModalLabel2">
            <div class="modal-dialog" role="document">
                <form method="post" id="get_quote_frm">
                    <div class="modal-content ">
                        <!-- <input type="hidden" name="email_e" value="admin@filmscafe.in"> -->
                        <div class="modal-header">
                            <h2 class="modal-title">Get a quote</h2>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body get_quote_view_modal_body">

                            <div class="form-row">

                                <div class="form-group col-sm-6">
                                    <label for="name">Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" required="" id="name" name="name">
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="email">Email <span class="text-danger">*</span></label>
                                    <input type="email" required="" class="form-control" id="email" name="email">
                                </div>
                                <div class="form-group  col-sm-12">
                                    <label for="contact">Mobile Number <span class="text-danger">*</span></label>
                                    <input type="email" required="" class="form-control" id="contact" name="contact">
                                </div>

                                <div class="form-group  col-sm-12">
                                    <label for="message">Type Message</label>
                                    <textarea class="form-control" id="message" name="message" rows="4"></textarea>
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="reset" class="btn btn-light mr-auto" data-dismiss="modal"><i
                                    class="fas fa-window-close mr-2"></i> Cancel</button>
                            <button type="submit" class="btn btn-primary" id="submit_btn">Submit</button>
                        </div>

                    </div><!-- //modal-content -->
                </form>
            </div><!-- modal-dialog -->
        </div><!-- modal -->
        <!-- //left modal -->

        <!-- left modal -->
        <div class="modal modal_outer right_modal fade" id="information_modal" tabindex="-1" role="dialog"
            aria-labelledby="myModalLabel2">
            <div class="modal-dialog" role="document">
                <form method="post" id="get_quote_frm">
                    <div class="modal-content ">
                        <!-- <input type="hidden" name="email_e" value="admin@filmscafe.in"> -->
                        <div class="modal-header">
                            <h2 class="modal-title">Information:</h2>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body get_quote_view_modal_body">
                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Magni numquam accusantium dolore
                                ipsum! Aut distinctio maxime obcaecati, sapiente nisi laudantium dignissimos optio, ea ex
                                quas laboriosam ab officia odit, sequi.</p><br><br>
                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Magni numquam accusantium dolore
                                ipsum! Aut distinctio maxime obcaecati, sapiente nisi laudantium dignissimos optio, ea ex
                                quas laboriosam ab officia odit, sequi.</p><br><br>
                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Magni numquam accusantium dolore
                                ipsum! Aut distinctio maxime obcaecati, sapiente nisi laudantium dignissimos optio, ea ex
                                quas laboriosam ab officia odit, sequi.</p><br><br>
                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Magni numquam accusantium dolore
                                ipsum! Aut distinctio maxime obcaecati, sapiente nisi laudantium dignissimos optio, ea ex
                                quas laboriosam ab officia odit, sequi.</p>


                        </div>

                    </div><!-- modal-content -->
                </form>
            </div><!-- modal-dialog -->
        </div><!-- modal -->




    </div>
@endsection
@section('footer')
    <script>
        $(document).ready(function() {
            $('#myModal').modal('show');
            $('#modal_view_left').modal({
                show: 'true'
            });

            $('#modal_view_right').modal({
                show: 'false'
            });

        });
    </script>

@endsection
