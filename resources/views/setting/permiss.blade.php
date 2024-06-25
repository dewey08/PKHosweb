@extends('layouts.admin_setting')
@section('title', 'PK-OFFICER || กำหนดสิทธิ์การใช้งาน')
<script>
    function TypeAdmin() {
        window.location.href = '{{ route('index') }}';
    }
</script>
<script>
    function settingdep_destroy(DEPARTMENT_ID) {
        // alert(bookrep_id);
        Swal.fire({
            title: 'ต้องการลบใช่ไหม?',
            text: "ข้อมูลนี้จะถูกลบไปเลย !!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'ใช่, ลบเดี๋ยวนี้ !',
            cancelButtonText: 'ไม่, ยกเลิก'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: "delete",
                    url: "{{ url('setting_index_destroy') }}" + '/' + DEPARTMENT_ID,
                    success: function(response) {
                        Swal.fire({
                            title: 'ลบข้อมูล!',
                            text: "You Delet data success",
                            icon: 'success',
                            showCancelButton: false,
                            confirmButtonColor: '#06D177',
                            // cancelButtonColor: '#d33',
                            confirmButtonText: 'เรียบร้อย'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $("#sid" + DEPARTMENT_ID).remove();
                                window.location.reload();
                                // window.location = "/book/bookmake_index"; //   

                            }
                        })
                    }
                })
            }
        })
    }
</script>
<?php
if (Auth::check()) {
    $type = Auth::user()->type;
    $iduser = Auth::user()->id;
} else {
    echo "<body onload=\"TypeAdmin()\"></body>";
    exit();
}
$url = Request::url();
$pos = strrpos($url, '/') + 1;
?>

@section('content')
    <div class="container-fluid">
        <div class="card ">

            <div class="row p-3">
                <div class="col-md-4">
                    <div class="table-responsive">
                        <table id="example" class="table table-striped table-bordered dt-responsive nowrap myTable" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        {{-- <table class="table table-hover table-bordered table-sm myTable" style="width: 100%;" id="example"> --}}
                            <thead>
                                <tr height="10px">
                                    <th width="5%" class="text-center">ลำดับ</th>
                                    <th class="text-center">ชื่อ-นามสกุล</th>
                                    <th width="10%" class="text-center">Manage</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $num = 0;
                                $date = date('Y');
                                ?>
                                @foreach ($users as $item)
                                    <?php $num++; ?>
                                    <tr id="sid{{ $item->id }}">
                                        <td class="text-center">{{ $num }}</td>
                                        <td class="p-2">{{ $item->fname }} {{ $item->lname }}</td>
                                        <td class="text-center" width="10%">
                                            <a href="{{ url('setting/permiss_liss/' . $item->id) }}"
                                                class="text-success me-3" data-bs-toggle="tooltip"
                                                data-bs-placement="bottom" data-bs-custom-class="custom-tooltip"
                                                title="กำหนดสิทธิ์การใช้งาน">
                                                <i class="fa-solid fa-user-shield"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
                <div class="col-md-8">

                    <div class="row me-1 mb-1 ms-1">

                        <div class="col-4 col-md-3 col-xl-3">
                            <div class="card">
                                <div class="card-body shadow-lg">

                                    <!-- Default checkbox -->
                                    <div class="form-check mt-2">
                                        <i class="fa-solid fa-user-tie text-primary"></i>
                                        <input class="form-check-input" type="checkbox" value="" id="permiss_person"
                                            name="permiss_person" />
                                        <label class="form-check-label" for="permiss_person">บุคคลากร</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-4 col-md-3 col-xl-3">
                            <div class="card">
                                <div class="card-body shadow-lg">

                                    <!-- Default checkbox -->
                                    <div class="form-check mt-2">
                                        <i class="fa-solid fa-book-open-reader text-secondary"></i>
                                        <input class="form-check-input" type="checkbox" value="" id="permiss_book"
                                            name="permiss_book" />
                                        <label class="form-check-label" for="permiss_book">สารบรรณ</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-4 col-md-3 col-xl-3">
                            <div class="card">
                                <div class="card-body shadow-lg">

                                    <div class="form-check mt-2">
                                        <i class="fa-solid fa-truck-medical text-info"></i>
                                        <input class="form-check-input" type="checkbox" value="" id="permiss_car"
                                            name="permiss_car" />
                                        <label class="form-check-label" for="permiss_car">ยานพาหนะ</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-4 col-md-3 col-xl-3">
                            <div class="card">
                                <div class="card-body shadow-lg">

                                    <div class="form-check mt-2">
                                        <i class="fa-solid fa-house-laptop text-success"></i>
                                        <input class="form-check-input" type="checkbox" value="" id="permiss_meetting"
                                            name="permiss_meetting" />
                                        <label class="form-check-label" for="permiss_meetting">ห้องประชุม</label>
                                    </div>
                                </div>
                            </div>

                        </div>

                    {{-- </div> --}}


                    {{-- <div class="row me-1 mb-1 ms-1"> --}}
                        <div class="col-4 col-md-3 col-xl-3">
                            <div class="card">
                                <div class="card-body shadow-lg">

                                    <div class="form-check mt-2">
                                        <i class="fa-solid fa-screwdriver-wrench text-info"></i>
                                        <input class="form-check-input" type="checkbox" value="" id="permiss_repair"
                                            name="permiss_repair" />
                                        <label class="form-check-label" for="permiss_repair">ซ่อมบำรุง</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-4 col-md-3 col-xl-3">
                            <div class="card">
                                <div class="card-body shadow-lg">

                                    <div class="form-check mt-2">
                                        <i class="fa-solid fa-computer text-secondary"></i>
                                        <input class="form-check-input" type="checkbox" value="" id="permiss_com"
                                            name="permiss_com" />
                                        <label class="form-check-label" for="permiss_com">คอมพิวเตอร์</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-4 col-md-3 col-xl-3">
                            <div class="card">
                                <div class="card-body shadow-lg">

                                    <div class="form-check mt-2">
                                        <i class="fa-solid fa-pump-medical text-warning"></i>
                                        <input class="form-check-input" type="checkbox" value=""
                                            id="permiss_medical" name="permiss_medical" />
                                        <label class="form-check-label" for="permiss_medical">เครื่องมือแพทย์</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-4 col-md-3 col-xl-3">
                            <div class="card">
                                <div class="card-body shadow-lg">

                                    <div class="form-check mt-2">
                                        <i class="fa-solid fa-house-chimney-user text-info"></i>
                                        <input class="form-check-input" type="checkbox" value=""
                                            id="permiss_hosing" name="permiss_hosing" />
                                        <label class="form-check-label" for="permiss_hosing">บ้านพัก</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                    {{-- </div> --}}


                    {{-- <div class="row me-1 mb-1 ms-1"> --}}

                        <div class="col-4 col-md-3 col-xl-3">
                            <div class="card">
                                <div class="card-body shadow-lg">

                                    <div class="form-check mt-2">
                                        <i class="fa-solid fa-clipboard text-danger"></i>
                                        <input class="form-check-input" type="checkbox" value="" id="permiss_plan"
                                            name="permiss_plan" />
                                        <label class="form-check-label" for="permiss_plan">แผนงาน</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-4 col-md-3 col-xl-3">
                            <div class="card">
                                <div class="card-body shadow-lg">

                                    <div class="form-check mt-2">
                                        <i class="fa-solid fa-building-shield text-secondary"></i>
                                        <input class="form-check-input" type="checkbox" value=""
                                            id="permiss_asset" name="permiss_asset" />
                                        <label class="form-check-label" for="permiss_asset">ทรัพย์สิน</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-4 col-md-3 col-xl-3">
                            <div class="card">
                                <div class="card-body shadow-lg">

                                    <div class="form-check mt-2">
                                        <i class="fa-solid fa-paste text-success"></i>
                                        <input class="form-check-input" type="checkbox" value=""
                                            id="permiss_supplies" name="permiss_supplies" />
                                        <label class="form-check-label" for="permiss_supplies">พัสดุ</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-4 col-md-3 col-xl-3">
                            <div class="card">
                                <div class="card-body shadow-lg">

                                    <div class="form-check mt-2">
                                        <i class="fa-solid fa-shop-lock text-primary"></i>
                                        <input class="form-check-input" type="checkbox" value=""
                                            id="permiss_store" name="permiss_store" />
                                        <label class="form-check-label" for="permiss_store">คลังวัสดุ</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                    {{-- </div> --}}

                    {{-- <div class="row me-1 mb-1 ms-1"> --}}

                        <div class="col-4 col-md-3 col-xl-3">
                            <div class="card">
                                <div class="card-body shadow-lg">

                                    <div class="form-check mt-2">
                                        <i class="fa-solid fa-prescription text-success"></i>
                                        <input class="form-check-input" type="checkbox" value=""
                                            id="permiss_store_dug" name="permiss_store_dug" />
                                        <label class="form-check-label" for="permiss_store_dug">คลังยา</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-4 col-md-3 col-xl-3">
                            <div class="card">
                                <div class="card-body shadow-lg">

                                    <div class="form-check mt-2">
                                        <i class="fa-solid fa-person-booth text-danger"></i>
                                        <input class="form-check-input" type="checkbox" value="" id="permiss_pay"
                                            name="permiss_pay" />
                                        <label class="form-check-label" for="permiss_pay">จ่ายกลาง</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-4 col-md-3 col-xl-3">
                            <div class="card">
                                <div class="card-body shadow-lg">

                                    <div class="form-check mt-2">
                                        <i class="fa-solid fa-file-invoice-dollar text-warning"></i>
                                        <input class="form-check-input" type="checkbox" value=""
                                            id="permiss_money" name="permiss_money" />
                                        <label class="form-check-label" for="permiss_money">การเงิน</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-4 col-md-3 col-xl-3">
                            <div class="card">
                                <div class="card-body shadow-lg">

                                    <div class="form-check mt-2">
                                        <i class="fa-solid fa-sack-dollar text-danger"></i>
                                        <input class="form-check-input" type="checkbox" value=""
                                            id="permiss_claim" name="permiss_claim" />
                                        <label class="form-check-label" for="permiss_claim">งานประกัน</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                    {{-- </div> --}}

                    {{-- <div class="row me-1 mb-1 ms-1"> --}}
                        {{-- <div class="col-4 col-md-3 col-xl-3">
                            <div class="card">
                                <div class="card-body shadow-lg">

                                    <div class="form-check mt-2">
                                        <i class="fa-solid fa-square-person-confined" style="color: rgb(159, 9, 197)"></i>
                                        <input class="form-check-input" type="checkbox"
                                            id="permiss_medicine" name="permiss_medicine" />
                                        <label class="form-check-label" for="permiss_medicine">แพทย์แผนไทย</label>
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                        <div class="col-4 col-md-3 col-xl-3">
                            <div class="card">
                                <div class="card-body shadow-lg">

                                    <div class="form-check mt-2">
                                        <i class="fa-solid fa-solid fa-people-line" style="color: rgb(9, 106, 197)"></i>
                                        <input class="form-check-input" type="checkbox" id="permiss_ot"
                                            name="permiss_ot" />
                                        <label class="form-check-label" for="permiss_ot">โอที</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-4 col-md-3 col-xl-3">
                            <div class="card">
                                <div class="card-body shadow-lg">

                                    <div class="form-check mt-2">
                                        <i class="fa-solid fa-solid fa-hospital-user" style="color: rgb(170, 7, 97)"></i>
                                        <input class="form-check-input" type="checkbox" id="permiss_gleave"
                                            name="permiss_gleave" />
                                        <label class="form-check-label" for="permiss_gleave">ระบบการลา</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-4 col-md-3 col-xl-3">
                            <div class="card">
                                <div class="card-body shadow-lg"> 
                                    <div class="form-check mt-2"> 
                                        <i class="fa-solid fa-p text-primary"></i><i class="fa-solid fa-4 text-primary"></i><i class="fa-solid fa-p text-primary"></i>
                                        <input class="form-check-input" type="checkbox" id="permiss_p4p"
                                            name="permiss_p4p" />
                                        <label class="form-check-label ms-3" for="permiss_p4p">งาน P4P</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-4 col-md-3 col-xl-3">
                            <div class="card">
                                <div class="card-body shadow-lg"> 
                                    <div class="form-check mt-2"> 
                                        <i class="fa-regular fa-clock text-primary"></i>  
                                        <input class="form-check-input" type="checkbox" id="permiss_timeer"
                                            name="permiss_timeer"/>
                                        <label class="form-check-label" for="permiss_timeer">ระบบลงเวลา</label> 
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-4 col-md-3 col-xl-3">
                            <div class="card">
                                <div class="card-body shadow-lg"> 
                                    <div class="form-check mt-2"> 
                                        <i class="fa-solid fa-hand-holding-droplet" style="color: rgb(9, 169, 197)"></i>                                     
                                        <input class="form-check-input" type="checkbox" id="permiss_env"
                                            name="permiss_env"/>
                                        <label class="form-check-label" for="permiss_env">ระบบ ENV</label> 
                                    </div>

                                    <div class="form-check mt-2"> 
                                        <i class="fa-solid fa-gear text-danger" style="color: rgb(9, 169, 197)"></i>                                     
                                        <input class="form-check-input" type="checkbox" id="permiss_setting_env" name="permiss_setting_env"/>
                                        <label class="form-check-label" for="permiss_setting_env">ตั้งค่า ENV</label> 
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-4 col-md-3 col-xl-3">
                            <div class="card">
                                <div class="card-body shadow-lg"> 
                                    <div class="form-check mt-2"> 
                                        <i class="fa-solid fa-house-medical-circle-check" style="color: rgb(9, 169, 197)"></i>                                     
                                        <input class="form-check-input" type="checkbox" id="permiss_clinic_tb"
                                            name="permiss_clinic_tb"/>
                                        <label class="form-check-label" for="permiss_clinic_tb">Clinic TB</label> 
                                    </div> 
                                </div>
                            </div> 
                        </div>

                        <div class="col-4 col-md-3 col-xl-3">
                            <div class="card">
                                <div class="card-body shadow-lg"> 
                                    <div class="form-check mt-2"> 
                                        <i class="fa-solid fa-camera-retro" style="color: rgb(9, 169, 197)"></i>                                     
                                        <input class="form-check-input" type="checkbox" id="permiss_sot"
                                            name="permiss_sot"/>
                                        <label class="form-check-label" for="permiss_sot">งานโสต</label> 
                                    </div> 
                                </div>
                            </div>
                        </div>

                        <div class="col-4 col-md-3 col-xl-3">
                            <div class="card">
                                <div class="card-body shadow-lg"> 
                                    <div class="form-check mt-2"> 
                                        <i class="fa-solid fa-square-person-confined" style="color: rgb(9, 169, 197)"></i>                                     
                                        <input class="form-check-input" type="checkbox" id="permiss_medicine_salt"
                                            name="permiss_medicine_salt"/>
                                        <label class="form-check-label" for="permiss_medicine_salt">แพทย์แผนไทย</label> 
                                    </div> 
                                </div>
                            </div> 
                        </div>

                        <div class="col-4 col-md-3 col-xl-3">
                            <div class="card">
                                <div class="card-body shadow-lg"> 
                                    <div class="form-check mt-2"> 
                                        <i class="fa-regular fa-heart" style="color: rgb(9, 169, 197)"></i>                                     
                                        <input class="form-check-input" type="checkbox" id="pesmiss_ct" name="pesmiss_ct"/>
                                        <label class="form-check-label" for="pesmiss_ct">CT</label> 
                                    </div> 
                                </div>
                            </div> 
                        </div>


                        <div class="col-4 col-md-3 col-xl-3">
                            <div class="card">
                                <div class="card-body shadow-lg"> 
                                    <div class="form-check mt-2"> 
                                        <i class="fa-solid fa-file-invoice-dollar" style="color: rgb(109, 105, 107)"></i>  
                                        <input class="form-check-input" type="checkbox" id="permiss_account"
                                            name="permiss_account"/>
                                        <label class="form-check-label" for="permiss_account">การบัญชี</label> 
                                    </div>

                                    <div class="form-check mt-2"> 
                                        <i class="fa-solid fa-gear text-danger" style="color: rgb(9, 169, 197)"></i>                                     
                                        <input class="form-check-input" type="checkbox" id="permiss_ucs" name="permiss_ucs"/>
                                        <label class="form-check-label" for="permiss_ucs">UCS</label> 
                                    </div>
                                    <div class="form-check mt-2"> 
                                        <i class="fa-solid fa-gear text-danger" style="color: rgb(9, 169, 197)"></i>                                     
                                        <input class="form-check-input" type="checkbox" id="permiss_sss" name="permiss_sss"/>
                                        <label class="form-check-label" for="permiss_sss">SSS</label> 
                                    </div>
                                    <div class="form-check mt-2"> 
                                        <i class="fa-solid fa-gear text-danger" style="color: rgb(9, 169, 197)"></i>                                     
                                        <input class="form-check-input" type="checkbox" id="permiss_ofc" name="permiss_ofc"/>
                                        <label class="form-check-label" for="permiss_ofc">OFC</label> 
                                    </div>
                                    <div class="form-check mt-2"> 
                                        <i class="fa-solid fa-gear text-danger" style="color: rgb(9, 169, 197)"></i>                                     
                                        <input class="form-check-input" type="checkbox" id="permiss_lgo" name="permiss_lgo"/>
                                        <label class="form-check-label" for="permiss_lgo">LGO</label> 
                                    </div>
                                    <div class="form-check mt-2"> 
                                        <i class="fa-solid fa-gear text-danger" style="color: rgb(9, 169, 197)"></i>                                     
                                        <input class="form-check-input" type="checkbox" id="permiss_prb" name="permiss_prb"/>
                                        <label class="form-check-label" for="permiss_prb">พรบ</label> 
                                    </div>
                                    <div class="form-check mt-2"> 
                                        <i class="fa-solid fa-gear text-danger" style="color: rgb(9, 169, 197)"></i>                                     
                                        <input class="form-check-input" type="checkbox" id="permiss_ti" name="permiss_ti"/>
                                        <label class="form-check-label" for="permiss_ti">ไต</label> 
                                    </div>
                                    <div class="form-check mt-2"> 
                                        <i class="fa-solid fa-gear text-danger" style="color: rgb(9, 169, 197)"></i>                                     
                                        <input class="form-check-input" type="checkbox" id="permiss_rep_money" name="permiss_rep_money"/>
                                        <label class="form-check-label" for="permiss_rep_money">ใบเสร็จรับเงิน</label> 
                                    </div>




                                    <div class="form-check mt-2"> 
                                        <i class="fa-solid fa-gear text-danger" style="color: rgb(9, 169, 197)"></i>                                     
                                        <input class="form-check-input" type="checkbox" id="permiss_setting_account" name="permiss_setting_account"/>
                                        <label class="form-check-label" for="permiss_setting_account">ตั้งค่า Account</label> 
                                    </div>

                                    <div class="form-check mt-2"> 
                                        <i class="fa-solid fa-gear text-danger" style="color: rgb(9, 169, 197)"></i>                                     
                                        <input class="form-check-input" type="checkbox" id="permiss_setting_upstm" name="permiss_setting_upstm"/>
                                        <label class="form-check-label" for="permiss_setting_upstm">UP STM</label> 
                                    </div>

                                    <div class="form-check mt-2"> 
                                        <i class="fa-solid fa-gear text-danger" style="color: rgb(9, 169, 197)"></i>                                     
                                        <input class="form-check-input" type="checkbox" id="permiss_rep_money" name="permiss_rep_money"/>
                                        <label class="form-check-label" for="permiss_rep_money">ใบเสร็จรับเงิน</label> 
                                    </div>

                                </div>
                            </div>
                        </div>

                       

                        

                    </div>
                </div>
            </div>


        </div>
    </div>
@endsection
