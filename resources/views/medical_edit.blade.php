@extends('layouts.medical')

<link href="{{ asset('datepicker/dist/css/bootstrap-datepicker.css') }}" rel="stylesheet" />

<link href="{{ asset('select2/select2.min.css') }}" rel="stylesheet" />

@section('content')

<?php
$status = Auth::user()->status; 
$id_user = Auth::user()->PERSON_ID; 
$url = Request::url();
$pos = strrpos($url, '/') + 1;
$user_id = substr($url, $pos); 

?>
<?php
function RemoveDateThai($strDate)
{
  $strYear = date("Y",strtotime($strDate))+543;
  $strMonth= date("n",strtotime($strDate));
  $strDay= date("j",strtotime($strDate));

  $strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
  $strMonthThai=$strMonthCut[$strMonth];
  return "$strDay $strMonthThai $strYear";
  }


  function Removeformate($strDate)
{
  $strYear = date("Y",strtotime($strDate));
  $strMonth= date("m",strtotime($strDate));
  $strDay= date("d",strtotime($strDate));

  return $strDay."/".$strMonth."/".$strYear;
  }

  
?>
<style>
    body {
        font-family: 'Kanit', sans-serif;
        font-size: 14px;

    }

    .form-control {
        font-family: 'Kanit', sans-serif;
        font-size: 14px;
    }

    #rcorners1 {
        border-radius: 10px;
        background: #FFFFCC;
        padding: 20px;

    }

    table,
    td,
    th {
        border: 1px solid black;
    }
</style>

<center>
    <div class="block" style="width: 95%;">
        <div class="block-header block-header-default">
            <h3 class="block-title" style="font-family: 'Kanit', sans-serif;"><B>

                    แก้ไขข้อมูลยาและเวชภัณฑ์

                </B></h3>

        </div>
        <div class="block-content block-content-full" align="left">

            <form method="post" action="" enctype="multipart/form-data">
                @csrf

                <div class="row push">

                    <div class="col-lg-4">
                        <div class="row push">
                            <div class="form-group">
                                <label style=" font-family: 'Kanit', sans-serif;">รูปประกอบ</label>
                                <img id="image_upload_preview" alt="กรุณาเพิ่มรูปภาพ" height="300px" width="300px" />
                            </div>
                            <div class="form-group">
                                *ขนาดรูปไม่เกิน 350 x 350 pixel
                                <input type="file" name="picture" id="picture" class="form-control">
                            </div>
                        </div>

                        <div class="row push">
                            <div class="col-lg-12">
                                <!-- Block Tabs Default Style -->
                                <div class="block block-rounded block-bordered">
                                    <ul class="nav nav-tabs nav-tabs-info" data-toggle="tabs" role="tablist"
                                        style="background-color: #FFEBCD;">
                                        <li class="nav-item">
                                            <a class="nav-link active" href="#object1"
                                                style="font-family: 'Kanit', sans-serif; font-size:12px;font-size: 1.0rem;font-weight:normal;">หน่วยนับ</a>
                                        </li>

                                    </ul>
                                    <div class="block-content tab-content">
                                        <div class="tab-pane active" id="object1" role="tabpanel">

                                            <table class="table gwt-table">
                                                <thead>
                                                    <tr>
                                                        <td style="text-align: center;">รายละเอียด</td>
                                                        <td style="text-align: center;">หน่วยนับ</td>
                                                        <td style="text-align: center;" width="20%">จำนวน</td>
                                                    </tr>
                                                </thead>
                                                <tbody class="tbody1">

                                                    <tr>
                                                        <td>
                                                            หน่วยย่อย

                                                        </td>
                                                        <td>
                                                            <select name="SUP_UNIT_ID0" id="SUP_UNIT_ID0"
                                                                class="form-control input-lg js-example-basic-single"
                                                                style=" font-family: 'Kanit', sans-serif;">

                                                                <option value="">--กรุณาเลือกหน่วย--</option>

                                                            </select>
                                                        </td>
                                                        <td>
                                                            <input name="SUP_TOTAL0" id="SUP_TOTAL0"
                                                                class="form-control input-sm"
                                                                style=" font-family: 'Kanit', sans-serif;text-align: center;"
                                                                value="1" readonly>
                                                        </td>

                                                    </tr>

                                                    <tr>
                                                        <td>
                                                            หน่วยบรรจุ

                                                        </td>
                                                        <td>
                                                            <select name="SUP_UNIT_ID1" id="SUP_UNIT_ID1"
                                                                class="form-control input-lg js-example-basic-single"
                                                                style=" font-family: 'Kanit', sans-serif;">

                                                                <option value="">--กรุณาเลือกหน่วย--</option>

                                                            </select>
                                                        </td>
                                                        <td>

                                                            <input name="SUP_TOTAL1" id="SUP_TOTAL1"
                                                                class="form-control input-sm"
                                                                style=" font-family: 'Kanit', sans-serif;text-align: center; ">

                                                        </td>

                                                    </tr>

                                                </tbody>
                                            </table>

                                        </div>

                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-8">
                        <div class="row">
                            <div class="col-lg-2">
                                <label style="text-align: left">รหัสวัสดุ :</label>
                            </div>
                            <div class="col-lg-4 number_parcel">
                                <input name="SUP_FSN_NUM" id="SUP_FSN_NUM" class="form-control input-sm"
                                    style=" font-family: 'Kanit', sans-serif;" readonly>

                            </div>

                            <div class="col-lg-2">
                                <label style="text-align: left">รหัสวัสดุเดิม :</label>
                            </div>
                            <div class="col-lg-4">
                                <input name="SUP_CODE" id="SUP_CODE" value="{{$infomedical->SUP_CODE}}"
                                    class="form-control input-sm" style=" font-family: 'Kanit', sans-serif;">
                            </div>

                        </div>
                        <br>

                        <div class="row push">
                            <div class="col-lg-2">
                                <label>รายการพัสดุ :</label>
                            </div>
                            <div class="col-lg-3">
                                <select name="" id="" class="form-control input-lg typekind_sub"
                                    style=" font-family: 'Kanit', sans-serif;">
                                    <option value="">--กรุณาเลือกรายการพัสดุ--</option>
                                    @foreach ($suppliestypekinds as $suppliestypekind)

                                    <option value="{{ $suppliestypekind ->SUP_TYPE_KIND_ID  }}">
                                        {{ $suppliestypekind->SUP_TYPE_KIND_NAME}}</option>

                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-1">
                                <label>ชื่อวัสดุ :</label>
                            </div>
                            <div class="col-lg-6">
                                <input name="SUP_NAME" id="SUP_NAME" value="{{$infomedical->SUP_NAME}}"
                                    class="form-control input-sm" style=" font-family: 'Kanit', sans-serif;">
                            </div>
                        </div>

                        <div class="row push">
                            <div class="col-lg-2">
                                <label>รูปแบบ :</label>
                            </div>
                            <div class="col-lg-3">
                                <select name="SUP_GENUS" id="SUP_GENUS" class="form-control input-lg typekind_sub"
                                    style=" font-family: 'Kanit', sans-serif;">
                                    <option value="">--กรุณาเลือกรูปแบบ--</option>
                                    @foreach ($medicaltypeitems as $medicaltypeitem)
                                    @if($medicaltypeitem->TYPE_ITEM_ID == $infomedical->SUP_GENUS)
                                    <option value="{{ $medicaltypeitem ->TYPE_ITEM_ID  }}" selected>
                                        {{ $medicaltypeitem->TYPE_ITEM_NAME}}</option>
                                    @else
                                    <option value="{{ $medicaltypeitem ->TYPE_ITEM_ID  }}">
                                        {{ $medicaltypeitem->TYPE_ITEM_NAME}}</option>
                                    @endif

                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-1">
                                <button type="button" class="btn btn-hero-sm btn-hero-info"
                                    style="font-family: 'Kanit', sans-serif; font-size: 10px;font-weight:normal;"><i
                                        class="fa fa-plus fa-1x"></i></button>
                            </div>

                            <div class="col-lg-2">
                                <label>ส่วนประกอบ :</label>
                            </div>
                            <div class="col-lg-4">
                                <input name="CONTENT" id="CONTENT" value="{{$infomedical->SUP_NAME}}"
                                    class="form-control input-sm" style=" font-family: 'Kanit', sans-serif;">
                            </div>
                        </div>
                        <div class="row push">
                            <div class="col-lg-2">
                                <label>ชื่อพ้อง 1 :</label>
                            </div>
                            <div class="col-lg-10">
                                <input name="SUP_SYNONYMS_01" id="SUP_SYNONYMS_01"
                                    value="{{$infomedical->SUP_SYNONYMS_01}}" class="form-control input-sm"
                                    style=" font-family: 'Kanit', sans-serif;">
                            </div>

                        </div>

                        <div class="row push">
                            <div class="col-lg-2">
                                <label>ชื่อพ้อง 2 :</label>
                            </div>
                            <div class="col-lg-10">
                                <input name="SUP_SYNONYMS_02" id="SUP_SYNONYMS_02"
                                    value="{{$infomedical->SUP_SYNONYMS_02}}" class="form-control input-sm"
                                    style=" font-family: 'Kanit', sans-serif;">
                            </div>
                        </div>

                        <div class="row push">
                            <div class="col-lg-2">
                                <label>ลักษณะ :</label>
                            </div>
                            <div class="col-lg-10">
                                <input name="SUP_PROP" id="SUP_PROP" value="{{$infomedical->SUP_PROP}}"
                                    class="form-control input-sm" style=" font-family: 'Kanit', sans-serif;">
                            </div>
                        </div>

                        <div class="row push">
                            <div class="col-lg-2">
                                <label>กลุ่มวัสดุคลังหลัก :</label>
                            </div>
                            <div class="col-lg-4">
                                <select name="SUP_TYPE_ID" id="SUP_TYPE_ID" class="form-control input-lg type_sub"
                                    style=" font-family: 'Kanit', sans-serif;">

                                    <option value="">--กรุณาเลือกหมวดพัสดุ--</option>
                                    @foreach ($suppliestypes as $suppliestype)

                                    @if($suppliestype ->SUP_TYPE_ID == '61')
                                    <option value="{{ $suppliestype ->SUP_TYPE_ID  }}" selected>
                                        {{ $suppliestype->SUP_TYPE_NAME}}
                                    </option>

                                    @else
                                    <option value="{{ $suppliestype ->SUP_TYPE_ID  }}">{{ $suppliestype->SUP_TYPE_NAME}}
                                    </option>

                                    @endif

                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-2">
                                <label>หมวดวัสดุคลังหลัก :</label>
                            </div>
                            <div class="col-lg-4">
                                <select name="" id="" class="form-control input-lg"
                                    style=" font-family: 'Kanit', sans-serif;">

                                    @foreach ($suppliestypemasters as $suppliestypemaster)

                                    <option value="{{ $suppliestypemaster ->SUP_TYPE_MASTER_ID  }}">
                                        {{ $suppliestypemaster->SUP_TYPE_MASTER_NAME}}</option>

                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row push">
                            <div class="col-lg-2">
                                <label>กลุ่มวัสดุ :</label>
                            </div>
                            <div class="col-lg-9">
                                <select name="SUP_GROUP" id="SUP_GROUP" class="form-control input-lg type_sub"
                                    style=" font-family: 'Kanit', sans-serif;">

                                    <option value="">--กรุณาเลือกกลุ่มวัสดุ--</option>
                                    @foreach ($medicalgroups as $medicalgroup)
                                    @if($medicalgroup ->GROUP_ID == $infomedical->SUP_GROUP)
                                    <option value="{{ $medicalgroup ->GROUP_ID  }}" selected>
                                        {{$medicalgroup ->GROUP_ID}} |
                                        {{ $medicalgroup->GROUP_NAME}}</option>
                                    @else
                                    <option value="{{ $medicalgroup ->GROUP_ID  }}">{{$medicalgroup ->GROUP_ID}} |
                                        {{ $medicalgroup->GROUP_NAME}}</option>
                                    @endif

                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-1">
                                <button type="button" class="btn btn-hero-sm btn-hero-info"
                                    style="font-family: 'Kanit', sans-serif; font-size: 10px;font-weight:normal;"><i
                                        class="fa fa-plus fa-1x"></i></button>
                            </div>
                            </div>

                            <div class="row push">
                            <div class="col-lg-2">
                                <label>หมวดวัสดุ :</label>
                            </div>
                            <div class="col-lg-9">
                                <select name="" id="" class="form-control input-lg"
                                    style=" font-family: 'Kanit', sans-serif;">
                                    <option value="">--กรุณาเลือกหมวดวัสดุ--</option>
                                    @foreach ($medicalcategorys as $medicalcategory)

                                    @if( $medicalcategory ->CAT_ID == $infomedical->SUP_CAT)
                                    <option value="{{ $medicalcategory ->CAT_ID  }}" selected>
                                        {{ $medicalcategory ->CAT_ID  }}
                                        |{{$medicalcategory ->CAT_SYM }} |{{ $medicalcategory->CAT_NAME}}</option>
                                    @else
                                    <option value="{{ $medicalcategory ->CAT_ID  }}">{{ $medicalcategory ->CAT_ID  }}
                                        |{{$medicalcategory ->CAT_SYM }} |{{ $medicalcategory->CAT_NAME}}</option>
                                    @endif

                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-1">
                                <button type="button" class="btn btn-hero-sm btn-hero-info"
                                    style="font-family: 'Kanit', sans-serif; font-size: 10px;font-weight:normal;"><i
                                        class="fa fa-plus fa-1x"></i></button>
                            </div>
                        </div>

                        <div class="row push">

                            <div class="col-lg-2">
                                <label>ผู้ผลิต :</label>
                            </div>
                            <div class="col-lg-9">
                                <select name="SUP_VENDOR_CODE" id="SUP_VENDOR_CODE" class="form-control input-lg"
                                    style=" font-family: 'Kanit', sans-serif;">
                                    <option value="">--กรุณาเลือกผู้ผลิต--</option>
                                    @foreach ($suppliesvendors as $suppliesvendor)

                                    @if($suppliesvendor ->VENDOR_ID == $infomedical->SUP_VENDOR_CODE)
                                    <option value="{{ $suppliesvendor ->VENDOR_ID  }}" selected>
                                        {{ $suppliesvendor ->VENDOR_NAME  }}</option>
                                    @else
                                    <option value="{{ $suppliesvendor ->VENDOR_ID  }}">
                                        {{ $suppliesvendor ->VENDOR_NAME  }}</option>
                                    @endif

                                    @endforeach
                                </select>

                            </div>
                            <div class="col-lg-1">
                                <button type="button" class="btn btn-hero-sm btn-hero-info"
                                    style="font-family: 'Kanit', sans-serif; font-size: 10px;font-weight:normal;"><i
                                        class="fa fa-plus fa-1x"></i></button>
                            </div>

                        </div>

                        <div class="row push">

                            <div class="col-lg-2">
                                <label>ผู้จำหน่ายล่าสุด :</label>
                            </div>
                            <div class="col-lg-10">
                                <select name="SUP_MANU" id="SUP_MANU" class="form-control input-lg"
                                    style=" font-family: 'Kanit', sans-serif;">
                                    <option value="">--กรุณาเลือกผู้ผลิต--</option>
                                    @foreach ($suppliesvendors as $suppliesvendor)
                                    @if($suppliesvendor ->VENDOR_ID == $infomedical->SUP_MANU)
                                    <option value="{{ $suppliesvendor ->VENDOR_ID  }}" selected>
                                        {{ $suppliesvendor ->VENDOR_NAME  }}</option>

                                    @else
                                    <option value="{{ $suppliesvendor ->VENDOR_ID  }}">
                                        {{ $suppliesvendor ->VENDOR_NAME  }}</option>
                                    @endif

                                    @endforeach
                                </select>
                            </div>

                        </div>

                        <div class="row push">
                            <div class="col-lg-2">
                                <label>รายละเอียด :</label>
                            </div>
                            <div class="col-lg-10">
                                <input name="" id="" class="form-control input-sm"
                                    style=" font-family: 'Kanit', sans-serif;">
                            </div>
                        </div>

                        <div class="row push">
                            <div class="col-lg-3">
                                <label>จำกัดคงคลังจำนวนต่ำสุด :</label>
                            </div>
                            <div class="col-lg-3">
                            <input name="MIN" id="MIN" value="{{$infomedical->MIN}}" class="form-control input-sm""
                                    style=" font-family: 'Kanit', sans-serif;">
                            </div>
                            <div class="col-lg-3">
                                <label>จำกัดคงคลังจำนวนสูงสุด :</label>
                            </div>
                            <div class="col-lg-3">
                                <input name="MAX" id="MAX" value="{{$infomedical->MAX}}" class="form-control input-sm"
                                    style=" font-family: 'Kanit', sans-serif;">
                            </div>
                        </div>

                        <div class="row push">
                            <div class="col-lg-2">
                                <label>หมายเหตุ :</label>
                            </div>
                            <div class="col-lg-10">
                                <input name="SUP_REMARK" id="SUP_REMARK" value={{$infomedical->SUP_REMARK}} class="form-control input-sm"
                                    style=" font-family: 'Kanit', sans-serif;">
                            </div>
                        </div>

                        <div class="row push">
                            <div class="col-lg-0.5">
                                <input type="checkbox" id="vehicle1" name="vehicle1">
                            </div>
                            <div class="col-lg-2">
                                <label>วัสดุเบิกจ่าย</label>
                            </div>
                            <div class="col-lg-0.5">
                                <input type="checkbox" id="vehicle1" name="vehicle2">
                            </div>
                            <div class="col-lg-3">
                                <label>มีผู้ผลิตในบัญชีนวัตกรรม</label>
                            </div>
                            <div class="col-lg-0.5">
                                <label>การจัดซื้อร่วม</label>
                            </div>
                            <div class="col-lg-4">
                                <select name="CONTINUE_PRICE_ID" id="CONTINUE_PRICE_ID"
                                    class="form-control input-lg js-example-basic-single"
                                    style=" font-family: 'Kanit', sans-serif;">

                                    <option value="">--กรุณาเลือก--</option>
                                    <option value="1">จังหวัด</option>
                                    <option value="2">เขต</option>
                                    <option value="3">ซื้อเอง</option>

                                </select>

                            </div>
                        </div>

                    </div>

                </div>

                <div id="rcorners1" class="col-lg-12">
                    <div class="row push">
                        <div class="col-lg-6">
                            <div class="row push">
                                <div class="col-lg-2">
                                    <label>ราคากลาง </label>
                                </div>
                                <div class="col-lg-2">
                                    <input name="" id="" class="form-control input-sm"
                                        style=" font-family: 'Kanit', sans-serif;">
                                </div>

                                <div class="col-lg-2">
                                    <label>ปรับปรุงล่าสุด </label>
                                </div>
                                <div class="col-lg-4">
                                    <input name="" id="" class="form-control input-sm"
                                        style=" font-family: 'Kanit', sans-serif;">
                                </div>

                            </div>
                            <div class="row push">
                                <div class="col-lg-2">
                                    <label>ราคาเฉลี่ย </label>
                                </div>
                                <div class="col-lg-2">
                                    <input name="" id="" class="form-control input-sm"
                                        style=" font-family: 'Kanit', sans-serif;">
                                </div>
                                <div class="col-lg-2">
                                    <label>รับเข้าล่าสุด </label>
                                </div>
                                <div class="col-lg-4">
                                    <input name="" id="" class="form-control input-sm"
                                        style=" font-family: 'Kanit', sans-serif;">
                                </div>

                            </div>
                            <div class="row push">
                                <div class="col-lg-2">
                                    <label>ราคาล่าสุด </label>
                                </div>
                                <div class="col-lg-2">
                                    <input name="" id="" class="form-control input-sm"
                                        style=" font-family: 'Kanit', sans-serif;">
                                </div>
                                <div class="col-lg-2">
                                    <label>จ่ายออกล่าสุด </label>
                                </div>
                                <div class="col-lg-4">
                                    <input name="" id="" class="form-control input-sm"
                                        style=" font-family: 'Kanit', sans-serif;">
                                </div>

                            </div>
                            <div class="row push">
                                <div class="col-lg-4">

                                </div>

                                <div class="col-lg-2">
                                    <label>วันหมดอายุ </label>
                                </div>
                                <div class="col-lg-4">
                                    <input name="" id="" class="form-control input-sm"
                                        style=" font-family: 'Kanit', sans-serif;">
                                </div>

                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="row push">
                                <div class="col-lg-2">
                                    <label>ตำแหน่งที่วาง </label>
                                </div>
                                <div class="col-lg-3">
                                    <input name="" id="" class="form-control input-sm"
                                        style=" font-family: 'Kanit', sans-serif;">
                                </div>
                                <div class="col-lg-2">
                                    <label>ปริมาณคงคลัง </label>
                                </div>
                                <div class="col-lg-3">
                                    <input name="" id="" class="form-control input-sm"
                                        style=" font-family: 'Kanit', sans-serif;">
                                </div>

                            </div>
                            <div class="row push">
                                <div class="col-lg-2">
                                    <label>ประเภทบัญชี </label>
                                </div>
                                <div class="col-lg-3">
                                    <input name="" id="" class="form-control input-sm"
                                        style=" font-family: 'Kanit', sans-serif;">
                                </div>

                                <div class="col-lg-2">
                                    <label>มูลค่าคงคลัง </label>
                                </div>
                                <div class="col-lg-3">
                                    <input name="" id="" class="form-control input-sm"
                                        style=" font-family: 'Kanit', sans-serif;">
                                </div>

                            </div>
                            <div class="row push">
                                <div class="col-lg-12">
                                    <label>ยอดเบิกต่อเดือน </label>
                                </div>
                            </div>
                            <div class="row push">

                                <table width="100%">
                                    <tr>
                                        <td align="center">ม.ค.</td>
                                        <td align="center">ก.พ.</td>
                                        <td align="center">มี.ค.</td>
                                        <td align="center">เม.ย.</td>
                                        <td align="center">พ.ค.</td>
                                        <td align="center">มิ.ย.</td>
                                        <td align="center">ก.ค.</td>
                                        <td align="center">ส.ค.</td>
                                        <td align="center">ก.ย.</td>
                                        <td align="center">ต.ค.</td>
                                        <td align="center">พ.ย.</td>
                                        <td align="center">ธ.ค.</td>
                                    </tr>
                                    <tr>

                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>

                                    </tr>
                                </table>

                            </div>
                        </div>
                    </div>
                </div>
                <br>

                <div class="modal-footer">
                    <div align="right">
                        <button type="submit" class="btn btn-hero-sm btn-hero-info"
                            >บันทึกข้อมูล</button>
                        <a href="{{ url('manager_medical/suppliesinfo')  }}" class="btn btn-hero-sm btn-hero-danger"
                            onclick="return confirm('ต้องการที่จะยกเลิกการเพิ่มข้อมูล ?')"
                            >ยกเลิก</a>
                    </div>

                </div>
            </form>

            @endsection

            @section('footer')

            <script src="{{ asset('select2/select2.min.js') }}"></script>

            <script src="{{ asset('asset/js/plugins/jquery.maskedinput/jquery.maskedinput.min.js') }}"></script>
            <script>
                jQuery(function() {
                    Dashmix.helpers(['masked-inputs']);
                });
            </script>

            <script src="{{ asset('datepicker/dist/js/bootstrap-datepicker-custom.js') }}"></script>
            <script src="{{ asset('datepicker/dist/locales/bootstrap-datepicker.th.min.js') }}" charset="UTF-8">
            </script>

            <script>
                function getnumberid(){
                   
                        var select = document.getElementById("SUP_TYPE_ID").value;
                        var _token = $('input[name="_token"]').val();
                        $.ajax({
                            url: "{{route('dropdown.parcel')}}",
                            method: "GET",
                            data: {
                                select: select,
                                _token: _token
                            },
                            success: function(result) {
                                $('.number_parcel').html(result);
                            }
                        })
                        // console.log(select);
                    
                }
                $(document).ready(function() {
                    $('select').select2();
                    getnumberid();
                });
                $('.typekind_sub').change(function() {
                    if ($(this).val() != '') {
                        var select = $(this).val();
                        var _token = $('input[name="_token"]').val();
                        $.ajax({
                            url: "{{route('msupplies.fetchsubtype')}}",
                            method: "GET",
                            data: {
                                select: select,
                                _token: _token
                            },
                            success: function(result) {
                                $('.type_sub').html(result);
                            }
                        })
                        // console.log(select);
                        $.ajax({
                            url: "{{route('msupplies.checkfetchsubtype')}}",
                            method: "GET",
                            data: {
                                select: select,
                                _token: _token
                            },
                            success: function(result) {
                                $('.checktypesub').html(result);
                            }
                        })
                    }
                });
                //-------------------------------------------------------------------------
                $('.type_sub').change(function() {
                    if ($(this).val() != '') {
                        var select = $(this).val();
                        var _token = $('input[name="_token"]').val();
                        $.ajax({
                            url: "{{route('msupplies.fetchmedicine')}}",
                            method: "GET",
                            data: {
                                select: select,
                                _token: _token
                            },
                            success: function(result) {
                                $('.medicine').html(result);
                            }
                        })
                        // console.log(select);
                    }
                });
                $(document).ready(function() {
                    $('.datepicker').datepicker({
                        format: 'dd/mm/yyyy',
                        todayBtn: true,
                        language: 'th', //เปลี่ยน label ต่างของ ปฏิทิน ให้เป็น ภาษาไทย   (ต้องใช้ไฟล์ bootstrap-datepicker.th.min.js นี้ด้วย)
                        thaiyear: true,
                        autoclose: true //Set เป็นปี พ.ศ.
                    }).datepicker("setDate", 0); //กำหนดเป็นวันปัจุบัน
                });

                function chkNumber(ele) {
                    var vchar = String.fromCharCode(event.keyCode);
                    if ((vchar < '0' || vchar > '9')) return false;
                    ele.onKeyPress = vchar;
                }

                function chkmunny(ele) {
                    var vchar = String.fromCharCode(event.keyCode);
                    if ((vchar < '0' || vchar > '9') && (vchar != '.')) return false;
                    ele.onKeyPress = vchar;
                }
                $('body').on('keydown', 'input, select, textarea', function(e) {
                    var self = $(this),
                        form = self.parents('form:eq(0)'),
                        focusable, next;
                    if (e.keyCode == 13) {
                        focusable = form.find('input,a,select,button,textarea').filter(':visible');
                        next = focusable.eq(focusable.index(this) + 1);
                        if (next.length) {
                            next.focus();
                        } else {
                            form.submit();
                        }
                        return false;
                    }
                });

                function readURL(input) {
                    var fileInput = document.getElementById('picture');
                    var url = input.value;
                    var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
                    var numb = input.files[0].size / 1024;
                    if (numb > 64) {
                        alert('กรุณาอัปโหลดไฟล์ขนาดไม่เกิน 64KB');
                        fileInput.value = '';
                        return false;
                    }
                    if (input.files && input.files[0] && (ext == "gif" || ext == "png" || ext == "jpeg" || ext ==
                            "jpg")) {
                        var reader = new FileReader();
                        reader.onload = function(e) {
                            $('#image_upload_preview').attr('src', e.target.result);
                        }
                        reader.readAsDataURL(input.files[0]);
                    } else {
                        alert('กรุณาอัพโหลดไฟล์ประเภทรูปภาพ .jpeg/.jpg/.png/.gif .');
                        fileInput.value = '';
                        return false;
                    }
                }
                $("#picture").change(function() {
                    readURL(this);
                });
                //-------------------------------------------------------
                $('.addRow').on('click', function() {
                    addRow();
                });

                function addRow() {
                    var count = $('.tbody1').children('tr').length;
                    var tr = '<tr>' +
                        '<td>' +
                        '<input name="" id="" class="form-control input-sm" style=" font-family: \'Kanit\', sans-serif;" >' +
                        '</td>' +
                        '<td>' +
                        '<input name="" id="" class="form-control input-sm" style=" font-family: \'Kanit\', sans-serif;" >' +
                        '</td>' +
                        '<td>' +
                        '<input name="" id="" class="form-control input-sm" style=" font-family: \'Kanit\', sans-serif;" >' +
                        '</td>' +
                        '<td style="text-align: center;"><a class="btn btn-danger fa fa-trash-alt remove" style="color:#FFFFFF;"></a></td>' +
                        '</tr>';
                    $('.tbody1').append(tr);
                };
                $('.tbody1').on('click', '.remove', function() {
                    $(this).parent().parent().remove();
                });
                //-------------------------------------------------
            </script>

            @endsection