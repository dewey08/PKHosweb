<?php

namespace App\Http\Controllers;



use App\Models\Alerttest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Person;
use App\Models\Teamlist;
use Illuminate\Support\Facades\Auth;
use App\Models\Saveecoin;
use App\Models\HapptR;
use App\Models\Equestion;
use App\Models\order;
use App\Models\Answer;
use App\Models\Coin;
use App\Models\Shop;
use App\Models\compliment_happy;
use App\Models\problem_happy;
use App\Models\problem_answer_happy;
use App\Models\Emodal_Happy;
use App\Models\Equestion_group;
use App\Models\Happysetcoin;
use App\Models\Happysetproblem;
use App\Models\Happysetcompliment;
use App\Models\Happyethics;

use Intervention\Image\ImageManagerStatic as Image;

date_default_timezone_set("Asia/Bangkok");

class Happy_Net_Controller extends Controller


{
    public function insert_modal_day_user(Request $request)
{  
    $id_user = Auth::user()->PERSON_ID;
    $happy_net_modal = DB::table('happy_net_modal')
    ->where('ID_USER','=',$id_user)
    ->where('DATE_SAVE','=',date('Y-m-d'))
    ->count();
// dd($happy_net_modal);
    if($happy_net_modal == 0){
        $save_modal = new Emodal_Happy();
        $save_modal->HAPPY_NET_MODAL_QUESTION = "True";
        $save_modal->ID_USER = $id_user;
        $save_modal->HAPPY_NET_MODAL_TYPE = "-";
       $save_modal->DATE_SAVE = date('Y-m-d');
        $save_modal->save();
   
    }else{
        $id = DB::table('happy_net_modal')
        ->where('ID_USER','=',$id_user)
        ->select('ID_USER')
        ->get();
// dd($id);

        $update_modal = Emodal_Happy::where('ID_USER', '=', $id_user)->first();
        // dd($update_modal);
        // $update_modal->HAPPY_NET_MODAL_QUESTION = "True";
        $update_modal->ID_USER = $id_user;
        $update_modal->DATE_SAVE = date('Y-m-d');
        $update_modal->save();
//  dd($update_modal);
    }
    
    return redirect()->route('Happy_Net');

   
       

    
}
    public function Happy_Net()
    {
        $id_user = Auth::user()->PERSON_ID;
        $m_budget = date("m");
        if ((int)$m_budget > 9) {
            $yearbudget = date("Y") + 544;
        } else {
            $yearbudget = date("Y") + 543;
        }

        $year_ = array();
        for ($i = $yearbudget; $i >= $yearbudget - 9; $i--) {
            $year_[$i] = $i;
        }
        $data['year_'] = $year_;

        $data['yearbudget_select'] = $yearbudget;
        $year = $data['yearbudget_select'] - 543;
        if (isset($_GET['yearbudget_select'])) {
            $data['yearbudget_select'] = $_GET['yearbudget_select'];
        }

        $year = date('Y');
        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();

        $year_id = $year + 543;

        $chom_send1 = DB::table('happy_net_compliment')->where('ID_USER_INSERT', '=', $id_user)->where('DATE_SAVE', 'like', $year . '-01%')->count();
        $chom_send2 = DB::table('happy_net_compliment')->where('ID_USER_INSERT', '=', $id_user)->where('DATE_SAVE', 'like', $year . '-02%')->count();
        $chom_send3 = DB::table('happy_net_compliment')->where('ID_USER_INSERT', '=', $id_user)->where('DATE_SAVE', 'like', $year . '-03%')->count();
        $chom_send4 = DB::table('happy_net_compliment')->where('ID_USER_INSERT', '=', $id_user)->where('DATE_SAVE', 'like', $year . '-04%')->count();
        $chom_send5 = DB::table('happy_net_compliment')->where('ID_USER_INSERT', '=', $id_user)->where('DATE_SAVE', 'like', $year . '-05%')->count();
        $chom_send6 = DB::table('happy_net_compliment')->where('ID_USER_INSERT', '=', $id_user)->where('DATE_SAVE', 'like', $year . '-06%')->count();
        $chom_send7 = DB::table('happy_net_compliment')->where('ID_USER_INSERT', '=', $id_user)->where('DATE_SAVE', 'like', $year . '-07%')->count();
        $chom_send8 = DB::table('happy_net_compliment')->where('ID_USER_INSERT', '=', $id_user)->where('DATE_SAVE', 'like', $year . '-08%')->count();
        $chom_send9 = DB::table('happy_net_compliment')->where('ID_USER_INSERT', '=', $id_user)->where('DATE_SAVE', 'like', $year . '-09%')->count();
        $chom_send10 = DB::table('happy_net_compliment')->where('ID_USER_INSERT', '=', $id_user)->where('DATE_SAVE', 'like', $year . '-10%')->count();
        $chom_send11 = DB::table('happy_net_compliment')->where('ID_USER_INSERT', '=', $id_user)->where('DATE_SAVE', 'like', $year . '-11%')->count();
        $chom_send12 = DB::table('happy_net_compliment')->where('ID_USER_INSERT', '=', $id_user)->where('DATE_SAVE', 'like', $year . '-12%')->count();

        $pro_send1 = DB::table('happy_net_problem')->where('ID_USER_INSERT_PROBLEM', '=', $id_user)->where('DATE_SAVE', 'like', $year . '-01%')->count();
        $pro_send2 = DB::table('happy_net_problem')->where('ID_USER_INSERT_PROBLEM', '=', $id_user)->where('DATE_SAVE', 'like', $year . '-02%')->count();
        $pro_send3 = DB::table('happy_net_problem')->where('ID_USER_INSERT_PROBLEM', '=', $id_user)->where('DATE_SAVE', 'like', $year . '-03%')->count();
        $pro_send4 = DB::table('happy_net_problem')->where('ID_USER_INSERT_PROBLEM', '=', $id_user)->where('DATE_SAVE', 'like', $year . '-04%')->count();
        $pro_send5 = DB::table('happy_net_problem')->where('ID_USER_INSERT_PROBLEM', '=', $id_user)->where('DATE_SAVE', 'like', $year . '-05%')->count();
        $pro_send6 = DB::table('happy_net_problem')->where('ID_USER_INSERT_PROBLEM', '=', $id_user)->where('DATE_SAVE', 'like', $year . '-06%')->count();
        $pro_send7 = DB::table('happy_net_problem')->where('ID_USER_INSERT_PROBLEM', '=', $id_user)->where('DATE_SAVE', 'like', $year . '-07%')->count();
        $pro_send8 = DB::table('happy_net_problem')->where('ID_USER_INSERT_PROBLEM', '=', $id_user)->where('DATE_SAVE', 'like', $year . '-08%')->count();
        $pro_send9 = DB::table('happy_net_problem')->where('ID_USER_INSERT_PROBLEM', '=', $id_user)->where('DATE_SAVE', 'like', $year . '-09%')->count();
        $pro_send10 = DB::table('happy_net_problem')->where('ID_USER_INSERT_PROBLEM', '=', $id_user)->where('DATE_SAVE', 'like', $year . '-10%')->count();
        $pro_send11 = DB::table('happy_net_problem')->where('ID_USER_INSERT_PROBLEM', '=', $id_user)->where('DATE_SAVE', 'like', $year . '-11%')->count();
        $pro_send12 = DB::table('happy_net_problem')->where('ID_USER_INSERT_PROBLEM', '=', $id_user)->where('DATE_SAVE', 'like', $year . '-12%')->count();


        $chom_get1 = DB::table('happy_net_compliment')->where('ID_USER', '=', $id_user)->where('DATE_SAVE', 'like', $year . '-01%')->count();
        $chom_get2 = DB::table('happy_net_compliment')->where('ID_USER', '=', $id_user)->where('DATE_SAVE', 'like', $year . '-02%')->count();
        $chom_get3 = DB::table('happy_net_compliment')->where('ID_USER', '=', $id_user)->where('DATE_SAVE', 'like', $year . '-03%')->count();
        $chom_get4 = DB::table('happy_net_compliment')->where('ID_USER', '=', $id_user)->where('DATE_SAVE', 'like', $year . '-04%')->count();
        $chom_get5 = DB::table('happy_net_compliment')->where('ID_USER', '=', $id_user)->where('DATE_SAVE', 'like', $year . '-05%')->count();
        $chom_get6 = DB::table('happy_net_compliment')->where('ID_USER', '=', $id_user)->where('DATE_SAVE', 'like', $year . '-06%')->count();
        $chom_get7 = DB::table('happy_net_compliment')->where('ID_USER', '=', $id_user)->where('DATE_SAVE', 'like', $year . '-07%')->count();
        $chom_get8 = DB::table('happy_net_compliment')->where('ID_USER', '=', $id_user)->where('DATE_SAVE', 'like', $year . '-08%')->count();
        $chom_get9 = DB::table('happy_net_compliment')->where('ID_USER', '=', $id_user)->where('DATE_SAVE', 'like', $year . '-09%')->count();
        $chom_get10 = DB::table('happy_net_compliment')->where('ID_USER', '=', $id_user)->where('DATE_SAVE', 'like', $year . '-10%')->count();
        $chom_get11 = DB::table('happy_net_compliment')->where('ID_USER', '=', $id_user)->where('DATE_SAVE', 'like', $year . '-11%')->count();
        $chom_get12 = DB::table('happy_net_compliment')->where('ID_USER', '=', $id_user)->where('DATE_SAVE', 'like', $year . '-12%')->count();

        $pro_get1 = DB::table('happy_net_problem')->where('ID_USER', '=', $id_user)->where('DATE_SAVE', 'like', $year . '-01%')->count();
        $pro_get2 = DB::table('happy_net_problem')->where('ID_USER', '=', $id_user)->where('DATE_SAVE', 'like', $year . '-02%')->count();
        $pro_get3 = DB::table('happy_net_problem')->where('ID_USER', '=', $id_user)->where('DATE_SAVE', 'like', $year . '-03%')->count();
        $pro_get4 = DB::table('happy_net_problem')->where('ID_USER', '=', $id_user)->where('DATE_SAVE', 'like', $year . '-04%')->count();
        $pro_get5 = DB::table('happy_net_problem')->where('ID_USER', '=', $id_user)->where('DATE_SAVE', 'like', $year . '-05%')->count();
        $pro_get6 = DB::table('happy_net_problem')->where('ID_USER', '=', $id_user)->where('DATE_SAVE', 'like', $year . '-06%')->count();
        $pro_get7 = DB::table('happy_net_problem')->where('ID_USER', '=', $id_user)->where('DATE_SAVE', 'like', $year . '-07%')->count();
        $pro_get8 = DB::table('happy_net_problem')->where('ID_USER', '=', $id_user)->where('DATE_SAVE', 'like', $year . '-08%')->count();
        $pro_get9 = DB::table('happy_net_problem')->where('ID_USER', '=', $id_user)->where('DATE_SAVE', 'like', $year . '-09%')->count();
        $pro_get10 = DB::table('happy_net_problem')->where('ID_USER', '=', $id_user)->where('DATE_SAVE', 'like', $year . '-10%')->count();
        $pro_get11 = DB::table('happy_net_problem')->where('ID_USER', '=', $id_user)->where('DATE_SAVE', 'like', $year . '-11%')->count();
        $pro_get12 = DB::table('happy_net_problem')->where('ID_USER', '=', $id_user)->where('DATE_SAVE', 'like', $year . '-12%')->count();

   

        $status_modal = DB::table('happy_net_modal')
            // ->where('happy_net_modal.HAPPY_NET_MODAL_QUESTION_ID', '=', '1')
            ->where('ID_USER', '=', $id_user)
            ->get();
            
        $status_modal_set = DB::table('happy_net_modal')
        // ->where('happy_net_modal.HAPPY_NET_MODAL_QUESTION_ID', '=', '1')
        ->where('HAPPY_NET_MODAL_TYPE', '=', 'คำถาม')
        ->get();
        // dd($status_modal_set);
        $status_modal_sets = DB::table('happy_net_modal')
        // ->where('happy_net_modal.HAPPY_NET_MODAL_QUESTION_ID', '=', '1')
        ->where('HAPPY_NET_MODAL_TYPE', '=', 'ประกาศรางวัล')
        ->get();
        $coin = DB::table('happy_net_coin')
            ->select(DB::raw('sum(happy_net_coin.HAPPY_NET_COIN) as sum'), 'ID_USER')
            ->groupBy('happy_net_coin.ID_USER')
            ->where('ID_USER', '=', $id_user)
            ->sum('HAPPY_NET_COIN');

        $shop = DB::table('happy_net_shop')
            ->select(DB::raw('sum(happy_net_shop.HAPPY_NET_COIN_SHOP) as sum'), 'ID_USER')
            ->groupBy('happy_net_shop.ID_USER')
            ->where('ID_USER', '=', $id_user)
            ->sum('HAPPY_NET_COIN_SHOP');

        $sumcoin =  $coin - $shop;


        $question = DB::table('happy_net_question')
            ->select('HAPPY_NET_QUESTION_ID', 'HAPPY_NET_QUESTION', 'HAPPY_NET_QUESTION_IMAGE', 'HAPPY_NET_QUESTION_COIN', 'HAPPY_NET_QUESTION_STATUS')
            ->where('HAPPY_NET_QUESTION_STATUS', '=', 'True')
            ->get();

        $chomsum = DB::table('happy_net_compliment')
            ->where('ID_USER', '=', $id_user)
            ->where('DATE_SAVE', 'like', $year . '%')->count();
        // ->count();

        $problem_idsum = DB::table('happy_net_problem')
            ->where('ID_USER', '=', $id_user)
            ->where('DATE_SAVE', 'like', $year . '%')->count();
        // ->count();

        $chomsum_get = DB::table('happy_net_compliment')
            ->where('ID_USER_INSERT', '=', $id_user)
            ->where('DATE_SAVE', 'like', $year . '%')->count();

        $problem_idsum_get = DB::table('happy_net_problem')
            ->where('ID_USER_INSERT_PROBLEM', '=', $id_user)
            ->where('DATE_SAVE', 'like', $year . '%')->count();




        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();
        $year_id = $year + 543;


        $rank = DB::table('happy_net_problem')
            ->where('ID_USER', '=', $id_user)
            ->where('HAPPY_NET_PROBLEM_STATUS', '=', 'True')
            ->where('DATE_SAVE', 'like', $year . '%')->count();
            $rankcoin_get = DB::table('happy_net_coin')
            ->select(DB::raw('sum(happy_net_coin.HAPPY_NET_COIN) as sum'), 'ID')
            ->leftJoin('hrd_person', 'hrd_person.ID', '=', 'happy_net_coin.ID_USER')
            ->groupBy('hrd_person.ID')
            ->orderBy('sum', 'desc')
    
            ->limit(1)
    
            ->get();
            $rankans_get = DB::table('happy_net_compliment')
    
            ->select('ID_USER', DB::raw('count(*) as HAPPY_NET_COIMPLIMENT_ID'))
    
            ->groupBy('ID_USER')
            ->orderBy('HAPPY_NET_COIMPLIMENT_ID', 'desc')
            ->limit(1)
            ->get();
            $rankq_get =  DB::table('happy_net_answer')

            ->select('ID_USER', DB::raw('count(*) as HAPPY_NET_ANSWER_ID'))

            ->groupBy('ID_USER')
            ->orderBy('HAPPY_NET_ANSWER_ID', 'desc')
            ->limit(1)
            ->get();

        return view('person_happynet.dashboard_Happy_Net', [
            
            'status_modal_sets' => $status_modal_sets,
            'rankq_get' => $rankq_get,
            'rankans_get' => $rankans_get,
            'rankcoin_get' => $rankcoin_get,
            'rank' => $rank,
            'question' => $question,
            'coin' => $coin,

            'chomsum' => $chomsum,
            'problem_idsum' => $problem_idsum,
            'chomsum_get' => $chomsum_get,
            'problem_idsum_get' => $problem_idsum_get,

            'sumcoin' => $sumcoin,
            'status_modal' => $status_modal,

            'budgets' =>  $budget,
            'year_id' => $year_id,
            // 'chom_g' => $chom_g,
            // 'problem_g' => $problem_g,
            'status_modal_set'      =>  $status_modal_set,


            'chom_send1'      =>  $chom_send1,
            'chom_send2'      =>  $chom_send2,
            'chom_send3'      =>  $chom_send3,
            'chom_send4'      =>  $chom_send4,
            'chom_send5'      =>  $chom_send5,
            'chom_send6'      =>  $chom_send6,
            'chom_send7'      =>  $chom_send7,
            'chom_send8'      =>  $chom_send8,
            'chom_send9'      =>  $chom_send9,
            'chom_send10'      =>  $chom_send10,
            'chom_send11'      =>  $chom_send11,
            'chom_send12'      =>  $chom_send12,


            'pro_send1'      =>  $pro_send1,
            'pro_send2'      =>  $pro_send2,
            'pro_send3'      =>  $pro_send3,
            'pro_send4'      =>  $pro_send4,
            'pro_send5'      =>  $pro_send5,
            'pro_send6'      =>  $pro_send6,
            'pro_send7'      =>  $pro_send7,
            'pro_send8'      =>  $pro_send8,
            'pro_send9'      =>  $pro_send9,
            'pro_send10'      =>  $pro_send10,
            'pro_send11'      =>  $pro_send11,
            'pro_send12'      =>  $pro_send12,

            'chom_get1'      =>  $chom_get1,
            'chom_get2'      =>  $chom_get2,
            'chom_get3'      =>  $chom_get3,
            'chom_get4'      =>  $chom_get4,
            'chom_get5'      =>  $chom_get5,
            'chom_get6'      =>  $chom_get6,
            'chom_get7'      =>  $chom_get7,
            'chom_get8'      =>  $chom_get8,
            'chom_get9'      =>  $chom_get9,
            'chom_get10'      =>  $chom_get10,
            'chom_get11'      =>  $chom_get11,
            'chom_get12'      =>  $chom_get12,


            'pro_get1'      =>  $pro_get1,
            'pro_get2'      =>  $pro_get2,
            'pro_get3'      =>  $pro_get3,
            'pro_get4'      =>  $pro_get4,
            'pro_get5'      =>  $pro_get5,
            'pro_get6'      =>  $pro_get6,
            'pro_get7'      =>  $pro_get7,
            'pro_get8'      =>  $pro_get8,
            'pro_get9'      =>  $pro_get9,
            'pro_get10'      =>  $pro_get10,
            'pro_get11'      =>  $pro_get11,
            'pro_get12'      =>  $pro_get12,
          
           
            
        ]);
    }
    public function dashboardsearch(Request $request)
    {

        $year_id = $request->STATUS_CODE;
        $year = $year_id - 543;

        $id_user = Auth::user()->PERSON_ID;
        $status_modal = DB::table('happy_net_modal')
            // ->where('happy_net_modal.HAPPY_NET_MODAL_QUESTION_ID', '=', '1')
            ->where('ID_USER', '=', $id_user)
            ->get();


        $chom_send1 = DB::table('happy_net_compliment')->where('ID_USER_INSERT', '=', $id_user)->where('DATE_SAVE', 'like', $year . '-01%')->count();
        $chom_send2 = DB::table('happy_net_compliment')->where('ID_USER_INSERT', '=', $id_user)->where('DATE_SAVE', 'like', $year . '-02%')->count();
        $chom_send3 = DB::table('happy_net_compliment')->where('ID_USER_INSERT', '=', $id_user)->where('DATE_SAVE', 'like', $year . '-03%')->count();
        $chom_send4 = DB::table('happy_net_compliment')->where('ID_USER_INSERT', '=', $id_user)->where('DATE_SAVE', 'like', $year . '-04%')->count();
        $chom_send5 = DB::table('happy_net_compliment')->where('ID_USER_INSERT', '=', $id_user)->where('DATE_SAVE', 'like', $year . '-05%')->count();
        $chom_send6 = DB::table('happy_net_compliment')->where('ID_USER_INSERT', '=', $id_user)->where('DATE_SAVE', 'like', $year . '-06%')->count();
        $chom_send7 = DB::table('happy_net_compliment')->where('ID_USER_INSERT', '=', $id_user)->where('DATE_SAVE', 'like', $year . '-07%')->count();
        $chom_send8 = DB::table('happy_net_compliment')->where('ID_USER_INSERT', '=', $id_user)->where('DATE_SAVE', 'like', $year . '-08%')->count();
        $chom_send9 = DB::table('happy_net_compliment')->where('ID_USER_INSERT', '=', $id_user)->where('DATE_SAVE', 'like', $year . '-09%')->count();
        $chom_send10 = DB::table('happy_net_compliment')->where('ID_USER_INSERT', '=', $id_user)->where('DATE_SAVE', 'like', $year . '-10%')->count();
        $chom_send11 = DB::table('happy_net_compliment')->where('ID_USER_INSERT', '=', $id_user)->where('DATE_SAVE', 'like', $year . '-11%')->count();
        $chom_send12 = DB::table('happy_net_compliment')->where('ID_USER_INSERT', '=', $id_user)->where('DATE_SAVE', 'like', $year . '-12%')->count();

        $pro_send1 = DB::table('happy_net_problem')->where('ID_USER_INSERT_PROBLEM', '=', $id_user)->where('DATE_SAVE', 'like', $year . '-01%')->count();
        $pro_send2 = DB::table('happy_net_problem')->where('ID_USER_INSERT_PROBLEM', '=', $id_user)->where('DATE_SAVE', 'like', $year . '-02%')->count();
        $pro_send3 = DB::table('happy_net_problem')->where('ID_USER_INSERT_PROBLEM', '=', $id_user)->where('DATE_SAVE', 'like', $year . '-03%')->count();
        $pro_send4 = DB::table('happy_net_problem')->where('ID_USER_INSERT_PROBLEM', '=', $id_user)->where('DATE_SAVE', 'like', $year . '-04%')->count();
        $pro_send5 = DB::table('happy_net_problem')->where('ID_USER_INSERT_PROBLEM', '=', $id_user)->where('DATE_SAVE', 'like', $year . '-05%')->count();
        $pro_send6 = DB::table('happy_net_problem')->where('ID_USER_INSERT_PROBLEM', '=', $id_user)->where('DATE_SAVE', 'like', $year . '-06%')->count();
        $pro_send7 = DB::table('happy_net_problem')->where('ID_USER_INSERT_PROBLEM', '=', $id_user)->where('DATE_SAVE', 'like', $year . '-07%')->count();
        $pro_send8 = DB::table('happy_net_problem')->where('ID_USER_INSERT_PROBLEM', '=', $id_user)->where('DATE_SAVE', 'like', $year . '-08%')->count();
        $pro_send9 = DB::table('happy_net_problem')->where('ID_USER_INSERT_PROBLEM', '=', $id_user)->where('DATE_SAVE', 'like', $year . '-09%')->count();
        $pro_send10 = DB::table('happy_net_problem')->where('ID_USER_INSERT_PROBLEM', '=', $id_user)->where('DATE_SAVE', 'like', $year . '-10%')->count();
        $pro_send11 = DB::table('happy_net_problem')->where('ID_USER_INSERT_PROBLEM', '=', $id_user)->where('DATE_SAVE', 'like', $year . '-11%')->count();
        $pro_send12 = DB::table('happy_net_problem')->where('ID_USER_INSERT_PROBLEM', '=', $id_user)->where('DATE_SAVE', 'like', $year . '-12%')->count();


        $chom_get1 = DB::table('happy_net_compliment')->where('ID_USER', '=', $id_user)->where('DATE_SAVE', 'like', $year . '-01%')->count();
        $chom_get2 = DB::table('happy_net_compliment')->where('ID_USER', '=', $id_user)->where('DATE_SAVE', 'like', $year . '-02%')->count();
        $chom_get3 = DB::table('happy_net_compliment')->where('ID_USER', '=', $id_user)->where('DATE_SAVE', 'like', $year . '-03%')->count();
        $chom_get4 = DB::table('happy_net_compliment')->where('ID_USER', '=', $id_user)->where('DATE_SAVE', 'like', $year . '-04%')->count();
        $chom_get5 = DB::table('happy_net_compliment')->where('ID_USER', '=', $id_user)->where('DATE_SAVE', 'like', $year . '-05%')->count();
        $chom_get6 = DB::table('happy_net_compliment')->where('ID_USER', '=', $id_user)->where('DATE_SAVE', 'like', $year . '-06%')->count();
        $chom_get7 = DB::table('happy_net_compliment')->where('ID_USER', '=', $id_user)->where('DATE_SAVE', 'like', $year . '-07%')->count();
        $chom_get8 = DB::table('happy_net_compliment')->where('ID_USER', '=', $id_user)->where('DATE_SAVE', 'like', $year . '-08%')->count();
        $chom_get9 = DB::table('happy_net_compliment')->where('ID_USER', '=', $id_user)->where('DATE_SAVE', 'like', $year . '-09%')->count();
        $chom_get10 = DB::table('happy_net_compliment')->where('ID_USER', '=', $id_user)->where('DATE_SAVE', 'like', $year . '-10%')->count();
        $chom_get11 = DB::table('happy_net_compliment')->where('ID_USER', '=', $id_user)->where('DATE_SAVE', 'like', $year . '-11%')->count();
        $chom_get12 = DB::table('happy_net_compliment')->where('ID_USER', '=', $id_user)->where('DATE_SAVE', 'like', $year . '-12%')->count();

        $pro_get1 = DB::table('happy_net_problem')->where('ID_USER', '=', $id_user)->where('DATE_SAVE', 'like', $year . '-01%')->count();
        $pro_get2 = DB::table('happy_net_problem')->where('ID_USER', '=', $id_user)->where('DATE_SAVE', 'like', $year . '-02%')->count();
        $pro_get3 = DB::table('happy_net_problem')->where('ID_USER', '=', $id_user)->where('DATE_SAVE', 'like', $year . '-03%')->count();
        $pro_get4 = DB::table('happy_net_problem')->where('ID_USER', '=', $id_user)->where('DATE_SAVE', 'like', $year . '-04%')->count();
        $pro_get5 = DB::table('happy_net_problem')->where('ID_USER', '=', $id_user)->where('DATE_SAVE', 'like', $year . '-05%')->count();
        $pro_get6 = DB::table('happy_net_problem')->where('ID_USER', '=', $id_user)->where('DATE_SAVE', 'like', $year . '-06%')->count();
        $pro_get7 = DB::table('happy_net_problem')->where('ID_USER', '=', $id_user)->where('DATE_SAVE', 'like', $year . '-07%')->count();
        $pro_get8 = DB::table('happy_net_problem')->where('ID_USER', '=', $id_user)->where('DATE_SAVE', 'like', $year . '-08%')->count();
        $pro_get9 = DB::table('happy_net_problem')->where('ID_USER', '=', $id_user)->where('DATE_SAVE', 'like', $year . '-09%')->count();
        $pro_get10 = DB::table('happy_net_problem')->where('ID_USER', '=', $id_user)->where('DATE_SAVE', 'like', $year . '-10%')->count();
        $pro_get11 = DB::table('happy_net_problem')->where('ID_USER', '=', $id_user)->where('DATE_SAVE', 'like', $year . '-11%')->count();
        $pro_get12 = DB::table('happy_net_problem')->where('ID_USER', '=', $id_user)->where('DATE_SAVE', 'like', $year . '-12%')->count();

        $rank = DB::table('happy_net_problem')
            ->where('ID_USER', '=', $id_user)
            ->where('HAPPY_NET_PROBLEM_STATUS', '=', 'True')
            ->where('DATE_SAVE', 'like', $year . '%')->count();


        $coin = DB::table('happy_net_coin')
            ->select(DB::raw('sum(happy_net_coin.HAPPY_NET_COIN) as sum'), 'ID_USER')
            ->groupBy('happy_net_coin.ID_USER')
            ->where('ID_USER', '=', $id_user)
            ->sum('HAPPY_NET_COIN');

        $shop = DB::table('happy_net_shop')
            ->select(DB::raw('sum(happy_net_shop.HAPPY_NET_COIN_SHOP) as sum'), 'ID_USER')
            ->groupBy('happy_net_shop.ID_USER')
            ->where('ID_USER', '=', $id_user)
            ->sum('HAPPY_NET_COIN_SHOP');

        $sumcoin =  $coin - $shop;


        $question = DB::table('happy_net_question')
            ->select('HAPPY_NET_QUESTION_ID', 'HAPPY_NET_QUESTION', 'HAPPY_NET_QUESTION_IMAGE', 'HAPPY_NET_QUESTION_COIN', 'HAPPY_NET_QUESTION_STATUS')
            ->where('HAPPY_NET_QUESTION_STATUS', '=', 'True')
            ->get();

        $chomsum = DB::table('happy_net_compliment')
            ->where('ID_USER', '=', $id_user)
            ->where('DATE_SAVE', 'like', $year . '%')->count();
        // ->count();

        $problem_idsum = DB::table('happy_net_problem')
            ->where('ID_USER', '=', $id_user)
            ->where('DATE_SAVE', 'like', $year . '%')->count();
        // ->count();

        $chomsum_get = DB::table('happy_net_compliment')
            ->where('ID_USER_INSERT', '=', $id_user)
            ->where('DATE_SAVE', 'like', $year . '%')->count();

        $problem_idsum_get = DB::table('happy_net_problem')
            ->where('ID_USER_INSERT_PROBLEM', '=', $id_user)
            ->where('DATE_SAVE', 'like', $year . '%')->count();

        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();

        $year_id = $year + 543;



        return view('person_happynet.dashboard_Happy_Net', [
            'rank' => $rank,
            'question' => $question,
            'coin' => $coin,

            'chomsum' => $chomsum,
            'problem_idsum' => $problem_idsum,
            'chomsum_get' => $chomsum_get,
            'problem_idsum_get' => $problem_idsum_get,

            'sumcoin' => $sumcoin,
            'status_modal' => $status_modal,


            // 'chom_g' => $chom_g,
            // 'problem_g' => $problem_g,

            'chom_send1'      =>  $chom_send1,
            'chom_send2'      =>  $chom_send2,
            'chom_send3'      =>  $chom_send3,
            'chom_send4'      =>  $chom_send4,
            'chom_send5'      =>  $chom_send5,
            'chom_send6'      =>  $chom_send6,
            'chom_send7'      =>  $chom_send7,
            'chom_send8'      =>  $chom_send8,
            'chom_send9'      =>  $chom_send9,
            'chom_send10'      =>  $chom_send10,
            'chom_send11'      =>  $chom_send11,
            'chom_send12'      =>  $chom_send12,


            'pro_send1'      =>  $pro_send1,
            'pro_send2'      =>  $pro_send2,
            'pro_send3'      =>  $pro_send3,
            'pro_send4'      =>  $pro_send4,
            'pro_send5'      =>  $pro_send5,
            'pro_send6'      =>  $pro_send6,
            'pro_send7'      =>  $pro_send7,
            'pro_send8'      =>  $pro_send8,
            'pro_send9'      =>  $pro_send9,
            'pro_send10'      =>  $pro_send10,
            'pro_send11'      =>  $pro_send11,
            'pro_send12'      =>  $pro_send12,

            'chom_get1'      =>  $chom_get1,
            'chom_get2'      =>  $chom_get2,
            'chom_get3'      =>  $chom_get3,
            'chom_get4'      =>  $chom_get4,
            'chom_get5'      =>  $chom_get5,
            'chom_get6'      =>  $chom_get6,
            'chom_get7'      =>  $chom_get7,
            'chom_get8'      =>  $chom_get8,
            'chom_get9'      =>  $chom_get9,
            'chom_get10'      =>  $chom_get10,
            'chom_get11'      =>  $chom_get11,
            'chom_get12'      =>  $chom_get12,


            'pro_get1'      =>  $pro_get1,
            'pro_get2'      =>  $pro_get2,
            'pro_get3'      =>  $pro_get3,
            'pro_get4'      =>  $pro_get4,
            'pro_get5'      =>  $pro_get5,
            'pro_get6'      =>  $pro_get6,
            'pro_get7'      =>  $pro_get7,
            'pro_get8'      =>  $pro_get8,
            'pro_get9'      =>  $pro_get9,
            'pro_get10'      =>  $pro_get10,
            'pro_get11'      =>  $pro_get11,
            'pro_get12'      =>  $pro_get12,

            'budgets' =>  $budget,
            'year_id' => $year_id,
        ]);
    }

    public function question_dashboard(Request $request)
    {
        $question = DB::table('happy_net_question_group') 
        ->leftJoin('happy_net_question', 'happy_net_question_group.HAPPY_NET_QUESTION_GROUP_ID', '=', 'happy_net_question.HAPPY_NET_QUESTION_ID_GROUP')
        ->where('HAPPY_NET_QUESTION_GROUP_STATUS', '=', 'True')
        ->where('HAPPY_NET_QUESTION_STATUS', '=', 'True')
        ->get();
// dd($question);
       
        return view('person_happynet.question_dashboard_Happy_Net', [
            'question' => $question,
        ]);
    }
    public function save_question_dashboard(Request $request)
    {

        $save_question_dashboard = new Answer();
        $save_question_dashboard->HAPPY_NET_ANSWER_SCORE = $request->HAPPY_NET_ANSWER_SCORE;
        // dd($request);

        $save_question_dashboard->HAPPY_NET_DIFFICULTY_COIN = $request->HAPPY_NET_DIFFICULTY_COIN;
        $save_question_dashboard->save();

        return redirect()->route('Happy_Net');
    }


    public function inseartdata(Request $request)
    {
        $idref =  $request->idref;

        $resultyn =  $request->resultyn;

        // dd($request);
        $id_user = Auth::user()->PERSON_ID;
        $save_question_dashboard = new Answer();

        $save_question_dashboard->HAPPY_NET_QUESTION_ID = $idref;
        $save_question_dashboard->HAPPY_NET_ANSWER_SCORE = $resultyn;

        $save_question_dashboard->ID_USER = $id_user;
    }


    public function sum_question_dashboard(Request $request)

    { $id_user = Auth::user()->PERSON_ID;
        $set_coin = DB::table('happy_net_set_coin')
        ->sum('HAPPY_NET_SET_COIN');
        $coin = DB::table('happy_net_coin')
        ->where('DATE_SAVE','=',date('Y-m-d'))
        ->where('HAPPY_NET_COIN_TYPE','=','ช่วยปัญหาจากบุคลากร')
        ->where('ID_USER','=',$id_user)
        ->get();
        $coins = DB::table('happy_net_coin')
            ->where('DATE_SAVE','=',date('Y-m-d'))
            ->where('HAPPY_NET_COIN_TYPE','=','ช่วยปัญหาจากบุคลากร')
            ->where('ID_USER','=',$id_user)
            ->sum('HAPPY_NET_COIN');
        $infosum = DB::table('happy_net_question')
            ->where('HAPPY_NET_QUESTION_STATUS', '=', 'True')
            ->sum('HAPPY_NET_QUESTION_COIN');
        // dd($infosum);

        return view('person_happynet.sum_question_dashboard_Happy_Net', [
            'infosum' => $infosum,
            'set_coin' => $set_coin,
            'coin' => $coin,
            'coins' => $coins,
        ]);
    }

    public function get_question_dashboard(Request $request)
    {
        // dd($request->HAPPY_NET_DIFFICULTY);
        $infosum = DB::table('happy_net_question')
            ->where('HAPPY_NET_QUESTION_STATUS', '=', 'True')
            ->sum('HAPPY_NET_QUESTION_COIN');
        $type = ('การตอบคำถาม');
        // dd($type);
        $id_user = Auth::user()->PERSON_ID;


        

        $get_question_dashboard = new Coin();

        // $get_question_dashboard = $request->HAPPY_NET_COIN_TYPE;
        $get_question_dashboard->HAPPY_NET_COIN = $infosum;
        $get_question_dashboard->ID_USER = $id_user;
        $get_question_dashboard->HAPPY_NET_COIN_TYPE = $type;
        $get_question_dashboard->DATE_SAVE = date('Y-m-d');
        $get_question_dashboard->ID_USER_GIVE = 0;
       
       
    
        $happy_net_modal = DB::table('happy_net_modal')
        ->where('ID_USER','=',$id_user)
        ->where('DATE_SAVE','=',date('Y-m-d'))
        ->count();
    // dd($happy_net_modal);
        if($happy_net_modal == 0){
        //     $save_modal = new Emodal_Happy();
        //     $save_modal->HAPPY_NET_MODAL_QUESTION = "True";
        //     $save_modal->ID_USER = $id_user;
        //    //  dd($save_modal);
        //    $save_modal->DATE_SAVE = date('Y-m-d');1
        //     $save_modal->save();
       
        $get_question_dashboard->save();
        return redirect()->route('Happy_Net');
        }else{
            $id = DB::table('happy_net_modal')
            ->where('ID_USER','=',$id_user)
            ->select('ID_USER')
            ->get();
    // dd($id);
    
            $update_modal = Emodal_Happy::where('ID_USER', '=', $id_user)->first();
            // dd($update_modal);
            $update_modal->HAPPY_NET_MODAL_QUESTION = "False";
            $update_modal->ID_USER = $id_user;
            $update_modal->DATE_SAVE = date('Y-m-d');
            $update_modal->save();
    //  dd($update_modal);
        }
        
        $get_question_dashboard->save();
        return redirect()->route('Happy_Net');

    }

    public function respond($id)
    {
        $pr_id = DB::table('happy_net_problem')
            ->leftJoin('hrd_person', 'happy_net_problem.ID_USER', '=', 'hrd_person.ID')
            // ->get();
            ->where('happy_net_problem.HAPPY_NET_PROBLEM_ID', '=', $id)->first();
        // dd($pr_id);

        $coins = DB::table('happy_net_problem')
            ->leftJoin('happy_net_difficulty', 'happy_net_problem.HAPPY_NET_DIFFICULTY_ID', '=', 'happy_net_difficulty.HAPPY_NET_DIFFICULTY_ID')
            ->where('happy_net_problem.HAPPY_NET_PROBLEM_ID', '=', $id)->first();
        // dd($coins);
        $SEtable = DB::table('happy_net_difficulty')
            ->select('happy_net_difficulty.HAPPY_NET_DIFFICULTY_ID', 'HAPPY_NET_DIFFICULTY', 'HAPPY_NET_DIFFICULTY_STATUS', 'HAPPY_NET_DIFFICULTY_COIN')
            ->orderBy('happy_net_difficulty.HAPPY_NET_DIFFICULTY_ID', 'asc')
            ->get();

        $problem_id = DB::table('happy_net_problem')
            ->leftJoin('hrd_person', 'happy_net_problem.ID_USER', '=', 'hrd_person.ID')
            // ->where('HAPPY_NET_PROBLEM_STATUS', '=', 'False')
            ->orderBy('HAPPY_NET_PROBLEM_ID', 'desc')
            ->get();




        $id_user = Auth::user()->PERSON_ID;
        // $name_user =  DB::table('hrd_person')->where('ID', '=', $id_user)->first();

        $inforperson =  Person::leftJoin('hrd_prefix', 'hrd_person.HR_PREFIX_ID', '=', 'hrd_prefix.HR_PREFIX_ID')
            ->leftJoin('hrd_sex', 'hrd_person.SEX', '=', 'hrd_sex.SEX_ID')
            ->leftJoin('hrd_status', 'hrd_person.HR_STATUS_ID', '=', 'hrd_status.HR_STATUS_ID')
            ->leftJoin('hrd_level', 'hrd_person.HR_LEVEL_ID', '=', 'hrd_level.HR_LEVEL_ID')
            ->leftJoin('hrd_department_sub_sub', 'hrd_person.HR_DEPARTMENT_SUB_SUB_ID', '=', 'hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
            ->leftJoin('hrd_department', 'hrd_person.HR_DEPARTMENT_ID', '=', 'hrd_department.HR_DEPARTMENT_ID')
            ->leftJoin('hrd_department_sub', 'hrd_person.HR_DEPARTMENT_SUB_ID', '=', 'hrd_department_sub.HR_DEPARTMENT_SUB_ID')
            ->where('hrd_person.HR_STATUS_ID', '=', 1)
            ->where('ID', '=', $id_user)->first();

        $ans = DB::table('happy_net_problem_answer')
            // ->leftJoin('happy_net_problem', 'happy_net_problem_answer.HAPPY_NET_PROBLEM_QUESTION_ID', '=', 'happy_net_problem.HAPPY_NET_PROBLEM_ID')
            ->orderBy('HAPPY_NET_PROBLEM_ANSWER_ID', 'desc')
            ->where('HAPPY_NET_PROBLEM_QUESTION_ID', '=', $id)->get();
        // ->get();
        // dd($ans);
        // $answer = DB::table('happy_net_problem_answer')
        //     // ->leftJoin('happy_net_problem_answer', 'happy_net_problem.HAPPY_NET_PROBLEM_ID', '=', 'happy_net_problem_answer.HAPPY_NET_PROBLEM_ID')
        //     ->leftJoin('happy_net_problem', 'happy_net_problem_answer.HAPPY_NET_PROBLEM_ID', '=', 'happy_net_problem.HAPPY_NET_PROBLEM_ID')
        //     ->where('happy_net_problem_answer.HAPPY_NET_PROBLEM_ID', '=', $id)->first();
        // dd($answer);



        return view('person_happynet.respond_Happy_Net', [
            'pr_id' => $pr_id,
            'SEtable' => $SEtable,
            'problem_id' => $problem_id,
            'coins' => $coins,
            'inforperson' => $inforperson,
            'ans' => $ans,


        ]);
    }
    public function respond_ans(Request $request)
    {
        // dd($request->HAPPY_NET_PROBLEM_ID);
        $id_user = Auth::user()->PERSON_ID;
        $tests = new problem_answer_happy();
        $tests->ID_USER = $id_user;
        $tests->HAPPY_NET_PROBLEM_QUESTION_ID = $request->HAPPY_NET_PROBLEM_ID;;
        $tests->HAPPY_NET_PROBLEM_ANSWER = $request->HAPPY_NET_PROBLEM_ANSWER;
        $tests->HAPPY_NET_PROBLEM_ANSWER_FNAME = $request->HAPPY_NET_PROBLEM_ANSWER_FNAME;
        $tests->HAPPY_NET_PROBLEM_ANSWER_LNAME = $request->HAPPY_NET_PROBLEM_ANSWER_LNAME;
        // dd($tests);  

        $tests->save();
        // return redirect()->route('send_user');
        return redirect()->route('happy.send_user')->with('success', 'ตอบปัญหาเรียบร้อยแล้ว');
    }
    public function respond_ans_get($id)
    {
        $pr_id = DB::table('happy_net_problem')
            ->leftJoin('hrd_person', 'happy_net_problem.ID_USER', '=', 'hrd_person.ID')
            // ->get();
            ->where('happy_net_problem.HAPPY_NET_PROBLEM_ID', '=', $id)->first();
        // dd($pr_id);

        $coins = DB::table('happy_net_problem')
            ->leftJoin('happy_net_difficulty', 'happy_net_problem.HAPPY_NET_DIFFICULTY_ID', '=', 'happy_net_difficulty.HAPPY_NET_DIFFICULTY_ID')
            ->where('happy_net_problem.HAPPY_NET_PROBLEM_ID', '=', $id)->first();
        // dd($coins);
        $SEtable = DB::table('happy_net_difficulty')
            ->select('happy_net_difficulty.HAPPY_NET_DIFFICULTY_ID', 'HAPPY_NET_DIFFICULTY', 'HAPPY_NET_DIFFICULTY_STATUS', 'HAPPY_NET_DIFFICULTY_COIN')
            ->orderBy('happy_net_difficulty.HAPPY_NET_DIFFICULTY_ID', 'asc')
            ->get();

        $problem_id = DB::table('happy_net_problem')
            ->leftJoin('hrd_person', 'happy_net_problem.ID_USER', '=', 'hrd_person.ID')
            ->orderBy('HAPPY_NET_PROBLEM_ID', 'desc')
            // ->where('HAPPY_NET_PROBLEM_STATUS', '=', 'False')
            ->get();


        $id_user = Auth::user()->PERSON_ID;
        // $name_user =  DB::table('hrd_person')->where('ID', '=', $id_user)->first();

        $inforperson =  Person::leftJoin('hrd_prefix', 'hrd_person.HR_PREFIX_ID', '=', 'hrd_prefix.HR_PREFIX_ID')
            ->leftJoin('hrd_sex', 'hrd_person.SEX', '=', 'hrd_sex.SEX_ID')
            ->leftJoin('hrd_status', 'hrd_person.HR_STATUS_ID', '=', 'hrd_status.HR_STATUS_ID')
            ->leftJoin('hrd_level', 'hrd_person.HR_LEVEL_ID', '=', 'hrd_level.HR_LEVEL_ID')
            ->leftJoin('hrd_department_sub_sub', 'hrd_person.HR_DEPARTMENT_SUB_SUB_ID', '=', 'hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
            ->leftJoin('hrd_department', 'hrd_person.HR_DEPARTMENT_ID', '=', 'hrd_department.HR_DEPARTMENT_ID')
            ->leftJoin('hrd_department_sub', 'hrd_person.HR_DEPARTMENT_SUB_ID', '=', 'hrd_department_sub.HR_DEPARTMENT_SUB_ID')
            ->where('hrd_person.HR_STATUS_ID', '=', 1)
            ->where('ID', '=', $id_user)->first();

        $ans = DB::table('happy_net_problem_answer')
            ->orderBy('HAPPY_NET_PROBLEM_ANSWER_ID', 'desc')
            ->where('HAPPY_NET_PROBLEM_QUESTION_ID', '=', $id)->get();




        return view('person_happynet.respond_ans_get_Happy_Net', [
            'pr_id' => $pr_id,
            'SEtable' => $SEtable,
            'problem_id' => $problem_id,
            'coins' => $coins,
            'inforperson' => $inforperson,
            'ans' => $ans,


        ]);
    }
    public function respond_ans_get_Happy_Nets(Request $request)
    {
        // dd($request->HAPPY_NET_PROBLEM_ID);
        $id_user = Auth::user()->PERSON_ID;
        $tests = new problem_answer_happy();
        $tests->ID_USER = $id_user;
        $tests->HAPPY_NET_PROBLEM_QUESTION_ID = $request->HAPPY_NET_PROBLEM_ID;;
        $tests->HAPPY_NET_PROBLEM_ANSWER = $request->HAPPY_NET_PROBLEM_ANSWER;
        $tests->HAPPY_NET_PROBLEM_ANSWER_FNAME = $request->HAPPY_NET_PROBLEM_ANSWER_FNAME;
        $tests->HAPPY_NET_PROBLEM_ANSWER_LNAME = $request->HAPPY_NET_PROBLEM_ANSWER_LNAME;


        // dd($tests);  

        $tests->save();
        // return redirect()->route('send_user');
        return redirect()->route('happy.send_user')->with('success', 'ตอบปัญหาเรียบร้อยแล้ว');
    }


    public function send_user()
    {

        $id_user = Auth::user()->PERSON_ID;
        $m_budget = date("m");
        if ((int)$m_budget > 9) {
            $yearbudget = date("Y") + 544;
        } else {
            $yearbudget = date("Y") + 543;
        }

        $year_ = array();
        for ($i = $yearbudget; $i >= $yearbudget - 9; $i--) {
            $year_[$i] = $i;
        }
        $data['year_'] = $year_;

        $data['yearbudget_select'] = $yearbudget;
        $year = $data['yearbudget_select'] - 543;
        if (isset($_GET['yearbudget_select'])) {
            $data['yearbudget_select'] = $_GET['yearbudget_select'];
        }

        $year = date('Y');
        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();

        $year_id = $year + 543;

        $person = Person::leftJoin('hrd_prefix', 'hrd_person.HR_PREFIX_ID', '=', 'hrd_prefix.HR_PREFIX_ID')
            ->leftJoin('hrd_sex', 'hrd_person.SEX', '=', 'hrd_sex.SEX_ID')
            ->leftJoin('hrd_status', 'hrd_person.HR_STATUS_ID', '=', 'hrd_status.HR_STATUS_ID')
            ->leftJoin('hrd_level', 'hrd_person.HR_LEVEL_ID', '=', 'hrd_level.HR_LEVEL_ID')
            ->leftJoin('hrd_department_sub_sub', 'hrd_person.HR_DEPARTMENT_SUB_SUB_ID', '=', 'hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
            ->leftJoin('hrd_department', 'hrd_person.HR_DEPARTMENT_ID', '=', 'hrd_department.HR_DEPARTMENT_ID')
            ->leftJoin('hrd_department_sub', 'hrd_person.HR_DEPARTMENT_SUB_ID', '=', 'hrd_department_sub.HR_DEPARTMENT_SUB_ID')
            ->leftJoin('hrd_bloodgroup', 'hrd_person.HR_BLOODGROUP_ID', '=', 'hrd_bloodgroup.HR_BLOODGROUP_ID')
            ->leftJoin('hrd_marry_status', 'hrd_person.HR_MARRY_STATUS_ID', '=', 'hrd_marry_status.HR_MARRY_STATUS_ID')
            ->leftJoin('hrd_religion', 'hrd_person.HR_RELIGION_ID', '=', 'hrd_religion.HR_RELIGION_ID')
            ->leftJoin('hrd_nationality', 'hrd_person.HR_NATIONALITY_ID', '=', 'hrd_nationality.HR_NATIONALITY_ID')
            ->leftJoin('hrd_citizenship', 'hrd_person.HR_CITIZENSHIP_ID', '=', 'hrd_citizenship.HR_CITIZENSHIP_ID')
            ->leftJoin('hrd_tumbon', 'hrd_person.TUMBON_ID', '=', 'hrd_tumbon.ID')
            ->leftJoin('hrd_amphur', 'hrd_person.AMPHUR_ID', '=', 'hrd_amphur.ID')
            ->leftJoin('hrd_province', 'hrd_person.PROVINCE_ID', '=', 'hrd_province.ID')
            ->leftJoin('hrd_kind', 'hrd_person.HR_KIND_ID', '=', 'hrd_kind.HR_KIND_ID')
            ->leftJoin('hrd_kind_type', 'hrd_person.HR_KIND_TYPE_ID', '=', 'hrd_kind_type.HR_KIND_TYPE_ID')
            ->leftJoin('hrd_person_type', 'hrd_person.HR_PERSON_TYPE_ID', '=', 'hrd_person_type.HR_PERSON_TYPE_ID')
            ->where('hrd_person.HR_STATUS_ID', '=', 1)
            ->get();

        $count = Person::count();

        $problem_s = DB::table('happy_net_problem')
            ->leftJoin('hrd_person', 'happy_net_problem.ID_USER', '=', 'hrd_person.ID')
            ->leftJoin('happy_net_difficulty', 'happy_net_problem.HAPPY_NET_DIFFICULTY_ID', '=', 'happy_net_difficulty.HAPPY_NET_DIFFICULTY_ID')
            ->orderBy('HAPPY_NET_PROBLEM_ID', 'desc')
            ->where('ID_USER', '=', $id_user)
            // ->get();
            ->where('HAPPY_NET_PROBLEM_STATUS', '=', 'False')
            ->where('DATE_SAVE', 'like', $year . '%')->get();
            $problem_id = DB::table('happy_net_problem')
            ->leftJoin('hrd_person', 'happy_net_problem.ID_USER', '=', 'hrd_person.ID')
            ->orderBy('HAPPY_NET_PROBLEM_ID', 'desc')
            ->where('HAPPY_NET_PROBLEM_STATUS', '=', 'False')
            ->where('ID_USER_INSERT_PROBLEM', '=', $id_user)
            
            ->where('DATE_SAVE', 'like', $year . '%')
            ->get();

        $inforperson =  Person::leftJoin('hrd_prefix', 'hrd_person.HR_PREFIX_ID', '=', 'hrd_prefix.HR_PREFIX_ID')
            ->leftJoin('hrd_sex', 'hrd_person.SEX', '=', 'hrd_sex.SEX_ID')
            ->leftJoin('hrd_status', 'hrd_person.HR_STATUS_ID', '=', 'hrd_status.HR_STATUS_ID')
            ->leftJoin('hrd_level', 'hrd_person.HR_LEVEL_ID', '=', 'hrd_level.HR_LEVEL_ID')
            ->leftJoin('hrd_department_sub_sub', 'hrd_person.HR_DEPARTMENT_SUB_SUB_ID', '=', 'hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
            ->leftJoin('hrd_department', 'hrd_person.HR_DEPARTMENT_ID', '=', 'hrd_department.HR_DEPARTMENT_ID')
            ->leftJoin('hrd_department_sub', 'hrd_person.HR_DEPARTMENT_SUB_ID', '=', 'hrd_department_sub.HR_DEPARTMENT_SUB_ID')
            ->where('hrd_person.HR_STATUS_ID', '=', 1)
            ->where('hrd_person.ID','<>',$id_user)
            ->get();
        //    dd($inforperson);

        $chom = DB::table('happy_net_compliment')
        ->where('DATE_SAVE', 'like', $year . '%')->get();

        $chom_id = DB::table('happy_net_compliment')
            ->leftJoin('hrd_person', 'happy_net_compliment.ID_USER', '=', 'hrd_person.ID')
            ->orderBy('HAPPY_NET_COIMPLIMENT_ID', 'desc')
            ->where('ID_USER_INSERT', '=', $id_user)
            ->where('DATE_SAVE', 'like', $year . '%')->get();
        // dd($chom_id);
     


        $pr_id = DB::table('happy_net_problem')
            ->leftJoin('hrd_person', 'happy_net_problem.ID_USER', '=', 'hrd_person.ID')
            ->where('DATE_SAVE', 'like', $year . '%')->get();
        // ->where('happy_net_problem.HAPPY_NET_PROBLEM_ID','=',$id)->first();
        // dd($pr_id);


        $chomsum = DB::table('happy_net_compliment')
            ->where('ID_USER_INSERT', '=', $id_user)
            // ->count();
            ->where('DATE_SAVE', 'like', $year . '%')->count();

        $problem_idsum = DB::table('happy_net_problem')
            ->where('ID_USER_INSERT_PROBLEM', '=', $id_user)
            // ->where('HAPPY_NET_PROBLEM_STATUS', '=', 'False')
            // ->count();
            ->where('DATE_SAVE', 'like', $year . '%')->count();


            $problem_idsum_get = DB::table('happy_net_problem')
            ->where('ID_USER', '=', $id_user)
            // ->count();
            ->where('DATE_SAVE', 'like', $year . '%')->count();

        $inforpersons =  Person::leftJoin('hrd_prefix', 'hrd_person.HR_PREFIX_ID', '=', 'hrd_prefix.HR_PREFIX_ID')
            ->leftJoin('hrd_sex', 'hrd_person.SEX', '=', 'hrd_sex.SEX_ID')
            ->leftJoin('hrd_status', 'hrd_person.HR_STATUS_ID', '=', 'hrd_status.HR_STATUS_ID')
            ->leftJoin('hrd_level', 'hrd_person.HR_LEVEL_ID', '=', 'hrd_level.HR_LEVEL_ID')
            ->leftJoin('hrd_department_sub_sub', 'hrd_person.HR_DEPARTMENT_SUB_SUB_ID', '=', 'hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
            ->leftJoin('hrd_department', 'hrd_person.HR_DEPARTMENT_ID', '=', 'hrd_department.HR_DEPARTMENT_ID')
            ->leftJoin('hrd_department_sub', 'hrd_person.HR_DEPARTMENT_SUB_ID', '=', 'hrd_department_sub.HR_DEPARTMENT_SUB_ID')
            ->where('hrd_person.HR_STATUS_ID', '=', 1)
            ->where('ID', '=', $id_user)->first();
      
            $pro_id_if = DB::table('happy_net_problem')
            ->where('DATE_SAVE','=',date('Y-m-d'))
            ->where('ID_USER_INSERT_PROBLEM','=',$id_user)
            // ->where('happy_net_compliment.HAPPY_NET_COIMPLIMENT_ID', '=', $id)->first();
            ->count();
            // dd($chom_id_if);
            $set_compliment = DB::table('happy_net_set_problem')
            ->sum('HAPPY_NET_SET_PROBLEM');
            // ->get();
            $countview = $set_compliment-$pro_id_if;
            // dd($countview);

        return view('person_happynet.send_user_Happy_Net', [
            'inforperson' => $inforperson,
            'inforpersons' => $inforpersons,
            'chom' => $chom,
            'chom_id' => $chom_id,
            'problem_id' => $problem_id,

            'pr_id' => $pr_id,
            'id_user' => $id_user,

            'chomsum' => $chomsum,
            'problem_idsum' => $problem_idsum,
            'problem_s' => $problem_s,

            'persons' => $person,
            'count' => $count,
            'problem_idsum_get' => $problem_idsum_get,
            'set_compliment' => $set_compliment,
            // 'budgets' =>  $budget,
            // 'year_id' => $year_id,
            'countview' => $countview,
        ]);
    }


    public function send_user_id($id)
    {

        $id_user = Auth::user()->PERSON_ID;
        $userid =  Person::where('hrd_person.ID', '=', $id)->first();
   

        // $userid =  Person::leftJoin('hrd_prefix', 'hrd_person.HR_PREFIX_ID', '=', 'hrd_prefix.HR_PREFIX_ID')
        // ->leftJoin('hrd_sex', 'hrd_person.SEX', '=', 'hrd_sex.SEX_ID')
        // ->leftJoin('hrd_status', 'hrd_person.HR_STATUS_ID', '=', 'hrd_status.HR_STATUS_ID')
        // ->leftJoin('hrd_level', 'hrd_person.HR_LEVEL_ID', '=', 'hrd_level.HR_LEVEL_ID')
        // ->leftJoin('hrd_department_sub_sub', 'hrd_person.HR_DEPARTMENT_SUB_SUB_ID', '=', 'hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
        // ->leftJoin('hrd_department', 'hrd_person.HR_DEPARTMENT_ID', '=', 'hrd_department.HR_DEPARTMENT_ID')
        // ->leftJoin('hrd_department_sub', 'hrd_person.HR_DEPARTMENT_SUB_ID', '=', 'hrd_department_sub.HR_DEPARTMENT_SUB_ID')
        // ->where('hrd_person.HR_STATUS_ID', '=', 1)
        // // ->get();
        // ->where('ID', '=', $id)->first();

        // dd($userid);

        $ets = DB::table('happy_net_ethics')
        ->orderBy('HAPPY_NET_SET_ETHICS_ID', 'asc')
        ->where('HAPPY_NET_SET_ETHICS_STATUS', '=', 'True')
        ->get();
        

        $SEtable = DB::table('happy_net_difficulty')
            ->select('happy_net_difficulty.HAPPY_NET_DIFFICULTY_ID', 'HAPPY_NET_DIFFICULTY', 'HAPPY_NET_DIFFICULTY_STATUS', 'HAPPY_NET_DIFFICULTY_COIN')
            ->orderBy('happy_net_difficulty.HAPPY_NET_DIFFICULTY_ID', 'asc')
            ->where('HAPPY_NET_DIFFICULTY_STATUS', '=', 'True')
            ->get();

            $chom_id_if = DB::table('happy_net_compliment')
            ->where('DATE_SAVE','=',date('Y-m-d'))
            ->where('ID_USER_INSERT','=',$id_user)
            // ->where('happy_net_compliment.HAPPY_NET_COIMPLIMENT_ID', '=', $id)->first();
            ->count();
            // dd($chom_id_if);

            $set_compliment = DB::table('happy_net_set_compliment')
            ->sum('HAPPY_NET_SET_COMPLIMENT');
            //  dd($set_compliment);

        return view('person_happynet.send_user_id_Happy_Net', [
            'userid' => $userid,
            'SEtable' => $SEtable,
            'chom_id_if' => $chom_id_if,
            'id_user' => $id_user,
            'set_compliment' => $set_compliment,
            'ets' => $ets,
        ]);
    }

    public function edit_send_user_id($id)
    {
        // dd($user);
        $chom_id = DB::table('happy_net_compliment')
            ->leftJoin('hrd_person', 'happy_net_compliment.ID_USER', '=', 'hrd_person.ID')
            // ->get();
            ->where('happy_net_compliment.HAPPY_NET_COIMPLIMENT_ID', '=', $id)->first();
        // dd($chom_id);


        $SEtable = DB::table('happy_net_difficulty')
            ->select('happy_net_difficulty.HAPPY_NET_DIFFICULTY_ID', 'HAPPY_NET_DIFFICULTY', 'HAPPY_NET_DIFFICULTY_STATUS', 'HAPPY_NET_DIFFICULTY_COIN')
            ->orderBy('happy_net_difficulty.HAPPY_NET_DIFFICULTY_ID', 'asc')
            ->where('HAPPY_NET_DIFFICULTY_STATUS', '=', 'True')
            ->get();

    
        return view('person_happynet.edit_send_user_id_Happy_Net', [
            // 'userid' => $userid,
            'SEtable' => $SEtable,
        
            'chom_id' => $chom_id,
        ]);
    }
    public function save_send_user(Request $request)
    {
        $id_user = Auth::user()->PERSON_ID;
        $save_send_user = new compliment_happy();
        $save_send_user->HAPPY_NET_COIMPLIMENT = $request->HAPPY_NET_COIMPLIMENT;
        $save_send_user->ID_USER = $request->ID_USER;
        $save_send_user->HAPPY_NET_DIFFICULTY_ID = $request->HAPPY_NET_DIFFICULTY_ID;

        $save_send_user->HAPPY_NET_COIMPLIMENT_FNAME = $request->HAPPY_NET_COIMPLIMENT_FNAME;
        $save_send_user->HAPPY_NET_COIMPLIMENT_LNAME = $request->HAPPY_NET_COIMPLIMENT_LNAME;
        $save_send_user->HAPPY_NET_SET_ID_ETHICS = $request->HAPPY_NET_SET_ID_ETHICS;
        $save_send_user->ID_USER_INSERT = $request->ID_USER_INSERT;
        $save_send_user->DATE_SAVE = date('Y-m-d');

        $save_coin = new Coin();
        $save_coin->HAPPY_NET_COIN = '1';
        $save_coin->ID_USER = $request->ID_USER;
        $save_coin->ID_USER_GIVE =  $id_user;
        $save_coin->HAPPY_NET_COIN_TYPE = 'คำชื่นชม';
        $save_coin->DATE_SAVE = date('Y-m-d');
        // dd($save_coin);
    
            $save_coin->save();
            $save_send_user->save();


               
           function DateThailinecar($strDate)
           {
             $strYear = date("Y",strtotime($strDate))+543;
             $strMonth= date("n",strtotime($strDate));
             $strDay= date("j",strtotime($strDate));
     
             $strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
             $strMonthThai=$strMonthCut[$strMonth];
             return "$strDay $strMonthThai $strYear";
             }


            $header = "ระบบความสุขของบุคลากร";
           
          

            $datebegin = DateThailinecar( date('Y-m-d')); 
        
            
               
          
            // $leave_type = DB::table('gleave_type')->where('LEAVE_TYPE_ID','=',$type_leave)->first(); 
            // $hrd_department = DB::table('hrd_department')->where('HR_DEPARTMENT_ID','=',$request->LEAVE_DEPARTMENT_ID)->first(); 
            
       
    
            $id_user_send = $request->ID_USER_INSERT;

            $namesend  = DB::table('hrd_person')->where('ID','=',$id_user_send)
            ->first(); 
            $ets_get = $request->HAPPY_NET_SET_ID_ETHICS;
            $namesends  = DB::table('happy_net_ethics')->where('HAPPY_NET_SET_ETHICS_ID','=',$ets_get)
            ->first(); 

           $message = $header.
               "\n"."คุณ " . $namesend->HR_FNAME. "  " .$namesend->HR_LNAME .
               "\n"."ได้ชื่นชมคุณ " .
               "\n"."คำชื่นชม : " . $request->HAPPY_NET_COIMPLIMENT .
               "\n"."สอดคล้องกับค่านิยมองค์กรในหัวข้อ : " . $namesends->HAPPY_NET_SET_ETHICS .
               "\n"."ชื่นชมวันที่ : " . $datebegin ;               
                     
              
               
               // dd($id_user_get);
            //    $name = DB::table('happy_net_compliment')
            //    ->leftJoin('hrd_person', 'happy_net_compliment.ID_USER', '=', 'hrd_person.ID')
            //    ->where('happy_net_compliment.HAPPY_NET_COIMPLIMENT_ID', '=', $request->ID_USER)->first();
                $id_user_get = $request->ID_USER;
              
                   $name = DB::table('hrd_person')->where('ID','=',$id_user_get)
                   ->first();  
                //    $name = "xwnkMl7HADLExNr3hLGWQgWyBTSsv7YZDOByInydkjZ";
                   
                //    dd($name);      
                  if($name == null){
                    //   dd('ไม่ได้แจ้ง');
                    $test ='';
                  }else{
                    // dd('ได้แจ้ง');
                    $test = $name->HR_LINE;
                    // $test = "xwnkMl7HADLExNr3hLGWQgWyBTSsv7YZDOByInydkjZ";
                    // dd($test);
                  }
                
                   
                  if($test !== '' && $test !== null){  
                   $chOne = curl_init();
                   curl_setopt( $chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify");
                   curl_setopt( $chOne, CURLOPT_SSL_VERIFYHOST, 0);
                   curl_setopt( $chOne, CURLOPT_SSL_VERIFYPEER, 0);
                   curl_setopt( $chOne, CURLOPT_POST, 1);
                   curl_setopt( $chOne, CURLOPT_POSTFIELDS, $message);
                   curl_setopt( $chOne, CURLOPT_POSTFIELDS, "message=$message");
                   curl_setopt( $chOne, CURLOPT_FOLLOWLOCATION, 1);
                   
                   $headers = array( 'Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer '.$test.'', );
                   curl_setopt($chOne, CURLOPT_HTTPHEADER, $headers);
                   curl_setopt( $chOne, CURLOPT_RETURNTRANSFER, 1);
                   $result = curl_exec( $chOne );
                   if(curl_error($chOne)) { echo 'error:' . curl_error($chOne); }
                   else { $result_ = json_decode($result, true);
                   echo "status : ".$result_['status']; echo "message : ". $result_['message']; }
                   curl_close( $chOne );
                   
                   }








            return redirect()->route('happy.get_user')->with('success', 'ชื่นชมสำเร็จ');
      



       
        // return redirect()->route('send_user');
     
    }
    public function up_send_user_id(Request $request)
    {
        $id = $request->HAPPY_NET_COIMPLIMENT_ID;
        $up_send_user_id = compliment_happy::where('HAPPY_NET_COIMPLIMENT_ID', '=', $id)->first();


        $up_send_user_id->ID_USER = $request->ID_USER;

        $up_send_user_id->HAPPY_NET_COIMPLIMENT_FNAME = $request->HAPPY_NET_COIMPLIMENT_FNAME;
        $up_send_user_id->HAPPY_NET_COIMPLIMENT_LNAME = $request->HAPPY_NET_COIMPLIMENT_LNAME;

        $up_send_user_id->HAPPY_NET_COIMPLIMENT = $request->HAPPY_NET_COIMPLIMENT;
        $up_send_user_id->HAPPY_NET_DIFFICULTY_ID = $request->HAPPY_NET_DIFFICULTY_ID;

        $up_send_user_id->ID_USER_INSERT = $request->ID_USER_INSERT;
        // dd($up_send_user_id);

        $up_send_user_id->save();
        // return redirect()->route('send_user');
        return redirect()->route('happy.get_user')->with('success', 'แก้ไขข้อมูลสำเร็จ');
    }




    public function get_user()
    {
        $id_user = Auth::user()->PERSON_ID;
        $m_budget = date("m");
        if ((int)$m_budget > 9) {
            $yearbudget = date("Y") + 544;
        } else {
            $yearbudget = date("Y") + 543;
        }

        $year_ = array();
        for ($i = $yearbudget; $i >= $yearbudget - 9; $i--) {
            $year_[$i] = $i;
        }
        $data['year_'] = $year_;

        $data['yearbudget_select'] = $yearbudget;
        $year = $data['yearbudget_select'] - 543;
        if (isset($_GET['yearbudget_select'])) {
            $data['yearbudget_select'] = $_GET['yearbudget_select'];
        }

        $year = date('Y');
        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();

        $year_id = $year + 543;
        
        $chom_id = DB::table('happy_net_compliment')
            ->leftJoin('hrd_person', 'happy_net_compliment.ID_USER', '=', 'hrd_person.ID')
            ->orderBy('HAPPY_NET_COIMPLIMENT_ID', 'desc')
            ->where('ID_USER', '=', $id_user)
            ->where('DATE_SAVE','=',date('Y-m-d'))
            // ->first();
            ->where('DATE_SAVE', 'like', $year . '%')->get();

            // ->get();

        $problem_s = DB::table('happy_net_problem')
            ->leftJoin('hrd_person', 'happy_net_problem.ID_USER', '=', 'hrd_person.ID')
            ->orderBy('HAPPY_NET_PROBLEM_ID', 'desc')
            ->where('ID_USER', '=', $id_user)
            // ->get();
            ->where('DATE_SAVE', 'like', $year . '%')->get();



        $chomsum = DB::table('happy_net_compliment')
            ->where('ID_USER', '=', $id_user)
            // ->count();
            ->where('DATE_SAVE', 'like', $year . '%')->count();

        $problem_idsum = DB::table('happy_net_problem')
            ->where('ID_USER', '=', $id_user)
            // ->count();
            ->where('DATE_SAVE', 'like', $year . '%')->count();
           
   

        $inforpersons =  Person::leftJoin('hrd_prefix', 'hrd_person.HR_PREFIX_ID', '=', 'hrd_prefix.HR_PREFIX_ID')
            ->leftJoin('hrd_sex', 'hrd_person.SEX', '=', 'hrd_sex.SEX_ID')
            ->leftJoin('hrd_status', 'hrd_person.HR_STATUS_ID', '=', 'hrd_status.HR_STATUS_ID')
            ->leftJoin('hrd_level', 'hrd_person.HR_LEVEL_ID', '=', 'hrd_level.HR_LEVEL_ID')
            ->leftJoin('hrd_department_sub_sub', 'hrd_person.HR_DEPARTMENT_SUB_SUB_ID', '=', 'hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
            ->leftJoin('hrd_department', 'hrd_person.HR_DEPARTMENT_ID', '=', 'hrd_department.HR_DEPARTMENT_ID')
            ->leftJoin('hrd_department_sub', 'hrd_person.HR_DEPARTMENT_SUB_ID', '=', 'hrd_department_sub.HR_DEPARTMENT_SUB_ID')
            ->where('hrd_person.HR_STATUS_ID', '=', 1)
            ->where('ID', '=', $id_user)->first();


            $chom_s = DB::table('happy_net_compliment')
            ->leftJoin('hrd_person', 'happy_net_compliment.ID_USER', '=', 'hrd_person.ID')
            ->orderBy('HAPPY_NET_COIMPLIMENT_ID', 'desc')
            ->where('ID_USER_INSERT', '=', $id_user)
            ->where('DATE_SAVE','=',date('Y-m-d'))
            ->where('DATE_SAVE', 'like', $year . '%')->get();
        // dd($chom_s);

        $chomsum_s = DB::table('happy_net_compliment')
        ->where('ID_USER_INSERT', '=', $id_user)
        
        // ->count();
        ->where('DATE_SAVE', 'like', $year . '%')->count();

        $inforperson =  Person::leftJoin('hrd_prefix', 'hrd_person.HR_PREFIX_ID', '=', 'hrd_prefix.HR_PREFIX_ID')
        ->leftJoin('hrd_sex', 'hrd_person.SEX', '=', 'hrd_sex.SEX_ID')
        ->leftJoin('hrd_status', 'hrd_person.HR_STATUS_ID', '=', 'hrd_status.HR_STATUS_ID')
        ->leftJoin('hrd_level', 'hrd_person.HR_LEVEL_ID', '=', 'hrd_level.HR_LEVEL_ID')
        ->leftJoin('hrd_department_sub_sub', 'hrd_person.HR_DEPARTMENT_SUB_SUB_ID', '=', 'hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
        ->leftJoin('hrd_department', 'hrd_person.HR_DEPARTMENT_ID', '=', 'hrd_department.HR_DEPARTMENT_ID')
        ->leftJoin('hrd_department_sub', 'hrd_person.HR_DEPARTMENT_SUB_ID', '=', 'hrd_department_sub.HR_DEPARTMENT_SUB_ID')
        ->where('hrd_person.HR_STATUS_ID', '=', 1)
        ->where('hrd_person.ID','<>',$id_user)
        ->get();

                
        $chom_id_if = DB::table('happy_net_compliment')
        ->where('DATE_SAVE','=',date('Y-m-d'))
        ->where('ID_USER_INSERT','=',$id_user)
        // ->where('happy_net_compliment.HAPPY_NET_COIMPLIMENT_ID', '=', $id)->first();
        ->count();
        // dd($chom_id_if);
        $set_compliment = DB::table('happy_net_set_compliment')
        ->sum('HAPPY_NET_SET_COMPLIMENT');
        // ->get();
// dd($set_compliment);
        $countview = $set_compliment-$chom_id_if;
        // dd($countview);
        return view('person_happynet.get_user_Happy_Net', [
            'chom_id' => $chom_id,
            'problem_s' => $problem_s,

            'inforpersons' => $inforpersons,

            'chomsum' => $chomsum,
            'problem_idsum' => $problem_idsum,

            'chom_s' => $chom_s,
            'chomsum_s' => $chomsum_s,
            'inforperson' => $inforperson,
            'set_compliment' => $set_compliment,
            'countview' => $countview,
        ]);
    }
    public function send_user_problem($id)
    {
        $id_user = Auth::user()->PERSON_ID;
        $userid =  Person::where('hrd_person.ID', '=', $id)->first();
        // dd($userid);

        $SEtable = DB::table('happy_net_difficulty')
            ->select('happy_net_difficulty.HAPPY_NET_DIFFICULTY_ID', 'HAPPY_NET_DIFFICULTY', 'HAPPY_NET_DIFFICULTY_STATUS', 'HAPPY_NET_DIFFICULTY_COIN')
            ->orderBy('happy_net_difficulty.HAPPY_NET_DIFFICULTY_ID', 'asc')
            ->where('HAPPY_NET_DIFFICULTY_STATUS', '=', 'True')
            ->get();
            $pro_if = DB::table('happy_net_problem')
            ->where('DATE_SAVE','=',date('Y-m-d'))
            // ->where('happy_net_compliment.HAPPY_NET_COIMPLIMENT_ID', '=', $id)->first();
            ->count();
            // dd($pro_if);
            $pro_id_if = DB::table('happy_net_problem')
            ->where('DATE_SAVE','=',date('Y-m-d'))
            ->where('ID_USER_INSERT_PROBLEM','=',$id_user)
            // ->where('happy_net_compliment.HAPPY_NET_COIMPLIMENT_ID', '=', $id)->first();
            ->count();
            // dd($chom_id_if);
            $set_compliment = DB::table('happy_net_set_problem')
            ->sum('HAPPY_NET_SET_PROBLEM');
            // ->get();
        
        return view('person_happynet.send_user_problem_Happy_Net', [
            'userid' => $userid,
            'SEtable' => $SEtable,

            'pro_if' => $pro_if,
            'set_compliment' => $set_compliment,
        ]);
    }
    public function save_send_user_problem(Request $request)
    {
        $save_send_user_problem = new problem_happy();
        $save_send_user_problem->ID_USER = $request->ID_USER;
        $save_send_user_problem->HAPPY_NET_PROBLEM_STATUS = $request->HAPPY_NET_PROBLEM_STATUS;
        $save_send_user_problem->HAPPY_NET_PROBLEM_FNAME = $request->HAPPY_NET_PROBLEM_FNAME;
        $save_send_user_problem->HAPPY_NET_PROBLEM_LNAME = $request->HAPPY_NET_PROBLEM_LNAME;
        $save_send_user_problem->HAPPY_NET_PROBLEM = $request->HAPPY_NET_PROBLEM;
        $save_send_user_problem->HAPPY_NET_DIFFICULTY_ID = $request->HAPPY_NET_DIFFICULTY_ID;
        $save_send_user_problem->HAPPY_NET_PROBLEM_HEAD = $request->HAPPY_NET_PROBLEM_HEAD;

        $save_send_user_problem->ID_USER_INSERT_PROBLEM = $request->ID_USER_INSERT_PROBLEM;
        $save_send_user_problem->DATE_SAVE = date('Y-m-d');
        // dd($save_send_user_problem);
        $save_send_user_problem->save();
        // return redirect()->route('send_user');
                function DateThailinecar($strDate)
                {
                $strYear = date("Y",strtotime($strDate))+543;
                $strMonth= date("n",strtotime($strDate));
                $strDay= date("j",strtotime($strDate));
                $strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
                $strMonthThai=$strMonthCut[$strMonth];
                return "$strDay $strMonthThai $strYear";
                }
         $header = "ระบบความสุขของบุคลากร";
         $datebegin = DateThailinecar( date('Y-m-d')); 
         $id_user_send = $request->ID_USER_INSERT_PROBLEM;
         $namesend  = DB::table('hrd_person')->where('ID','=',$id_user_send)
         ->first(); 

         $coin = $request->HAPPY_NET_DIFFICULTY_ID;       
         $coins  = DB::table('happy_net_difficulty')->where('HAPPY_NET_DIFFICULTY_ID','=',$coin) ->first(); 
        //  dd($coins);
        $message = $header.
            "\n"."คุณ " . $namesend->HR_FNAME. "  " .$namesend->HR_LNAME .
            "\n"."ได้ขอความช่วยเหลือคุณ " .
            "\n"."เรื่อง : " . $request->HAPPY_NET_PROBLEM_HEAD .
            "\n"."เนื้อหา : " . $request->HAPPY_NET_PROBLEM .
       
            "\n"."วันที่ : " . $datebegin .
            "\n"."เมื่อคุณช่วยเพื่อนแก้ไขปัญหาคุณจะได้รับ  " . $coins->HAPPY_NET_DIFFICULTY_COIN ."คะแนน" ;           
             $id_user_get = $request->ID_USER;
                $name = DB::table('hrd_person')->where('ID','=',$id_user_get)
                ->first();  
               if($name == null){
                 $test ='';
               }else{
                 $test = $name->HR_LINE;
               }
               if($test !== '' && $test !== null){  
                $chOne = curl_init();
                curl_setopt( $chOne, CURLOPT_URL, "https://notify-api.line.me/api/notify");
                curl_setopt( $chOne, CURLOPT_SSL_VERIFYHOST, 0);
                curl_setopt( $chOne, CURLOPT_SSL_VERIFYPEER, 0);
                curl_setopt( $chOne, CURLOPT_POST, 1);
                curl_setopt( $chOne, CURLOPT_POSTFIELDS, $message);
                curl_setopt( $chOne, CURLOPT_POSTFIELDS, "message=$message");
                curl_setopt( $chOne, CURLOPT_FOLLOWLOCATION, 1);
                
                $headers = array( 'Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer '.$test.'', );
                curl_setopt($chOne, CURLOPT_HTTPHEADER, $headers);
                curl_setopt( $chOne, CURLOPT_RETURNTRANSFER, 1);
                $result = curl_exec( $chOne );
                if(curl_error($chOne)) { echo 'error:' . curl_error($chOne); }
                else { $result_ = json_decode($result, true);
                echo "status : ".$result_['status']; echo "message : ". $result_['message']; }
                curl_close( $chOne );
                
                }

        return redirect()->route('happy.send_user')->with('prosuccess', 'มอบหมายงาน / สอบถามบุคลากรสำเร็จ');
    }
    public function edit_problem($id)
    {
        // dd($user);
        $pr_id = DB::table('happy_net_problem')
            ->leftJoin('hrd_person', 'happy_net_problem.ID_USER', '=', 'hrd_person.ID')
            // ->get();
            ->where('happy_net_problem.HAPPY_NET_PROBLEM_ID', '=', $id)->first();
        // dd($pr_id);
        $SEtable = DB::table('happy_net_difficulty')
            ->select('happy_net_difficulty.HAPPY_NET_DIFFICULTY_ID', 'HAPPY_NET_DIFFICULTY', 'HAPPY_NET_DIFFICULTY_STATUS', 'HAPPY_NET_DIFFICULTY_COIN')
            ->orderBy('happy_net_difficulty.HAPPY_NET_DIFFICULTY_ID', 'asc')
            ->get();


        return view('person_happynet.edit_problem_Happy_Net', [
            // 'userid' => $userid,
            'SEtable' => $SEtable,
            'pr_id' => $pr_id,
            // 'problem_id' => $problem_id,

        ]);
    }
    public function up_problem(Request $request)
    {
        $id = $request->HAPPY_NET_PROBLEM_ID;
        $up_send_user_id = problem_happy::where('HAPPY_NET_PROBLEM_ID', '=', $id)->first();


        $up_send_user_id->ID_USER = $request->ID_USER;

        $up_send_user_id->HAPPY_NET_PROBLEM_FNAME = $request->HAPPY_NET_PROBLEM_FNAME;
        $up_send_user_id->HAPPY_NET_PROBLEM_LNAME = $request->HAPPY_NET_PROBLEM_LNAME;

        $up_send_user_id->HAPPY_NET_PROBLEM = $request->HAPPY_NET_PROBLEM;
        $up_send_user_id->HAPPY_NET_DIFFICULTY_ID = $request->HAPPY_NET_DIFFICULTY_ID;
        $up_send_user_id->HAPPY_NET_PROBLEM_STATUS = $request->HAPPY_NET_PROBLEM_STATUS;
        $up_send_user_id->HAPPY_NET_PROBLEM_HEAD = $request->HAPPY_NET_PROBLEM_HEAD;

        $up_send_user_id->ID_USER_INSERT_PROBLEM = $request->ID_USER_INSERT_PROBLEM;

        // dd($up_send_user_id);

        $up_send_user_id->save();
        // return redirect()->route('send_user');
        return redirect()->route('happy.send_user')->with('Epsuccess', 'แก้ไขข้อมูลสำเร็จ');
    }
    public function submit_problem_view($id)
    {$id_user = Auth::user()->PERSON_ID;

        // dd($user);
        $pr_id = DB::table('happy_net_problem')
            ->leftJoin('hrd_person', 'happy_net_problem.ID_USER', '=', 'hrd_person.ID')
            ->leftJoin('happy_net_coin', 'happy_net_problem.HAPPY_NET_DIFFICULTY_ID', '=', 'happy_net_coin.HAPPY_NET_COIN_ID')
            // ->get();
            ->where('happy_net_problem.HAPPY_NET_PROBLEM_ID', '=', $id)->first();
        // dd($pr_id);

        $pp = $pr_id->HAPPY_NET_DIFFICULTY_ID;

        $pp1 = DB::table('happy_net_difficulty')
            ->select('happy_net_difficulty.HAPPY_NET_DIFFICULTY_ID', 'HAPPY_NET_DIFFICULTY', 'HAPPY_NET_DIFFICULTY_STATUS', 'HAPPY_NET_DIFFICULTY_COIN')
            ->where('HAPPY_NET_DIFFICULTY_ID', '=', $pp)->first();
        // ->get();

        // dd($pp1);

        $SEtable = DB::table('happy_net_difficulty')
            ->select('happy_net_difficulty.HAPPY_NET_DIFFICULTY_ID', 'HAPPY_NET_DIFFICULTY', 'HAPPY_NET_DIFFICULTY_STATUS', 'HAPPY_NET_DIFFICULTY_COIN')
            ->orderBy('happy_net_difficulty.HAPPY_NET_DIFFICULTY_ID', 'asc')
            ->get();
  
        $set_coin = DB::table('happy_net_set_coin')
        ->sum('HAPPY_NET_SET_COIN');
        $coin = DB::table('happy_net_coin')
        ->where('DATE_SAVE','=',date('Y-m-d'))
        ->where('HAPPY_NET_COIN_TYPE','=','ช่วยปัญหาจากบุคลากร')
        ->where('ID_USER','=',$id_user)
        ->get();
        $coins = DB::table('happy_net_coin')
            ->where('DATE_SAVE','=',date('Y-m-d'))
            ->where('HAPPY_NET_COIN_TYPE','=','ช่วยปัญหาจากบุคลากร')
            ->where('ID_USER','=',$id_user)
            ->sum('HAPPY_NET_COIN');

            $A =  $set_coin-$pr_id->HAPPY_NET_COIN ;
            // dd($A);
        return view('person_happynet.submit_problem_view_Happy_Net', [
            // 'userid' => $userid,
            'SEtable' => $SEtable,
            'pr_id' => $pr_id,
            'pp1' => $pp1,
            'set_coin' => $set_coin,
            'coins' => $coins,
            'coin' => $coin,
            'A' => $A,
        ]);
    }
    public function submit_problem(Request $request)
    {


        $id_user = Auth::user()->PERSON_ID;

        $id = $request->HAPPY_NET_PROBLEM_ID;
        $submit_problem = problem_happy::where('HAPPY_NET_PROBLEM_ID', '=', $id)->first();
        $submit_problem->HAPPY_NET_PROBLEM_STATUS = $request->HAPPY_NET_PROBLEM_STATUS;
        $submit_problem->save();

        $save_coin = new Coin();
        $save_coin->HAPPY_NET_COIN = $request->HAPPY_NET_COIN;
        $save_coin->ID_USER = $request->receive;
        $save_coin->ID_USER_GIVE =  $id_user;
        $save_coin->HAPPY_NET_COIN_TYPE = $request->HAPPY_NET_COIN_TYPE;
        $save_coin->DATE_SAVE = date('Y-m-d');
        // $save_coin->save();
    //    dd( $save_coin);

        $set_coin = DB::table('happy_net_set_coin')
        ->sum('HAPPY_NET_SET_COIN');
        // ->get();
        // dd( $set_coin);
        $coin = DB::table('happy_net_coin')
        ->where('DATE_SAVE','=',date('Y-m-d'))
        ->where('HAPPY_NET_COIN_TYPE','=','ช่วยปัญหาจากบุคลากร')
        ->where('ID_USER_GIVE','=',$id_user)
        ->get();
        // dd($coin);

        if ($coin){
            $coins = DB::table('happy_net_coin')
            ->where('DATE_SAVE','=',date('Y-m-d'))
            ->where('HAPPY_NET_COIN_TYPE','=','ช่วยปัญหาจากบุคลากร')
            ->where('ID_USER_GIVE','=',$id_user)
            ->sum('HAPPY_NET_COIN');
            //   dd($coins);
              
              if($coins > $set_coin){
                // dd('วันนี้ได้เงินเยอะไป');
                      return redirect()->route('happy.send_user')->with('success', 'งาน/คำถาม/ปัญหา สำเร็จแล้ว');
              }else{
                // dd('ได้เงินพอดี');
                $save_coin->save();
                      return redirect()->route('happy.send_user')->with('success', 'งาน/คำถาม/ปัญหา สำเร็จแล้ว');
              }

        }else{
            // dd('ได้เงินพอดี');
            $save_coin->save();
                  return redirect()->route('happy.send_user')->with('success', 'งาน/คำถาม/ปัญหา สำเร็จแล้ว');
        }





        // dd($submit_problem,$save_coin);
        // return redirect()->route('happy.send_user')->with('success', 'งาน/คำถาม/ปัญหา สำเร็จแล้ว');
    }
    public function submit_problems(Request $request)
    {


        $id_user = Auth::user()->PERSON_ID;

        $id = $request->HAPPY_NET_PROBLEM_ID;
        $submit_problem = problem_happy::where('HAPPY_NET_PROBLEM_ID', '=', $id)->first();
        $submit_problem->HAPPY_NET_PROBLEM_STATUS = $request->HAPPY_NET_PROBLEM_STATUS;
        $submit_problem->save();

        $save_coin = new Coin();
        $save_coin->HAPPY_NET_COIN = $request->HAPPY_NET_COIN;
        $save_coin->ID_USER = $request->receive;
        $save_coin->ID_USER_GIVE =  $id_user;
        $save_coin->HAPPY_NET_COIN_TYPE = $request->HAPPY_NET_COIN_TYPE;
        $save_coin->DATE_SAVE = date('Y-m-d');
        // $save_coin->save();
    //    dd( $save_coin);

      
            $save_coin->save();
                  return redirect()->route('happy.send_user')->with('success', 'งาน/คำถาม/ปัญหา สำเร็จแล้ว');
      


        // 
    }




    public function order()
    {
        $orderall = DB::table('happy_net_order')->get();
        return view('person_happynet.order_Happy_Net', [
            'orderall' => $orderall,
        ]);
    }
    public function content_order($id)
    {
        $con_order = order::where('HAPPY_NET_ORDER_ID', '=', $id)->first();
        // dd($con_order);
        $reward = $con_order->HAPPY_NET_REWARD_ID;
        $rewards = DB::table('happy_net_reward')->where('HAPPY_NET_REWARD_ID', '=', $reward)->first();
        // dd($rewards);
        return view('person_happynet.content_order_Happy_Net', [
            'con_order' => $con_order,
            'rewards' => $rewards,
        ]);
    }
    public function con_order($id)
    {
        $con_order = order::where('HAPPY_NET_ORDER_ID', '=', $id)->first();
        // dd($con_order);
        $reward = $con_order->HAPPY_NET_REWARD_ID;
        $rewards = DB::table('happy_net_reward')->where('HAPPY_NET_REWARD_ID', '=', $reward)->first();
        // dd($rewards);
        return view('person_happynet.con_order_Happy_Net', [
            'con_order' => $con_order,
            'rewards' => $rewards,
        ]);
    }
    public function con_up(Request $request)
    {
        $id = $request->HAPPY_NET_ORDER_ID;
        $con = order::where('HAPPY_NET_ORDER_ID', '=', $id)->first();
        $id_user = Auth::user()->PERSON_ID;
        $name_user =  DB::table('hrd_person')->where('ID', '=', $id_user)->first();


        $con->HAPPY_NET_NAME_PAY = $name_user->HR_FNAME . ' ' . $name_user->HR_LNAME;
        $con->HAPPY_NET_NAME_PAY_ID = $id_user;
        $con->HAPPY_NET_ORDER_STATUS = $request->HAPPY_NET_ORDER_STATUS;


        $con->save();;
        return redirect()->route('happy.order');
    }
    public function Econ_order($id)
    {
        $con_order = order::where('HAPPY_NET_ORDER_ID', '=', $id)->first();
        // dd($con_order);
        $reward = $con_order->HAPPY_NET_REWARD_ID;
        $rewards = DB::table('happy_net_reward')->where('HAPPY_NET_REWARD_ID', '=', $reward)->first();
        // dd($rewards);
        return view('person_happynet.Econ_order_Happy_Net', [
            'con_order' => $con_order,
            'rewards' => $rewards,
        ]);
    }
    public function Ucon_up(Request $request)
    {
        $id = $request->HAPPY_NET_ORDER_ID;
        $con = order::where('HAPPY_NET_ORDER_ID', '=', $id)->first();


        $con->HAPPY_NET_NAME_PAY = $request->HAPPY_NET_NAME_PAY;
        $con->HAPPY_NET_ORDER_STATUS = $request->HAPPY_NET_ORDER_STATUS;
        $con->save();;
        return redirect()->route('happy.order');
    }



    public function reward_content($id)
    {

        $con1 = HapptR::where('HAPPY_NET_REWARD_ID', '=', $id)->first();

        return view('person_happynet.reward_content_Happy_Net', [

            'con1' => $con1,
        ]);
    }

    public function send_reward(Request $request)
    {
        $id_user = Auth::user()->PERSON_ID;
        $name_user =  DB::table('hrd_person')->where('ID', '=', $id_user)->first();

        $id = $request->HAPPY_NET_REWARD_ID;
        $send_reward = HapptR::where('HAPPY_NET_REWARD_ID', '=', $id)->first();
        $order = $send_reward->HAPPY_NET_REWARD_NAME;
        $order_id = $send_reward->HAPPY_NET_REWARD_ID;
        $order_Q = $send_reward->HAPPY_NET_REWARD_QUANTITY;
        // dd($order_Q);
        $price = $send_reward->HAPPY_NET_REWARD_PRICE;
        $coin = DB::table('happy_net_coin')
            ->select(DB::raw('sum(happy_net_coin.HAPPY_NET_COIN) as sum'), 'ID_USER')
            ->groupBy('happy_net_coin.ID_USER')
            ->sum('HAPPY_NET_COIN');

        $QUANTITY =  $request->QUANTITY;

        if ($QUANTITY > $order_Q) {
            return redirect()->route('happy.reward')->with('danger2', 'จำนวนของรางวัลไม่เพียงพอ กรุณาลดจำนวนของรางวัลให้น้อยลง หรือ เลือกของรางวัลชิ้นอื่น');
        } else {

            $shop = $coin - $price;

            $type = ('ซื้อของรางวัล');
            $STATUS_COIN = ('True');
            if ($shop > 0) {
                $id_user = Auth::user()->PERSON_ID;

                $save_shop = new Shop();

                $prices = $price * $QUANTITY;
                $save_shop->HAPPY_NET_COIN_SHOP = $prices;
                // dd($save_shop);

                $save_shop->ID_USER = $id_user;
                $save_shop->HAPPY_NET_SHOP_TYPE = $type;
                $save_shop->HAPPY_NET_SHOP_QUANTITY = $QUANTITY;
                $save_shop->HAPPY_NET_REWARD_ID = $order_id;



                $orders = new order();
                $orders->HAPPY_NET_ORDER_QUANTITY = $QUANTITY;
                $orders->HAPPY_NET_ORDER_STATUS_COIN = $STATUS_COIN;
                $orders->HAPPY_NET_ORDER_STATUS = $request->HAPPY_NET_ORDER_STATUS;
                $orders->HAPPY_NET_REWARD_NAME = $order;
                $orders->HAPPY_NET_REWARD_ID = $order_id;

                $orders->HAPPY_NET_NAME_USER = $name_user->HR_FNAME . ' ' . $name_user->HR_LNAME;
                $orders->HAPPY_NET_NAME_USER_ID = $id_user;


                $orders->save();
                $save_shop->save();
                //   dd($save_shop);
                //   dd($orders,$save_shop);
                // return redirect()->route('happy.reward');
                return redirect()->route('happy.reward')->with('success', 'ทำรายการสำเร็จสามารถดูรายละเอียดต่างๆได้ในหมายเหตุภายในรายการขอวรางวัล');
            } else {
                // return redirect()->route('happy.reward');  
                return redirect()->route('happy.reward')->with('danger', 'จำนวนคอยน์ไม่เพียงพอสำหรับการแรกของรางวัล กรุณาเลือกของรางวัลชิ้นใหม่ หรือ เก็บคอยน์เพิ่ม');
            }
        }
    }


    public function reward()
    {
        $rewards = DB::table('happy_net_reward')
            ->select('happy_net_reward.HAPPY_NET_REWARD_ID', 'HAPPY_NET_REWARD_NAME', 'HAPPY_NET_REWARD_IMAGE', 'HAPPY_NET_REWARD_DETAILS', 'HAPPY_NET_REWARD_DETAILS2', 'HAPPY_NET_REWARD_PRICE', 'HAPPY_NET_REWARD_QUANTITY', 'HAPPY_NET_REWARD_STATUS')
            ->where('HAPPY_NET_REWARD_STATUS', '=', 'True')
            ->get();

        $reward = DB::table('happy_net_reward')
            ->select('happy_net_reward.HAPPY_NET_REWARD_ID', 'HAPPY_NET_REWARD_NAME', 'HAPPY_NET_REWARD_IMAGE', 'HAPPY_NET_REWARD_DETAILS', 'HAPPY_NET_REWARD_DETAILS2', 'HAPPY_NET_REWARD_PRICE', 'HAPPY_NET_REWARD_QUANTITY', 'HAPPY_NET_REWARD_STATUS')
            ->where('HAPPY_NET_REWARD_STATUS', '=', 'True')
            ->count();
        $numreward = DB::table('happy_net_reward')
            // ->pluck('HAPPY_NET_REWARD_QUANTITY')
            ->where('HAPPY_NET_REWARD_STATUS', '=', 'True')
            ->sum('HAPPY_NET_REWARD_QUANTITY');
        // ->get();
        return view('person_happynet.reward_Happy_Net', [
            'reward' => $reward,
            'rewards' => $rewards,
            'numreward' => $numreward,

        ]);
    }



    //เมยนูตั้งค่า
    

    // ของรางวัล
    public function Ereward()
    {
        $REtable = DB::table('happy_net_reward')
            ->select('happy_net_reward.HAPPY_NET_REWARD_ID', 'HAPPY_NET_REWARD_NAME', 'HAPPY_NET_REWARD_IMAGE', 'HAPPY_NET_REWARD_DETAILS', 'HAPPY_NET_REWARD_DETAILS2', 'HAPPY_NET_REWARD_PRICE', 'HAPPY_NET_REWARD_QUANTITY', 'HAPPY_NET_REWARD_STATUS')
            ->orderBy('happy_net_reward.HAPPY_NET_REWARD_ID', 'asc')
            ->get();
        return view('person_happynet/Ereward_Happy_Net', [
            'REtable' => $REtable,
        ]);
    }
    public function  add_Ereward()
    {
        return view('person_happynet.add_Ereward_Happy_Net', []);
    }
    public function save_Ereward(Request $request)
    {
        $save_Ereward = new HapptR();
        $save_Ereward->HAPPY_NET_REWARD_NAME = $request->HAPPY_NET_REWARD_NAME;
        $save_Ereward->HAPPY_NET_REWARD_DETAILS = $request->HAPPY_NET_REWARD_DETAILS;
        $save_Ereward->HAPPY_NET_REWARD_DETAILS2 = $request->HAPPY_NET_REWARD_DETAILS2;
        $save_Ereward->HAPPY_NET_REWARD_PRICE = $request->HAPPY_NET_REWARD_PRICE;
        $save_Ereward->HAPPY_NET_REWARD_QUANTITY = $request->HAPPY_NET_REWARD_QUANTITY;
       
        // if ($request->hasFile('picture')) {
        //     $image_happy = $request->file('picture');
        //     $name_gen = hexdec(uniqid());
        //     $img_ext = strtolower($image_happy->getClientOriginalExtension());
        //     $img_name = $name_gen . '.' . $img_ext;
        //     $upload_location = 'image/happy_net_image/';
        //     $full_path = $upload_location . $img_name;
        //     $save_Ereward->HAPPY_NET_REWARD_IMAGE = $full_path;
            
        // }


        if ($request->hasFile('picture')) {
            $file                = $request->file('picture');
            $image_resize        = Image::make($file)->fit(300)->encode();
            // dd($image_resize);
            $contents            = $file->openFile()->fread($file->getSize());
            $save_Ereward->HAPPY_NET_REWARD_IMAGE =  $image_resize;
    }
        // เก็บแบบ strorage
        // if($request->picture != null){
     
        //     if($request->hasFile('picture')){
        //         $maxid = HapptR::max('HAPPY_NET_REWARD_ID');
        //         $idfile = $maxid+1;
        //         $image_happy = 'happy.reward_'.$idfile.'.'.$request->picture->extension();
        //         $request->picture->storeAs('happy_image_reward',$image_happy,'public');
        //         $save_Ereward->HAPPY_NET_REWARD_IMAGE = $image_happy;
        //     }
        // }else{
        //     $image_happy = 'null';
        // }
        $save_Ereward->save();
        // $image_happy->move($upload_location, $img_name);

        return redirect()->route('Ereward');
    }
    public function edit_Ereward($id)
    {
        $edit_Erewards = HapptR::where('HAPPY_NET_REWARD_ID', '=', $id)->first();
        //    dd($edit_Erewards);   
        return view('person_happynet.edit_Ereward_Happy_Net', [
            'edit_Erewards' => $edit_Erewards,
            // 'idref' => $id,
        ]);
    }
    public function update_Ereward(Request $request)
    {
        $id = $request->HAPPY_NET_REWARD_ID;
        $update_Ereward = HapptR::where('HAPPY_NET_REWARD_ID', '=', $id)->first();
        $image_happy = $request->file('picture_edit');
      
     
        if ($image_happy) {
            // $name_gen = hexdec(uniqid());
            // $img_ext = strtolower($image_happy->getClientOriginalExtension());
            // $img_name = $name_gen . '.' . $img_ext;
            // $upload_location = 'image/happy_net_image/';
            // $full_path = $upload_location . $img_name;

            // $old_image = $request->old_image;
            // unlink($old_image);
            // $image_happy->move($upload_location, $img_name);
            $file                = $request->file('picture_edit');
            $image_resize        = Image::make($file)->fit(300)->encode();
            // dd($image_resize);
            $contents            = $file->openFile()->fread($file->getSize());
            $update_Ereward->HAPPY_NET_REWARD_IMAGE =  $image_resize;
            $update_Ereward->HAPPY_NET_REWARD_NAME = $request->HAPPY_NET_REWARD_NAME;
            $update_Ereward->HAPPY_NET_REWARD_DETAILS = $request->HAPPY_NET_REWARD_DETAILS;
            $update_Ereward->HAPPY_NET_REWARD_DETAILS2 = $request->HAPPY_NET_REWARD_DETAILS2;
            $update_Ereward->HAPPY_NET_REWARD_PRICE = $request->HAPPY_NET_REWARD_PRICE;
            $update_Ereward->HAPPY_NET_REWARD_QUANTITY = $request->HAPPY_NET_REWARD_QUANTITY;
       
            $update_Ereward->save();
            return redirect()->route('Ereward')->with('success', "แก้ไขข้อมูลเรียบร้อย");
        } else {
            $update_Ereward->HAPPY_NET_REWARD_NAME = $request->HAPPY_NET_REWARD_NAME;
            $update_Ereward->HAPPY_NET_REWARD_DETAILS = $request->HAPPY_NET_REWARD_DETAILS;
            $update_Ereward->HAPPY_NET_REWARD_DETAILS2 = $request->HAPPY_NET_REWARD_DETAILS2;
            $update_Ereward->HAPPY_NET_REWARD_PRICE = $request->HAPPY_NET_REWARD_PRICE;
            $update_Ereward->HAPPY_NET_REWARD_QUANTITY = $request->HAPPY_NET_REWARD_QUANTITY;
            $update_Ereward->save();
            return redirect()->route('Ereward')->with('success', "แก้ไขข้อมูลเรียบร้อย");
        }
    }

    public function destroy_Ereward($id)
    {

        HapptR::destroy($id);
        return redirect()->route('Ereward')->with('success', "ลบข้อมูลเรียบร้อย");
    }
    public function status_Ereward(Request $request)
    {
        $id = $request->status_Erewards;
        $status_Ereward1 = HapptR::find($id);
        $status_Ereward1->HAPPY_NET_REWARD_STATUS = $request->onoff;
        $status_Ereward1->save();
    }

    // end ของรางวัล

    // ความยาก
    public function Ecoin()
    {

        $SEtable = DB::table('happy_net_difficulty')
            ->select('happy_net_difficulty.HAPPY_NET_DIFFICULTY_ID', 'HAPPY_NET_DIFFICULTY', 'HAPPY_NET_DIFFICULTY_STATUS', 'HAPPY_NET_DIFFICULTY_COIN')
            ->orderBy('happy_net_difficulty.HAPPY_NET_DIFFICULTY_ID', 'asc')
            ->get();
         
        $set_check = DB::table('happy_net_set_coin')->count();
        $set_coin = DB::table('happy_net_set_coin')->first();
        
        return view('person_happynet.Ecoin_Happy_Net', [
            'SEtable' => $SEtable,
            'set_check' => $set_check,
            'set_coin' => $set_coin,
        ]);
    }
    public function add_ecoin()
    {
        return view('person_happynet.add_ecoin_Happy_Net', []);
    }

    public function save_ecoin(Request $request)
    {
        // dd($request->HAPPY_NET_DIFFICULTY);
        $save_ecoin = new Saveecoin();
        $save_ecoin->HAPPY_NET_DIFFICULTY = $request->HAPPY_NET_DIFFICULTY;
        $save_ecoin->HAPPY_NET_DIFFICULTY_COIN = $request->HAPPY_NET_DIFFICULTY_COIN;
        $save_ecoin->save();
        return redirect()->route('ecoin')->with('success', "บันทึกข้อมูลเรียบร้อย");
    }
    public function edit_ecoin($id)
    {
        $edit_ecoins = Saveecoin::where('HAPPY_NET_DIFFICULTY_ID', '=', $id)->first();
        return view('person_happynet.edit_ecoin_Happy_Net', [
            'edit_ecoins' => $edit_ecoins,
        ]);
    }
    public function update_ecoin(Request $request)
    {
        $id = $request->HAPPY_NET_DIFFICULTY_ID;
        $update_ecoin = Saveecoin::where('HAPPY_NET_DIFFICULTY_ID', '=', $id)->first();
        $update_ecoin->HAPPY_NET_DIFFICULTY = $request->HAPPY_NET_DIFFICULTY;
        $update_ecoin->HAPPY_NET_DIFFICULTY_COIN = $request->HAPPY_NET_DIFFICULTY_COIN;
        $update_ecoin->save();
        return redirect()->route('ecoin')->with('success', "แก้ไขข้อมูลเรียบร้อย");
    }
    public function destroy_ecoin($id)
    {
        Saveecoin::destroy($id);
        return redirect()->route('ecoin')->with('danger', "ลบข้อมูลเรียบร้อย");
    }
    public function status_ecoin(Request $request)
    {
        $id = $request->status_ecoins;
        $status_ecoin1 = Saveecoin::find($id);
        $status_ecoin1->HAPPY_NET_DIFFICULTY_STATUS = $request->onoff;
        $status_ecoin1->save();
    }
    // end ความยาก

// ค่านิยม
public function Ethics()
{

    $ethics = DB::table('happy_net_ethics')
        ->orderBy('HAPPY_NET_SET_ETHICS_ID', 'asc')
        ->get();
     
    
    return view('person_happynet.Ethics_Happy_Net', [
        'ethics' => $ethics,
    ]);
}
public function add_Ethics()
{
    return view('person_happynet.add_Ethics_Happy_Net', []);
}

public function save_Ethics(Request $request)
{
    // dd($request->HAPPY_NET_DIFFICULTY);
    $save_eth = new Happyethics();
    $save_eth->HAPPY_NET_SET_ETHICS = $request->HAPPY_NET_SET_ETHICS;
    $save_eth->HAPPY_NET_SET_ETHICS_CONTENT = $request->HAPPY_NET_SET_ETHICS_CONTENT;
    $save_eth->DATE_SAVE = date('y-m-d');
    $save_eth->save();
    return redirect()->route('happy.Ethics')->with('success', "บันทึกข้อมูลเรียบร้อย");
}
public function edit_Ethics($id)
{
    $update_ets = Happyethics::where('HAPPY_NET_SET_ETHICS_ID', '=', $id)->first();
    return view('person_happynet.edit_Ethics_Happy_Net', [
        'update_ets' => $update_ets,
    ]);
}
public function update_Ethics(Request $request)
{
    $id = $request->HAPPY_NET_SET_ETHICS_ID;
    $update_ets = Happyethics::where('HAPPY_NET_SET_ETHICS_ID', '=', $id)->first();
    $update_ets->HAPPY_NET_SET_ETHICS = $request->HAPPY_NET_SET_ETHICS;
    $update_ets->HAPPY_NET_SET_ETHICS_CONTENT = $request->HAPPY_NET_SET_ETHICS_CONTENT;
    $update_ets->save();
    return redirect()->route('happy.Ethics')->with('success', "แก้ไขข้อมูลเรียบร้อย");
}
public function destroy_Ethics($id)
{
    Happyethics::destroy($id);
    return redirect()->route('happy.Ethics')->with('danger', "ลบข้อมูลเรียบร้อย");
}
public function status_Ethics(Request $request)
    {
        $id = $request->status_ETS;
        $ets = Happyethics::find($id);
        $ets->HAPPY_NET_SET_ETHICS_STATUS = $request->onoff;
        $ets->save();
    }
// end ค่านิยม


// ตั้งค่าหมวดหมู่
public function status_modal(Request $request)
{
    $id = $request->status_modals;
    $status_modal = Emodal_Happy::find($id);
    $status_modal->HAPPY_NET_MODAL_QUESTION = $request->onoff;
    $status_modal->save();
}
public function view_status_modal(Request $request)
{  
    $status_modals = DB::table('happy_net_modal')
    // ->where('happy_net_modal.HAPPY_NET_MODAL_QUESTION_ID', '=', '1')
    ->get();
    
    $status_modal = DB::table('happy_net_modal')
    ->where('HAPPY_NET_MODAL_TYPE','=','คำถาม')
    ->count();
    // ->where('happy_net_modal.HAPPY_NET_MODAL_QUESTION_ID', '=', '1')
 
    // dd($status_modal);
    $ID = '1';
    // $null = 'True' ;


    // if(!empty($status_modal))
    if($status_modal < 1)
    {
    // //  $save_modal->HAPPY_NET_MODAL_QUESTION_ID = $ID;
    $save_modal = new Emodal_Happy();
     $save_modal->HAPPY_NET_MODAL_QUESTION = "False";
     $save_modal->DATE_SAVE = date('Y-m-d');
     $save_modal->ID_USER = '0';
     $save_modal->HAPPY_NET_MODAL_TYPE = "คำถาม";
     $save_modal->save();
    // dd('null');
    return redirect()->route('view_status_modal');

    }else{
        return view('person_happynet.view_status_modal_Happy_Net', [
        
            'status_modals' => $status_modals,
        ]);
        
    }

    
}

public function view_status_modals()
{  
       
    $status_modal = DB::table('happy_net_modal')
    // ->where('happy_net_modal.HAPPY_NET_MODAL_QUESTION_ID', '=', '1')
    ->get();
    
   

    return view('person_happynet.view_status_modal_Happy_Net', [
        
        'status_modal' => $status_modal,                    
    ]);
}

public function Equestion_group()
{
    $Egroup = DB::table('happy_net_question_group')
        ->orderBy('HAPPY_NET_QUESTION_GROUP_ID', 'asc')
        ->get();

        $status_modal = DB::table('happy_net_modal')
        ->where('happy_net_modal.HAPPY_NET_MODAL_QUESTION_ID', '=', '1')
        ->get();

    return view('person_happynet.Equestion_group_Happy_Net', [
        'Egroup' => $Egroup,
        'status_modal' => $status_modal,
    ]);
}



public function add_Equestion_group()
{
    
    return view('person_happynet.add_Equestion_group_Happy_Net', [

        
    ]);
}

public function save_Equestion_group(Request $request)
{

    $save_Equestion_group = new Equestion_group();
    $save_Equestion_group->HAPPY_NET_QUESTION_GROUP = $request->HAPPY_NET_QUESTION_GROUP;
    $save_Equestion_group->HAPPY_NET_QUESTION_GROUP_STATUS = $request->HAPPY_NET_QUESTION_GROUP_STATUS;
    
    $save_Equestion_group->DATE_SAVE = date('Y-m-d');
    

    $save_Equestion_group->save();
    return redirect()->route('happy.Equestion_group')->with('success', "บันทึกข้อมูลเรียบร้อย");
}

public function edit_Equestion_group($id)
{
    $edit_egroup = Equestion_group::where('HAPPY_NET_QUESTION_GROUP_ID', '=', $id)->first();
    return view('person_happynet.edit_Equestion_group_Happy_Net', [
        'edit_egroup' => $edit_egroup,
    ]);
}
public function update_Equestion_group(Request $request)
{
    $id = $request->HAPPY_NET_QUESTION_GROUP_ID;
    $update_Equestion_group = Equestion_group::where('HAPPY_NET_QUESTION_GROUP_ID', '=', $id)->first();

    $update_Equestion_group->HAPPY_NET_QUESTION_GROUP = $request->HAPPY_NET_QUESTION_GROUP;
// dd($update_Equestion_group);
    $update_Equestion_group->save();
    return redirect()->route('happy.Equestion_group')->with('success', "แก้ไขข้อมูลเรียบร้อย");
}
public function destroy_Equestion_group($id)
{
    Equestion_group::destroy($id);
    return redirect()->route('happy.Equestion_group')->with('success', "ลบข้อมูลเรียบร้อย");
}
public function status_Equestion_group(Request $request)
{
    $id = $request->status_egroup;
    $status_egroup1 = Equestion_group::find($id);
    $status_egroup1->HAPPY_NET_QUESTION_GROUP_STATUS = $request->onoff;
    $status_egroup1->save();
}
// end ตั้งค่าหมวดหมู่




//คำถาม

public function Equestion($id)
{
    $add_q = Equestion_group::where('HAPPY_NET_QUESTION_GROUP_ID', '=', $id)->first();
    
// dd( $add_q);

    // $status_modal = DB::table('happy_net_modal')
    //     ->where('happy_net_modal.HAPPY_NET_MODAL_QUESTION_ID', '=', '1')
    //     ->get();


    $QEtable = DB::table('happy_net_question')
    ->where('HAPPY_NET_QUESTION_ID_GROUP','=',$id)
        ->get();

        
    return view('person_happynet.Equestion_Happy_Net', [
        'QEtable' => $QEtable,
        // 'status_modal' => $status_modal,
        
           'add_q' => $add_q,
    ]);
}
public function  add_Equestion($id)
{   

        $add_q = Equestion_group::where('HAPPY_NET_QUESTION_GROUP_ID', '=', $id)->first();
        return view('person_happynet.add_Equestion_Happy_Net', [
            'add_q' => $add_q,
        ]);
}
public function save_Equestion(Request $request ,$id)
{
    $id = Equestion_group::where('HAPPY_NET_QUESTION_GROUP_ID', '=', $id)->first();

    $save_Equestion = new Equestion();
    $save_Equestion->HAPPY_NET_QUESTION_ID_GROUP = $request->HAPPY_NET_QUESTION_ID_GROUP;
    $save_Equestion->HAPPY_NET_QUESTION = $request->HAPPY_NET_QUESTION;
    $save_Equestion->HAPPY_NET_QUESTION_COIN = $request->HAPPY_NET_QUESTION_COIN;

    // if ($request->hasFile('picture')) {
    //     $image_qq = $request->file('picture');
    //     $name_gen = hexdec(uniqid());
    //     $img_ext = strtolower($image_qq->getClientOriginalExtension());
    //     $img_name = $name_gen . '.' . $img_ext;
    //     $upload_location = 'image/happy_net_image_question/';
    //     $full_path = $upload_location . $img_name;
    //     $save_Equestion->HAPPY_NET_QUESTION_IMAGE = $full_path;
    // }
    if ($request->hasFile('picture')) {
        $file                = $request->file('picture');
        $image_resize        = Image::make($file)->fit(300)->encode();
        // dd($image_resize);
        $contents            = $file->openFile()->fread($file->getSize());
        $save_Equestion->HAPPY_NET_QUESTION_IMAGE =  $image_resize;
    }
    // dd($save_Equestion);
  
    $save_Equestion->save();
    // dd($save_Equestion);
    // $image_qq->move($upload_location, $img_name);
    return redirect()->route('happy.Equestion',[
        'id' => $id
    ])->with('success', "บันทึกข้อมูลเรียบร้อย");
}
public function edit_Equestion($id)
{  
    //  $add_q = Equestion_group::where('HAPPY_NET_QUESTION_GROUP_ID', '=', $id)->first();
    $edit_Equestions = Equestion::where('HAPPY_NET_QUESTION_ID', '=', $id)->first();

  
    $add_q = Equestion_group::where('HAPPY_NET_QUESTION_GROUP_ID', '=', $id)->first();
 
    
    // //    dd($edit_Equestions);   
    return view('person_happynet.edit_Equestion_Happy_Net', [
        'edit_Equestions' => $edit_Equestions,
        'add_q' => $add_q,
    ]);
}
public function update_Equestion(Request $request )
{
    // $idg =$idg ;
    // $idg = Equestion_group::where('HAPPY_NET_QUESTION_GROUP_ID', '=', $idg)->first();
    $id_q = $request->HAPPY_NET_QUESTION_ID;
    $update_Equestion = Equestion::where('HAPPY_NET_QUESTION_ID', '=', $id_q)->first();
    $id =  $request->HAPPY_NET_QUESTION_ID_GROUP;
    // dd($id);
    
    $image_qq = $request->file('picture_edit');
    // if ($image_qq) {
    //     $name_gen = hexdec(uniqid());
    //     $img_ext = strtolower($image_qq->getClientOriginalExtension());
    //     $img_name = $name_gen . '.' . $img_ext;
    //     $upload_location = 'image/happy_net_image_question/';
    //     $full_path = $upload_location . $img_name;

    if ($image_qq) {
        $file                = $request->file('picture_edit');
            $image_resize        = Image::make($file)->fit(300)->encode();
            // dd($image_resize);
            $contents            = $file->openFile()->fread($file->getSize());
            $update_Equestion->HAPPY_NET_QUESTION_IMAGE =  $image_resize;
    
        $update_Equestion->HAPPY_NET_QUESTION = $request->HAPPY_NET_QUESTION;
        $update_Equestion->HAPPY_NET_QUESTION_COIN = $request->HAPPY_NET_QUESTION_COIN;

        // $update_Equestion->HAPPY_NET_QUESTION_IMAGE = $full_path;
        $update_Equestion->save();
        // $old_image = $request->old_image;
        // unlink($old_image);
        // $image_qq->move($upload_location, $img_name);
        return redirect()->route('happy.Equestion',[
            'id'=>$id
        ])->with('success', "แก้ไขข้อมูลเรียบร้อย");
    } else {
        $update_Equestion->HAPPY_NET_QUESTION = $request->HAPPY_NET_QUESTION;
        $update_Equestion->HAPPY_NET_QUESTION_COIN = $request->HAPPY_NET_QUESTION_COIN;

        $update_Equestion->save();
        return redirect()->route('happy.Equestion',[
            'id'=>$id
        ])->with('success', "แก้ไขข้อมูลเรียบร้อย");
        
    }
}
// public function destroy_Equestion($id ,Request $request)
// {
//     $id_q = Equestion::where('HAPPY_NET_QUESTION_ID', '=', $id_q)->first();

//     Equestion::destroy($id);

//       return redirect()->route('happy.Equestion',[
//         'id_q' => $id_q
//     ]);
//     // return redirect()->route('Equestion')->with('success', "ลบข้อมูลเรียบร้อย");
// }
public function status_Equestion(Request $request)
{
    $id = $request->status_Equestions;
    $status_Equestion1 = Equestion::find($id);
    $status_Equestion1->HAPPY_NET_QUESTION_STATUS = $request->onoff;
    $status_Equestion1->save();
}


// end คำถาม



    public function send_user_search(Request $request)
    {
        $search = $request->get('search');

        $person = Person::leftJoin('hrd_prefix', 'hrd_person.HR_PREFIX_ID', '=', 'hrd_prefix.HR_PREFIX_ID')
            ->leftJoin('hrd_sex', 'hrd_person.SEX', '=', 'hrd_sex.SEX_ID')
            ->leftJoin('hrd_status', 'hrd_person.HR_STATUS_ID', '=', 'hrd_status.HR_STATUS_ID')
            ->leftJoin('hrd_level', 'hrd_person.HR_LEVEL_ID', '=', 'hrd_level.HR_LEVEL_ID')
            ->leftJoin('hrd_department_sub_sub', 'hrd_person.HR_DEPARTMENT_SUB_SUB_ID', '=', 'hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
            ->leftJoin('hrd_department', 'hrd_person.HR_DEPARTMENT_ID', '=', 'hrd_department.HR_DEPARTMENT_ID')
            ->leftJoin('hrd_department_sub', 'hrd_person.HR_DEPARTMENT_SUB_ID', '=', 'hrd_department_sub.HR_DEPARTMENT_SUB_ID')
            ->leftJoin('users', 'hrd_person.ID', '=', 'users.PERSON_ID')
            ->where('HR_CID', 'like', '%' . $search . '%')
            ->orwhere('HR_PREFIX_NAME', 'like', '%' . $search . '%')
            ->orwhere('HR_FNAME', 'like', '%' . $search . '%')
            ->orwhere('HR_LNAME', 'like', '%' . $search . '%')
            ->orwhere('NICKNAME', 'like', '%' . $search . '%')
            ->orwhere('SEX_NAME', 'like', '%' . $search . '%')
            ->orwhere('HR_STATUS_NAME', 'like', '%' . $search . '%')
            ->orwhere('POSITION_IN_WORK', 'like', '%' . $search . '%')
            ->orwhere('HR_LEVEL_NAME', 'like', '%' . $search . '%')
            ->orwhere('HR_DEPARTMENT_SUB_SUB_NAME', 'like', '%' . $search . '%')
            ->orwhere('HR_DEPARTMENT_SUB_NAME', 'like', '%' . $search . '%')
            ->orwhere('HR_DEPARTMENT_NAME', 'like', '%' . $search . '%')
            ->orderBy('hrd_person.ID', 'desc')
            ->get();
        //dd($person);

        $count = Person::leftJoin('hrd_prefix', 'hrd_person.HR_PREFIX_ID', '=', 'hrd_prefix.HR_PREFIX_ID')
            ->leftJoin('hrd_sex', 'hrd_person.SEX', '=', 'hrd_sex.SEX_ID')
            ->leftJoin('hrd_status', 'hrd_person.HR_STATUS_ID', '=', 'hrd_status.HR_STATUS_ID')
            ->leftJoin('hrd_level', 'hrd_person.HR_LEVEL_ID', '=', 'hrd_level.HR_LEVEL_ID')
            ->leftJoin('hrd_department_sub_sub', 'hrd_person.HR_DEPARTMENT_SUB_SUB_ID', '=', 'hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
            ->leftJoin('hrd_department', 'hrd_person.HR_DEPARTMENT_ID', '=', 'hrd_department.HR_DEPARTMENT_ID')
            ->leftJoin('hrd_department_sub', 'hrd_person.HR_DEPARTMENT_SUB_ID', '=', 'hrd_department_sub.HR_DEPARTMENT_SUB_ID')
            ->leftJoin('users', 'hrd_person.ID', '=', 'users.PERSON_ID')
            ->where('HR_CID', 'like', '%' . $search . '%')
            ->orwhere('HR_PREFIX_NAME', 'like', '%' . $search . '%')
            ->orwhere('HR_FNAME', 'like', '%' . $search . '%')
            ->orwhere('HR_LNAME', 'like', '%' . $search . '%')
            ->orwhere('NICKNAME', 'like', '%' . $search . '%')
            ->orwhere('SEX_NAME', 'like', '%' . $search . '%')
            ->orwhere('HR_STATUS_NAME', 'like', '%' . $search . '%')
            ->orwhere('POSITION_IN_WORK', 'like', '%' . $search . '%')
            ->orwhere('HR_LEVEL_NAME', 'like', '%' . $search . '%')
            ->orwhere('HR_DEPARTMENT_SUB_SUB_NAME', 'like', '%' . $search . '%')
            ->orwhere('HR_DEPARTMENT_SUB_NAME', 'like', '%' . $search . '%')
            ->orwhere('HR_DEPARTMENT_NAME', 'like', '%' . $search . '%')
            ->count();


        $id_user = Auth::user()->PERSON_ID;
        $inforperson =  Person::leftJoin('hrd_prefix', 'hrd_person.HR_PREFIX_ID', '=', 'hrd_prefix.HR_PREFIX_ID')
            ->leftJoin('hrd_sex', 'hrd_person.SEX', '=', 'hrd_sex.SEX_ID')
            ->leftJoin('hrd_status', 'hrd_person.HR_STATUS_ID', '=', 'hrd_status.HR_STATUS_ID')
            ->leftJoin('hrd_level', 'hrd_person.HR_LEVEL_ID', '=', 'hrd_level.HR_LEVEL_ID')
            ->leftJoin('hrd_department_sub_sub', 'hrd_person.HR_DEPARTMENT_SUB_SUB_ID', '=', 'hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
            ->leftJoin('hrd_department', 'hrd_person.HR_DEPARTMENT_ID', '=', 'hrd_department.HR_DEPARTMENT_ID')
            ->leftJoin('hrd_department_sub', 'hrd_person.HR_DEPARTMENT_SUB_ID', '=', 'hrd_department_sub.HR_DEPARTMENT_SUB_ID')
            ->where('hrd_person.HR_STATUS_ID', '=', 1)
            ->orwhere('HR_PREFIX_NAME', 'like', '%' . $search . '%')
            ->orwhere('HR_FNAME', 'like', '%' . $search . '%')
            ->orwhere('HR_LNAME', 'like', '%' . $search . '%')
            ->orwhere('POSITION_IN_WORK', 'like', '%' . $search . '%')
            ->get();
        //    dd($inforperson);

        $count =  Person::leftJoin('hrd_prefix', 'hrd_person.HR_PREFIX_ID', '=', 'hrd_prefix.HR_PREFIX_ID')
            ->leftJoin('hrd_sex', 'hrd_person.SEX', '=', 'hrd_sex.SEX_ID')
            ->leftJoin('hrd_status', 'hrd_person.HR_STATUS_ID', '=', 'hrd_status.HR_STATUS_ID')
            ->leftJoin('hrd_level', 'hrd_person.HR_LEVEL_ID', '=', 'hrd_level.HR_LEVEL_ID')
            ->leftJoin('hrd_department_sub_sub', 'hrd_person.HR_DEPARTMENT_SUB_SUB_ID', '=', 'hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
            ->leftJoin('hrd_department', 'hrd_person.HR_DEPARTMENT_ID', '=', 'hrd_department.HR_DEPARTMENT_ID')
            ->leftJoin('hrd_department_sub', 'hrd_person.HR_DEPARTMENT_SUB_ID', '=', 'hrd_department_sub.HR_DEPARTMENT_SUB_ID')
            ->where('hrd_person.HR_STATUS_ID', '=', 1)
            ->orwhere('HR_PREFIX_NAME', 'like', '%' . $search . '%')
            ->orwhere('HR_FNAME', 'like', '%' . $search . '%')
            ->orwhere('HR_LNAME', 'like', '%' . $search . '%')
            ->orwhere('POSITION_IN_WORK', 'like', '%' . $search . '%')
            ->count();

        $chom = DB::table('happy_net_compliment')
            ->get();

        $chom_id = DB::table('happy_net_compliment')
            ->leftJoin('hrd_person', 'happy_net_compliment.ID_USER', '=', 'hrd_person.ID')
            ->orderBy('HAPPY_NET_COIMPLIMENT_ID', 'desc')
            ->where('ID_USER_INSERT', '=', $id_user)
            ->get();
        // dd($chom_id);
        $problem_id = DB::table('happy_net_problem')
            ->leftJoin('hrd_person', 'happy_net_problem.ID_USER', '=', 'hrd_person.ID')
            ->orderBy('HAPPY_NET_PROBLEM_ID', 'desc')
            // ->where('HAPPY_NET_PROBLEM_STATUS', '=', 'False')
            ->get();

        $pr_id = DB::table('happy_net_problem')
            ->leftJoin('hrd_person', 'happy_net_problem.ID_USER', '=', 'hrd_person.ID')
            ->get();
        // ->where('happy_net_problem.HAPPY_NET_PROBLEM_ID','=',$id)->first();
        // dd($pr_id);


        $chomsum = DB::table('happy_net_compliment')
            ->where('ID_USER_INSERT', '=', $id_user)
            ->count();

        $problem_idsum = DB::table('happy_net_problem')
            ->where('ID_USER_INSERT_PROBLEM', '=', $id_user)
            // ->where('HAPPY_NET_PROBLEM_STATUS', '=', 'False')
            ->count();


        $ans = DB::table('happy_net_problem')
            ->leftJoin('hrd_person', 'happy_net_problem.ID_USER', '=', 'hrd_person.ID')
            ->leftJoin('happy_net_problem_answer', 'happy_net_problem.HAPPY_NET_PROBLEM_ID', '=', 'happy_net_problem_answer.HAPPY_NET_PROBLEM_QUESTION_ID')
            ->orderBy('HAPPY_NET_PROBLEM_QUESTION_ID', 'desc')
            // ->where('HAPPY_NET_PROBLEM_ID', '=', 'HAPPY_NET_PROBLEM_QUESTION_ID')
            // ->first();
            ->get();
        // dd($ans);

        // $a = DB::table('happy_net_problem') ->select('HAPPY_NET_PROBLEM_ID')->get();
        // $b =DB::table('happy_net_problem_answer') ->select('HAPPY_NET_PROBLEM_QUESTION_ID') ->get();

        $inforpersons =  Person::leftJoin('hrd_prefix', 'hrd_person.HR_PREFIX_ID', '=', 'hrd_prefix.HR_PREFIX_ID')
            ->leftJoin('hrd_sex', 'hrd_person.SEX', '=', 'hrd_sex.SEX_ID')
            ->leftJoin('hrd_status', 'hrd_person.HR_STATUS_ID', '=', 'hrd_status.HR_STATUS_ID')
            ->leftJoin('hrd_level', 'hrd_person.HR_LEVEL_ID', '=', 'hrd_level.HR_LEVEL_ID')
            ->leftJoin('hrd_department_sub_sub', 'hrd_person.HR_DEPARTMENT_SUB_SUB_ID', '=', 'hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
            ->leftJoin('hrd_department', 'hrd_person.HR_DEPARTMENT_ID', '=', 'hrd_department.HR_DEPARTMENT_ID')
            ->leftJoin('hrd_department_sub', 'hrd_person.HR_DEPARTMENT_SUB_ID', '=', 'hrd_department_sub.HR_DEPARTMENT_SUB_ID')
            ->where('hrd_person.HR_STATUS_ID', '=', 1)
            ->where('ID', '=', $id_user)->first();

        return view('person_happynet/send_user_Happy_Net', [
            'persons' => $person,
            'count' => $count,
            'search' => $search,

            'inforperson' => $inforperson,
            'inforpersons' => $inforpersons,
            'chom' => $chom,
            'chom_id' => $chom_id,
            'problem_id' => $problem_id,

            'pr_id' => $pr_id,
            'id_user' => $id_user,

            'chomsum' => $chomsum,
            'problem_idsum' => $problem_idsum,
            'ans' => $ans,
        ]);
    }


    public function rank_coin()
    {


        $rankcoin_get = DB::table('happy_net_coin')
            ->select(DB::raw('sum(happy_net_coin.HAPPY_NET_COIN) as sum'), 'ID')
            ->leftJoin('hrd_person', 'hrd_person.ID', '=', 'happy_net_coin.ID_USER')
            ->groupBy('hrd_person.ID')
            ->orderBy('sum', 'desc')

            ->limit(100)

            ->get();


        // $get = $rankcoin_get->ID ; 
        // dd($get);

        $all = Person::leftJoin('hrd_prefix', 'hrd_person.HR_PREFIX_ID', '=', 'hrd_prefix.HR_PREFIX_ID')
            ->leftJoin('hrd_sex', 'hrd_person.SEX', '=', 'hrd_sex.SEX_ID')
            ->leftJoin('hrd_status', 'hrd_person.HR_STATUS_ID', '=', 'hrd_status.HR_STATUS_ID')
            ->leftJoin('hrd_level', 'hrd_person.HR_LEVEL_ID', '=', 'hrd_level.HR_LEVEL_ID')
            ->leftJoin('hrd_department_sub_sub', 'hrd_person.HR_DEPARTMENT_SUB_SUB_ID', '=', 'hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
            ->leftJoin('hrd_department', 'hrd_person.HR_DEPARTMENT_ID', '=', 'hrd_department.HR_DEPARTMENT_ID')
            ->leftJoin('hrd_department_sub', 'hrd_person.HR_DEPARTMENT_SUB_ID', '=', 'hrd_department_sub.HR_DEPARTMENT_SUB_ID')
            ->where('hrd_person.HR_STATUS_ID', '=', 1)
            ->get();



        //  dd($all);
        //  dd($rankcoin_get);
        return view('person_happynet.rank_coin_Happy_Net', [
            'rankcoin_get' => $rankcoin_get,
            'all' => $all,
        ]);
    }
    public function rank_ans()
    {
        $rankans_get = DB::table('happy_net_compliment')

            ->select('ID_USER', DB::raw('count(*) as HAPPY_NET_COIMPLIMENT_ID'))

            ->groupBy('ID_USER')
            ->orderBy('HAPPY_NET_COIMPLIMENT_ID', 'desc')
            ->limit(100)
            ->get();

        // dd($rankans_get);
        return view('person_happynet.rank_ans_Happy_Net', [
            'rankans_get' => $rankans_get,
            // 'all' => $all,
        ]);
    }
    public function rank_ques()
    {
        $rankq_get =  DB::table('happy_net_answer')

            ->select('ID_USER', DB::raw('count(*) as HAPPY_NET_ANSWER_ID'))

            ->groupBy('ID_USER')
            ->orderBy('HAPPY_NET_ANSWER_ID', 'desc')
            ->limit(100)
            ->get();


        // dd($rankq_get);
        return view('person_happynet.rank_ques_Happy_Net', [
            'rankq_get' => $rankq_get,
            // 'all' => $all,


        ]);
    }


    public function like(Request $request)
    {
        // $id_user = Auth::user()->PERSON_ID;

        $idpro =  $request->idpro;
        // dd($idpro);
        $status =  $request->status;


        $update_like = problem_happy::where('HAPPY_NET_PROBLEM_ID', '=', $idpro)->first();


        // $save_question_dashboard = new Answer();

        $update_like->PROBLEM_USER_LIKE = $status;
       
    }

    //  static function

    public static function person_image($id_preson)
    {

        $inforperson = DB::table('hrd_person')->where('ID', '=', $id_preson)->first();
        if ($inforperson == null) {
            $resultimage = '-';
        } else {
            $resultimage = chunk_split(base64_encode($inforperson->HR_IMAGE));
        }
        return $resultimage;
    }
    public static function person_work($id_preson)
    {

        $inforperson = DB::table('hrd_person')->where('ID', '=', $id_preson)->first();

        if ($inforperson == null) {

            $resultwork = '-';
        } else {

            $resultwork = ($inforperson->POSITION_IN_WORK);
        }


        return $resultwork;
    }
    public static function person_fname($id_preson)
    {

        $inforperson = DB::table('hrd_person')->where('ID', '=', $id_preson)->first();

        if ($inforperson == null) {

            $resultfname = '-';
        } else {

            $resultfname = ($inforperson->HR_FNAME);
        }


        return $resultfname;
    }

    public static function person_lname($id_preson)
    {

        $inforperson = DB::table('hrd_person')->where('ID', '=', $id_preson)->first();

        if ($inforperson == null) {

            $resultlname = '-';
        } else {

            $resultlname = ($inforperson->HR_LNAME);
        }


        return $resultlname;
    }

    // ไม่ได้  join

    public static function dd_image($id_preson)
    {

        $inforperson = DB::table('hrd_person')->where('ID', '=', $id_preson)->first();

        if ($inforperson == null) {

            $resultimage = '-';
        } else {

            $resultimage = chunk_split(base64_encode($inforperson->HR_IMAGE));
        }


        return $resultimage;
    }
    public static function dd_work($id_preson)
    {

        $inforperson = DB::table('hrd_person')->where('ID', '=', $id_preson)->first();

        if ($inforperson == null) {

            $resultwork = '-';
        } else {

            $resultwork = ($inforperson->POSITION_IN_WORK);
        }


        return $resultwork;
    }
    public static function dd_fname($id_preson)
    {

        $inforperson = DB::table('hrd_person')->where('ID', '=', $id_preson)->first();

        if ($inforperson == null) {

            $resultfname = '-';
        } else {

            $resultfname = ($inforperson->HR_FNAME);
        }


        return $resultfname;
    }

    public static function dd_lname($id_preson)
    {

        $inforperson = DB::table('hrd_person')->where('ID', '=', $id_preson)->first();

        if ($inforperson == null) {

            $resultlname = '-';
        } else {

            $resultlname = ($inforperson->HR_LNAME);
        }


        return $resultlname;
    }

    public static function conut_ans($id_ans)
    {

        $ans = DB::table('happy_net_problem_answer')->where('HAPPY_NET_PROBLEM_ANSWER_ID', '=', $id_ans)->first();

        if ($ans == null) {

            $resultAns = '-';
        } else {

            $resultAns = ($ans->HR_LNAME);
        }


        return $resultAns;
    }

    public static function  compliment_image($id_preson)
    {

        $inforperson = DB::table('hrd_person')->where('ID', '=', $id_preson)->first();

        if ($inforperson == null) {

            $resultimage =  asset('image/pers.png');

          
            
        } else {

            $resultimage = chunk_split(base64_encode($inforperson->HR_IMAGE));
        }


        return $resultimage;
    }

    
    public static function  count_probem()
    {
        $m_budget = date("m");
        if ((int)$m_budget > 9) {
            $yearbudget = date("Y") + 544;
        } else {
            $yearbudget = date("Y") + 543;
        }

        $year_ = array();
        for ($i = $yearbudget; $i >= $yearbudget - 9; $i--) {
            $year_[$i] = $i;
        }
        $data['year_'] = $year_;

        $data['yearbudget_select'] = $yearbudget;
        $year = $data['yearbudget_select'] - 543;
        if (isset($_GET['yearbudget_select'])) {
            $data['yearbudget_select'] = $_GET['yearbudget_select'];
        }

        $year = date('Y');
        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();

        $year_id = $year + 543;
        // $inforperson = DB::table('hrd_person')->where('ID', '=', $id_preson)->first();
      
        $id_user = Auth::user()->PERSON_ID;
        $happy_net_modal = DB::table('happy_net_modal')
        ->where('ID_USER','=',$id_user)
        ->where('DATE_SAVE','=',date('Y-m-d'))
        ->count();

        $problem_s = DB::table('happy_net_problem')
        ->leftJoin('hrd_person', 'happy_net_problem.ID_USER', '=', 'hrd_person.ID')
        ->leftJoin('happy_net_difficulty', 'happy_net_problem.HAPPY_NET_DIFFICULTY_ID', '=', 'happy_net_difficulty.HAPPY_NET_DIFFICULTY_ID')
        ->orderBy('HAPPY_NET_PROBLEM_ID', 'desc')
        ->where('ID_USER', '=', $id_user)
        // ->get();
        ->where('HAPPY_NET_PROBLEM_STATUS', '=', 'False')
        ->where('DATE_SAVE', 'like', $year . '%')->count();
        $problem_id = DB::table('happy_net_problem')
        ->leftJoin('hrd_person', 'happy_net_problem.ID_USER', '=', 'hrd_person.ID')
        ->orderBy('HAPPY_NET_PROBLEM_ID', 'desc')
        ->where('HAPPY_NET_PROBLEM_STATUS', '=', 'False')
        ->where('ID_USER_INSERT_PROBLEM', '=', $id_user)
        // ->where('DATE_SAVE', '=', date('Y-m-d'))
        ->where('DATE_SAVE', 'like', $year . '%')
        ->count();

        $count = $problem_s +  $problem_id ;

        if ($count == !null) {

            $resultimage =   $count ;
          
            
        } else {

            $resultimage =   '' ;
          
        }


        return $resultimage;
    }
    public static function  count_chom()
    {
        $m_budget = date("m");
        if ((int)$m_budget > 9) {
            $yearbudget = date("Y") + 544;
        } else {
            $yearbudget = date("Y") + 543;
        }

        $year_ = array();
        for ($i = $yearbudget; $i >= $yearbudget - 9; $i--) {
            $year_[$i] = $i;
        }
        $data['year_'] = $year_;

        $data['yearbudget_select'] = $yearbudget;
        $year = $data['yearbudget_select'] - 543;
        if (isset($_GET['yearbudget_select'])) {
            $data['yearbudget_select'] = $_GET['yearbudget_select'];
        }

        $year = date('Y');
        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();

        $year_id = $year + 543;
        // $inforperson = DB::table('hrd_person')->where('ID', '=', $id_preson)->first();
      
        $id_user = Auth::user()->PERSON_ID;
        $count_chom = DB::table('happy_net_compliment')
        ->where('ID_USER', '=', $id_user)
        ->where('DATE_SAVE', '=', date('Y-m-d'))
        // ->count();
        ->where('DATE_SAVE', 'like', $year . '%')->count();


        if ($count_chom == !null) {

            $resultimage =   $count_chom ;
          
            
        } else {

            $resultimage =   '' ;
        }


        return $resultimage;
    }




     // ตั้งค่าการกำหนดการจ่ายเหรียญในแต่ละวัน
     public function set_coin(Request $request)
     {
        
        $set_check = DB::table('happy_net_set_coin')->count();
        $edit_setcoin = DB::table('happy_net_set_coin')->get();
            return view('person_happynet.Eset_coin_Happy_Net', [
                'edit_setcoin' => $edit_setcoin,
                'set_check' => $set_check,
             ]);
            
        
     }
     public function set_coins(Request $request,$id)
     {
        $set_check = DB::table('happy_net_set_coin')->count();
            $edit_setcoins = Happysetcoin::where('HAPPY_NET_SET_COIN_ID', '=', $id)->first();
            return view('person_happynet.Eset_coin_Happy_Net', [
                'edit_setcoins' => $edit_setcoins,
                'set_check' => $set_check,
             ]);
        

        
     }
     public function update_set_coin(Request $request)
     {
         $save_ecoin = new Happysetcoin();
         $save_ecoin->HAPPY_NET_SET_COIN = $request->HAPPY_NET_SET_COIN;
         $save_ecoin->HAPPY_NET_SET_COIN_STATUS = 'True';
         $save_ecoin->DATE_SAVE = date('Y-m-d');

         $save_ecoin->save();
         return redirect()->route('ecoin')->with('success', "บันทึกข้อมูลเรียบร้อย");

       
     }


     
     public function update_set_coins(Request $request)
     {
         $id = $request->HAPPY_NET_SET_COIN_ID;
         $update_ecoin = Happysetcoin::where('HAPPY_NET_SET_COIN_ID', '=',$id)->first();
         $update_ecoin->HAPPY_NET_SET_COIN = $request->HAPPY_NET_SET_COIN;
         $update_ecoin->HAPPY_NET_SET_COIN_STATUS = 'True';
         $update_ecoin->DATE_SAVE = date('Y-m-d');

         $update_ecoin->save();
         return redirect()->route('ecoin')->with('success', "บันทึกข้อมูลเรียบร้อย");
     }

 //จบ




 public static function setcompliment_Happy()
 {
    $counts = DB::table('happy_net_set_compliment')->get();
     $count = DB::table('happy_net_set_compliment')->count();


  return $count ;
 }
 public static function setproblem_Happy()
 {
    $counts = DB::table('happy_net_set_problem')->get();
     $count = DB::table('happy_net_set_problem')->count();
  return $count ;
 }

 public static function setcompliment_Happys()
 {
    $counts = 1 ;
   
  return $counts ;
 }
 public static function setproblem_Happys()
 {
    $counts = 1 ;
   
  return $counts ;
 }
 public static function ets_st($id)
 {

     $inforperson = DB::table('happy_net_ethics')->where('HAPPY_NET_SET_ETHICS_ID', '=', $id)->first();

     if ($inforperson == null) {

         $resultwork = '-';
     } else {

         $resultwork = ($inforperson->HAPPY_NET_SET_ETHICS);
     }


     return $resultwork;
 }



     // ตั้งค่าการกำหนดการชื่นชมในแต่ละวัน
     public function Eset_compliment(Request $request)
     {
        
        $set_check = DB::table('happy_net_set_compliment')->count();
        $edit_setcoin = DB::table('happy_net_set_compliment')->get();
            return view('person_happynet.Eset_compliment_Happy_Net', [
                'edit_setcoin' => $edit_setcoin,
                'set_check' => $set_check,
             ]);
            
        
     }
     public function Eset_compliments(Request $request,$id)
     {
        $set_check = DB::table('happy_net_set_compliment')->count();
            $edit_compliments = Happysetcompliment::where('HAPPY_NET_SET_COMPLIMENT_ID', '=', $id)->first();
            // dd($edit_compliments);
            return view('person_happynet.Eset_compliment_Happy_Net', [
                'edit_compliments' => $edit_compliments,
                'set_check' => $set_check,
             ]);
        

        
     }
     public function update_Eset_compliment(Request $request)
     {
         $save_ecoin = new Happysetcompliment();
         $save_ecoin->HAPPY_NET_SET_COMPLIMENT = $request->HAPPY_NET_SET_COMPLIMENT;
         $save_ecoin->HAPPY_NET_SET_COMPLIMENT_STATUS = 'True';
         $save_ecoin->DATE_SAVE = date('Y-m-d');

         $save_ecoin->save();
         return redirect()->route('Happy_Net')->with('success', "บันทึกข้อมูลเรียบร้อย");

       
     }


     
     public function update_Eset_compliments(Request $request)
     {
         $id = $request->HAPPY_NET_SET_COMPLIMENT_ID;
         $update_ecoin = Happysetcompliment::where('HAPPY_NET_SET_COMPLIMENT_ID', '=',$id)->first();
         $update_ecoin->HAPPY_NET_SET_COMPLIMENT = $request->HAPPY_NET_SET_COMPLIMENT;
         $update_ecoin->HAPPY_NET_SET_COMPLIMENT_STATUS = 'True';
         $update_ecoin->DATE_SAVE = date('Y-m-d');

         $update_ecoin->save();
         return redirect()->route('Happy_Net')->with('success', "บันทึกข้อมูลเรียบร้อย");
     }

 //จบ

     // ตั้งค่าการกำหนดการการถามคำถามในแต่ละวัน
     public function Eset_problem(Request $request)
     {
        
        $set_check = DB::table('happy_net_set_problem')->count();
        $edit_setproblem = DB::table('happy_net_set_problem')->get();
            return view('person_happynet.Eset_problem_Happy_Net', [
                'edit_setproblem' => $edit_setproblem,
                'set_check' => $set_check,
             ]);
            
        
     }
     public function Eset_problems(Request $request,$id)
     {
        $set_check = DB::table('happy_net_set_problem')->count();
            $edit_setproblems = Happysetproblem::where('HAPPY_NET_SET_PROBLEM_ID', '=', $id)->first();
            return view('person_happynet.Eset_problem_Happy_Net', [
                'edit_setproblems' => $edit_setproblems,
                'set_check' => $set_check,
             ]);
        

        
     }
     public function update_Eset_problem(Request $request)
     {
         $save_eproblem = new Happysetproblem();
         $save_eproblem->HAPPY_NET_SET_PROBLEM = $request->HAPPY_NET_SET_PROBLEM;
         $save_eproblem->HAPPY_NET_SET_PROBLEM_STATUS = 'True';
         $save_eproblem->DATE_SAVE = date('Y-m-d');

         $save_eproblem->save();
         return redirect()->route('Happy_Net')->with('success', "บันทึกข้อมูลเรียบร้อย");

       
     }


     
     public function update_Eset_problems(Request $request)
     {
         $id = $request->HAPPY_NET_SET_PROBLEM_ID;
         $update_eproblem = Happysetproblem::where('HAPPY_NET_SET_PROBLEM_ID', '=',$id)->first();
         $update_eproblem->HAPPY_NET_SET_PROBLEM = $request->HAPPY_NET_SET_PROBLEM;
         $update_eproblem->HAPPY_NET_SET_PROBLEM_STATUS = 'True';
         $update_eproblem->DATE_SAVE = date('Y-m-d');

         $update_eproblem->save();
         return redirect()->route('Happy_Net')->with('success', "บันทึกข้อมูลเรียบร้อย");
     }

 //จบ

//  ดูประวัติ
public function history_send_user()
    {

        $id_user = Auth::user()->PERSON_ID;
        $m_budget = date("m");
        if ((int)$m_budget > 9) {
            $yearbudget = date("Y") + 544;
        } else {
            $yearbudget = date("Y") + 543;
        }

        $year_ = array();
        for ($i = $yearbudget; $i >= $yearbudget - 9; $i--) {
            $year_[$i] = $i;
        }
        $data['year_'] = $year_;

        $data['yearbudget_select'] = $yearbudget;
        $year = $data['yearbudget_select'] - 543;
        if (isset($_GET['yearbudget_select'])) {
            $data['yearbudget_select'] = $_GET['yearbudget_select'];
        }

        $year = date('Y');
        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();

        $year_id = $year + 543;

        $person = Person::leftJoin('hrd_prefix', 'hrd_person.HR_PREFIX_ID', '=', 'hrd_prefix.HR_PREFIX_ID')
            ->leftJoin('hrd_sex', 'hrd_person.SEX', '=', 'hrd_sex.SEX_ID')
            ->leftJoin('hrd_status', 'hrd_person.HR_STATUS_ID', '=', 'hrd_status.HR_STATUS_ID')
            ->leftJoin('hrd_level', 'hrd_person.HR_LEVEL_ID', '=', 'hrd_level.HR_LEVEL_ID')
            ->leftJoin('hrd_department_sub_sub', 'hrd_person.HR_DEPARTMENT_SUB_SUB_ID', '=', 'hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
            ->leftJoin('hrd_department', 'hrd_person.HR_DEPARTMENT_ID', '=', 'hrd_department.HR_DEPARTMENT_ID')
            ->leftJoin('hrd_department_sub', 'hrd_person.HR_DEPARTMENT_SUB_ID', '=', 'hrd_department_sub.HR_DEPARTMENT_SUB_ID')
            ->leftJoin('hrd_bloodgroup', 'hrd_person.HR_BLOODGROUP_ID', '=', 'hrd_bloodgroup.HR_BLOODGROUP_ID')
            ->leftJoin('hrd_marry_status', 'hrd_person.HR_MARRY_STATUS_ID', '=', 'hrd_marry_status.HR_MARRY_STATUS_ID')
            ->leftJoin('hrd_religion', 'hrd_person.HR_RELIGION_ID', '=', 'hrd_religion.HR_RELIGION_ID')
            ->leftJoin('hrd_nationality', 'hrd_person.HR_NATIONALITY_ID', '=', 'hrd_nationality.HR_NATIONALITY_ID')
            ->leftJoin('hrd_citizenship', 'hrd_person.HR_CITIZENSHIP_ID', '=', 'hrd_citizenship.HR_CITIZENSHIP_ID')
            ->leftJoin('hrd_tumbon', 'hrd_person.TUMBON_ID', '=', 'hrd_tumbon.ID')
            ->leftJoin('hrd_amphur', 'hrd_person.AMPHUR_ID', '=', 'hrd_amphur.ID')
            ->leftJoin('hrd_province', 'hrd_person.PROVINCE_ID', '=', 'hrd_province.ID')
            ->leftJoin('hrd_kind', 'hrd_person.HR_KIND_ID', '=', 'hrd_kind.HR_KIND_ID')
            ->leftJoin('hrd_kind_type', 'hrd_person.HR_KIND_TYPE_ID', '=', 'hrd_kind_type.HR_KIND_TYPE_ID')
            ->leftJoin('hrd_person_type', 'hrd_person.HR_PERSON_TYPE_ID', '=', 'hrd_person_type.HR_PERSON_TYPE_ID')
            ->where('hrd_person.HR_STATUS_ID', '=', 1)
            ->get();

        $count = Person::count();

        $problem_s = DB::table('happy_net_problem')
            ->leftJoin('hrd_person', 'happy_net_problem.ID_USER', '=', 'hrd_person.ID')
            ->leftJoin('happy_net_difficulty', 'happy_net_problem.HAPPY_NET_DIFFICULTY_ID', '=', 'happy_net_difficulty.HAPPY_NET_DIFFICULTY_ID')
            ->orderBy('HAPPY_NET_PROBLEM_ID', 'desc')
            ->where('ID_USER', '=', $id_user)
            // ->get();
            ->where('HAPPY_NET_PROBLEM_STATUS', '=', 'False')
            ->where('DATE_SAVE', 'like', $year . '%')->get();
            $problem_id = DB::table('happy_net_problem')
            ->leftJoin('hrd_person', 'happy_net_problem.ID_USER', '=', 'hrd_person.ID')
            ->orderBy('HAPPY_NET_PROBLEM_ID', 'desc')
            ->where('HAPPY_NET_PROBLEM_STATUS', '=', 'False')
            ->where('ID_USER_INSERT_PROBLEM', '=', $id_user)
            ->where('DATE_SAVE', 'like', $year . '%')
            ->get();

        $inforperson =  Person::leftJoin('hrd_prefix', 'hrd_person.HR_PREFIX_ID', '=', 'hrd_prefix.HR_PREFIX_ID')
            ->leftJoin('hrd_sex', 'hrd_person.SEX', '=', 'hrd_sex.SEX_ID')
            ->leftJoin('hrd_status', 'hrd_person.HR_STATUS_ID', '=', 'hrd_status.HR_STATUS_ID')
            ->leftJoin('hrd_level', 'hrd_person.HR_LEVEL_ID', '=', 'hrd_level.HR_LEVEL_ID')
            ->leftJoin('hrd_department_sub_sub', 'hrd_person.HR_DEPARTMENT_SUB_SUB_ID', '=', 'hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
            ->leftJoin('hrd_department', 'hrd_person.HR_DEPARTMENT_ID', '=', 'hrd_department.HR_DEPARTMENT_ID')
            ->leftJoin('hrd_department_sub', 'hrd_person.HR_DEPARTMENT_SUB_ID', '=', 'hrd_department_sub.HR_DEPARTMENT_SUB_ID')
            ->where('hrd_person.HR_STATUS_ID', '=', 1)
            ->where('hrd_person.ID','<>',$id_user)
            ->get();
        //    dd($inforperson);

        $chom = DB::table('happy_net_compliment')
        ->where('DATE_SAVE', 'like', $year . '%')->get();

        $chom_id = DB::table('happy_net_compliment')
            ->leftJoin('hrd_person', 'happy_net_compliment.ID_USER', '=', 'hrd_person.ID')
            ->orderBy('HAPPY_NET_COIMPLIMENT_ID', 'desc')
            ->where('ID_USER_INSERT', '=', $id_user)
            ->where('DATE_SAVE', 'like', $year . '%')->get();
        // dd($chom_id);
     


        $pr_id = DB::table('happy_net_problem')
            ->leftJoin('hrd_person', 'happy_net_problem.ID_USER', '=', 'hrd_person.ID')
            ->where('DATE_SAVE', 'like', $year . '%')->get();
        // ->where('happy_net_problem.HAPPY_NET_PROBLEM_ID','=',$id)->first();
        // dd($pr_id);


        $chomsum = DB::table('happy_net_compliment')
            ->where('ID_USER_INSERT', '=', $id_user)
            // ->count();
            ->where('DATE_SAVE', 'like', $year . '%')->count();

        $problem_idsum = DB::table('happy_net_problem')
            ->where('ID_USER_INSERT_PROBLEM', '=', $id_user)
            // ->where('HAPPY_NET_PROBLEM_STATUS', '=', 'False')
            // ->count();
            ->where('DATE_SAVE', 'like', $year . '%')->count();


            $problem_idsum_get = DB::table('happy_net_problem')
            ->where('ID_USER', '=', $id_user)
            // ->count();
            ->where('DATE_SAVE', 'like', $year . '%')->count();

        $inforpersons =  Person::leftJoin('hrd_prefix', 'hrd_person.HR_PREFIX_ID', '=', 'hrd_prefix.HR_PREFIX_ID')
            ->leftJoin('hrd_sex', 'hrd_person.SEX', '=', 'hrd_sex.SEX_ID')
            ->leftJoin('hrd_status', 'hrd_person.HR_STATUS_ID', '=', 'hrd_status.HR_STATUS_ID')
            ->leftJoin('hrd_level', 'hrd_person.HR_LEVEL_ID', '=', 'hrd_level.HR_LEVEL_ID')
            ->leftJoin('hrd_department_sub_sub', 'hrd_person.HR_DEPARTMENT_SUB_SUB_ID', '=', 'hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
            ->leftJoin('hrd_department', 'hrd_person.HR_DEPARTMENT_ID', '=', 'hrd_department.HR_DEPARTMENT_ID')
            ->leftJoin('hrd_department_sub', 'hrd_person.HR_DEPARTMENT_SUB_ID', '=', 'hrd_department_sub.HR_DEPARTMENT_SUB_ID')
            ->where('hrd_person.HR_STATUS_ID', '=', 1)
            ->where('ID', '=', $id_user)->first();
      
            $pro_id_if = DB::table('happy_net_problem')
            ->where('DATE_SAVE','=',date('Y-m-d'))
            ->where('ID_USER_INSERT_PROBLEM','=',$id_user)
            // ->where('happy_net_compliment.HAPPY_NET_COIMPLIMENT_ID', '=', $id)->first();
            ->count();
            // dd($chom_id_if);
            $set_compliment = DB::table('happy_net_set_problem')
            ->sum('HAPPY_NET_SET_PROBLEM');
            // ->get();
            $countview = $set_compliment-$pro_id_if;
            // dd($countview);

            
            $problem_his = DB::table('happy_net_problem')
            ->leftJoin('hrd_person', 'happy_net_problem.ID_USER', '=', 'hrd_person.ID')
            ->orderBy('HAPPY_NET_PROBLEM_ID', 'desc')
            // ->where('HAPPY_NET_PROBLEM_STATUS', '=', 'True')
            ->where('ID_USER', '=', $id_user)
            ->orwhere('ID_USER_INSERT_PROBLEM', '=', $id_user)
           
          
            

            ->get();
            
    // dd($problem_his);
        return view('person_happynet.history_send_user_Happy_Net', [
            'problem_his' => $problem_his,
            'inforperson' => $inforperson,
            'inforpersons' => $inforpersons,
            'chom' => $chom,
            'chom_id' => $chom_id,
            'problem_id' => $problem_id,

            'pr_id' => $pr_id,
            'id_user' => $id_user,

            'chomsum' => $chomsum,
            'problem_idsum' => $problem_idsum,
            'problem_s' => $problem_s,

            'persons' => $person,
            'count' => $count,
            'problem_idsum_get' => $problem_idsum_get,
            'set_compliment' => $set_compliment,
            // 'budgets' =>  $budget,
            // 'year_id' => $year_id,
            'countview' => $countview,
        ]);
    }
    public function historycon_send_user($id)
    {

        $id_user = Auth::user()->PERSON_ID;
        $problem_id = problem_happy::where('HAPPY_NET_PROBLEM_ID', '=', $id)->first();
        // $a = '1';
        // dd($a);

        $inforpersons =  Person::leftJoin('hrd_prefix', 'hrd_person.HR_PREFIX_ID', '=', 'hrd_prefix.HR_PREFIX_ID')
            ->leftJoin('hrd_sex', 'hrd_person.SEX', '=', 'hrd_sex.SEX_ID')
            ->leftJoin('hrd_status', 'hrd_person.HR_STATUS_ID', '=', 'hrd_status.HR_STATUS_ID')
            ->leftJoin('hrd_level', 'hrd_person.HR_LEVEL_ID', '=', 'hrd_level.HR_LEVEL_ID')
            ->leftJoin('hrd_department_sub_sub', 'hrd_person.HR_DEPARTMENT_SUB_SUB_ID', '=', 'hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
            ->leftJoin('hrd_department', 'hrd_person.HR_DEPARTMENT_ID', '=', 'hrd_department.HR_DEPARTMENT_ID')
            ->leftJoin('hrd_department_sub', 'hrd_person.HR_DEPARTMENT_SUB_ID', '=', 'hrd_department_sub.HR_DEPARTMENT_SUB_ID')
            ->where('hrd_person.HR_STATUS_ID', '=', 1)
            ->where('ID', '=', $id_user)->first();
        // $problem_id = DB::table('happy_net_problem')
        // ->leftJoin('hrd_person', 'happy_net_problem.ID_USER', '=', 'hrd_person.ID')
        // ->orderBy('HAPPY_NET_PROBLEM_ID', 'desc')
        // // ->where('HAPPY_NET_PROBLEM_STATUS', '=', 'True')
        // // ->where('ID_USER_INSERT_PROBLEM', '=', $id_user)
        // ->where('HAPPY_NET_PROBLEM_ID', '=', $id)->first();
            return view('person_happynet.historycon_send_user_Happy_Net', [
                'problem_id' => $problem_id,
                'inforpersons' => $inforpersons,
            ]);
    }
    public static function image_histrory($id_preson)
    {

        $inforperson = DB::table('hrd_person')->where('ID', '=', $id_preson)->first();
        if ($inforperson == null) {
            $resultimage = '-';
        } else {
            $resultimage = chunk_split(base64_encode($inforperson->HR_IMAGE));
        }
        return $resultimage;
    }
    public function history_get_user()
    {
        $id_user = Auth::user()->PERSON_ID;
        $m_budget = date("m");
        if ((int)$m_budget > 9) {
            $yearbudget = date("Y") + 544;
        } else {
            $yearbudget = date("Y") + 543;
        }

        $year_ = array();
        for ($i = $yearbudget; $i >= $yearbudget - 9; $i--) {
            $year_[$i] = $i;
        }
        $data['year_'] = $year_;

        $data['yearbudget_select'] = $yearbudget;
        $year = $data['yearbudget_select'] - 543;
        if (isset($_GET['yearbudget_select'])) {
            $data['yearbudget_select'] = $_GET['yearbudget_select'];
        }

        $year = date('Y');
        $budget = DB::table('budget_year')->orderBy('LEAVE_YEAR_ID', 'desc')->get();

        $year_id = $year + 543;
        
        $chom_id = DB::table('happy_net_compliment')
            ->leftJoin('hrd_person', 'happy_net_compliment.ID_USER', '=', 'hrd_person.ID')
            ->orderBy('HAPPY_NET_COIMPLIMENT_ID', 'desc')
            ->where('ID_USER', '=', $id_user)
            // ->first();
            ->where('DATE_SAVE', 'like', $year . '%')->get();

            // ->get();

        $problem_s = DB::table('happy_net_problem')
            ->leftJoin('hrd_person', 'happy_net_problem.ID_USER', '=', 'hrd_person.ID')
            ->orderBy('HAPPY_NET_PROBLEM_ID', 'desc')
            ->where('ID_USER', '=', $id_user)
            // ->get();
            ->where('DATE_SAVE', 'like', $year . '%')->get();



        $chomsum = DB::table('happy_net_compliment')
            ->where('ID_USER', '=', $id_user)
            // ->count();
            ->where('DATE_SAVE', 'like', $year . '%')->count();

        $problem_idsum = DB::table('happy_net_problem')
            ->where('ID_USER', '=', $id_user)
            // ->count();
            ->where('DATE_SAVE', 'like', $year . '%')->count();
           
   

        $inforpersons =  Person::leftJoin('hrd_prefix', 'hrd_person.HR_PREFIX_ID', '=', 'hrd_prefix.HR_PREFIX_ID')
            ->leftJoin('hrd_sex', 'hrd_person.SEX', '=', 'hrd_sex.SEX_ID')
            ->leftJoin('hrd_status', 'hrd_person.HR_STATUS_ID', '=', 'hrd_status.HR_STATUS_ID')
            ->leftJoin('hrd_level', 'hrd_person.HR_LEVEL_ID', '=', 'hrd_level.HR_LEVEL_ID')
            ->leftJoin('hrd_department_sub_sub', 'hrd_person.HR_DEPARTMENT_SUB_SUB_ID', '=', 'hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
            ->leftJoin('hrd_department', 'hrd_person.HR_DEPARTMENT_ID', '=', 'hrd_department.HR_DEPARTMENT_ID')
            ->leftJoin('hrd_department_sub', 'hrd_person.HR_DEPARTMENT_SUB_ID', '=', 'hrd_department_sub.HR_DEPARTMENT_SUB_ID')
            ->where('hrd_person.HR_STATUS_ID', '=', 1)
            ->where('ID', '=', $id_user)->first();


            $chom_s = DB::table('happy_net_compliment')
            ->leftJoin('hrd_person', 'happy_net_compliment.ID_USER', '=', 'hrd_person.ID')
            ->orderBy('HAPPY_NET_COIMPLIMENT_ID', 'desc')
            ->where('ID_USER_INSERT', '=', $id_user)
            ->where('DATE_SAVE', 'like', $year . '%')->get();
        // dd($chom_id);

        $chomsum_s = DB::table('happy_net_compliment')
        ->where('ID_USER_INSERT', '=', $id_user)
        // ->count();
        ->where('DATE_SAVE', 'like', $year . '%')->count();

        $inforperson =  Person::leftJoin('hrd_prefix', 'hrd_person.HR_PREFIX_ID', '=', 'hrd_prefix.HR_PREFIX_ID')
        ->leftJoin('hrd_sex', 'hrd_person.SEX', '=', 'hrd_sex.SEX_ID')
        ->leftJoin('hrd_status', 'hrd_person.HR_STATUS_ID', '=', 'hrd_status.HR_STATUS_ID')
        ->leftJoin('hrd_level', 'hrd_person.HR_LEVEL_ID', '=', 'hrd_level.HR_LEVEL_ID')
        ->leftJoin('hrd_department_sub_sub', 'hrd_person.HR_DEPARTMENT_SUB_SUB_ID', '=', 'hrd_department_sub_sub.HR_DEPARTMENT_SUB_SUB_ID')
        ->leftJoin('hrd_department', 'hrd_person.HR_DEPARTMENT_ID', '=', 'hrd_department.HR_DEPARTMENT_ID')
        ->leftJoin('hrd_department_sub', 'hrd_person.HR_DEPARTMENT_SUB_ID', '=', 'hrd_department_sub.HR_DEPARTMENT_SUB_ID')
        ->where('hrd_person.HR_STATUS_ID', '=', 1)
        ->where('hrd_person.ID','<>',$id_user)
        ->get();

                
        $chom_id_if = DB::table('happy_net_compliment')
        ->where('DATE_SAVE','=',date('Y-m-d'))
        ->where('ID_USER_INSERT','=',$id_user)
        // ->where('happy_net_compliment.HAPPY_NET_COIMPLIMENT_ID', '=', $id)->first();
        ->count();
        // dd($chom_id_if);
        $set_compliment = DB::table('happy_net_set_compliment')
        ->sum('HAPPY_NET_SET_COMPLIMENT');
        // ->get();
// dd($set_compliment);
        $countview = $set_compliment-$chom_id_if;
        // dd($countview);
              
    
        $chom_id_his = DB::table('happy_net_compliment')
        ->leftJoin('hrd_person', 'happy_net_compliment.ID_USER', '=', 'hrd_person.ID')
        ->orderBy('HAPPY_NET_COIMPLIMENT_ID', 'desc')
        ->where('ID_USER', '=', $id_user)
        ->orwhere('ID_USER_INSERT', '=', $id_user)
       ->get();
        return view('person_happynet.history_get_user_Happy_Net', [
            'chom_id' => $chom_id,
            'problem_s' => $problem_s,

            'inforpersons' => $inforpersons,

            'chomsum' => $chomsum,
            'problem_idsum' => $problem_idsum,

            'chom_s' => $chom_s,
            'chomsum_s' => $chomsum_s,
            'inforperson' => $inforperson,
            'set_compliment' => $set_compliment,
            'countview' => $countview,
            'chom_id_his' => $chom_id_his,
        ]);
    }
    
    



    public function status_modal_reward(Request $request)
    {
        $id = $request->status_modals;
        $status_modal = Emodal_Happy::find($id);
        $status_modal->HAPPY_NET_MODAL_QUESTION = $request->onoff;
        $status_modal->save();
    }
    public function view_status_modal_reward(Request $request)
    {  
        $status_modals = DB::table('happy_net_modal')
        // ->where('ID_USER', '=', '-1')
        ->get();
        
        $status_modal = DB::table('happy_net_modal')
 ->where('HAPPY_NET_MODAL_TYPE', '=', 'ประกาศรางวัล')
        ->count();
        // dd($status_modal);
        $ID = '1';
        // $null = 'True' ;
        // dd($status_modal);
    
        // if(!empty($status_modal))
        if($status_modal < 1)
        {
        // //  $save_modal->HAPPY_NET_MODAL_QUESTION_ID = $ID;
        $save_modal = new Emodal_Happy();
         $save_modal->HAPPY_NET_MODAL_QUESTION = "False";
         $save_modal->DATE_SAVE = date('Y-m-d');
         $save_modal->ID_USER = '0';
         $save_modal->HAPPY_NET_MODAL_TYPE = "ประกาศรางวัล";
         $save_modal->save();
        // dd('save_modal');
        return redirect()->route('happy.view_status_modal_reward');
    
        }else{
            // dd('00');
            return view('person_happynet.view_status_modal_reward_Happy_Net', [
            
                'status_modals' => $status_modals,
            ]);
            
        }
    
        
    }
    

    function ets_show(Request $request)
    {
       
      $id = $request->get('select');
      $result=array();
      $query= DB::table('happy_net_ethics')->where('HAPPY_NET_SET_ETHICS_ID',$id)->get();
      $output='';
      
      foreach ($query as $row){

            $output.= ''.$row->HAPPY_NET_SET_ETHICS_CONTENT.'';
    }

    echo $output;
        
    }


}
