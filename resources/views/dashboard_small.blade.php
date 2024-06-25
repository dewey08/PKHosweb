@extends('layouts.backend_small')

<style>
    .table-cont {
        /**make table can scroll**/
        max-height: 300px;
        overflow: auto;
        /** add some style**/
        /*padding: 2px;*/
        background: #ddd;
        margin: 20px 10px;
        box-shadow: 0 0 1px 3px #ddd;
    }


    .text-pedding {
        padding-left: 10px;
    }

    .text-font {
        font-size: 14px;
    }

</style>

@section('content')
    <script>
        function checklogin() {
            window.location.href = '{{ route('index') }}';
        }
    </script>
    <?php
    if (Auth::check()) {
        $status = Auth::user()->status;
        $id_user = Auth::user()->PERSON_ID;
    } else {
        echo "<body onload=\"checklogin()\"></body>";
        exit();
    }
    $NAME_USER = Auth::user()->name;
    $url = Request::url();
    $pos = strrpos($url, '/') + 1;
    
    if ($status == 'ADMIN') {
        $user_id = substr($url, $pos);
    } else {
        $user_id = $id_user;
    }
    
    function Removeformatetime($strtime)
    {
        $H = substr($strtime, 0, 5);
        return $H;
    }
    
    function getMac()
    {
        $d = explode('Physical Address. . . . . . . . .', shell_exec('ipconfig/all'));
        $d1 = explode(':', $d[1]);
        $d2 = explode(' ', $d1[1]);
        return $d2[1];
    }
    ?>
    {{-- <?php echo getMac(); ?> --}}
    <div class="bg-body-light">

        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 style="font-family: 'Kanit', sans-serif; font-size:15px;font-size: 1.5rem;font-weight:normal;"></h1>
                <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <div class="row">


                               
                         
                                <div>&nbsp;</div>
                               
                 
                </nav>
            </div>
        </div>
    </div>   



      
            <div style="max-width:100%;">
                @foreach ($imgpresents as $imgpresent)
                    <img class="mySlides"
                        src="data:image/png;base64,{{ chunk_split(base64_encode($imgpresent->IMG)) }}"
                        style="width:100%;height: 300px;">
                @endforeach
            </div>
            <br>

            <div class="row">
                <div class="col-sm-6">
                    <div class="block block-themed">
                      
                        <div class="block-content">
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
          
                </div>
                <div class="col-sm-12">
                    <div class="block">
                        <div class="block-header bg-success">
                            <div class="block-title fw-4" style="color: rgba(255, 255, 255, 0.9);">
                                ข่าวประชาสัมพันธ์
                            </div>
                        </div>
                        <div class="block-content">
                            @if (!empty($publicize))
                                @foreach ($publicize as $row)
                                    <a class="block block-rounded block-link-pop py-3 shadow" target="_blank"
                                        href="{{ $row->IPUB_LINK }}">
                                        <div class="col-12">
                                            <div class="row">
                                                <div class="col-2 p-1 d-flex justify-content-center align-items-center">
                                                    <div class="card" width="100%">
                                                        <div class="text-sl-r3 fw-b fs-16">
                                                            {{ shortMonthThai(date('m', strtotime($row->IPUB_DATE))) }}
                                                        </div>
                                                        <hr class="m-1">
                                                        <div class="fw-b fs-20">
                                                            {{ date('d', strtotime($row->IPUB_DATE)) }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-3" style="over-flow:hidden">
                                                    @if (empty($row->IPUB_IMG))
                                                        <img id="image_upload_preview"
                                                            src="{{ asset('image/information_publicize.png') }}"
                                                            width="100%">
                                                    @else
                                                        <img id="image_upload_preview"
                                                            src="data:image/jpeg;base64,{{ chunk_split(base64_encode($row->IPUB_IMG)) }}"
                                                            width="100%">
                                                    @endif
                                                </div>
                                                <div class="col-7 text-left">
                                                    <h3 class="mb-1 fw-b">{{ $row->IPUB_NAME }}</h3>
                                                    <p>
                                                        {{ $row->IPUB_DETAIL }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            
            </div>
        </div>

        </ceneter>

        <script>
            $(window).resize(function() {
                $('#reload_page_face').html('<?= $page_facebook ? $page_facebook->IFP_DATASHOW : '' ?>');
                FB.XFBML.parse();
            });
        </script>
        <?= $page_facebook ? $page_facebook->IFP_PLUGIN : '' ?>
        <script>
            var myIndex = 0;
            carousel();

            function carousel() {
                var i;
                var x = document.getElementsByClassName("mySlides");
                for (i = 0; i < x.length; i++) {
                    x[i].style.display = "none";
                }
                myIndex++;
                if (myIndex > x.length) {
                    myIndex = 1
                }
                x[myIndex - 1].style.display = "block";
                setTimeout(carousel, 5000); // Change image every 2 seconds
            }
        </script>
        <script>
            // Code goes here

            window.onload = function() {
                var tableCont = document.querySelector('#table-cont')
                var tableCont2 = document.querySelector('#table-cont2')
                /**
                 * scroll handle
                 * @param {event} e -- scroll event
                 */
                function scrollHandle(e) {
                    var scrollTop = this.scrollTop;
                    this.querySelector('thead').style.transform = 'translateY(' + scrollTop + 'px)';
                }

                tableCont.addEventListener('scroll', scrollHandle)
                tableCont2.addEventListener('scroll', scrollHandle)
            }
        </script>
    @endsection
