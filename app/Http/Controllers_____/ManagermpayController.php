<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Web_meta_data_Controller;
use App\Models\Cpay_defective;
use App\Models\Cpay_defective_list;
use App\Models\Cpay_defective_status;
use App\Models\Cpay_department_sub_sub;
use App\Models\Cpay_department_sub_sub_quota;
use App\Models\Cpay_export;
use App\Models\Cpay_export_list;
use App\Models\Cpay_gsetequpment;
use App\Models\Cpay_machine;
use App\Models\Cpay_machine_maintenance;
use App\Models\Cpay_print_sticker;
use App\Models\Cpay_production;
use App\Models\Cpay_receive;
use App\Models\Cpay_receive_list;
use App\Models\Cpay_receive_status;
use App\Models\Cpay_setequpment;
use App\Models\Cpay_setequpment_list;
use App\Models\Cpay_setequpment_sub;
use App\Models\Cpay_typemachine;
use App\Models\Cpay_unit;
use App\Models\Hrddepartmentsubsub;
use App\Models\Person;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Session;

date_default_timezone_set("Asia/Bangkok");

class ManagermpayController extends Controller
{
    public function dashboard()
    {
        $year   = date('Y');
        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();

        $year_id = $year + 543;

        $req_1  = DB::table('mpay_withdrow')->where('MPAY_WITHDROW_STATUS', '=', 'Request')->count();
        $succ_1 = DB::table('mpay_withdrow')->where('MPAY_WITHDROW_STATUS', '=', 'Success')->count();

        $night = DB::table('mpay_stickernight_sub')->sum('STICKERNIGHT_SUB_QTY');

        $pay  = DB::table('mpay_pay_sub')->sum('MPAY_PAY_SUB_AMOUNT');
        $rec  = DB::table('mpay_recieve_sub')->sum('MPAY_RECIEVE_SUB_QTY');
        $disp = DB::table('mpay_dispose_sub')->sum('MPAY_DISPOSE_SUB_QTY');

        $L1  = DB::table('mpay_withdrow')->where('MPAY_WITHDROW_STATUS', '=', 'Request')->where('MPAY_WITHDROW_DATE', 'like', $year . '-01%')->count();
        $L2  = DB::table('mpay_withdrow')->where('MPAY_WITHDROW_STATUS', '=', 'Request')->where('MPAY_WITHDROW_DATE', 'like', $year . '-02%')->count();
        $L3  = DB::table('mpay_withdrow')->where('MPAY_WITHDROW_STATUS', '=', 'Request')->where('MPAY_WITHDROW_DATE', 'like', $year . '-03%')->count();
        $L4  = DB::table('mpay_withdrow')->where('MPAY_WITHDROW_STATUS', '=', 'Request')->where('MPAY_WITHDROW_DATE', 'like', $year . '-04%')->count();
        $L5  = DB::table('mpay_withdrow')->where('MPAY_WITHDROW_STATUS', '=', 'Request')->where('MPAY_WITHDROW_DATE', 'like', $year . '-05%')->count();
        $L6  = DB::table('mpay_withdrow')->where('MPAY_WITHDROW_STATUS', '=', 'Request')->where('MPAY_WITHDROW_DATE', 'like', $year . '-06%')->count();
        $L7  = DB::table('mpay_withdrow')->where('MPAY_WITHDROW_STATUS', '=', 'Request')->where('MPAY_WITHDROW_DATE', 'like', $year . '-07%')->count();
        $L8  = DB::table('mpay_withdrow')->where('MPAY_WITHDROW_STATUS', '=', 'Request')->where('MPAY_WITHDROW_DATE', 'like', $year . '-08%')->count();
        $L9  = DB::table('mpay_withdrow')->where('MPAY_WITHDROW_STATUS', '=', 'Request')->where('MPAY_WITHDROW_DATE', 'like', $year . '-09%')->count();
        $L10 = DB::table('mpay_withdrow')->where('MPAY_WITHDROW_STATUS', '=', 'Request')->where('MPAY_WITHDROW_DATE', 'like', $year . '-10%')->count();
        $L11 = DB::table('mpay_withdrow')->where('MPAY_WITHDROW_STATUS', '=', 'Request')->where('MPAY_WITHDROW_DATE', 'like', $year . '-11%')->count();
        $L12 = DB::table('mpay_withdrow')->where('MPAY_WITHDROW_STATUS', '=', 'Request')->where('MPAY_WITHDROW_DATE', 'like', $year . '-12%')->count();

        $L1_1   = DB::table('mpay_withdrow')->where('MPAY_WITHDROW_STATUS', '=', 'Success')->where('MPAY_WITHDROW_DATE', 'like', $year . '-01%')->count();
        $L2_2   = DB::table('mpay_withdrow')->where('MPAY_WITHDROW_STATUS', '=', 'Success')->where('MPAY_WITHDROW_DATE', 'like', $year . '-02%')->count();
        $L3_3   = DB::table('mpay_withdrow')->where('MPAY_WITHDROW_STATUS', '=', 'Success')->where('MPAY_WITHDROW_DATE', 'like', $year . '-03%')->count();
        $L4_4   = DB::table('mpay_withdrow')->where('MPAY_WITHDROW_STATUS', '=', 'Success')->where('MPAY_WITHDROW_DATE', 'like', $year . '-04%')->count();
        $L5_5   = DB::table('mpay_withdrow')->where('MPAY_WITHDROW_STATUS', '=', 'Success')->where('MPAY_WITHDROW_DATE', 'like', $year . '-05%')->count();
        $L6_6   = DB::table('mpay_withdrow')->where('MPAY_WITHDROW_STATUS', '=', 'Success')->where('MPAY_WITHDROW_DATE', 'like', $year . '-06%')->count();
        $L7_7   = DB::table('mpay_withdrow')->where('MPAY_WITHDROW_STATUS', '=', 'Success')->where('MPAY_WITHDROW_DATE', 'like', $year . '-07%')->count();
        $L8_8   = DB::table('mpay_withdrow')->where('MPAY_WITHDROW_STATUS', '=', 'Success')->where('MPAY_WITHDROW_DATE', 'like', $year . '-08%')->count();
        $L9_9   = DB::table('mpay_withdrow')->where('MPAY_WITHDROW_STATUS', '=', 'Success')->where('MPAY_WITHDROW_DATE', 'like', $year . '-09%')->count();
        $L10_10 = DB::table('mpay_withdrow')->where('MPAY_WITHDROW_STATUS', '=', 'Success')->where('MPAY_WITHDROW_DATE', 'like', $year . '-10%')->count();
        $L11_11 = DB::table('mpay_withdrow')->where('MPAY_WITHDROW_STATUS', '=', 'Success')->where('MPAY_WITHDROW_DATE', 'like', $year . '-11%')->count();
        $L12_12 = DB::table('mpay_withdrow')->where('MPAY_WITHDROW_STATUS', '=', 'Success')->where('MPAY_WITHDROW_DATE', 'like', $year . '-12%')->count();

        return view('manager_mpay.dashboard_mpay', [
            'budgets' => $budget, 'year_id' => $year_id, 'req_1' => $req_1, 'succ_1' => $succ_1, 'nights' => $night, 'pays' => $pay, 'recs'  => $rec, 'disps' => $disp,
            'L1'      => $L1, 'L2'          => $L2, 'L3'         => $L3, 'L4'        => $L4, 'L5'         => $L5, 'L6'      => $L6, 'L7'     => $L7, 'L8'     => $L8, 'L9'     => $L9, 'L10'      => $L10, 'L11'       => $L11, 'L12'       => $L12,
            'L1_1'    => $L1_1, 'L2_2'      => $L2_2, 'L3_3'     => $L3_3, 'L4_4'    => $L4_4, 'L5_5'     => $L5_5, 'L6_6'  => $L6_6, 'L7_7' => $L7_7, 'L8_8' => $L8_8, 'L9_9' => $L9_9, 'L10_10' => $L10_10, 'L11_11' => $L11_11, 'L12_12' => $L12_12

        ]);
    }

    ////////////service/////////////////
    // ___ service stock ___________________
    public function mpay_service_stock()
    {
        $setequpment = cpay_setequpment::select('cpay_unit.CPAY_UNIT_NAME', 'cpay_setequpment.*','cpay_typemachine.CPAY_TYPEMACH_NAME')
                        ->leftJoin('cpay_unit', 'cpay_unit.CPAY_UNIT_ID', 'cpay_setequpment.CPAY_UNIT_ID')
                        ->leftJoin('cpay_typemachine', 'cpay_typemachine.CPAY_TYPEMACH_ID', 'cpay_setequpment.CPAY_TYPEMACH_ID')
                        ->get();

        return view('manager_mpay.mpay_service_stock_view', compact('setequpment'));
    }

    // ________________________________________________ end service stock ___________________

    // ___ service receive ___________________
    public function mpay_service_receive(Request $request)
    {
        if ($request->method() === 'POST') {
            $receive_date_start = CheckDatethaiParse($request->receive_date_start);
            $receive_date_end   = CheckDatethaiParse($request->receive_date_end);
            session([
                'manager_mpay.mpay_service_receive.receive_date_start' => $receive_date_start,
                'manager_mpay.mpay_service_receive.receive_date_end'   => $receive_date_end
            ]);
        } elseif (Session::has('manager_mpay.mpay_service_receive')) {
            $receive_date_start = session('manager_mpay.mpay_service_receive.receive_date_start');
            $receive_date_end   = session('manager_mpay.mpay_service_receive.receive_date_end');
        } else {
            $receive_date_start = date('Y-m-01');
            $receive_date_end   = date('Y-m-d', strtotime(date('Y-m-1') . ' +1month -1day'));
        }

        $cpay_receive_q = Cpay_receive::whereBetween('RECEIVE_DATE', [$receive_date_start, $receive_date_end])
            ->orderByDesc('RECEIVE_DATE')->orderByDesc('RECEIVE_TIME');
        $data['cpay_receive']       = $cpay_receive_q->get();
        $data['timecheck']          = strtotime('-10minute');
        $data['receive_date_start'] = $receive_date_start;
        $data['receive_date_end']   = $receive_date_end;
        return view('manager_mpay.mpay_service_receive_view', $data);
    }

    public function ajax_mpay_service_receive_detail(Request $request)
    {
        $receive_list = cpay_receive_list::leftJoin('cpay_receive', 'cpay_receive.RECEIVE_ID', 'cpay_receive_list.RECEIVE_ID')
            ->leftJoin('cpay_receive_status', 'cpay_receive_status.RECEIVE_STATUS_ID', 'cpay_receive_list.RECEIVE_STATUS_ID')
            ->where('cpay_receive_list.RECEIVE_ID', $request->receive_id)->get();
        $status          = false;
        $number          = 1;
        $dep_sender      = '';
        $person_sender   = '';
        $person_receiver = '';
        $date_receive    = '';
        $html            = '';
        foreach ($receive_list as $row) {
            if ($number == 1) {
                $status          = true;
                $dep_sender      = $row->DELIVERY_DEP_SUB_SUB_NAME;
                $person_sender   = $row->DELIVERY_PERSON_NAME;
                $person_receiver = $row->RECEIVE_PERSON_NAME;
                $date_receive    = $row->RECEIVE_DATE . ' ' . $row->RECEIVE_TIME;
            }
            $html .= '<tr>';
            $html .= '<td class="text-center">' . $number++ . '</td>';
            $html .= '<td>' . $row->CPAY_SET_NAME . '</td>';
            $html .= '<td class="text-center">' . $row->RECEIVE_QUANTITY . '</td>';
            $html .= '<td>' . $row->PRODUCT_BARCODE . '</td>';
            $html .= '<td class="text-center">' . $row->RECEIVE_STATUS_NAME . '</td>';
            $html .= '<td class="text-center">' . $row->RECEIVE_LIST_DETAIL . '</td>';
            $html .= '</tr>';
        }
        return json_encode_u(array(
            'status'          => $status,
            'dep_sender'      => $dep_sender,
            'person_sender'   => $person_sender,
            'person_receiver' => $person_receiver,
            'date_receive'    => $date_receive,
            'msg'             => $html
        ));
    }

    public function mpay_service_receive_cancel($receive_id)
    {
        $receive = cpay_receive::find($receive_id);
        if ($receive->IS_CANCEL) {
            session::flash('err', 'รายการนี้ทำการยกเลิกแล้ว');
            return redirect(route('mpay.mpay_service_receive'));
        }
        $person                     = Person::find(Auth::user()->PERSON_ID);
        $receive->RECEIVE_CANCEL_BY = $person->HR_FNAME;
        $receive->IS_CANCEL         = true;
        $receive->save();
        $cpay_receive_list = cpay_receive_list::where('RECEIVE_ID', $receive_id)->get();
        $hr_depart_id      = cpay_department_sub_sub::where('CPAY_DEP_ID', $receive->DELIVERY_DEP_SUB_SUB_ID)->first();
        foreach ($cpay_receive_list as $row) {
            //ลดจำนวนชุดอุปกรณ์
            $setqupment_update = cpay_setequpment::find($row->CPAY_SET_ID);
            $setqupment_update->CPAY_SET_NOT_STERILE_QUANTITY -= $row->RECEIVE_QUANTITY;
            $setqupment_update->save();

            //เพิ่มจำนวนในโควตาคืน
            $depart_sub_sub_id = web_meta_data_Controller::getvalueByname('CPAY_DEFAULT_DEPARTMENT_SUB_SUB_ID');
            if ($row->RECEIVE_STATUS_ID != 4 && $hr_depart_id->HR_DEPARTMENT_SUB_SUB_ID != $depart_sub_sub_id) {
                $depart_quota        = cpay_department_sub_sub_quota::where('CPAY_DEP_ID', $receive->DELIVERY_DEP_SUB_SUB_ID)->where('CPAY_SET_ID', $row->CPAY_SET_ID)->first();
                $depart_quota_update = cpay_department_sub_sub_quota::find($depart_quota->DEP_QUOTA_ID);
                $depart_quota_update->DEP_QUOTA_BALANCE += $row->RECEIVE_QUANTITY;
                $depart_quota_update->save();
            }
        }
        session::flash('scc', 'ทำการยกเลิกสำเร็จ');
        return redirect(route('mpay.mpay_service_receive'));
    }

    public function mpay_service_receive_add()
    {
        $cpay_depart_id = web_meta_data_Controller::getvalueByname('CPAY_DEFAULT_DEPARTMENT_SUB_SUB_ID');
        $deliver        = DB::table('hrd_person')->select('ID', 'HR_FNAME', 'HR_LNAME')->where('HR_STATUS_ID', 1)->get();
        $receiver       = DB::table('hrd_person')->select('ID', 'HR_FNAME', 'HR_LNAME')
            ->where('HR_DEPARTMENT_SUB_SUB_ID', $cpay_depart_id)->where('HR_STATUS_ID', 1)->get();
        $departments    = cpay_department_sub_sub::where('ACTIVE', true)->get();
        $receive_status = cpay_receive_status::all();
        $person         = Person::select('ID', 'HR_FNAME')->find(Auth::user()->PERSON_ID);
        return view('manager_mpay.mpay_service_receive_add', compact(
            'deliver', 'receiver', 'person', 'departments', 'receive_status'
        ));
    }

    public function receive_update_select(Request $request)
    {
        $depart            = json_decode($request->depart);
        $depart_sub_sub_id = web_meta_data_Controller::getvalueByname('CPAY_DEFAULT_DEPARTMENT_SUB_SUB_ID');

        $receive_status   = cpay_receive_status::all();
        $setequpment_html = '';
        $status_html      = '';
        if ($depart->depart_sub_sub_id == $depart_sub_sub_id) {
            $setequpment = cpay_setequpment::where('ACTIVE', true)->get();
            foreach ($receive_status as $row_status) {
                if ($row_status->RECEIVE_STATUS_ID === 4) {
                    $status_html .= "<option value='" . $row_status->RECEIVE_STATUS_ID . "' selected >" . $row_status->RECEIVE_STATUS_NAME . "</option>";
                } else {
                    $status_html .= "<option value='" . $row_status->RECEIVE_STATUS_ID . "'>" . $row_status->RECEIVE_STATUS_NAME . "</option>";
                }
            }
        } else {
            $setequpment = cpay_department_sub_sub_quota::select('cpay_setequpment.CPAY_SET_ID', 'cpay_setequpment.CPAY_SET_NAME_INSIDE')
                ->leftJoin('cpay_setequpment', 'cpay_setequpment.CPAY_SET_ID', 'cpay_department_sub_sub_quota.CPAY_SET_ID')
                ->where('cpay_department_sub_sub_quota.CPAY_DEP_ID', $depart->dep_id)
                ->where('cpay_department_sub_sub_quota.ACTIVE', true)->get();
            foreach ($receive_status as $row_status) {
                $status_html .= "<option value='" . $row_status->RECEIVE_STATUS_ID . "'>" . $row_status->RECEIVE_STATUS_NAME . "</option>";
            }
        }

        foreach ($setequpment as $row) {
            $json = json_encode_u(array($row->CPAY_SET_ID, $row->CPAY_SET_NAME_INSIDE));
            $setequpment_html .= "<option value='" . $json . "'>" . $row->CPAY_SET_NAME_INSIDE . "</option>";
        }

        $results['setqupment']     = $setequpment_html;
        $results['status_receive'] = $status_html;
        echo json_encode_u($results);
    }

    public function mpay_service_receive_save(Request $request)
    {
        #หัวรายการรับเข้า
        $dep                                          = json_decode($request->DELIVERY_DEP_SUB_SUB_ID);
        $delivery                                     = json_decode($request->DELIVERY_PERSON_ID);
        $receiver                                     = json_decode($request->RECEIVE_PERSON_ID);
        $cpay_receive_save                            = new cpay_receive();
        $cpay_receive_save->DELIVERY_DEP_SUB_SUB_ID   = $dep->dep_id;
        $cpay_receive_save->DELIVERY_DEP_SUB_SUB_NAME = $dep->dep_name;
        $cpay_receive_save->DELIVERY_PERSON_ID        = $delivery->person_id;
        $cpay_receive_save->DELIVERY_PERSON_NAME      = $delivery->person_fname;
        $cpay_receive_save->RECEIVE_PERSON_ID         = $receiver->person_id;
        $cpay_receive_save->RECEIVE_PERSON_NAME       = $receiver->person_fname;
        $cpay_receive_save->RECEIVE_DATE              = CheckDatethaiParse($request->RECEIVE_DATE);
        $cpay_receive_save->RECEIVE_TIME              = $request->RECEIVE_TIME;
        $cpay_receive_save->RECEIVE_DETAIL            = $request->RECEIVE_DETAIL;
        $cpay_receive_save->save();
        $receive_id = $cpay_receive_save->RECEIVE_ID;
        #ลูปบันทึก และอัพเดตจำนวนใน set,โควตา
        #เพิ่ม set not sterlize
        #ลบ โควตา ยกเว้นสถานะรับเข้าใหม่
        $PRODUCT_BARCODE     = $request->PRODUCT_BARCODE;
        $RECEIVE_QUANTITY    = $request->RECEIVE_QUANTITY;
        $RECEIVE_STATUS_ID   = $request->RECEIVE_STATUS_ID;
        $RECEIVE_LIST_DETAIL = $request->RECEIVE_LIST_DETAIL;
        foreach ($request->CPAY_SET_ID as $key => $cpay_set) {
            $cpayset                                                 = json_decode($cpay_set);
            $set_update                                              = cpay_setequpment::find($cpayset[0]);
            $cpay_receive_list_save                                  = new cpay_receive_list();
            $cpay_receive_list_save->RECEIVE_ID                      = $receive_id;
            $cpay_receive_list_save->CPAY_SET_ID                     = $cpayset[0];
            $cpay_receive_list_save->CPAY_SET_NAME                   = $cpayset[1];
            $cpay_receive_list_save->PRODUCT_BARCODE                 = $PRODUCT_BARCODE[$key];
            $cpay_receive_list_save->RECEIVE_QUANTITY                = $RECEIVE_QUANTITY[$key];
            $cpay_receive_list_save->BEFORE_SET_NOT_STERILE_QUANTITY = $set_update->CPAY_SET_NOT_STERILE_QUANTITY;
            $cpay_receive_list_save->AFTER_SET_NOT_STERILE_QUANTITY  = $set_update->CPAY_SET_NOT_STERILE_QUANTITY + $RECEIVE_QUANTITY[$key];
            $cpay_receive_list_save->RECEIVE_STATUS_ID               = $RECEIVE_STATUS_ID[$key];
            $cpay_receive_list_save->RECEIVE_LIST_DETAIL             = $RECEIVE_LIST_DETAIL[$key];
            $cpay_receive_list_save->save();

            //เพิ่มจำนวนในชุดอุปกรณ์
            $set_update->CPAY_SET_NOT_STERILE_QUANTITY += $RECEIVE_QUANTITY[$key];
            $set_update->save();

            //ลดจำนวนในโควตา
            $depart_sub_sub_id = web_meta_data_Controller::getvalueByname('CPAY_DEFAULT_DEPARTMENT_SUB_SUB_ID');
            if ($RECEIVE_STATUS_ID[$key] != 4 && $dep->depart_sub_sub_id != $depart_sub_sub_id) {
                $depart_quota        = cpay_department_sub_sub_quota::where('CPAY_DEP_ID', $dep->dep_id)->where('CPAY_SET_ID', $cpayset[0])->first();
                $depart_quota_update = cpay_department_sub_sub_quota::find($depart_quota->DEP_QUOTA_ID);
                $depart_quota_update->DEP_QUOTA_BALANCE -= $RECEIVE_QUANTITY[$key];
                $depart_quota_update->save();
            }
        }
        session::flash('scc_notify', 'บันทึกข้อมูลสำเร็จ');
        return redirect(route('mpay.mpay_service_receive_add'));
    }

    // ________________________________________________ end service receive ___________________

    // ___ service sticker print ___________________
    public function mpay_service_stickerprint()
    {
        $productions = Cpay_production::select('cpay_production.*', 'cpay_machine.CPAY_MACH_NAME_INSIDE', 'cpay_machine.CPAY_MACH_NUMBER')
            ->leftJoin('cpay_machine', 'cpay_machine.CPAY_MACH_ID', 'cpay_production.CPAY_MACH_ID')
            ->where('PRODUCTION_QUANTITY_BALANCE', '!=', 0)
            ->orderByDesc('cpay_production.created_at')
            ->get();
        $timecheck = strtotime('-10minute');
        return view('manager_mpay.mpay_service_stickerprint_view', compact('productions', 'timecheck'));
    }

    public function mpay_service_stickerprint_add()
    {
        $department_id = web_meta_data_Controller::getvalueByname('CPAY_DEFAULT_DEPARTMENT_SUB_SUB_ID');
        $departments   = cpay_department_sub_sub::where('ACTIVE', true)->get();
        $persons       = DB::table('hrd_person')->select('ID', 'HR_FNAME', 'HR_LNAME')
            ->where('HR_DEPARTMENT_SUB_SUB_ID', $department_id)->where('HR_STATUS_ID', 1)->get();
        $stock = Cpay_setequpment::select('cpay_setequpment.*', 'cpay_unit.CPAY_UNIT_NAME')
            ->leftJoin('cpay_unit', 'cpay_unit.CPAY_UNIT_ID', 'cpay_setequpment.CPAY_UNIT_ID')
            ->where('CPAY_SET_NOT_STERILE_QUANTITY', '>', 0)
            ->where('cpay_setequpment.ACTIVE', true)->get();
        $person_auth_id  = Person::find(Auth::user()->PERSON_ID);
        $person_login_id = ($person_auth_id) ? $person_auth_id->ID : 0;
        return view('manager_mpay.mpay_service_stickerprint_add', compact('stock', 'departments', 'persons', 'person_login_id'));
    }

    public function equpment_update_list(Request $request)
    {
        $stock = Cpay_setequpment::select('cpay_setequpment.*', 'cpay_unit.CPAY_UNIT_NAME')
            ->leftJoin('cpay_unit', 'cpay_unit.CPAY_UNIT_ID', 'cpay_setequpment.CPAY_UNIT_ID')
            ->leftJoin('cpay_department_sub_sub_quota', 'cpay_department_sub_sub_quota.CPAY_SET_ID', 'cpay_setequpment.CPAY_SET_ID')
            ->where('CPAY_SET_NOT_STERILE_QUANTITY', '>', 0)
            ->where('cpay_department_sub_sub_quota.CPAY_DEP_ID', $request->department_id)
            ->where('cpay_setequpment.ACTIVE', true)->get();
        $html = '';
        foreach ($stock as $row) {
            $html .= '<tr style="cursor:pointer" onclick="add_list_production(' . $row->CPAY_SET_ID . ')">';
            $html .= '<td width="60%">[' . $row->CPAY_SET_ID . '] ' . $row->CPAY_SET_NAME_INSIDE . '</td>';
            $html .= '<td width="20%" class="text-center">' . $row->CPAY_SET_NOT_STERILE_QUANTITY . '</td>';
            $html .= '<td width="20%" class="text-center">' . $row->CPAY_UNIT_NAME . '</td>';
            $html .= '</tr>';
        }
        echo $html;
    }

    public function add_list_production(Request $request)
    {
        $product = Cpay_setequpment::select('cpay_setequpment.*', 'cpay_unit.CPAY_UNIT_NAME')
            ->leftJoin('cpay_unit', 'cpay_unit.CPAY_UNIT_ID', 'cpay_setequpment.CPAY_UNIT_ID')
            ->leftJoin('cpay_department_sub_sub_quota', 'cpay_department_sub_sub_quota.CPAY_SET_ID', 'cpay_setequpment.CPAY_SET_ID')
            ->where('CPAY_SET_NOT_STERILE_QUANTITY', '>', 0)
            ->where('cpay_department_sub_sub_quota.CPAY_DEP_ID', $request->department_id)
            ->where('cpay_department_sub_sub_quota.CPAY_SET_ID', $request->CPAY_SET_ID)
            ->where('cpay_setequpment.ACTIVE', true)->first();

        $status   = 'error';
        $html     = '';
        $set_name = '';
        $set_id   = '';
        if ($product) {
            //ดึงข้อมูลเครื่งนึ่ง/อบที่มี
            $machine = cpay_machine::all();
            if (count($machine) == 0) {
                $status = 'error';
                $html   = 'ไม่พบเครื่องนึ่ง/อบ ของประเภทเครื่องมือที่กำหนดในชุดอุปกรณ์';
            } else {
                //เพิ่มข้อมูลลง row ของ table
                $set_id   = $product->CPAY_SET_ID;
                $set_name = $product->CPAY_SET_NAME_INSIDE;
                $status   = 'success';
                $html .= '<tr class="set_id_row" data-set_id="' . $set_id . '">';
                $data_set_id = json_encode_u(array('CPAY_SET_ID' => $product->CPAY_SET_ID, 'CPAY_SET_NAME' => $product->CPAY_SET_NAME_INSIDE));
                $html .= '<td width="35%"><input name="CPAY_SET_ID[]" type="hidden" value=' . "'" . $data_set_id . "'" . '>' . $product->CPAY_SET_NAME_INSIDE . '</td>';
                $html .= '<td width="13%"><input min="1" max="' . $product->CPAY_SET_NOT_STERILE_QUANTITY . '" value="' . $product->CPAY_SET_NOT_STERILE_QUANTITY . '" class="form-control" type="number" name="PRODUCTION_QUANTITY[]"></td>';
                $html .= '<td width="25%">';
                $html .= '<div class="form-group mb-0">';
                $html .= '<select class="js-select2 form-control select2" id="CPAY_MACH_ID" name="CPAY_MACH_ID[]"';
                $html .= 'style="width: 100%;" data-placeholder="เลือกชุดอุปกรณ์" required>';
                foreach ($machine as $mach) {
                    $html .= '<option value="' . $mach->CPAY_MACH_ID . '">' . $mach->CPAY_MACH_NAME_INSIDE . '</option>'; ///// เพิ่มข้อมูล ลิสเครื่องอบ
                }
                $html .= '</select>';
                $html .= '</div>';
                $html .= '</td>';
                $html .= '<td width="15%"><input min="1" value="1" class="form-control" type="number" name="PRODUCTION_AROUND[]"></td>';
                $html .= '<td width="5%" class="text-center"><span style="cursor:pointer" class="remove btn btn-sm btn-danger"><i class="fa fa-times"></i></span></td>';
                $html .= '</tr>';
            }
        } else {
            $status = 'error';
            $html   = 'ไม่พบรหัสชุดอุปกรณ์';
        }
        $result = json_encode_u(array('status' => $status, 'set_id' => $set_id, 'set_name' => $set_name, 'msg' => $html));
        echo $result;
    }

    public function mpay_service_stickerprint_save(Request $request)
    {
        //เช็คตั้งค่าสติ๊กเกอร์ก่อนปริ้น
        $stickerbig     = cpay_print_sticker::where('CAPY_STICK_FOR_LIST',true)->where('ACTIVE',true)->orderByDesc('updated_at')->first();
        $stickersmall   = cpay_print_sticker::where('CAPY_STICK_FOR_LIST',false)->where('ACTIVE',true)->orderByDesc('updated_at')->first();
        if(empty($stickerbig)){
            session::flash('err','กรุณาตั้งค่าสติ๊กเกอร์ใหญ่ ก่อนทำรายการ');
            return redirect(route('mpay.mpay_service_stickerprint_save'));
        }
        if(empty($stickersmall)){
            session::flash('err','กรุณาตั้งค่าสติ๊กเกอร์เล็ก ก่อนทำรายการ');
            return redirect(route('mpay.mpay_service_stickerprint_save'));
        }
        $data['template_big']           = $stickerbig->CAPY_STICK_HTML_FORMAT;
        $data['template_big_list']      = $stickerbig->CPAY_STICKER_HTML_FORMAT_LIST; 
        $data['template_small']         = $stickersmall->CAPY_STICK_HTML_FORMAT; 
        
        $forptint_r = array();
        $CPAY_DEP_ID              = json_decode($request->CPAY_DEP_ID)->CPAY_DEP_ID;
        $CPAY_DEP_NAME            = json_decode($request->CPAY_DEP_ID)->CPAY_DEP_NAME;
        $MANUFACTURER_PERSON_ID   = json_decode($request->MANUFACTURER_PERSON_ID)->MANUFACTURER_PERSON_ID;
        $MANUFACTURER_PERSON_NAME = json_decode($request->MANUFACTURER_PERSON_ID)->MANUFACTURER_PERSON_NAME;
        $CHECK_PERSON_ID          = json_decode($request->CHECK_PERSON_ID)->CHECK_PERSON_ID;
        $CHECK_PERSON_NAME        = json_decode($request->CHECK_PERSON_ID)->CHECK_PERSON_NAME;
        $STERLIZE_PERSON_ID       = json_decode($request->STERLIZE_PERSON_ID)->STERLIZE_PERSON_ID;
        $STERLIZE_PERSON_NAME     = json_decode($request->STERLIZE_PERSON_ID)->STERLIZE_PERSON_NAME;
        $PRODUCTION_DATE          = CheckDatethaiParse($request->PRODUCTION_DATE);
        $PRODUCTION_TIME          = $request->PRODUCTION_TIME;

        //array
        $CPAY_SET_ID         = $request->CPAY_SET_ID;
        $PRODUCTION_QUANTITY = $request->PRODUCTION_QUANTITY;
        $CPAY_MACH_ID        = $request->CPAY_MACH_ID;
        $PRODUCTION_AROUND   = $request->PRODUCTION_AROUND;
        foreach ($CPAY_SET_ID as $key => $set_id_value) {
            
            $CPAY_SET_ID   = json_decode($set_id_value)->CPAY_SET_ID;
            $CPAY_SET_NAME = json_decode($set_id_value)->CPAY_SET_NAME;
            $data_check = cpay_production::where('PRODUCTION_DATE',$PRODUCTION_DATE)->where('PRODUCTION_TIME',$PRODUCTION_TIME)->where('CPAY_SET_ID',$CPAY_SET_ID)->first();
            //ถ้ามีข้อมูลให้ออกจากลูป ไม่ต้องบันทึก
            if(!empty($data_check)){
                continue;
            }
            //create product id
            $new_barcode = cpay_production::where('PRODUCTION_DATE', date('Y-m-d'))->max('PRODUCT_BARCODE');
            if (!$new_barcode) {
                $new_barcode = date('ymd') . '000001';
            } else {
                $new_barcode += 1;
            }

            $set_equpment    = cpay_setequpment::find($CPAY_SET_ID);
            $EXPIRATION_DATE = date('Y-m-d', strtotime($PRODUCTION_DATE . ' +' . $set_equpment->CPAY_SET_STERILE_DAY . 'day'));
            //
            $cpay_production_save                                  = new cpay_production();
            $cpay_production_save->PRODUCT_BARCODE                 = $new_barcode;
            $cpay_production_save->CPAY_DEP_ID                     = $CPAY_DEP_ID;
            $cpay_production_save->CPAY_DEP_NAME                   = $CPAY_DEP_NAME;
            $cpay_production_save->MANUFACTURER_PERSON_ID          = $MANUFACTURER_PERSON_ID;
            $cpay_production_save->MANUFACTURER_PERSON_NAME        = $MANUFACTURER_PERSON_NAME;
            $cpay_production_save->CHECK_PERSON_ID                 = $CHECK_PERSON_ID;
            $cpay_production_save->CEHCK_PERSON_NAME               = $CHECK_PERSON_NAME;
            $cpay_production_save->STERLIZE_PERSON_ID              = $STERLIZE_PERSON_ID;
            $cpay_production_save->STERLIZE_PERSON_NAME            = $STERLIZE_PERSON_NAME;
            $cpay_production_save->CPAY_SET_ID                     = $CPAY_SET_ID;
            $cpay_production_save->CPAY_SET_NAME                   = $CPAY_SET_NAME;
            $cpay_production_save->PRODUCTION_QUANTITY_BALANCE     = $PRODUCTION_QUANTITY[$key];
            $cpay_production_save->PRODUCTION_QUANTITY             = $PRODUCTION_QUANTITY[$key];
            $cpay_production_save->PRODUCTION_PRICE                = $set_equpment->CPAY_SET_PRICE;
            $cpay_production_save->PRODUCTION_VALUE                = $PRODUCTION_QUANTITY[$key] * $set_equpment->CPAY_SET_PRICE;
            $cpay_production_save->BEFORE_SET_NOT_STERILE_QUANTITY = $set_equpment->CPAY_SET_NOT_STERILE_QUANTITY;
            $cpay_production_save->AFTER_SET_NOT_STERILE_QUANTITY  = $set_equpment->CPAY_SET_NOT_STERILE_QUANTITY - $PRODUCTION_QUANTITY[$key];
            $cpay_production_save->BEFORE_SET_STERILE_QUANTITY     = $set_equpment->CPAY_SET_STERILE_QUANTITY;
            $cpay_production_save->AFTER_SET_STERILE_QUANTITY      = $set_equpment->CPAY_SET_STERILE_QUANTITY + $PRODUCTION_QUANTITY[$key];
            $cpay_production_save->CPAY_MACH_ID                    = $CPAY_MACH_ID[$key];
            $cpay_production_save->PRODUCTION_AROUND               = $PRODUCTION_AROUND[$key];
            $cpay_production_save->CPAY_SET_STERILE_DAY            = $set_equpment->CPAY_SET_STERILE_DAY;
            $cpay_production_save->PRODUCTION_DATE                 = $PRODUCTION_DATE;
            $cpay_production_save->PRODUCTION_TIME                 = $PRODUCTION_TIME;
            $cpay_production_save->EXPIRATION_DATE                 = $EXPIRATION_DATE;
            $cpay_production_save->EXPIRATION_TIME                 = $PRODUCTION_TIME;
            $cpay_production_save->save();
            //อัพเดตจำนวนชุดอุปกรณ์
            $set_equpment->CPAY_SET_NOT_STERILE_QUANTITY -= $PRODUCTION_QUANTITY[$key];
            $set_equpment->CPAY_SET_STERILE_QUANTITY += $PRODUCTION_QUANTITY[$key];
            $set_equpment->save();

            $forptint_r[] = cpay_production::select('cpay_production.*','cpay_setequpment.CPAY_SET_HAVE_LIST','cpay_typemachine.CPAY_TYPEMACH_NAME','cpay_department_sub_sub.DEP_CODE','cpay_machine.CPAY_MACH_NAME_INSIDE','cpay_machine.CPAY_MACH_NUMBER')
                            ->where('cpay_production.PRODUCT_ID',$cpay_production_save->PRODUCT_ID)
                            ->leftJoin('cpay_setequpment','cpay_setequpment.CPAY_SET_ID','cpay_production.CPAY_SET_ID')
                            ->leftJoin('cpay_machine','cpay_machine.CPAY_MACH_ID','cpay_production.CPAY_MACH_ID')
                            ->leftJoin('cpay_typemachine','cpay_typemachine.CPAY_TYPEMACH_ID','cpay_machine.CPAY_TYPEMACH_ID')
                            ->leftJoin('cpay_department_sub_sub','cpay_department_sub_sub.CPAY_DEP_ID','cpay_production.CPAY_DEP_ID')
                            ->first();
        }
        $data['production_prints'] = $forptint_r;
        $info_org                        = DB::table('info_org')->first();
        $data['hostpital_name']          = (!empty($info_org))?$info_org->ORG_INITIALS:'';
        session(['scc' => 'บันทึกข้อมูลสำเร็จ']);
        return view('manager_mpay.mpay_service_stickerprint_prints', $data);
    }

    public function mpay_service_stickerprint_cancel($product_id)
    {
        //อัพเดตสถานะยกเลิก
        $person         = Person::find(Auth::user()->PERSON_ID);
        $product_update = cpay_production::find($product_id);
        //เช็คสถานะยกเลิก ป้องกันยกเลิกซ้ำ
        if ($product_update->IS_CANCEL) {
            session::flash('err', 'รายการนี้ทำการยกเลิกแล้ว ไม่สามารถยกเลิกซ้ำได้');
            return redirect(route('mpay.mpay_service_stickerprint'));
        }
        //เช็คว่ามีการจำหน่ายออกหรือยัง
        if ($product_update->PRODUCTION_QUANTITY !== $product_update->PRODUCTION_QUANTITY_BALANCE) {
            session::flash('err', 'รายการนี้ไม่สามารถยกเลิกได้ เนื่องจากมีการจ่ายออกแล้ว');
            return redirect(route('mpay.mpay_service_stickerprint'));
        }
        $product_update->IS_CANCEL            = true;
        $product_update->PRODUCTION_CANCEL_BY = $person->HR_FNAME;
        $product_update->save();

        //คืนค่าจำนวนเพิ่มลดของชุดอุปกรณ์
        $cpay_setequpment_update = cpay_setequpment::find($product_update->CPAY_SET_ID);
        $cpay_setequpment_update->CPAY_SET_NOT_STERILE_QUANTITY += $product_update->PRODUCTION_QUANTITY;
        $cpay_setequpment_update->CPAY_SET_STERILE_QUANTITY -= $product_update->PRODUCTION_QUANTITY;
        $cpay_setequpment_update->save();
        session::flash('scc', 'ยกเลิกข้อมูลสำเร็จ');
        return redirect(route('mpay.mpay_service_stickerprint'));
    }

    // ________________________________________________ end service sticker print ___________________

    // ___ service export ___________________
    public function mpay_service_export(Request $request)
    {
        if ($request->method() === 'POST') {
            $export_date_start = CheckDatethaiParse($request->export_date_start);
            $export_date_end   = CheckDatethaiParse($request->export_date_end);
            session([
                'manager_mpay.mpay_service_export.export_date_start' => $export_date_start,
                'manager_mpay.mpay_service_export.export_date_end'   => $export_date_end
            ]);
        } elseif (session::has('manager_mpay.mpay_service_export')) {
            $export_date_start = session('manager_mpay.mpay_service_export.export_date_start');
            $export_date_end   = session('manager_mpay.mpay_service_export.export_date_end');

        } else {
            $export_date_start = date('Y-m-01');
            $export_date_end   = date('Y-m-d', strtotime(date('Y-m-1') . ' +1month -1day'));
        }
        $data['export_date_start'] = $export_date_start;
        $data['export_date_end']   = $export_date_end;
        $data['cpay_export']       = cpay_export::whereBetween('EXPORT_DATE', [$export_date_start, $export_date_end])
            ->orderBydesc('created_at')->get();
        $data['timecheck'] = strtotime('-10minute');
        return view('manager_mpay.mpay_service_export_view', $data);
    }

    public function ajax_mpay_service_export_detail(Request $request)
    {
        $export_list = cpay_export_list::leftJoin('cpay_export', 'cpay_export.EXPORT_ID', 'cpay_export_list.EXPORT_ID')
            ->where('cpay_export_list.EXPORT_ID', $request->export_id)->get();
        $status         = false;
        $number         = 1;
        $dep_send_to    = '';
        $person_send_to = '';
        $person_sender  = '';
        $date_export    = '';
        $html           = '';
        foreach ($export_list as $row) {
            if ($number == 1) {
                $status         = true;
                $dep_send_to    = $row->SEND_TO_DEP_SUB_SUB_NAME;
                $person_send_to = $row->SEND_TO_PERSON_NAME;
                $person_sender  = $row->SENDER_PERSON_NAME;
                $date_export    = $row->EXPORT_DATE . ' ' . $row->EXPORT_TIME;
            }
            $html .= '<tr>';
            $html .= '<td class="text-center">' . $number++ . '</td>';
            $html .= '<td>' . $row->CPAY_SET_NAME . '</td>';
            $html .= '<td class="text-center">' . $row->SEND_TO_QUANTITY . '</td>';
            $html .= '<td>' . $row->PRODUCT_BARCODE . '</td>';
            $html .= '</tr>';
        }
        return json_encode_u(array(
            'status'         => $status,
            'dep_send_to'    => $dep_send_to,
            'person_send_to' => $person_send_to,
            'person_sender'  => $person_sender,
            'date_export'    => $date_export,
            'msg'            => $html
        ));
    }

    public function mpay_service_export_cancel($export_id)
    {
        $cpay_export = cpay_export::find($export_id);
        if ($cpay_export->IS_CANCEL) {
            session::flash('err', 'ไม่สามารถยกเลิกได้ เนื่องจากรายการดังกล่าวถูกยกเลิกแล้ว');
            return redirect(route('mpay.mpay_service_export'));
        }
        $person                        = Person::find(Auth::user()->PERSON_ID);
        $cpay_export->IS_CANCEL        = true;
        $cpay_export->EXPORT_CANCEL_BY = $person->HR_FNAME;
        $cpay_export->save();
        $cpay_export_list = cpay_export_list::where('EXPORT_ID', $cpay_export->EXPORT_ID)->get();
        foreach ($cpay_export_list as $row) {
            //อัพเดตยอด การผลิต
            $cpay_production = cpay_production::find($row->PRODUCT_ID);
            $cpay_production->PRODUCTION_QUANTITY_BALANCE += $row->SEND_TO_QUANTITY;
            $cpay_production->save();

            //อัพเดตยอด คลังหลัก
            $setequpment = cpay_setequpment::find($row->CPAY_SET_ID);
            $setequpment->CPAY_SET_STERILE_QUANTITY += $row->SEND_TO_QUANTITY;
            $setequpment->save();

            //อัพเดตยอด โควต้าคงเหลือ
            $quota = cpay_department_sub_sub_quota::where('CPAY_SET_ID', $row->CPAY_SET_ID)->where('CPAY_DEP_ID', $cpay_export->SEND_TO_DEP_SUB_SUB_ID)->first();
            $quota->DEP_QUOTA_BALANCE -= $SEND_TO_QUANTITY;
            $quota->save();
        }

        session::flash('scc', 'ยกเลิกรายการจ่ายออกสำเร็จ');
        return redirect(route('mpay.mpay_service_export'));
    }

    public function mpay_service_export_add()
    {
        $data['departments']    = cpay_department_sub_sub::where('ACTIVE', true)->get();
        $data['dep_id_cpay']    = Web_meta_data_Controller::getValueByName('CPAY_DEFAULT_DEPARTMENT_SUB_SUB_ID');
        $data['person_send_to'] = DB::table('hrd_person')->select('ID', 'HR_FNAME', 'HR_LNAME')->where('HR_STATUS_ID', 1)->get();
        $data['person_sender']  = DB::table('hrd_person')->select('ID', 'HR_FNAME', 'HR_LNAME')
            ->where('HR_DEPARTMENT_SUB_SUB_ID', $data['dep_id_cpay'])
            ->where('HR_STATUS_ID', 1)->get();
        $data['stock'] = cpay_production::select('cpay_production.*', 'cpay_unit.CPAY_UNIT_NAME'
            , 'cpay_setequpment.CPAY_SET_NAME_INSIDE', 'cpay_department_sub_sub.CPAY_DEP_NAME_INSIDE')
            ->where('PRODUCTION_QUANTITY_BALANCE', '!=', 0)
            ->where('IS_CANCEL', '!=', true)
            ->leftJoin('cpay_department_sub_sub', 'cpay_department_sub_sub.CPAY_DEP_ID', 'cpay_production.CPAY_DEP_ID')
            ->leftJoin('cpay_setequpment', 'cpay_setequpment.CPAY_SET_ID', 'cpay_production.CPAY_SET_ID')
            ->leftJoin('cpay_unit', 'cpay_unit.CPAY_UNIT_ID', 'cpay_setequpment.CPAY_UNIT_ID')
            ->get();
        return view('manager_mpay.mpay_service_export_add', $data);
    }

    public function export_update_list(Request $request)
    {
        $stock = cpay_production::select('cpay_production.*', 'cpay_unit.CPAY_UNIT_NAME'
            , 'cpay_setequpment.CPAY_SET_NAME_INSIDE', 'cpay_department_sub_sub.CPAY_DEP_NAME_INSIDE')
            ->where('PRODUCTION_QUANTITY_BALANCE', '!=', 0)
            ->where('IS_CANCEL', '!=', true)
            ->where('cpay_department_sub_sub_quota.CPAY_DEP_ID', $request->department_id)
            ->leftJoin('cpay_department_sub_sub_quota', 'cpay_department_sub_sub_quota.CPAY_SET_ID', 'cpay_production.CPAY_SET_ID')
            ->leftJoin('cpay_department_sub_sub', 'cpay_department_sub_sub.CPAY_DEP_ID', 'cpay_production.CPAY_DEP_ID')
            ->leftJoin('cpay_setequpment', 'cpay_setequpment.CPAY_SET_ID', 'cpay_production.CPAY_SET_ID')
            ->leftJoin('cpay_unit', 'cpay_unit.CPAY_UNIT_ID', 'cpay_setequpment.CPAY_UNIT_ID')
            ->get();
        $html = '';
        foreach ($stock as $row) {
            $html .= '<tr style="cursor:pointer" onclick="add_list_export(' . $row->PRODUCT_BARCODE . ')">';
            $html .= '<td width="10%">' . $row->PRODUCT_BARCODE . '</td>';
            $html .= '<td width="15%">[' . $row->CPAY_SET_ID . '] ' . $row->CPAY_SET_NAME_INSIDE . '</td>';
            $html .= '<td width="15%">' . $row->CPAY_DEP_NAME_INSIDE . '</td>';
            $html .= '<td width="10%" class="text-center">' . $row->PRODUCTION_AROUND . '</td>';
            $html .= '<td width="10%" style="background-color:#edffed">' . $row->PRODUCTION_DATE . ' ' . $row->PRODUCTION_TIME . '</td>';
            $html .= '<td width="10%" style="background-color:#ffefef">' . $row->EXPIRATION_DATE . ' ' . $row->EXPIRATION_TIME . '</td>';
            $html .= '<td width="5%" class="text-center">' . $row->CPAY_SET_STERILE_DAY . '</td>';
            $html .= '<td width="10%" class="text-center">' . $row->PRODUCTION_QUANTITY . '</td>';
            $html .= '<td width="10%" class="text-center bg-sl2-g1">' . $row->PRODUCTION_QUANTITY_BALANCE . '</td>';
            $html .= '<td width="5%" class="text-center">' . $row->CPAY_UNIT_NAME . '</td>';
            $html .= '</tr>';
        }
        echo $html;
    }

    public function add_list_export(Request $request)
    {
        $product = cpay_production::select('cpay_production.*', 'cpay_unit.CPAY_UNIT_NAME'
            , 'cpay_setequpment.CPAY_SET_NAME_INSIDE', 'cpay_department_sub_sub.CPAY_DEP_NAME_INSIDE')
            ->where('PRODUCTION_QUANTITY_BALANCE', '!=', 0)
            ->where('cpay_production.PRODUCT_BARCODE', $request->barcode)
            ->where('cpay_department_sub_sub_quota.CPAY_DEP_ID', $request->department_id)
            ->leftJoin('cpay_department_sub_sub_quota', 'cpay_department_sub_sub_quota.CPAY_SET_ID', 'cpay_production.CPAY_SET_ID')
            ->leftJoin('cpay_department_sub_sub', 'cpay_department_sub_sub.CPAY_DEP_ID', 'cpay_production.CPAY_DEP_ID')
            ->leftJoin('cpay_setequpment', 'cpay_setequpment.CPAY_SET_ID', 'cpay_production.CPAY_SET_ID')
            ->leftJoin('cpay_unit', 'cpay_unit.CPAY_UNIT_ID', 'cpay_setequpment.CPAY_UNIT_ID')
            ->first();
        $status          = 'error';
        $html            = '';
        $data_production = '';
        $barcode         = $request->barcode;
        if ($product) {
            //เพิ่มข้อมูลลง row ของ table
            $status          = 'success';
            $data_production = json_encode_u(array(
                'CPAY_SET_ID'     => $product->CPAY_SET_ID,
                'CPAY_SET_NAME'   => $product->CPAY_SET_NAME,
                'PRODUCT_ID'      => $product->PRODUCT_ID,
                'PRODUCT_BARCODE' => $product->PRODUCT_BARCODE,
                'SEND_TO_PRICE'   => $product->PRODUCTION_PRICE
            ));
            $html .= '<tr class="product_row" data-product_barcode=' . "'" . $product->PRODUCT_BARCODE . "'" . '>';
            $html .= '<td width="20%"><input name="data_production[]" type="hidden" value=' . "'" . $data_production . "'" . '>' . $product->PRODUCT_BARCODE . '</td>';
            $html .= '<td width="35%">' . $product->CPAY_SET_NAME . '</td>';
            $html .= '<td width="10%"><input min="1" max="' . $product->PRODUCTION_QUANTITY_BALANCE . '" value="' . $product->PRODUCTION_QUANTITY_BALANCE . '" class="form-control" type="number" name="SEND_TO_QUANTITY[]"></td>';
            $html .= '<td width="25%">' . $product->CPAY_DEP_NAME . '</td>';
            $html .= '<td width="10%" class="text-center"><span style="cursor:pointer" class="remove btn btn-sm btn-danger"><i class="fa fa-times"></i></span></td>';
            $html .= '</tr>';
        } else {
            $status = 'error';
            $html   = 'ไม่พบบาร์โค้ดชุดอุปกรณ์ที่พร้อมใช้';
        }
        $result = json_encode_u(array('status' => $status, 'msg' => $html, 'barcode' => $barcode));
        echo $result;
    }

    public function mpay_service_export_save(Request $request)
    {
        $SEND_TO_DEP_SUB_SUB                   = json_decode($request->SEND_TO_DEP_SUB_SUB_ID);
        $SEND_TO_PERSON                        = json_decode($request->SEND_TO_PERSON_ID);
        $SENDER_PERSON                         = json_decode($request->SENDER_PERSON_ID);
        $cpay_export                           = new cpay_export();
        $cpay_export->SEND_TO_DEP_SUB_SUB_ID   = $SEND_TO_DEP_SUB_SUB->dep_id;
        $cpay_export->SEND_TO_DEP_SUB_SUB_NAME = $SEND_TO_DEP_SUB_SUB->dep_name;
        $cpay_export->SEND_TO_PERSON_ID        = $SEND_TO_PERSON->person_id;
        $cpay_export->SEND_TO_PERSON_NAME      = $SEND_TO_PERSON->person_fname;
        $cpay_export->SENDER_PERSON_ID         = $SENDER_PERSON->person_id;
        $cpay_export->SENDER_PERSON_NAME       = $SENDER_PERSON->person_fname;
        $cpay_export->EXPORT_DATE              = CheckDatethaiParse($request->EXPORT_DATE);
        $cpay_export->EXPORT_TIME              = $request->EXPORT_TIME;
        $cpay_export->EXPORT_DETAIL            = $request->EXPORT_DETAIL;
        $cpay_export->save();
        $product_list = $request->data_production;
        foreach ($product_list as $key => $row) {
            $data_product                                  = json_decode($row);
            $SEND_TO_QUANTITY                              = $request->SEND_TO_QUANTITY[$key];
            $setequpment                                   = cpay_setequpment::find($data_product->CPAY_SET_ID);
            $cpay_export_list                              = new cpay_export_list();
            $cpay_export_list->EXPORT_ID                   = $cpay_export->EXPORT_ID;
            $cpay_export_list->CPAY_SET_ID                 = $data_product->CPAY_SET_ID;
            $cpay_export_list->CPAY_SET_NAME               = $data_product->CPAY_SET_NAME;
            $cpay_export_list->PRODUCT_ID                  = $data_product->PRODUCT_ID;
            $cpay_export_list->PRODUCT_BARCODE             = $data_product->PRODUCT_BARCODE;
            $cpay_export_list->SEND_TO_QUANTITY            = $SEND_TO_QUANTITY;
            $cpay_export_list->SEND_TO_PRICE               = $data_product->SEND_TO_PRICE;
            $cpay_export_list->SEND_TO_VALUE               = $data_product->SEND_TO_PRICE * $SEND_TO_QUANTITY;
            $cpay_export_list->BEFORE_SET_STERILE_QUANTITY = $setequpment->CPAY_SET_STERILE_QUANTITY;
            $cpay_export_list->AFTER_SET_STERILE_QUANTITY  = $setequpment->CPAY_SET_STERILE_QUANTITY - $SEND_TO_QUANTITY;
            $cpay_export_list->save();

            //อัพเดตยอด การผลิต
            $cpay_production = cpay_production::find($data_product->PRODUCT_ID);
            $cpay_production->PRODUCTION_QUANTITY_BALANCE -= $SEND_TO_QUANTITY;
            $cpay_production->save();

            //อัพเดตยอด คลังหลัก
            $setequpment->CPAY_SET_STERILE_QUANTITY -= $SEND_TO_QUANTITY;
            $setequpment->save();

            //อัพเดตยอด โควต้าคงเหลือ
            $quota = cpay_department_sub_sub_quota::where('CPAY_SET_ID', $data_product->CPAY_SET_ID)->where('CPAY_DEP_ID', $SEND_TO_DEP_SUB_SUB->dep_id)->first();
            $quota->DEP_QUOTA_BALANCE += $SEND_TO_QUANTITY;
            $quota->save();
        }
        session::flash('scc_notify', 'บันทึกข้อมูลสำเร็จ');
        return redirect(route('mpay.mpay_service_export_add'));

    }

    // ________________________________________________ end service export ___________________

    // ___ service defective ___________________
    public function mpay_service_defective(Request $request)
    {
        if ($request->method() === 'POST') {
            $defective_date_start = CheckDatethaiParse($request->defective_date_start);
            $defective_date_end   = CheckDatethaiParse($request->defective_date_end);
            session([
                'manager_mpay.mpay_service_defective.defective_date_start' => $defective_date_start,
                'manager_mpay.mpay_service_defective.defective_date_end'   => $defective_date_end
            ]);
        } elseif (Session::has('manager_mpay.mpay_service_defective')) {
            $defective_date_start = session('manager_mpay.mpay_service_defective.defective_date_start');
            $defective_date_end   = session('manager_mpay.mpay_service_defective.defective_date_end');
        } else {
            $defective_date_start = date('Y-m-01');
            $defective_date_end   = date('Y-m-d', strtotime(date('Y-m-1') . ' +1month -1day'));
        }

        $cpay_defective_q = Cpay_defective::whereBetween('DEFECTIVE_DATE', [$defective_date_start, $defective_date_end])
            ->orderByDesc('created_at');
        $data['cpay_defective']       = $cpay_defective_q->get();
        $data['timecheck']            = strtotime('-10minute');
        $data['defective_date_start'] = $defective_date_start;
        $data['defective_date_end']   = $defective_date_end;
        return view('manager_mpay.mpay_service_defective_view', $data);
    }

    public function ajax_mpay_service_defective_detail(Request $request)
    {
        $defective_list = cpay_defective_list::select('cpay_defective_list.*', 'cpay_defective.*', 'cpay_defective_status.DEFECTIVE_STATUS_NAME', 'cpay_setequpment.CPAY_SET_NAME_INSIDE')
            ->leftJoin('cpay_defective', 'cpay_defective.DEFECTIVE_ID', 'cpay_defective_list.DEFECTIVE_ID')
            ->leftJoin('cpay_defective_status', 'cpay_defective_status.DEFECTIVE_STATUS_ID', 'cpay_defective_list.DEFECTIVE_STATUS_ID')
            ->leftJoin('cpay_setequpment', 'cpay_setequpment.CPAY_SET_ID', 'cpay_defective_list.CPAY_SET_ID')
            ->where('cpay_defective_list.DEFECTIVE_ID', $request->defective_id)->get();
        $status           = false;
        $number           = 1;
        $person_destroyer = '';
        $date_defective   = '';
        $html             = '';
        foreach ($defective_list as $row) {
            if ($number == 1) {
                $status           = true;
                $person_destroyer = $row->DESTROYER_PERSON_NAME;
                $date_defective   = $row->DEFECTIVE_DATE . ' ' . $row->DEFECTIVE_TIME;
            }
            $html .= '<tr>';
            $html .= '<td class="text-center">' . $number++ . '</td>';
            $html .= '<td>' . $row->CPAY_SET_NAME_INSIDE . '</td>';
            $html .= '<td class="text-center">' . $row->DEFECTIVE_QUANTITY . '</td>';
            $html .= '<td>' . $row->PRODUCT_BARCODE . '</td>';
            $html .= '<td class="text-center">' . $row->DEFECTIVE_STATUS_NAME . '</td>';
            $html .= '<td class="text-center">' . $row->DEFECTIVE_DETAIL . '</td>';
            $html .= '</tr>';
        }
        return json_encode_u(array(
            'status'           => $status,
            'person_destroyer' => $person_destroyer,
            'date_defective'   => $date_defective,
            'msg'              => $html
        ));
    }

    public function mpay_service_defective_add()
    {
        $cpay_depart_id = web_meta_data_Controller::getvalueByname('CPAY_DEFAULT_DEPARTMENT_SUB_SUB_ID');
        $destroyer      = DB::table('hrd_person')->select('ID', 'HR_FNAME', 'HR_LNAME')
            ->where('HR_DEPARTMENT_SUB_SUB_ID', $cpay_depart_id)->where('HR_STATUS_ID', 1)->get();
        $defective_status = cpay_defective_status::all();
        $stock            = cpay_production::select('cpay_production.*', 'cpay_unit.CPAY_UNIT_NAME'
            , 'cpay_setequpment.CPAY_SET_NAME_INSIDE', 'cpay_department_sub_sub.CPAY_DEP_NAME_INSIDE')
            ->where('PRODUCTION_QUANTITY_BALANCE', '!=', 0)
            ->where('IS_CANCEL', '!=', true)
            ->leftJoin('cpay_department_sub_sub', 'cpay_department_sub_sub.CPAY_DEP_ID', 'cpay_production.CPAY_DEP_ID')
            ->leftJoin('cpay_setequpment', 'cpay_setequpment.CPAY_SET_ID', 'cpay_production.CPAY_SET_ID')
            ->leftJoin('cpay_unit', 'cpay_unit.CPAY_UNIT_ID', 'cpay_setequpment.CPAY_UNIT_ID')
            ->get();
        return view('manager_mpay.mpay_service_defective_add', compact(
            'destroyer', 'defective_status', 'stock'
        ));
    }

    public function mpay_service_defective_save(Request $request)
    {
        $DESTROYER_PERSON                      = json_decode($request->DESTROYER_PERSON);
        $cpay_defective                        = new cpay_defective();
        $cpay_defective->DESTROYER_PERSON_ID   = $DESTROYER_PERSON->DESTROYER_PERSON_ID;
        $cpay_defective->DESTROYER_PERSON_NAME = $DESTROYER_PERSON->DESTROYER_PERSON_NAME;
        $cpay_defective->DEFECTIVE_DATE        = CheckDatethaiParse($request->DEFECTIVE_DATE);
        $cpay_defective->DEFECTIVE_TIME        = $request->DEFECTIVE_TIME;
        $cpay_defective->DEFECTIVE_DETAILS     = $request->DEFECTIVE_DETAILS;
        $cpay_defective->save();

        $product_id_list     = $request->PRODUCT_ID;
        $DEFECTIVE_QUANTITY  = $request->DEFECTIVE_QUANTITY;
        $DEFECTIVE_STATUS_ID = $request->DEFECTIVE_STATUS_ID;
        $DEFECTIVE_DETAIL    = $request->DEFECTIVE_DETAIL;
        foreach ($product_id_list as $key => $product_id) {
            $product                                          = cpay_production::find($product_id);
            $setequpment                                      = cpay_setequpment::find($product->CPAY_SET_ID);
            $cpay_defective_list                              = new cpay_defective_list();
            $cpay_defective_list->DEFECTIVE_ID                = $cpay_defective->DEFECTIVE_ID;
            $cpay_defective_list->CPAY_SET_ID                 = $product->CPAY_SET_ID;
            $cpay_defective_list->CPAY_SET_NAME               = $product->CPAY_SET_NAME;
            $cpay_defective_list->PRODUCT_ID                  = $product->PRODUCT_ID;
            $cpay_defective_list->PRODUCT_BARCODE             = $product->PRODUCT_BARCODE;
            $cpay_defective_list->DEFECTIVE_QUANTITY          = $DEFECTIVE_QUANTITY[$key];
            $cpay_defective_list->DEFECTIVE_PRICE             = $product->PRODUCTION_PRICE;
            $cpay_defective_list->DEFECTIVE_VALUE             = $DEFECTIVE_QUANTITY[$key] * $product->PRODUCTION_PRICE;
            $cpay_defective_list->BEFORE_SET_STERILE_QUANTITY = $setequpment->CPAY_SET_STERILE_QUANTITY;
            $cpay_defective_list->AFTER_SET_STERILE_QUANTITY  = $setequpment->CPAY_SET_STERILE_QUANTITY - $DEFECTIVE_QUANTITY[$key];
            $cpay_defective_list->DEFECTIVE_STATUS_ID         = $DEFECTIVE_STATUS_ID[$key];
            $cpay_defective_list->DEFECTIVE_DETAIL            = $DEFECTIVE_DETAIL[$key];
            $cpay_defective_list->save();

            //อัพเดตยอด การผลิต
            $product->PRODUCTION_QUANTITY_BALANCE -= $DEFECTIVE_QUANTITY[$key];
            $product->save();

            //อัพเดตยอด คลังหลัก
            $setequpment->CPAY_SET_STERILE_QUANTITY -= $DEFECTIVE_QUANTITY[$key];
            $setequpment->save();
        }
        session::flash('scc', 'บันทึกข้อมูลสำเร็จ');
        return redirect(route('mpay.mpay_service_defective'));
    }

    public function mpay_service_defective_cancel($defective_id)
    {
        $cpay_defective = cpay_defective::find($defective_id);
        if ($cpay_defective->IS_CANCEL) {
            session::flash('err', 'ไม่สามารถยกเลิกได้ เนื่องจากรายการดังกล่าวถูกยกเลิกแล้ว');
            return redirect(route('mpay.mpay_service_defective'));
        }
        $person                              = Person::find(Auth::user()->PERSON_ID);
        $cpay_defective->IS_CANCEL           = true;
        $cpay_defective->DEFECTIVE_CANCEL_BY = $person->HR_FNAME;
        $cpay_defective->save();
        $cpay_defective_list = cpay_defective_list::where('DEFECTIVE_ID', $cpay_defective->DEFECTIVE_ID)->get();
        foreach ($cpay_defective_list as $row) {
            //อัพเดตยอด การผลิต
            $cpay_production = cpay_production::find($row->PRODUCT_ID);
            $cpay_production->PRODUCTION_QUANTITY_BALANCE += $row->DEFECTIVE_QUANTITY;
            $cpay_production->save();

            //อัพเดตยอด คลังหลัก
            $setequpment = cpay_setequpment::find($row->CPAY_SET_ID);
            $setequpment->CPAY_SET_STERILE_QUANTITY += $row->DEFECTIVE_QUANTITY;
            $setequpment->save();
        }

        Session::flash('scc', 'ยกเลิกรายการตัดจ่ายสำเร็จ');
        return redirect(route('mpay.mpay_service_defective'));
    }

    // ________________________________________________ end service defective ___________________

    // ___ service maintenance machine ___________________
    public function mpay_maintenance_machine()
    {
        $maintenance = cpay_machine_maintenance::orderByDESC('created_at')->get();
        return view('manager_mpay.mpay_maintenance_machine_view', compact(
            'maintenance'
        ));
    }

    public function mpay_maintenance_machine_add()
    {
        $maintenance     = cpay_machine_maintenance::all();
        $machine         = cpay_machine::where('ACTIVE', true)->get();
        $cpay_depart_id  = web_meta_data_Controller::getvalueByname('CPAY_DEFAULT_DEPARTMENT_SUB_SUB_ID');
        $inside_personal = DB::table('hrd_person')->select('ID', 'HR_FNAME', 'HR_LNAME')
            ->where('HR_DEPARTMENT_SUB_SUB_ID', $cpay_depart_id)->where('HR_STATUS_ID', 1)->get();
        return view('manager_mpay.mpay_maintenance_machine_add', compact(
            'maintenance', 'machine', 'inside_personal'
        ));
    }

    public function mpay_maintenance_machine_save(Request $request)
    {
        $CPAY_MACH                               = json_decode($request->CPAY_MACH);
        $CHECK_PERSON                            = json_decode($request->CHECK_PERSON);
        $CHECK_MACHINE_PERSON                    = json_decode($request->CHECK_MACHINE_PERSON);
        $mmaintenance                            = new cpay_machine_maintenance();
        $mmaintenance->CPAY_MACH_ID              = $CPAY_MACH->CPAY_MACH_ID;
        $mmaintenance->CPAY_MACH_NAME            = $CPAY_MACH->CPAY_MACH_NAME;
        $mmaintenance->CHECK_PERSON_ID           = $CHECK_PERSON->person_id;
        $mmaintenance->CHECK_PERSON_NAME         = $CHECK_PERSON->person_fname;
        $mmaintenance->CHECK_MACHINE_PERSON_ID   = $CHECK_MACHINE_PERSON->person_id;
        $mmaintenance->CHECK_MACHINE_PERSON_NAME = $CHECK_MACHINE_PERSON->person_fname;
        $mmaintenance->MMAINTENANCE_TEST_DATE    = CheckDatethaiParse($request->MMAINTENANCE_TEST_DATE);
        $mmaintenance->MMAINTENANCE_TEST_TIME    = $request->MMAINTENANCE_TEST_TIME;
        $mmaintenance->MMAINTENANCE_RESULT       = $request->MMAINTENANCE_RESULT;
        $mmaintenance->MMAINTENANCE_DETAIL       = $request->MMAINTENANCE_DETAIL;
        $mmaintenance->save();
        session(['scc', 'บันทึกข้อมูลสำเร็จ']);
        return redirect(route('mpay.mpay_maintenance_machine'));
    }

    public function mpay_maintenance_machine_edit($maintenc_id)
    {
        $maintenance     = cpay_machine_maintenance::where('MMAINTENANCE_ID', $maintenc_id)->first();
        $machine         = cpay_machine::where('ACTIVE', true)->get();
        $cpay_depart_id  = web_meta_data_Controller::getvalueByname('CPAY_DEFAULT_DEPARTMENT_SUB_SUB_ID');
        $inside_personal = DB::table('hrd_person')->select('ID', 'HR_FNAME', 'HR_LNAME')
            ->where('HR_DEPARTMENT_SUB_SUB_ID', $cpay_depart_id)->where('HR_STATUS_ID', 1)->get();
        return view('manager_mpay.mpay_maintenance_machine_edit', compact(
            'maintenance', 'machine', 'inside_personal'
        ));
    }

    public function mpay_maintenance_machine_update(Request $request)
    {
        $CPAY_MACH                               = json_decode($request->CPAY_MACH);
        $CHECK_PERSON                            = json_decode($request->CHECK_PERSON);
        $CHECK_MACHINE_PERSON                    = json_decode($request->CHECK_MACHINE_PERSON);
        $mmaintenance                            = cpay_machine_maintenance::find($request->MMAINTENANCE_ID);
        $mmaintenance->CPAY_MACH_ID              = $CPAY_MACH->CPAY_MACH_ID;
        $mmaintenance->CPAY_MACH_NAME            = $CPAY_MACH->CPAY_MACH_NAME;
        $mmaintenance->CHECK_PERSON_ID           = $CHECK_PERSON->person_id;
        $mmaintenance->CHECK_PERSON_NAME         = $CHECK_PERSON->person_fname;
        $mmaintenance->CHECK_MACHINE_PERSON_ID   = $CHECK_MACHINE_PERSON->person_id;
        $mmaintenance->CHECK_MACHINE_PERSON_NAME = $CHECK_MACHINE_PERSON->person_fname;
        $mmaintenance->MMAINTENANCE_TEST_DATE    = CheckDatethaiParse($request->MMAINTENANCE_TEST_DATE);
        $mmaintenance->MMAINTENANCE_TEST_TIME    = $request->MMAINTENANCE_TEST_TIME;
        $mmaintenance->MMAINTENANCE_RESULT       = $request->MMAINTENANCE_RESULT;
        $mmaintenance->MMAINTENANCE_DETAIL       = $request->MMAINTENANCE_DETAIL;
        $mmaintenance->save();
        session(['scc', 'แก้ไขข้อมูลสำเร็จ']);
        return redirect(route('mpay.mpay_maintenance_machine'));
    }

    public function mpay_maintenance_machine_delete($maintenc_id)
    {
        cpay_machine_maintenance::destroy($maintenc_id);
        session(['scc', 'ลบข้อมูลสำเร็จ']);
        return redirect(route('mpay.mpay_maintenance_machine'));
    }

    // ________________________________________________ end service maintenance machine ___________________

    // --------------------------------- show ------------------------------------
    // ___ show quota ___________________
    public function mpay_show_quota(Request $request)
    {
        $dep_id         = (!empty($request->dep_id))?$request->dep_id:'';

        $data['dep_list']   = cpay_department_sub_sub::where('ACTIVE',true)->get();
        $query              = cpay_department_sub_sub_quota::where('cpay_department_sub_sub_quota.ACTIVE',true)
                            ->leftJoin('cpay_department_sub_sub','cpay_department_sub_sub.CPAY_DEP_ID','cpay_department_sub_sub_quota.CPAY_DEP_ID')
                            ->leftJoin('cpay_setequpment','cpay_setequpment.CPAY_SET_ID','cpay_department_sub_sub_quota.CPAY_SET_ID');
        if($dep_id !== ''){
            $query->where('cpay_department_sub_sub_quota.CPAY_DEP_ID',$dep_id);
        }
        $data['dep_quota']  = $query->get();
        return view('manager_mpay.mpay_show_quota_view',$data);
    }
    // ________________________________________________ end show quota ___________________

    // --------------------------------- settings ------------------------------------

    // ___ setting printer and stickers ___________________
    public function mpay_setting_defaultsticker()
    {
        $stickerbig     = cpay_print_sticker::where('CAPY_STICK_FOR_LIST',true)->where('ACTIVE',true)->orderByDesc('updated_at')->first();
        $stickersmall   = cpay_print_sticker::where('CAPY_STICK_FOR_LIST',false)->where('ACTIVE',true)->orderByDesc('updated_at')->first();
        $stickers = Cpay_print_sticker::orderby('updated_at', 'DESC')->get();
        return view('manager_mpay.mpay_setting_defaultsticker_view', compact('stickers','stickerbig','stickersmall'));
    }

   // ทดสอบปริ้น
   public function test_print()
   {
       return view('manager_mpay.mpay_setting_defaultsticker_print_test');
   }

    public function mpay_setting_defaultsticker_example($sticker_id)
    {
        $sticker = cpay_print_sticker::find($sticker_id);
        return view('manager_mpay.mpay_setting_defaultsticker_example',compact('sticker'));
    }
    public function ajax_mpay_setting_defaultsticker_updateopen(Request $request)
    {
        $onoff = $request->onoff;
        $id    = $request->id;
        if ($onoff === 'true') {
            $onoff = true;
        } else {
            $onoff = false;
        }

        $person                  = Person::find(Auth::user()->PERSON_ID);
        $updatestick             = Cpay_print_sticker::find($id);
        $updatestick->ACTIVE     = $onoff;
        $updatestick->UPDATED_BY = $person->HR_FNAME;
        $updatestick->save();
        echo $updatestick->ACTIVE;
    }
    public function mpay_setting_defaultsticker_add(){
        return view('manager_mpay.mpay_setting_defaultsticker_add');
    } 
    public function mpay_setting_defaultsticker_save(Request $request){
        $person                  = Person::find(Auth::user()->PERSON_ID);
        $sticker = new cpay_print_sticker();
        $sticker->CAPY_STICK_NAME               = $request->CAPY_STICK_NAME;
        $sticker->CAPY_STICK_WIDTH              = $request->CAPY_STICK_WIDTH;
        $sticker->CAPY_STICK_HEIGHT             = $request->CAPY_STICK_HEIGHT;
        $sticker->CAPY_STICK_HTML_FORMAT        = $request->CAPY_STICK_HTML_FORMAT;
        $sticker->CPAY_STICKER_HTML_FORMAT_LIST = $request->CPAY_STICKER_HTML_FORMAT_LIST;
        $sticker->CAPY_STICK_BRAND_PRINTER      = $request->CAPY_STICK_BRAND_PRINTER;
        $sticker->CAPY_STICK_MODEL_PRINTER      = $request->CAPY_STICK_MODEL_PRINTER;
        $sticker->CAPY_STICK_FOR_LIST           = (empty($request->CAPY_STICK_FOR_LIST))?0:1;
        $sticker->CAPY_STICK_DETAIL             = $request->CAPY_STICK_DETAIL;
        $sticker->UPDATED_BY                    = $person->HR_FNAME;
        $sticker->save();
        session::flash('scc','บันทึกข้อมูลสำเร็จ');
        return redirect(route('mpay.mpay_setting_defaultsticker'));
    } 
    public function mpay_setting_defaultsticker_edit($id){
        $sticker    = cpay_print_sticker::find($id);
        if(empty($sticker)){
            session::flash('err','ไม่พบข้อมูล');
            return redirect(route('mpay.mpay_setting_defaultsticker'));
        }
        return view('manager_mpay.mpay_setting_defaultsticker_edit',compact('sticker'));
    } 
    public function mpay_setting_defaultsticker_update(Request $request){
        $person                  = Person::find(Auth::user()->PERSON_ID);
        $sticker = cpay_print_sticker::find($request->CAPY_STICK_ID);
        $sticker->CAPY_STICK_NAME               = $request->CAPY_STICK_NAME;
        $sticker->CAPY_STICK_WIDTH              = $request->CAPY_STICK_WIDTH;
        $sticker->CAPY_STICK_HEIGHT             = $request->CAPY_STICK_HEIGHT;
        $sticker->CAPY_STICK_HTML_FORMAT        = $request->CAPY_STICK_HTML_FORMAT;
        $sticker->CPAY_STICKER_HTML_FORMAT_LIST = $request->CPAY_STICKER_HTML_FORMAT_LIST;
        $sticker->CAPY_STICK_BRAND_PRINTER      = $request->CAPY_STICK_BRAND_PRINTER;
        $sticker->CAPY_STICK_MODEL_PRINTER      = $request->CAPY_STICK_MODEL_PRINTER;
        $sticker->CAPY_STICK_FOR_LIST           = (empty($request->CAPY_STICK_FOR_LIST))?0:1;
        $sticker->CAPY_STICK_DETAIL             = $request->CAPY_STICK_DETAIL;
        $sticker->UPDATED_BY                    = $person->HR_FNAME;
        $sticker->save();
        session::flash('scc','แก้ไขข้อมูลสำเร็จ');
        return redirect(route('mpay.mpay_setting_defaultsticker'));
    } 

    public function mpay_setting_defaultsticker_delete($id){
        cpay_print_sticker::destroy($id);
        session::flash('scc','ลบข้อมูลสำเร็จ');
        return redirect(route('mpay.mpay_setting_defaultsticker'));
    } 
    // ________________________________________________ end setting printer and stickers ___________________

    // ___ setting department sub sub ___________________
    public function mpay_setting_department_sub_sub()
    {
        $dep = Cpay_department_sub_sub::get();
        return view('manager_mpay.mpay_setting_department_sub_sub_view', compact('dep'));
    }

    public function mpay_setting_department_sub_sub_add()
    {
        $departments_sub_sub = DB::table('hrd_department_sub_sub')->where('ACTIVE', true)->get();
        return view('manager_mpay.mpay_setting_department_sub_sub_add', compact('departments_sub_sub'));
    }

    public function mpay_setting_department_sub_sub_save(Request $request)
    {
        $dep = Cpay_department_sub_sub::where('HR_DEPARTMENT_SUB_SUB_ID', $request->HR_DEPARTMENT_SUB_SUB_ID)->first();
        if (!$dep) {
            $person                            = Person::find(Auth::user()->PERSON_ID);
            $depsave                           = new Cpay_department_sub_sub();
            $depsave->HR_DEPARTMENT_SUB_SUB_ID = $request->HR_DEPARTMENT_SUB_SUB_ID;
            $depsave->DEP_CODE                 = $request->DEP_CODE;
            $depsave->CPAY_DEP_NAME_INSIDE     = $request->CPAY_DEP_NAME_INSIDE;
            $depsave->CPAY_DEP_NAME_TH         = $request->CPAY_DEP_NAME_TH;
            $depsave->CPAY_DEP_NAME_EN         = $request->CPAY_DEP_NAME_EN;
            $depsave->CPAY_DEP_DETAIL          = $request->CPAY_DEP_DETAIL;
            $depsave->UPDATED_BY               = $person->HR_FNAME;
            $depsave->save();
            Session::flash('scc', 'บันทึกข้อมูลสำเร็จ');
        } else {
            Session::flash('err_detail', 'ไม่สามารถบันทึกได้เนื่องจากข้อมูลหน่วยงานดังกล่าวถูกเพิ่มแล้ว||ชื่อภายใน : ' . $dep->CPAY_DEP_NAME_INSIDE . ', ' . 'อักษรย่อ : ' . $dep->DEP_CODE);
        }
        return redirect(route('mpay.mpay_setting_department_sub_sub'));
    }

    public function ajax_mpay_setting_department_sub_sub_updateopen(Request $request)
    {
        $onoff = $request->onoff;
        $id    = $request->id;
        if ($onoff === 'true') {
            $onoff = true;
        } else {
            $onoff = false;
        }
        $person                = Person::find(Auth::user()->PERSON_ID);
        $updatedep             = Cpay_department_sub_sub::find($id);
        $updatedep->UPDATED_BY = $person->HR_FNAME;
        $updatedep->ACTIVE     = $onoff;
        $updatedep->save();
        echo $updatedep->ACTIVE;
    }

    public function mpay_setting_department_sub_sub_edit($dep_subsub_id)
    {
        $dep                 = Cpay_department_sub_sub::find($dep_subsub_id);
        $departments_sub_sub = DB::table('hrd_department_sub_sub')->where('ACTIVE', true)->get();
        return view('manager_mpay.mpay_setting_department_sub_sub_edit', compact('dep', 'departments_sub_sub'));
    }

    public function mpay_setting_department_sub_sub_update(Request $request)
    {
        $person                            = Person::find(Auth::user()->PERSON_ID);
        $depsave                           = Cpay_department_sub_sub::find($request->CPAY_DEP_ID);
        $depsave->HR_DEPARTMENT_SUB_SUB_ID = $request->HR_DEPARTMENT_SUB_SUB_ID;
        $depsave->DEP_CODE                 = $request->DEP_CODE;
        $depsave->CPAY_DEP_NAME_INSIDE     = $request->CPAY_DEP_NAME_INSIDE;
        $depsave->CPAY_DEP_NAME_TH         = $request->CPAY_DEP_NAME_TH;
        $depsave->CPAY_DEP_NAME_EN         = $request->CPAY_DEP_NAME_EN;
        $depsave->CPAY_DEP_DETAIL          = $request->CPAY_DEP_DETAIL;
        $depsave->UPDATED_BY               = $person->HR_FNAME;
        $depsave->save();
        Session::flash('scc', 'แก้ไขข้อมูลสำเร็จ');
        return redirect(route('mpay.mpay_setting_department_sub_sub'));
    }

    public function mpay_setting_department_sub_sub_delete($dep_subsub_id)
    {
        // ยังไม่เสร็จ ต้องตรวจสอบการว่าใช้ในตารางไหนหรือยัง ถ้ายังไม่ให้ลบ รอตารางรับเข้า ปริ้นหรือจ่ายออก
        $count_receive = cpay_receive::where('DELIVERY_DEP_SUB_SUB_ID', $dep_subsub_id)->count();
        $count_quota   = cpay_department_sub_sub_quota::where('CPAY_DEP_ID', $dep_subsub_id)->count();
        if ($count_receive || $count_quota) {
            Session::flash('err', 'ไม่สามารถลบข้อมูลสำเร็จ เนื่องจากถูกใช้งานแล้ว');
        } else {
            Cpay_department_sub_sub::destroy($dep_subsub_id);
            Session::flash('scc', 'ลบข้อมูลสำเร็จ');
        }
        return redirect(route('mpay.mpay_setting_department_sub_sub'));
    }

    // ________________________________________________ end setting department sub sub ___________________

    // ___ default setting department sub sub id ___________________

    public function mpay_setting_default_department_sub_sub_id()
    {
        $dep_subsub_all = Hrddepartmentsubsub::all();
        return view('manager_mpay.mpay_setting_defaultdepartment_sub_sub_id', compact('dep_subsub_all'));
    }

    public function mpay_setting_default_department_sub_sub_id_update(Request $request)
    {
        DB::table('web_meta_data')
            ->where('meta_name', 'CPAY_DEFAULT_DEPARTMENT_SUB_SUB_ID')
            ->update([
                'meta_value' => $request->CPAY_DEFAULT_DEPARTMENT_SUB_SUB_ID,
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        Session::flash('scc', 'อัพเดตข้อมูลสำเร็จ');
        return redirect(route('mpay.mpay_setting_default_department_sub_sub_id'));
    }

    // ________________________________________________ end setting default department sub sub id ___________________

    // ___ setting type clean machine ___________________
    public function mpay_setting_typecleanmachine()
    {
        $typemach = Cpay_typemachine::get();
        return view('manager_mpay.mpay_setting_typecleanmachine_view', compact('typemach'));
    }

    public function ajax_mpay_setting_typecleanmachine_update_active(Request $request)
    {
        $onoff = $request->onoff;
        $id    = $request->id;
        if ($onoff === 'true') {
            $onoff = true;
        } else {
            $onoff = false;
        }
        $person                        = Person::find(Auth::user()->PERSON_ID);
        $updatetypemachine             = Cpay_typemachine::find($id);
        $updatetypemachine->UPDATED_BY = $person->HR_FNAME;
        $updatetypemachine->ACTIVE     = $onoff;
        $updatetypemachine->save();
        echo $updatetypemachine->ACTIVE;
    }

    public function mpay_setting_typecleanmachine_add()
    {
        return view('manager_mpay.mpay_setting_typecleanmachine_add');
    }

    public function mpay_setting_typecleanmachine_save(Request $request)
    {
        $person                                     = Person::find(Auth::user()->PERSON_ID);
        $Cpay_typemachinesave                       = new Cpay_typemachine();
        $Cpay_typemachinesave->CPAY_TYPEMACH_NAME   = $request->CPAY_TYPEMACH_NAME;
        $Cpay_typemachinesave->CPAY_TYPEMACH_DETAIL = $request->CPAY_TYPEMACH_DETAIL;
        $Cpay_typemachinesave->UPDATED_BY           = $person->HR_FNAME;
        $Cpay_typemachinesave->save();
        Session::flash('scc', 'บันทึกข้อมูลสำเร็จ');
        return redirect(route('mpay.mpay_setting_typecleanmachine'));
    }

    public function mpay_setting_typecleanmachine_edit($typemachine_id)
    {
        $typemachine = Cpay_typemachine::find($typemachine_id);
        return view('manager_mpay.mpay_setting_typecleanmachine_edit', compact('typemachine'));
    }

    public function mpay_setting_typecleanmachine_update(Request $request)
    {
        $person                                     = Person::find(Auth::user()->PERSON_ID);
        $Cpay_typemachinesave                       = Cpay_typemachine::find($request->CPAY_TYPEMACH_ID);
        $Cpay_typemachinesave->CPAY_TYPEMACH_NAME   = $request->CPAY_TYPEMACH_NAME;
        $Cpay_typemachinesave->CPAY_TYPEMACH_DETAIL = $request->CPAY_TYPEMACH_DETAIL;
        $Cpay_typemachinesave->UPDATED_BY           = $person->HR_FNAME;
        $Cpay_typemachinesave->save();
        Session::flash('scc', 'แก้ไขข้อมูลสำเร็จ');
        return redirect(route('mpay.mpay_setting_typecleanmachine'));
    }

    public function mpay_setting_typecleanmachine_delete($typemachine_id)
    {
        $count_typemachine = cpay_machine::where('CPAY_TYPEMACH_ID', $typemachine_id)->count();
        if ($count_typemachine > 0) {
            Session::flash('err', 'ไม่สามารถลบข้อมูลได้ เนื่องจากถูกใช้งานแล้ว');
        } else {
            Cpay_typemachine::destroy($typemachine_id);
            Session::flash('scc', 'ลบข้อมูลสำเร็จ');
        }
        return redirect(route('mpay.mpay_setting_typecleanmachine'));
    }

    // ________________________________________________ end setting type clean machine ___________________

    // ___ setting clean machine ___________________
    public function mpay_setting_cleanmachine()
    {
        $machine = Cpay_machine::select('cpay_machine.*', 'cpay_typemachine.CPAY_TYPEMACH_NAME')
            ->leftJoin('cpay_typemachine', 'cpay_typemachine.CPAY_TYPEMACH_ID', 'cpay_machine.CPAY_TYPEMACH_ID')
            ->orderBy('cpay_machine.ACTIVE', 'DESC')
            ->orderBy('cpay_machine.CPAY_MACH_NUMBER')
            ->get();
        return view('manager_mpay.mpay_setting_cleanmachine_view', compact('machine'));
    }

    public function ajax_mpay_setting_cleanmachine_update_active(Request $request)
    {
        $onoff = $request->onoff;
        $id    = $request->id;
        if ($onoff === 'true') {
            $onoff = true;
        } else {
            $onoff = false;
        }
        $person                    = Person::find(Auth::user()->PERSON_ID);
        $updatemachine             = Cpay_machine::find($id);
        $updatemachine->UPDATED_BY = $person->HR_FNAME;
        $updatemachine->ACTIVE     = $onoff;
        $updatemachine->save();
        echo $updatemachine->ACTIVE;
    }

    public function mpay_setting_cleanmachine_add()
    {
        $supply = DB::table('asset_article')
            ->select('asset_article.ARTICLE_ID', 'asset_article.ARTICLE_NUM', 'asset_article.ARTICLE_NAME')->get();
        $typemachine   = cpay_typemachine::where('ACTIVE', true)->get();
        $machinenumrun = cpay_machine::max('CPAY_MACH_NUMBER') + 1;
        return view('manager_mpay.mpay_setting_cleanmachine_add', compact('supply', 'typemachine', 'machinenumrun'));
    }

    public function mpay_setting_cleanmachine_save(Request $request)
    {
        $count = Cpay_machine::where('ARTICLE_NUM', $request->ARTICLE_NUM)->count();
        if ($count > 0) {
            Session::flash('err', 'ไม่สามารถเพิ่มข้อมูลได้ เนื่องจากข้อมูลครุภัณฑ์นี้ได้เพิ่มเข้าแล้ว');
        } else {
            $person                                  = Person::find(Auth::user()->PERSON_ID);
            $Cpay_machinesave                        = new Cpay_machine();
            $Cpay_machinesave->ARTICLE_ID            = $request->ARTICLE_ID;
            $Cpay_machinesave->ARTICLE_NUM           = $request->ARTICLE_NUM;
            $Cpay_machinesave->CPAY_MACH_NAME_INSIDE = $request->CPAY_MACH_NAME_INSIDE;
            $Cpay_machinesave->CPAY_MACH_NAME_TH     = $request->CPAY_MACH_NAME_TH;
            $Cpay_machinesave->CPAY_MACH_NAME_EN     = $request->CPAY_MACH_NAME_EN;
            $Cpay_machinesave->CPAY_MACH_NUMBER      = $request->CPAY_MACH_NUMBER;
            $Cpay_machinesave->CPAY_TYPEMACH_ID      = $request->CPAY_TYPEMACH_ID;
            $Cpay_machinesave->CPAY_MACH_DETAIL      = $request->CPAY_MACH_DETAIL;
            $Cpay_machinesave->UPDATED_BY            = $person->HR_FNAME;
            $Cpay_machinesave->save();
            Session::flash('scc', 'บันทึกข้อมูลสำเร็จ');
        }
        return redirect(route('mpay.mpay_setting_cleanmachine'));
    }

    public function mpay_setting_cleanmachine_edit($machine_id)
    {
        $supply = DB::table('asset_article')
            ->select('asset_article.ARTICLE_ID', 'asset_article.ARTICLE_NUM', 'asset_article.ARTICLE_NAME')->get();
        $typemachine = cpay_typemachine::where('ACTIVE', true)->get();
        $machine     = Cpay_machine::find($machine_id);
        return view('manager_mpay.mpay_setting_cleanmachine_edit', compact('machine', 'supply', 'typemachine'));
    }

    public function mpay_setting_cleanmachine_update(Request $request)
    {
        $person                                    = Person::find(Auth::user()->PERSON_ID);
        $Cpay_machineupdate                        = Cpay_machine::find($request->CPAY_MACH_ID);
        $Cpay_machineupdate->ARTICLE_ID            = $request->ARTICLE_ID;
        $Cpay_machineupdate->ARTICLE_NUM           = $request->ARTICLE_NUM;
        $Cpay_machineupdate->CPAY_MACH_NAME_INSIDE = $request->CPAY_MACH_NAME_INSIDE;
        $Cpay_machineupdate->CPAY_MACH_NAME_TH     = $request->CPAY_MACH_NAME_TH;
        $Cpay_machineupdate->CPAY_MACH_NAME_EN     = $request->CPAY_MACH_NAME_EN;
        $Cpay_machineupdate->CPAY_MACH_NUMBER      = $request->CPAY_MACH_NUMBER;
        $Cpay_machineupdate->CPAY_TYPEMACH_ID      = $request->CPAY_TYPEMACH_ID;
        $Cpay_machineupdate->CPAY_MACH_DETAIL      = $request->CPAY_MACH_DETAIL;
        $Cpay_machineupdate->UPDATED_BY            = $person->HR_FNAME;
        $Cpay_machineupdate->save();
        Session::flash('scc', 'แก้ไขข้อมูลสำเร็จ');
        return redirect(route('mpay.mpay_setting_cleanmachine'));
    }

    public function mpay_setting_cleanmachine_delete($machine_id)
    {
        $count_production = cpay_production::where('CPAY_MACH_ID', $machine_id)->count();
        if ($count_production > 0) {
            Session::flash('err', 'ไม่สามารถลบข้อมูลสำเร็จ เนื่องจากถูกใช้งานแล้ว');
        } else {
            Cpay_machine::destroy($machine_id);
            Session::flash('scc', 'ลบข้อมูลสำเร็จ');
        }
        return redirect(route('mpay.mpay_setting_cleanmachine'));
    }

    // ________________________________________________ end setting type clean machine ___________________

    // ___ setting type medical equipment ___________________
    public function mpay_setting_typemedequipment()
    {
        $gsetequpment = Cpay_gsetequpment::orderBy('ACTIVE', 'DESC')->get();
        return view('manager_mpay.mpay_setting_typemedequipment_view', compact('gsetequpment'));
    }

    public function ajax_mpay_setting_typemedequipment_update_active(Request $request)
    {
        $onoff = $request->onoff;
        $id    = $request->id;
        if ($onoff === 'true') {
            $onoff = true;
        } else {
            $onoff = false;
        }
        $person                    = Person::find(Auth::user()->PERSON_ID);
        $updatemachine             = Cpay_gsetequpment::find($id);
        $updatemachine->UPDATED_BY = $person->HR_FNAME;
        $updatemachine->ACTIVE     = $onoff;
        $updatemachine->save();
        echo $updatemachine->ACTIVE;
    }

    public function mpay_setting_typemedequipment_add()
    {
        return view('manager_mpay.mpay_setting_typemedequipment_add');
    }

    public function mpay_setting_typemedequipment_save(Request $request)
    {
        $count = Cpay_gsetequpment::where('CPAY_GSET_NAME', $request->CPAY_GSET_NAME)->count();
        if ($count > 0) {
            Session::flash('err', 'ไม่สามารบันทึกได้ เนื่องจากชื่อดังกล่าวถูกใช้แล้ว');
        } else {
            $person                                  = Person::find(Auth::user()->PERSON_ID);
            $Cpay_gsetequpmentsave                   = new Cpay_gsetequpment();
            $Cpay_gsetequpmentsave->CPAY_GSET_NAME   = $request->CPAY_GSET_NAME;
            $Cpay_gsetequpmentsave->CPAY_GSET_DETAIL = $request->CPAY_GSET_DETAIL;
            $Cpay_gsetequpmentsave->UPDATED_BY       = $person->HR_FNAME;
            $Cpay_gsetequpmentsave->save();
            Session::flash('scc', 'บันทึกข้อมูลสำเร็จ');
        }
        return redirect(route('mpay.mpay_setting_typemedequipment'));
    }

    public function mpay_setting_typemedequipment_edit($typeequp_id)
    {
        $typeequpment = Cpay_gsetequpment::find($typeequp_id);
        return view('manager_mpay.mpay_setting_typemedequipment_edit', compact('typeequpment'));
    }

    public function mpay_setting_typemedequipment_update(Request $request)
    {
        $person                                    = Person::find(Auth::user()->PERSON_ID);
        $Cpay_gsetequpmentupdate                   = Cpay_gsetequpment::find($request->CPAY_GSET_ID);
        $Cpay_gsetequpmentupdate->CPAY_GSET_NAME   = $request->CPAY_GSET_NAME;
        $Cpay_gsetequpmentupdate->CPAY_GSET_DETAIL = $request->CPAY_GSET_DETAIL;
        $Cpay_gsetequpmentupdate->UPDATED_BY       = $person->HR_FNAME;
        $Cpay_gsetequpmentupdate->save();
        Session::flash('scc', 'แก้ไขข้อมูลสำเร็จ');
        return redirect(route('mpay.mpay_setting_typemedequipment'));
    }

    public function mpay_setting_typemedequipment_delete($typeequp_id)
    {
        $count = cpay_setequpment::where('CPAY_GSET_ID', $typeequp_id)->count();
        if ($count > 0) {
            Session::flash('err', 'ไม่สามารถลบข้อมูลได้ เนื่องจากถูกใช้แล้ว');
        } else {
            Cpay_gsetequpment::destroy($typeequp_id);
            Session::flash('scc', 'ลบข้อมูลสำเร็จ');
        }
        return redirect(route('mpay.mpay_setting_typemedequipment'));
    }

    // ________________________________________________ end setting type medical equipment ___________________

    // ___ setting unit ___________________
    public function mpay_setting_unit()
    {
        $cpay_unit = cpay_unit::get();
        return view('manager_mpay.mpay_setting_unit_view', compact('cpay_unit'));
    }

    public function ajax_mpay_setting_unit_update_active(Request $request)
    {
        $onoff = $request->onoff;
        $id    = $request->id;
        if ($onoff === 'true') {
            $onoff = true;
        } else {
            $onoff = false;
        }
        $person                    = Person::find(Auth::user()->PERSON_ID);
        $updatemachine             = Cpay_unit::find($id);
        $updatemachine->UPDATED_BY = $person->HR_FNAME;
        $updatemachine->ACTIVE     = $onoff;
        $updatemachine->save();
        echo $updatemachine->ACTIVE;
    }

    public function mpay_setting_unit_add()
    {
        $sup_unit = DB::table('supplies_unit')->where('ACTIVE', true)->get();
        return view('manager_mpay.mpay_setting_unit_add', compact('sup_unit'));
    }

    public function mpay_setting_unit_save(Request $request)
    {
        $count_name = Cpay_unit::where('CPAY_UNIT_NAME', $request->CPAY_UNIT_NAME)->count();
        if ($count_name > 0) {
            Session::flash('err', 'ไม่สามารถเพิ่มข้อมูลได้ เนื่องจากมีการใช้ชื่อนี้แล้ว');
        } else {
            $person                          = Person::find(Auth::user()->PERSON_ID);
            $Cpay_unitsave                   = new Cpay_unit();
            $Cpay_unitsave->CPAY_UNIT_NAME   = $request->CPAY_UNIT_NAME;
            $Cpay_unitsave->CPAY_UNIT_DETAIL = $request->CPAY_UNIT_DETAIL;
            $Cpay_unitsave->UPDATED_BY       = $person->HR_FNAME;
            $Cpay_unitsave->save();
            Session::flash('scc', 'บันทึกข้อมูลสำเร็จ');
        }
        return redirect(route('mpay.mpay_setting_unit'));
    }

    public function mpay_setting_unit_edit($unit_id)
    {
        $sup_unit = DB::table('supplies_unit')->where('ACTIVE', true)->get();
        $set_unit = Cpay_unit::find($unit_id);
        return view('manager_mpay.mpay_setting_unit_edit', compact('sup_unit', 'set_unit'));
    }

    public function mpay_setting_unit_update(Request $request)
    {
        $person                            = Person::find(Auth::user()->PERSON_ID);
        $Cpay_unitupdate                   = Cpay_unit::find($request->CPAY_UNIT_ID);
        $Cpay_unitupdate->CPAY_UNIT_NAME   = $request->CPAY_UNIT_NAME;
        $Cpay_unitupdate->CPAY_UNIT_DETAIL = $request->CPAY_UNIT_DETAIL;
        $Cpay_unitupdate->UPDATED_BY       = $person->HR_FNAME;
        $Cpay_unitupdate->save();
        Session::flash('scc', 'แก้ไขข้อมูลสำเร็จ');
        return redirect(route('mpay.mpay_setting_unit'));
    }

    public function mpay_setting_unit_delete($unit_id)
    {
        $count_setequpemnt     = cpay_setequpment::where('CPAY_UNIT_ID', $unit_id)->count();
        $count_setequpemnt_sub = cpay_setequpment_sub::where('CPAY_UNIT_ID', $unit_id)->count();
        if ($count_setequpemnt > 0 || $count_setequpemnt_sub > 0) {
            Session::flash('err', 'ไม่สามารถลบข้อมูลสำเร็จ เนื่องจากถูกใช้งานแล้ว');
        } else {
            Cpay_unit::destroy($unit_id);
            Session::flash('scc', 'ลบข้อมูลสำเร็จ');
        }
        return redirect(route('mpay.mpay_setting_unit'));
    }

    // ________________________________________________ end setting unit ___________________

    // ___ setting subset med ___________________
    public function mpay_setting_subset_medequipment()
    {
        $equp_sub = cpay_setequpment_sub::select('cpay_setequpment_sub.*', 'cpay_unit.CPAY_UNIT_NAME')
            ->leftJoin('cpay_unit', 'cpay_unit.CPAY_UNIT_ID', 'cpay_setequpment_sub.CPAY_UNIT_ID')
            ->get();
        return view('manager_mpay.mpay_setting_subset_medequipment_view', compact('equp_sub'));
    }

    public function ajax_mpay_setting_subset_medequipment_update_active(Request $request)
    {
        $onoff = $request->onoff;
        $id    = $request->id;
        if ($onoff === 'true') {
            $onoff = true;
        } else {
            $onoff = false;
        }
        $person                    = Person::find(Auth::user()->PERSON_ID);
        $updatemachine             = cpay_setequpment_sub::find($id);
        $updatemachine->UPDATED_BY = $person->HR_FNAME;
        $updatemachine->ACTIVE     = $onoff;
        $updatemachine->save();
        echo $updatemachine->ACTIVE;
    }

    public function mpay_setting_subset_medequipment_add()
    {
        // $warehouse = DB::table('warehouse_store')->get();
        $warehouse = DB::table('supplies')
            ->select('supplies.ID', 'supplies.SUP_FSN_NUM', 'supplies.SUP_NAME')->get();
        $set_unit  = cpay_unit::where('ACTIVE', true)->get();
        return view('manager_mpay.mpay_setting_subset_medequipment_add', compact('warehouse', 'set_unit'));
    }

    public function mpay_setting_subset_medequipment_save(Request $request)
    {
        $count = cpay_setequpment_sub::where('CPAY_SET_SUB_NAME_INSIDE', $request->CPAY_SET_SUB_NAME_INSIDE)->count();
        if ($count > 0) {
            Session::flash('err', 'ไม่สามารถบันทึกข้อมูลได้ เนื่องจากมีการบันทึกชื่อดังกล่าวแล้ว');
        } else {
            $person                                             = Person::find(Auth::user()->PERSON_ID);
            $cpay_setequpment_subsave                           = new cpay_setequpment_sub();
            $cpay_setequpment_subsave->CPAY_SET_SUB_NAME_INSIDE = $request->CPAY_SET_SUB_NAME_INSIDE;
            $cpay_setequpment_subsave->CPAY_SET_SUB_NAME_TH     = $request->CPAY_SET_SUB_NAME_TH;
            $cpay_setequpment_subsave->CPAY_SET_SUB_NAME_EN     = $request->CPAY_SET_SUB_NAME_EN;
            $cpay_setequpment_subsave->CPAY_UNIT_ID             = $request->CPAY_UNIT_ID;
            $cpay_setequpment_subsave->CPAY_SET_SUB_PRICE       = $request->CPAY_SET_SUB_PRICE;
            $cpay_setequpment_subsave->CPAY_SET_SUB_DETAIL      = $request->CPAY_SET_SUB_DETAIL;
            $cpay_setequpment_subsave->UPDATED_BY               = $person->HR_FNAME;
            $cpay_setequpment_subsave->save();
            Session::flash('scc', 'บันทึกข้อมูลสำเร็จ');
        }
        return redirect(route('mpay.mpay_setting_subset_medequipment'));
    }

    public function mpay_setting_subset_medequipment_edit($subset_id)
    {
        $subsetequp = cpay_setequpment_sub::find($subset_id);
        $warehouse = DB::table('supplies')
            ->select('supplies.ID', 'supplies.SUP_FSN_NUM', 'supplies.SUP_NAME')->get();
        $set_unit   = cpay_unit::where('ACTIVE', true)->get();
        return view('manager_mpay.mpay_setting_subset_medequipment_edit', compact('warehouse', 'set_unit', 'subsetequp'));
    }

    public function mpay_setting_subset_medequipment_update(Request $request)
    {
        $person                                               = Person::find(Auth::user()->PERSON_ID);
        $cpay_setequpment_subupdate                           = cpay_setequpment_sub::find($request->CPAY_SET_SUB_ID);
        $cpay_setequpment_subupdate->CPAY_SET_SUB_NAME_INSIDE = $request->CPAY_SET_SUB_NAME_INSIDE;
        $cpay_setequpment_subupdate->CPAY_SET_SUB_NAME_TH     = $request->CPAY_SET_SUB_NAME_TH;
        $cpay_setequpment_subupdate->CPAY_SET_SUB_NAME_EN     = $request->CPAY_SET_SUB_NAME_EN;
        $cpay_setequpment_subupdate->CPAY_UNIT_ID             = $request->CPAY_UNIT_ID;
        $cpay_setequpment_subupdate->CPAY_SET_SUB_PRICE       = $request->CPAY_SET_SUB_PRICE;
        $cpay_setequpment_subupdate->CPAY_SET_SUB_DETAIL      = $request->CPAY_SET_SUB_DETAIL;
        $cpay_setequpment_subupdate->UPDATED_BY               = $person->HR_FNAME;
        $cpay_setequpment_subupdate->save();
        Session::flash('scc', 'แก้ไขข้อมูลสำเร็จ');
        return redirect(route('mpay.mpay_setting_subset_medequipment'));
    }

    public function mpay_setting_subset_medequipment_delete($subset_equip_id)
    {
        $count = cpay_setequpment_list::where('CPAY_SET_SUB_ID', $subset_equip_id)->count();
        if ($count > 0) {
            Session::flash('err', 'ไม่สามารถลบข้อมูลสำเร็จ เนื่องจากถูกใช้งานแล้ว');
        } else {
            cpay_setequpment_sub::destroy($subset_equip_id);
            Session::flash('scc', 'ลบข้อมูลสำเร็จ');
        }
        return redirect(route('mpay.mpay_setting_subset_medequipment'));
    }

    // ________________________________________________ end setting subset med ___________________

    // ___ setting med ___________________
    public function mpay_setting_medequipment()
    {
        $setequpment = cpay_setequpment::select('cpay_typemachine.CPAY_TYPEMACH_NAME', 'cpay_setequpment.*', 'cpay_unit.CPAY_UNIT_NAME')
            ->leftJoin('cpay_typemachine', 'cpay_typemachine.CPAY_TYPEMACH_ID', 'cpay_setequpment.CPAY_TYPEMACH_ID')
            ->leftJoin('cpay_unit', 'cpay_unit.CPAY_UNIT_ID', 'cpay_setequpment.CPAY_UNIT_ID')->orderBy('updated_at', 'DESC')->get();
        return view('manager_mpay.mpay_setting_medequipment_view', compact('setequpment'));
    }

    public function ajax_mpay_setting_medequipment_update_active(Request $request)
    {
        $onoff = $request->onoff;
        $id    = $request->id;
        if ($onoff === 'true') {
            $onoff = true;
        } else {
            $onoff = false;
        }
        $person                    = Person::find(Auth::user()->PERSON_ID);
        $updatemachine             = cpay_setequpment::find($id);
        $updatemachine->UPDATED_BY = $person->HR_FNAME;
        $updatemachine->ACTIVE     = $onoff;
        $updatemachine->save();
        echo $updatemachine->ACTIVE;
    }

    public function ajax_mpay_list_medequipment(Request $request)
    {
        // ชื่อ จำนวน หน่วยนับ ราคา
        $list = cpay_setequpment_list::select('cpay_setequpment_sub.CPAY_SET_SUB_NAME_INSIDE', 'cpay_setequpment_list.CPAY_SETLIST_QUANTITY', 'cpay_unit.CPAY_UNIT_NAME', 'cpay_setequpment_sub.CPAY_SET_SUB_PRICE')
            ->leftJoin('cpay_setequpment_sub', 'cpay_setequpment_sub.CPAY_SET_SUB_ID', 'cpay_setequpment_list.CPAY_SET_SUB_ID')
            ->leftJoin('cpay_unit', 'cpay_unit.CPAY_UNIT_ID', 'cpay_setequpment_sub.CPAY_UNIT_ID')
            ->where('CPAY_SET_ID', $request->id)->get();
        $html   = '';
        $number = 1;
        foreach ($list as $row) {
            $html .= '<tr>
            <td class="text-center">' . $number++ . '</td>
            <td>' . $row->CPAY_SET_SUB_NAME_INSIDE . '</td>
            <td class="text-right">' . $row->CPAY_SETLIST_QUANTITY . '</td>
            <td class="text-center">' . $row->CPAY_UNIT_NAME . '</td>
            <td class="text-right">' . number_format($row->CPAY_SET_SUB_PRICE, 2) . '</td>
            </tr>';
        }
        return $html;
    }

    public function mpay_setting_medequipment_add()
    {
        // $warehouse   = DB::table('warehouse_store')->get();
        $warehouse = DB::table('supplies')
            ->select('supplies.ID', 'supplies.SUP_FSN_NUM', 'supplies.SUP_NAME')->get();
        $typemach    = Cpay_typemachine::where('ACTIVE', true)->get();
        $unit        = cpay_unit::where('ACTIVE', true)->get();
        $setequp_sub = cpay_setequpment_sub::where('ACTIVE', true)->get();
        $gset_equp   = cpay_gsetequpment::where('ACTIVE', true)->get();
        return view('manager_mpay.mpay_setting_medequipment_add', compact('typemach', 'unit', 'warehouse', 'setequp_sub', 'gset_equp'));
    }

    public function mpay_setting_medequipment_save(Request $request)
    {
        $count = cpay_setequpment::where('CPAY_SET_NAME_INSIDE', $request->CPAY_SET_NAME_INSIDE)->count();
        if ($count > 0) {
            Session::flash('err', 'ไม่สามารถบันทึกข้อมูลได้ เนื่องจากชื่อชุดอุปกรณ์ดังกล่าวถูกใช้แล้ว');
        } else {
            $person                                      = Person::find(Auth::user()->PERSON_ID);
            $setequp_save                                = new cpay_setequpment();
            $setequp_save->CPAY_SET_NAME_INSIDE          = $request->CPAY_SET_NAME_INSIDE;
            $setequp_save->CPAY_SET_NAME_TH              = $request->CPAY_SET_NAME_TH;
            $setequp_save->CPAY_SET_NAME_EN              = $request->CPAY_SET_NAME_EN;
            $setequp_save->CPAY_SET_BRAND                = $request->CPAY_SET_BRAND;
            $setequp_save->CPAY_SET_PRICE                = $request->CPAY_SET_PRICE;
            $setequp_save->CPAY_SET_STERILE_DAY          = $request->CPAY_SET_STERILE_DAY;
            $setequp_save->CPAY_UNIT_ID                  = $request->CPAY_UNIT_ID;
            $setequp_save->CPAY_GSET_ID                  = $request->CPAY_GSET_ID;
            $setequp_save->CPAY_SET_NOT_STERILE_QUANTITY = 0;
            $setequp_save->CPAY_SET_STERILE_QUANTITY     = 0;
            $setequp_save->CPAY_TYPEMACH_ID              = $request->CPAY_TYPEMACH_ID;
            $setequp_save->CPAY_SET_HAVE_LIST            = ($request->CPAY_SET_HAVE_LIST) ? true : false;
            $setequp_save->CPAY_SET_DETAIL               = $request->CPAY_SET_DETAIL;
            $setequp_save->UPDATED_BY                    = $person->HR_FNAME;
            $setequp_save->save();
            $CPAY_SET_ID = $setequp_save->CPAY_SET_ID;
            if (!empty($request->CPAY_SET_SUB_ID)) {
                foreach ($request->CPAY_SET_SUB_ID as $key => $SET_SUB_ID) {
                    $setequp_list_save                        = new cpay_setequpment_list();
                    $setequp_list_save->CPAY_SET_ID           = $CPAY_SET_ID;
                    $setequp_list_save->CPAY_SET_SUB_ID       = $SET_SUB_ID;
                    $setequp_list_save->CPAY_SETLIST_QUANTITY = $request->CPAY_SETLIST_QUANTITY[$key];
                    $setequp_list_save->UPDATED_BY            = $person->HR_FNAME;
                    $setequp_list_save->save();
                }
            }
            Session::flash('scc', 'บันทึกข้อมูลสำเร็จ');
        }
        return redirect(route('mpay.mpay_setting_medequipment'));
    }

    public function mpay_setting_medequipment_edit($set_id)
    {
        $warehouse   = DB::table('warehouse_store')->get();
        $typemach    = Cpay_typemachine::where('ACTIVE', true)->get();
        $unit        = cpay_unit::where('ACTIVE', true)->get();
        $setequp_sub = cpay_setequpment_sub::where('ACTIVE', true)->get();
        $gset_equp   = cpay_gsetequpment::where('ACTIVE', true)->get();
        $setequpment = cpay_setequpment::find($set_id);
        if ($setequpment->CPAY_SET_HAVE_LIST) {
            $setequpment_list = cpay_setequpment_list::leftJoin('cpay_setequpment', 'cpay_setequpment.CPAY_SET_ID', 'cpay_setequpment_list.CPAY_SET_ID')->where('cpay_setequpment.CPAY_SET_ID', $set_id)->get();
        } else {
            $setequpment_list = array();
        }
        return view('manager_mpay.mpay_setting_medequipment_edit', compact('typemach', 'unit', 'warehouse', 'setequp_sub', 'setequpment', 'setequpment_list', 'gset_equp'));
    }

    public function mpay_setting_medequipment_update(Request $request)
    {
        $person                                        = Person::find(Auth::user()->PERSON_ID);
        $setequp_update                                = cpay_setequpment::find($request->CPAY_SET_ID);
        $setequp_update->CPAY_SET_NAME_INSIDE          = $request->CPAY_SET_NAME_INSIDE;
        $setequp_update->CPAY_SET_NAME_TH              = $request->CPAY_SET_NAME_TH;
        $setequp_update->CPAY_SET_NAME_EN              = $request->CPAY_SET_NAME_EN;
        $setequp_update->CPAY_SET_BRAND                = $request->CPAY_SET_BRAND;
        $setequp_update->CPAY_SET_PRICE                = $request->CPAY_SET_PRICE;
        $setequp_update->CPAY_SET_STERILE_DAY          = $request->CPAY_SET_STERILE_DAY;
        $setequp_update->CPAY_UNIT_ID                  = $request->CPAY_UNIT_ID;
        $setequp_update->CPAY_GSET_ID                  = $request->CPAY_GSET_ID;
        $setequp_update->CPAY_TYPEMACH_ID              = $request->CPAY_TYPEMACH_ID;
        $setequp_update->CPAY_SET_HAVE_LIST            = ($request->CPAY_SET_HAVE_LIST) ? true : false;
        $setequp_update->CPAY_SET_DETAIL               = $request->CPAY_SET_DETAIL;
        $setequp_update->UPDATED_BY                    = $person->HR_FNAME;
        $setequp_update->save();
        $CPAY_SET_ID = $setequp_update->CPAY_SET_ID;
        cpay_setequpment_list::where('CPAY_SET_ID', $request->CPAY_SET_ID)->delete();
        if (!empty($request->CPAY_SET_SUB_ID)) {
            foreach ($request->CPAY_SET_SUB_ID as $key => $SET_SUB_ID) {
                $setequp_list_update                        = new cpay_setequpment_list();
                $setequp_list_update->CPAY_SET_ID           = $CPAY_SET_ID;
                $setequp_list_update->CPAY_SET_SUB_ID       = $SET_SUB_ID;
                $setequp_list_update->CPAY_SETLIST_QUANTITY = $request->CPAY_SETLIST_QUANTITY[$key];
                $setequp_list_update->UPDATED_BY            = $person->HR_FNAME;
                $setequp_list_update->save();
            }
        }
        Session::flash('scc', 'แก้ไขข้อมูลสำเร็จ');
        return redirect(route('mpay.mpay_setting_medequipment'));
    }

    public function mpay_setting_medequipment_delete($set_id)
    {
        $count       = cpay_receive_list::where('CPAY_SET_ID', $set_id)->count();
        $count_quota = cpay_department_sub_sub_quota::where('CPAY_SET_ID', $set_id)->count();
        if ($count > 0 || $count_quota > 0) {
            Session::flash('err', 'ไม่สามารถลบข้อมูลได้ เนื่องจากถูกใช้แล้ว');
        } else {
            cpay_setequpment::destroy($set_id);
            cpay_setequpment_list::where('CPAY_SET_ID', $set_id)->delete();
            Session::flash('scc', 'ลบข้อมูลสำเร็จ');
        }
        return redirect(route('mpay.mpay_setting_medequipment'));
    }

    // ________________________________________________ end setting med ___________________
    // ___ setting quota ___________________
    public function mpay_setting_quota(Request $request)
    {
        if ($request->method() === 'POST') {
            $dep_sub_sub_id = $request->dep_sub_sub_id;
            session([
                'manager_mpay.mpay_setting_quota.dep_sub_sub_id' => $dep_sub_sub_id
            ]);
        } elseif (session::has('manager_mpay.mpay_setting_quota')) {
            $dep_sub_sub_id = session('manager_mpay.mpay_setting_quota.dep_sub_sub_id');
        } else {
            $dep_sub_sub_id = 'all';
        }

        $query_quota = Cpay_department_sub_sub_quota::select('cpay_department_sub_sub_quota.*', 'cpay_setequpment.CPAY_SET_NAME_INSIDE', 'cpay_department_sub_sub.CPAY_DEP_NAME_INSIDE')
            ->leftJoin('cpay_setequpment', 'cpay_setequpment.CPAY_SET_ID', 'cpay_department_sub_sub_quota.CPAY_SET_ID')
            ->leftJoin('cpay_department_sub_sub', 'cpay_department_sub_sub.CPAY_DEP_ID', 'cpay_department_sub_sub_quota.CPAY_DEP_ID');
        if ($dep_sub_sub_id !== 'all') {
            $query_quota->where('cpay_department_sub_sub_quota.CPAY_DEP_ID', $dep_sub_sub_id);
        }
        $dep_quota   = $query_quota->get();
        $dep_sub_sub = cpay_department_sub_sub::where('ACTIVE', true)->get();
        return view('manager_mpay.mpay_setting_quota_view', compact('dep_quota', 'dep_sub_sub', 'dep_sub_sub_id'));
    }

    public function ajax_mpay_setting_quota_update_quantity(Request $request)
    {
        $dep_quota_update = cpay_department_sub_sub_quota::find($request->id);
        if ($dep_quota_update) {
            $person                               = Person::find(Auth::user()->PERSON_ID);
            $dep_quota_update->DEP_QUOTA_QUANTITY = $request->quota;
            $dep_quota_update->UPDATED_BY         = $person->HR_FNAME;
            $dep_quota_update->save();
            $data = [
                'status' => 'success',
                'msg'    => 'อัพเดตจำนวนโควต้าสำเร็จ [ ' . $dep_quota_update->DEP_QUOTA_ID . ' ]'
            ];
        } else {
            $data = [
                'status' => 'error',
                'msg'    => 'ไม่พบไอดีโควต้าของหน่วยงาน [ ' . $request->id . ' ]'
            ];
        }
        return json_encode_u($data);
    }

    public function ajax_mpay_setting_quota_update_active(Request $request)
    {
        $onoff = $request->onoff;
        $id    = $request->id;
        if ($onoff === 'true') {
            $onoff = true;
        } else {
            $onoff = false;
        }
        $person                       = Person::find(Auth::user()->PERSON_ID);
        $dep_quota_update             = cpay_department_sub_sub_quota::find($id);
        $dep_quota_update->UPDATED_BY = $person->HR_FNAME;
        $dep_quota_update->ACTIVE     = $onoff;
        $dep_quota_update->save();
        echo $dep_quota_update->ACTIVE;
    }

    public function mpay_setting_quota_add()
    {
        $cpay_setequpment = cpay_setequpment::where('ACTIVE', true)->get();
        $dep_sub_sub      = cpay_department_sub_sub::where('ACTIVE', true)->get();
        return view('manager_mpay.mpay_setting_quota_add', compact('cpay_setequpment', 'dep_sub_sub'));
    }

    public function mpay_setting_quota_save(Request $request)
    {
        $count = cpay_department_sub_sub_quota::where('CPAY_SET_ID', $request->CPAY_SET_ID)
            ->where('CPAY_DEP_ID', $request->CPAY_DEP_ID)
            ->count();
        if ($count > 0) {
            Session::flash('err', 'ไม่สามารถเพิ่มข้อมูลได้ เนื่องเพิ่มข้อมูล หน่วยงานและชุดอุปกรณ์นี้แล้ว');
        } else {
            $person                         = Person::find(Auth::user()->PERSON_ID);
            $quota_save                     = new cpay_department_sub_sub_quota();
            $quota_save->CPAY_SET_ID        = $request->CPAY_SET_ID;
            $quota_save->CPAY_DEP_ID        = $request->CPAY_DEP_ID;
            $quota_save->DEP_QUOTA_QUANTITY = $request->DEP_QUOTA_QUANTITY;
            $quota_save->DEP_QUOTA_BALANCE  = 0;
            $quota_save->UPDATED_BY         = $person->HR_FNAME;
            $quota_save->save();
            Session::flash('scc', 'บันทึกข้อมูลสำเร็จ');
        }
        return redirect(route('mpay.mpay_setting_quota'));
    }

    public function mpay_setting_quota_edit($quota_id)
    {
        $cpay_setequpment = cpay_setequpment::where('ACTIVE', true)->get();
        $dep_sub_sub      = cpay_department_sub_sub::where('ACTIVE', true)->get();
        $dep_quota        = cpay_department_sub_sub_quota::find($quota_id);
        return view('manager_mpay.mpay_setting_quota_edit', compact('cpay_setequpment', 'dep_sub_sub', 'dep_quota'));
    }

    public function mpay_setting_quota_update(Request $request)
    {
        $count = cpay_department_sub_sub_quota::where('CPAY_SET_ID', $request->CPAY_SET_ID)
            ->where('CPAY_DEP_ID', $request->CPAY_DEP_ID)
            ->get();
        if (!empty($count)) {
            Session::flash('err', 'ไม่สามารถแก้ไขข้อมูลได้ เนื่องเพิ่มข้อมูล หน่วยงานและชุดอุปกรณ์นี้แล้ว');
        } else {
            $person                           = Person::find(Auth::user()->PERSON_ID);
            $quota_update                     = cpay_department_sub_sub_quota::where('DEP_QUOTA_ID', $request->DEP_QUOTA_ID)->first();
            $quota_update->CPAY_DEP_ID        = $request->CPAY_DEP_ID;
            $quota_update->CPAY_SET_ID        = $request->CPAY_SET_ID;
            $quota_update->DEP_QUOTA_QUANTITY = $request->DEP_QUOTA_QUANTITY;
            $quota_update->UPDATED_BY         = $person->HR_FNAME;
            $quota_update->save();
            Session::flash('scc', 'แก้ไขข้อมูลสำเร็จ');
        }
        return redirect(route('mpay.mpay_setting_quota'));
    }

    public function mpay_setting_quota_delete($quota_id)
    {
        $count = cpay_department_sub_sub_quota::where('DEP_QUOTA_BALANCE', '!=', 0)
            ->where('DEP_QUOTA_ID', $quota_id)
            ->count();
        if ($count > 0) {
            Session::flash('err', 'ไม่สามารถลบข้อมูลได้ เนื่องจากถูกใช้งานแล้ว');
        } else {
            cpay_department_sub_sub_quota::destroy($quota_id);
            Session::flash('scc', 'ลบข้อมูลสำเร็จ');
        }
        return redirect(route('mpay.mpay_setting_quota'));
    }

    // ________________________________________________ end setting quota ___________________
}
