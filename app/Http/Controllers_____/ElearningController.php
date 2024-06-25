<?php

namespace App\Http\Controllers;
use Artisan;
use Storage;
use File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Elearning_lesson_group;
use App\Models\Elearning_lesson;
use App\Models\Elearning_exam_group;
use App\Models\Elearning_exam;
use App\Models\Elearning_exam_choice;
use App\Models\Elearning_score;
use App\Models\users;
use Illuminate\Database\QueryException;
use Intervention\Image\ImageManagerStatic as Image;

class ElearningController extends Controller
{
    public function dashboard(){
        $id_lesson = DB::table('e_learning_lesson')->count();
        $id_user = Auth::user()->id;

        $count = DB::table('e_learning_score')
        ->where('STATUS_EXAM','=','1')
        ->where('ID_USER','=',$id_user)
        ->groupBy('ID_USER','ID_EXAM_GROUP')
        ->select('ID_USER','ID_EXAM_GROUP')
        ->get();
        $count_std = $count->count();

        $info_sum_score = DB::table('e_learning_score') 
        ->select(DB::raw('count(*) as score, ID_USER,e_learning_score.ID_EXAM_GROUP'),'e_learning_lesson.NAME_LESSON')
        ->leftJoin('e_learning_exam_group','e_learning_exam_group.ID_EXAM_GROUP','=','e_learning_score.ID_EXAM_GROUP')
        ->leftJoin('e_learning_lesson','e_learning_lesson.ID_LESSON','=','e_learning_exam_group.ID_LESSON')
        ->leftJoin('elearning_lesson_group','elearning_lesson_group.ID_LESSON_GROU','=','e_learning_lesson.ID_LESSON_GROUP')    
        ->where('e_learning_score.ID_USER','=',$id_user)
        ->groupBy('ID_USER','e_learning_score.ID_EXAM_GROUP','e_learning_lesson.NAME_LESSON')
        ->limit(5)
        ->get();

        $i=0;
        foreach($info_sum_score as $row){
            $data [$i] = DB::table('e_learning_score')
            ->where('SCORE','=','True')
            ->where('STATUS_EXAM','=','1')
            ->where('ID_EXAM_GROUP','=',$row->ID_EXAM_GROUP)
            ->where('ID_USER','=',$row->ID_USER)
            ->count();
            $i++;
        }
        $j=0;
        foreach($info_sum_score as $row){
            $name [$j] = $row->NAME_LESSON;
            $j++;
        }
        

       if(empty($name)){
        return view('person_elearning.dashboard_elearning',[
            'id_lesson' => $id_lesson,
            'count_std' => $count_std,
            'info_sum_score' => $info_sum_score,
        ]);

       }

        return view('person_elearning.dashboard_elearning',[
            'id_lesson' => $id_lesson,
            'count_std' => $count_std,
            'name' => $name,
            'data' => $data,
            'info_sum_score' => $info_sum_score,


        ]);
}
    public function information_group(){
        $info_lesson_group = DB::table('elearning_lesson_group')->where('ACTIVE_LESSON_GROUP','=','True')->get();
        
        //จำนวนคนเข้าเรียน
        $i=0;
        foreach($info_lesson_group as $row){

            $count [$i] = DB::table('e_learning_score')
            ->leftjoin('e_learning_exam_group','e_learning_exam_group.ID_EXAM_GROUP','=','e_learning_score.ID_EXAM_GROUP')
            ->leftjoin('e_learning_lesson','e_learning_exam_group.ID_LESSON','=','e_learning_lesson.ID_LESSON')
            ->where('e_learning_score.STATUS_EXAM','=','1')
            ->where('e_learning_lesson.ID_LESSON_GROUP','=',$row->ID_LESSON_GROU)
            ->groupBy('e_learning_score.ID_USER')
            ->select('e_learning_score.ID_USER')
            ->get();
            $count_std[$i] = $count[$i]->count();
            $i++;
        }
    
         $j=0;
         foreach($info_lesson_group as $row){
             $count_lesson [$j] = DB::table('e_learning_lesson')
             ->where('ID_LESSON_GROUP','=',$row->ID_LESSON_GROU)
             ->groupBy('ID_LESSON_GROUP')
             ->count();
             $j++;
         }

        if(empty($count_lesson) && empty($count_std)){
            return view('person_elearning.elearning_information_group',[
                'info_lesson_group' => $info_lesson_group,
            ]);  
        }
 
        return view('person_elearning.elearning_information_group',[
            'info_lesson_group' => $info_lesson_group,
            'count_lesson' => $count_lesson,
            'count_std' => $count_std
        ]);  
    }

    public function information_points(){
        $id_lesson_group = DB::table('elearning_lesson_group')->get();
        $id_user = Auth::user()->id;

        $info_sum_score = DB::table('e_learning_score') 
        ->select(DB::raw('count(*) as score, ID_USER,e_learning_score.ID_EXAM_GROUP'),'e_learning_lesson.NAME_LESSON')
        ->leftJoin('e_learning_exam_group','e_learning_exam_group.ID_EXAM_GROUP','=','e_learning_score.ID_EXAM_GROUP')
        ->leftJoin('e_learning_lesson','e_learning_lesson.ID_LESSON','=','e_learning_exam_group.ID_LESSON')
        ->leftJoin('elearning_lesson_group','elearning_lesson_group.ID_LESSON_GROU','=','e_learning_lesson.ID_LESSON_GROUP')    
        ->where('e_learning_score.ID_USER','=',$id_user)
        ->groupBy('ID_USER','e_learning_score.ID_EXAM_GROUP','e_learning_lesson.NAME_LESSON')
        ->get();

        $i=0;
        $j=0;
        foreach($info_sum_score as $row){
            $data [$i] = DB::table('e_learning_score')
            ->where('SCORE','=','True')
            ->where('STATUS_EXAM','=','0')
            ->where('ID_EXAM_GROUP','=',$row->ID_EXAM_GROUP)
            ->where('ID_USER','=',$row->ID_USER)
            ->count();
            $i++;
        }

        foreach($info_sum_score as $row){
            $data2 [$j] = DB::table('e_learning_score')
            ->where('SCORE','=','True')
            ->where('STATUS_EXAM','=','1')
            ->where('ID_EXAM_GROUP','=',$row->ID_EXAM_GROUP)
            ->where('ID_USER','=',$row->ID_USER)
            ->count();
            $j++;
        }

        if(empty($data)){
            return view('person_elearning.elearning_information_points',[
                'info_sum_score' => $info_sum_score,
                'id_lesson_group' => $id_lesson_group,
                ]);
        }


        return view('person_elearning.elearning_information_points',[
            'info_sum_score' => $info_sum_score,
            'id_lesson_group' => $id_lesson_group,
            'data' => $data,
            'data2' => $data2,
            
        ]);   
    }

    public function information_points_search(Request $request){
        $id_lesson_group_search = $request->ID_LESSON_GROU;

        $id_lesson_group = DB::table('elearning_lesson_group')->get();
        $id_user = Auth::user()->id;

        if($id_lesson_group_search == ''){
            $info_sum_score = DB::table('e_learning_score') 
            ->select(DB::raw('count(*) as score, ID_USER,e_learning_score.ID_EXAM_GROUP'),'e_learning_lesson.NAME_LESSON')
            ->leftJoin('e_learning_exam_group','e_learning_exam_group.ID_EXAM_GROUP','=','e_learning_score.ID_EXAM_GROUP')
            ->leftJoin('e_learning_lesson','e_learning_lesson.ID_LESSON','=','e_learning_exam_group.ID_LESSON')
            ->leftJoin('elearning_lesson_group','elearning_lesson_group.ID_LESSON_GROU','=','e_learning_lesson.ID_LESSON_GROUP')    
            ->where('e_learning_score.ID_USER','=',$id_user)
            ->groupBy('ID_USER','e_learning_score.ID_EXAM_GROUP','e_learning_lesson.NAME_LESSON')
            ->get();
        }else{
            $info_sum_score = DB::table('e_learning_score') 
            ->select(DB::raw('count(*) as score, ID_USER,e_learning_score.ID_EXAM_GROUP'),'e_learning_lesson.NAME_LESSON')
            ->leftJoin('e_learning_exam_group','e_learning_exam_group.ID_EXAM_GROUP','=','e_learning_score.ID_EXAM_GROUP')
            ->leftJoin('e_learning_lesson','e_learning_lesson.ID_LESSON','=','e_learning_exam_group.ID_LESSON')
            ->leftJoin('elearning_lesson_group','elearning_lesson_group.ID_LESSON_GROU','=','e_learning_lesson.ID_LESSON_GROUP')
            ->where('e_learning_score.ID_USER','=',$id_user)
            ->where('elearning_lesson_group.ID_LESSON_GROU','=',$id_lesson_group_search)
            ->groupBy('ID_USER','e_learning_score.ID_EXAM_GROUP','e_learning_lesson.NAME_LESSON')
            ->get();
        }  

        $i=0;
        $j=0;
            foreach($info_sum_score as $row){
                $data [$i] = DB::table('e_learning_score')
                ->where('SCORE','=','True')
                ->where('STATUS_EXAM','=','0')
                ->where('ID_EXAM_GROUP','=',$row->ID_EXAM_GROUP)
                ->where('ID_USER','=',$row->ID_USER)
                ->count();
                $i++;
            }
    
            foreach($info_sum_score as $row){
                $data2 [$j] = DB::table('e_learning_score')
                ->where('SCORE','=','True')
                ->where('STATUS_EXAM','=','1')
                ->where('ID_EXAM_GROUP','=',$row->ID_EXAM_GROUP)
                ->where('ID_USER','=',$row->ID_USER)
                ->count();
                $j++;
            }

        if(empty($data)){

        }else{
            return view('person_elearning.elearning_information_points',[
                'id_lesson_group' => $id_lesson_group,
                'info_sum_score' => $info_sum_score,
                'data' => $data,
                'data2' => $data2,
                'id_lesson_group_search'=>$id_lesson_group_search
            ]);   
        }


        return view('person_elearning.elearning_information_points',[
            'info_sum_score' => $info_sum_score,
            'id_lesson_group' => $id_lesson_group,
            'id_lesson_group_search'=>$id_lesson_group_search
        ]);   
    }

    public function information_lesson($id){
        $info_group = DB::table('elearning_lesson_group')->where('ID_LESSON_GROU','=',$id)->first();

        $info_lesson = DB::table('e_learning_lesson')
        ->where('ID_LESSON_GROUP','=',$id)
        ->where('ACTIVE_LESSON','=','True')->get();
    
        $i=0;
        foreach($info_lesson as $row){
            $num_exam [$i] = DB::table('e_learning_exam')
            ->leftjoin('e_learning_exam_group','e_learning_exam_group.ID_EXAM_GROUP','=','e_learning_exam.ID_EXAM_GROUP')
            ->leftjoin('e_learning_lesson','e_learning_lesson.ID_LESSON','=','e_learning_exam_group.ID_LESSON')
            ->where('e_learning_exam.ACTIVE_EXAM','=','True')
            ->where('e_learning_lesson.ID_LESSON','=',$row->ID_LESSON)
            ->count();
            $i++;
        }

        $j=0;
        foreach($info_lesson as $row){
            $count [$j] = DB::table('e_learning_score')
            ->leftjoin('e_learning_exam_group','e_learning_exam_group.ID_EXAM_GROUP','=','e_learning_score.ID_EXAM_GROUP')
            ->leftjoin('e_learning_lesson','e_learning_exam_group.ID_LESSON','=','e_learning_lesson.ID_LESSON')
            ->where('e_learning_score.STATUS_EXAM','=','1')
            ->where('e_learning_exam_group.ID_LESSON','=',$row->ID_LESSON)
            ->groupBy('e_learning_score.ID_USER')
            ->select('e_learning_score.ID_USER')
            ->get();
            $count_std[$j] = $count[$j]->count();
            $j++;
        }
 
        if(empty($num_exam) && empty($count_std)){
            return view('person_elearning.elearning_information_lesson',[
                'info_lesson' => $info_lesson,
                'info_group' => $info_group,
            ]);
        }
  
        return view('person_elearning.elearning_information_lesson',[
            'info_lesson' => $info_lesson,
            'info_group' => $info_group,
            'num_exam' => $num_exam,
            'count_std' => $count_std,
        ]);
    }

    public function lesson_detail($id){
        $info_lesson = DB::table('e_learning_lesson')->where('ID_LESSON','=',$id)->first();

        $num_exam = DB::table('e_learning_exam')
        ->leftjoin('e_learning_exam_group','e_learning_exam_group.ID_EXAM_GROUP','=','e_learning_exam.ID_EXAM_GROUP')
        ->leftjoin('e_learning_lesson','e_learning_lesson.ID_LESSON','=','e_learning_exam_group.ID_LESSON')
        ->where('e_learning_exam.ACTIVE_EXAM','=','True')
        ->where('e_learning_lesson.ID_LESSON','=',$id)
        ->count();
        
        return view('person_elearning.elearning_lesson_detail',[
            'info_lesson' => $info_lesson,
            'num_exam' => $num_exam,
        ]);
    }

    public function lesson_pre_exam($id){
        $info_lesson    = DB::table('e_learning_lesson')->where('ID_LESSON','=',$id)->first();
        $info_question  = DB::table('e_learning_lesson')
        ->leftjoin('e_learning_exam_group','e_learning_exam_group.ID_LESSON','=','e_learning_lesson.ID_LESSON')->where('e_learning_lesson.ID_LESSON','=',$id)
        ->leftjoin('e_learning_exam','e_learning_exam.ID_EXAM_GROUP','=','e_learning_exam_group.ID_EXAM_GROUP')->where('e_learning_exam_group.ACTIVE_EXAM_GROUP','=','True')
        ->leftjoin('e_learning_exam_choice','e_learning_exam_choice.ID_EXAM','=','e_learning_exam.ID_EXAM')->where('e_learning_exam.ACTIVE_EXAM','=','True')
        ->where('e_learning_exam_choice.ACTIVE_EXAM_CHOICE','=','True')
        ->GroupBy('e_learning_exam.QUESTION_EXAM','e_learning_exam.ID_EXAM','e_learning_exam.QUESTION_IMG_EXAMP','e_learning_exam.ID_EXAM_GROUP')
        ->select('e_learning_exam.QUESTION_EXAM','e_learning_exam.ID_EXAM','e_learning_exam.QUESTION_IMG_EXAMP','e_learning_exam.ID_EXAM_GROUP')
        ->get();

        $info_choice  = DB::table('e_learning_lesson')
        ->leftjoin('e_learning_exam_group','e_learning_exam_group.ID_LESSON','=','e_learning_lesson.ID_LESSON')->where('e_learning_lesson.ID_LESSON','=',$id)
        ->leftjoin('e_learning_exam','e_learning_exam.ID_EXAM_GROUP','=','e_learning_exam_group.ID_EXAM_GROUP')->where('e_learning_exam_group.ACTIVE_EXAM_GROUP','=','True')
        ->leftjoin('e_learning_exam_choice','e_learning_exam_choice.ID_EXAM','=','e_learning_exam.ID_EXAM')->where('e_learning_exam.ACTIVE_EXAM','=','True')
        ->where('e_learning_exam_choice.ACTIVE_EXAM_CHOICE','=','True')
        ->select('e_learning_exam_choice.EXAM_CHOICE','e_learning_exam_choice.ID_EXAM','e_learning_exam_choice.ID_EXAM_CHOICE','e_learning_exam_choice.ANSWER_EXAM_CHOICE')
        ->get();

        return view('person_elearning.elearning_lesson_pre_exam',[
            'info_lesson' => $info_lesson,
            'info_question' => $info_question,
            'info_choice' => $info_choice,
        ]);  
    }

    public function save_lesson_pre_exam(Request $request, $id){
      
        $info_lesson    = DB::table('e_learning_lesson')->where('ID_LESSON','=',$id)->first();
        $info_question  = DB::table('e_learning_lesson')
        ->leftjoin('e_learning_exam_group','e_learning_exam_group.ID_LESSON','=','e_learning_lesson.ID_LESSON')->where('e_learning_lesson.ID_LESSON','=',$id)
        ->leftjoin('e_learning_exam','e_learning_exam.ID_EXAM_GROUP','=','e_learning_exam_group.ID_EXAM_GROUP')->where('e_learning_exam_group.ACTIVE_EXAM_GROUP','=','True')
        ->leftjoin('e_learning_exam_choice','e_learning_exam_choice.ID_EXAM','=','e_learning_exam.ID_EXAM')->where('e_learning_exam.ACTIVE_EXAM','=','True')
        ->where('e_learning_exam_choice.ACTIVE_EXAM_CHOICE','=','True')
        ->GroupBy('e_learning_exam.QUESTION_EXAM','e_learning_exam.ID_EXAM','e_learning_exam.QUESTION_IMG_EXAMP','e_learning_exam.ID_EXAM_GROUP')
        ->select('e_learning_exam.QUESTION_EXAM','e_learning_exam.ID_EXAM','e_learning_exam.QUESTION_IMG_EXAMP','e_learning_exam.ID_EXAM_GROUP')
        ->get();

        $count_question = count($info_question);

        $info_choice  = DB::table('e_learning_lesson')
        ->leftjoin('e_learning_exam_group','e_learning_exam_group.ID_LESSON','=','e_learning_lesson.ID_LESSON')->where('e_learning_lesson.ID_LESSON','=',$id)
        ->leftjoin('e_learning_exam','e_learning_exam.ID_EXAM_GROUP','=','e_learning_exam_group.ID_EXAM_GROUP')->where('e_learning_exam_group.ACTIVE_EXAM_GROUP','=','True')
        ->leftjoin('e_learning_exam_choice','e_learning_exam_choice.ID_EXAM','=','e_learning_exam.ID_EXAM')->where('e_learning_exam.ACTIVE_EXAM','=','True')
        ->where('e_learning_exam_choice.ACTIVE_EXAM_CHOICE','=','True')
        ->select('e_learning_exam_choice.EXAM_CHOICE','e_learning_exam_choice.ID_EXAM','e_learning_exam_choice.ID_EXAM_CHOICE','e_learning_exam_choice.ANSWER_EXAM_CHOICE')
        ->get();

             for($i=0; $i<$count_question; $i++){
                $ID_EXAM[$i] =  $info_question[$i]->ID_EXAM;
                $ID_EXAM_GROUP[$i] =  $info_question[$i]->ID_EXAM_GROUP;                   
             }

             $user_id  =   $request->ID_USER;
             elearning_score::where('ID_USER','=',$user_id)
             ->where('ID_EXAM_GROUP','=',$ID_EXAM_GROUP)
             ->where('STATUS_EXAM','=','0')
             ->delete();

            for($i=0; $i<$count_question; $i++){
                $qq[$i] = $request->{$ID_EXAM[$i]};
                 
 
                if($qq[$i] == NULL || $qq[$i] == ''){
                     return back()->with('alert', 'กรุณาตอบคำถามให้ครบ!');
                   
                }else{

                    $id_choice[] =  DB::table('e_learning_exam_choice')->where('ID_EXAM_CHOICE', '=' , $qq[$i])
                    ->select('ANSWER_EXAM_CHOICE')
                    ->first();
                    
                    $score_result[$i] = $id_choice[$i]->ANSWER_EXAM_CHOICE;    

            
                        $addscore = new elearning_score();
                        $addscore->STATUS_EXAM      =   $request->STATUS_EXAM;
                        $addscore->ID_EXAM_GROUP    =   $ID_EXAM_GROUP[$i];
                        $addscore->ID_EXAM          =   $ID_EXAM[$i];
                        $addscore->ID_USER          =   $user_id;
                        $addscore->ID_CHOICE_ANS    =   $request->{$ID_EXAM[$i]};
                        $addscore->SCORE            =   $score_result[$i];
                        $addscore->save(); 

                }
            }

      
            $info_sum = DB::table('e_learning_score')->where('ID_USER','=',$user_id)
            ->where('ID_EXAM_GROUP','=',$ID_EXAM_GROUP)
            ->where('SCORE','=','True')
            ->where('STATUS_EXAM','=','0')
            ->count();                                                  
            return view('person_elearning.elearning_lesson_pre_exam_result',[
            'info_lesson' => $info_lesson,
            'info_question' => $info_question,
            'info_choice' => $info_choice,
            'info_sum' => $info_sum,
        ]);  
    }

    public function lesson_video($id){
        $info_lesson = DB::table('e_learning_lesson')->where('ID_LESSON','=',$id)->first();

        return view('person_elearning.elearning_lesson_video',[
            'info_lesson' => $info_lesson,
        ]);  
    }

    public function lesson_post_exam(Request $request,$id){
        $info_lesson    = DB::table('e_learning_lesson')->where('ID_LESSON','=',$id)->first();
        $info_question  = DB::table('e_learning_lesson')
        ->leftjoin('e_learning_exam_group','e_learning_exam_group.ID_LESSON','=','e_learning_lesson.ID_LESSON')->where('e_learning_lesson.ID_LESSON','=',$id)
        ->leftjoin('e_learning_exam','e_learning_exam.ID_EXAM_GROUP','=','e_learning_exam_group.ID_EXAM_GROUP')->where('e_learning_exam_group.ACTIVE_EXAM_GROUP','=','True')
        ->leftjoin('e_learning_exam_choice','e_learning_exam_choice.ID_EXAM','=','e_learning_exam.ID_EXAM')->where('e_learning_exam.ACTIVE_EXAM','=','True')
        ->where('e_learning_exam_choice.ACTIVE_EXAM_CHOICE','=','True')
        ->GroupBy('e_learning_exam.QUESTION_EXAM','e_learning_exam.ID_EXAM','e_learning_exam.QUESTION_IMG_EXAMP','e_learning_exam.ID_EXAM_GROUP')
        ->select('e_learning_exam.QUESTION_EXAM','e_learning_exam.ID_EXAM','e_learning_exam.QUESTION_IMG_EXAMP','e_learning_exam.ID_EXAM_GROUP')
        ->get();

        $info_choice  = DB::table('e_learning_lesson')
        ->leftjoin('e_learning_exam_group','e_learning_exam_group.ID_LESSON','=','e_learning_lesson.ID_LESSON')->where('e_learning_lesson.ID_LESSON','=',$id)
        ->leftjoin('e_learning_exam','e_learning_exam.ID_EXAM_GROUP','=','e_learning_exam_group.ID_EXAM_GROUP')->where('e_learning_exam_group.ACTIVE_EXAM_GROUP','=','True')
        ->leftjoin('e_learning_exam_choice','e_learning_exam_choice.ID_EXAM','=','e_learning_exam.ID_EXAM')->where('e_learning_exam.ACTIVE_EXAM','=','True')
        ->where('e_learning_exam_choice.ACTIVE_EXAM_CHOICE','=','True')
        ->select('e_learning_exam_choice.EXAM_CHOICE','e_learning_exam_choice.ID_EXAM','e_learning_exam_choice.ID_EXAM_CHOICE','e_learning_exam_choice.ANSWER_EXAM_CHOICE')
        ->get();
        return view('person_elearning.elearning_lesson_post_exam',[
            'info_lesson' => $info_lesson,
            'info_question' => $info_question,
            'info_choice' => $info_choice,
        ]); 
    }

    public function save_lesson_post_exam(Request $request, $id){
        $info_lesson    = DB::table('e_learning_lesson')->where('ID_LESSON','=',$id)->first();
        $info_question  = DB::table('e_learning_lesson')
        ->leftjoin('e_learning_exam_group','e_learning_exam_group.ID_LESSON','=','e_learning_lesson.ID_LESSON')->where('e_learning_lesson.ID_LESSON','=',$id)
        ->leftjoin('e_learning_exam','e_learning_exam.ID_EXAM_GROUP','=','e_learning_exam_group.ID_EXAM_GROUP')->where('e_learning_exam_group.ACTIVE_EXAM_GROUP','=','True')
        ->leftjoin('e_learning_exam_choice','e_learning_exam_choice.ID_EXAM','=','e_learning_exam.ID_EXAM')->where('e_learning_exam.ACTIVE_EXAM','=','True')
        ->where('e_learning_exam_choice.ACTIVE_EXAM_CHOICE','=','True')
        ->GroupBy('e_learning_exam.QUESTION_EXAM','e_learning_exam.ID_EXAM','e_learning_exam.QUESTION_IMG_EXAMP','e_learning_exam.ID_EXAM_GROUP')
        ->select('e_learning_exam.QUESTION_EXAM','e_learning_exam.ID_EXAM','e_learning_exam.QUESTION_IMG_EXAMP','e_learning_exam.ID_EXAM_GROUP')
        ->get();

        $count_question = count($info_question);

        $info_choice  = DB::table('e_learning_lesson')
        ->leftjoin('e_learning_exam_group','e_learning_exam_group.ID_LESSON','=','e_learning_lesson.ID_LESSON')->where('e_learning_lesson.ID_LESSON','=',$id)
        ->leftjoin('e_learning_exam','e_learning_exam.ID_EXAM_GROUP','=','e_learning_exam_group.ID_EXAM_GROUP')->where('e_learning_exam_group.ACTIVE_EXAM_GROUP','=','True')
        ->leftjoin('e_learning_exam_choice','e_learning_exam_choice.ID_EXAM','=','e_learning_exam.ID_EXAM')->where('e_learning_exam.ACTIVE_EXAM','=','True')
        ->where('e_learning_exam_choice.ACTIVE_EXAM_CHOICE','=','True')
        ->select('e_learning_exam_choice.EXAM_CHOICE','e_learning_exam_choice.ID_EXAM','e_learning_exam_choice.ID_EXAM_CHOICE','e_learning_exam_choice.ANSWER_EXAM_CHOICE')
        ->get();
        
             for($i=0; $i<$count_question; $i++){
                $ID_EXAM[$i] =  $info_question[$i]->ID_EXAM;
                $ID_EXAM_GROUP[$i] =  $info_question[$i]->ID_EXAM_GROUP;                   
             }

             $user_id  =   $request->ID_USER;
             elearning_score::where('ID_USER','=',$user_id)
             ->where('ID_EXAM_GROUP','=',$ID_EXAM_GROUP)
             ->where('STATUS_EXAM','=','1')
             ->delete();

            for($i=0; $i<$count_question; $i++){
                $qq[$i] = $request->{$ID_EXAM[$i]};
                 
                if($qq[$i] == NULL || $qq[$i] == ''){
                    return back()->with('alert', 'กรุณาตอบคำถามให้ครบ!');
                  
               }else{

                   $id_choice[] =  DB::table('e_learning_exam_choice')->where('ID_EXAM_CHOICE', '=' , $qq[$i])
                   ->select('ANSWER_EXAM_CHOICE')
                   ->first();
                   
                   $score_result[$i] = $id_choice[$i]->ANSWER_EXAM_CHOICE;    

                       //insert
                       $addscore = new elearning_score();
                       $addscore->STATUS_EXAM      =   $request->STATUS_EXAM;
                       $addscore->ID_EXAM_GROUP    =   $ID_EXAM_GROUP[$i];
                       $addscore->ID_EXAM          =   $ID_EXAM[$i];
                       $addscore->ID_USER          =   $user_id;
                       $addscore->ID_CHOICE_ANS    =   $request->{$ID_EXAM[$i]};
                       $addscore->SCORE            =   $score_result[$i];
                       $addscore->save(); 

               }
            }

            $info_sum = DB::table('e_learning_score')->where('ID_USER','=',$user_id)
            ->where('ID_EXAM_GROUP','=',$ID_EXAM_GROUP)
            ->where('SCORE','=','True')
            ->where('STATUS_EXAM','=','1')
            ->count();

            $info_sum_pre = DB::table('e_learning_score')->where('ID_USER','=',$user_id)
            ->where('ID_EXAM_GROUP','=',$ID_EXAM_GROUP)
            ->where('SCORE','=','True')
            ->where('STATUS_EXAM','=','0')
            ->count();



            //dd($STATUS_EXAM);
        return view('person_elearning.elearning_lesson_post_exam_result',[
            'info_lesson' => $info_lesson,
            'info_question' => $info_question,
            'info_choice' => $info_choice,
            'info_sum' => $info_sum,
            'info_sum_pre' => $info_sum_pre,
        ]);  
    }
//จัดการหมวดหมู๋บทเรียน
    public function manage_group(){
        $infolessongroup = DB::table('elearning_lesson_group')->get();

        return view('person_elearning.elearning_manage_group',[
            'infolessongroup' => $infolessongroup,
            
        ]);
    }

    public function savelessongroup(Request $request)
    {  
        $addlessongroup = new elearning_lesson_group();
        $addlessongroup->NAME_LESSON_GROUP  = $request->NAME_LESSON_GROUP;
        $addlessongroup->ACTIVE_LESSON_GROUP  = 'True';
        
        if ($request->hasFile('picture')) {
            // $file                = $request->file('picture');
            // $image_resize        = Image::make($file)->fit(200)->encode();
            // $contents            = $file->openFile()->fread($file->getSize());
            // $addlessongroup->IMG_LESSON_GROUP =  $image_resize;

            $file                = $request->file('picture');
            $image_resize = Image::make($file->getRealPath());
            $image_resize->resize(200, 100)->encode(); 
            $addlessongroup->IMG_LESSON_GROUP =  $image_resize;

        }
       
        $addlessongroup->save();  
 
        return redirect()->route('manage_lesson_group')->with('alert', 'เพิ่มข้อมูลสำเร็จเเล้ว!');
    }

    public function detaillessongroup($id){
        $deatail_lessongroup = elearning_lesson_group::where('ID_LESSON_GROU','=',$id)->first();
        $deatail_lesson = elearning_lesson::where('ID_LESSON_GROUP','=',$id)->get();

        return view('person_elearning.elearning_manage_group_detail',[
            'deatail_lessongroup' => $deatail_lessongroup,
            'deatail_lesson' => $deatail_lesson
        ]);
    }

    public function editlessongroup($id){
        $infolessongroup = DB::table('elearning_lesson_group')->where('ID_LESSON_GROU','=',$id)->first();

        return view('person_elearning.elearning_manage_group_edit',[
            'infolessongroup' => $infolessongroup,
        ]);
    }

    public function updatelessongroup(Request $request)
    {
        $id = $request->ID_LESSON_GROU;
        $updatelessongroup = elearning_lesson_group::find($id);

        $updatelessongroup->NAME_LESSON_GROUP = $request->NAME_LESSON_GROUP;
        if ($request->hasFile('picture_img')) {
            $file                = $request->file('picture_img');
            // $image_resize        = Image::make($file)->fit(200)->encode();
            $image_resize = Image::make($file->getRealPath());
            $image_resize->resize(200, 200)->encode(); 
            $contents            = $file->openFile()->fread($file->getSize());
            $updatelessongroup->IMG_LESSON_GROUP =  $image_resize;
        }
       
        $updatelessongroup->save();
        
        return redirect()->route('manage_lesson_group')->with('alert', 'แก้ไขข้อมูลสำเร็จเเล้ว!');
             
    }

    public function destroylessongroup($id) {

        elearning_lesson_group::destroy($id);
        return redirect()->route('manage_lesson_group')->with('alert',"ลบข้อมูลเรียบร้อยเเล้ว!");
    }

    function switchlessongroup(Request $request)
    {
        $id = $request->status_lesson_group;
        $lessonactive = elearning_lesson_group::find($id);
        $lessonactive->ACTIVE_LESSON_GROUP = $request->onoff;
        $lessonactive->save();
    }
//จัดการบทเรียน
    public function manage_lesson(){
        $id_lesson_group = DB::table('elearning_lesson_group')->where('ACTIVE_LESSON_GROUP','=','True')->get();
        $lesson = DB::table('e_learning_lesson')
        ->leftjoin('elearning_lesson_group','elearning_lesson_group.ID_LESSON_GROU','=','e_learning_lesson.ID_LESSON_GROUP')
        ->get();

        $test = DB::table('e_learning_lesson')->get();

//dd($lesson);
        return view('person_elearning.elearning_manage_lesson',[
            'id_lesson_group' => $id_lesson_group,
            'lesson' => $lesson
        ]);   
    }

    public function savelesson(Request $request)
    {  
        
        $addlesson = new elearning_lesson();
        $addlesson->NAME_LESSON         = $request->NAME_LESSON;
        $addlesson->OBJECTIVE_LESSON    = $request->OBJECTIVE_LESSON;
        $addlesson->DETAIL_LESSON       = $request->DETAIL_LESSON;
        $addlesson->TIME_LESSON         = $request->TIME_LESSON;
        $addlesson->LINK_VIDEO_LESSON   = $request->LINK_VIDEO_LESSON;
        $addlesson->ID_LESSON_GROUP     = $request->ID_LESSON_GROUP;
        $addlesson->TEACH_LESSON        = $request->TEACH_LESSON;
        $addlesson->ACTIVE_LESSON       = 'True';
        //ภาพปก
        if ($request->hasFile('picture')) {
            $file                = $request->file('picture');
            // $image_resize        = Image::make($file)->fit(200)->encode();
            $image_resize = Image::make($file->getRealPath());
            $image_resize->resize(200, 100)->encode(); 
            $contents            = $file->openFile()->fread($file->getSize());
            $addlesson->IMG_LESSON =  $image_resize;
        }
        //ภาพคนสอน
        if ($request->hasFile('TEACH_IMG_LESSON')) {
            $file                = $request->file('TEACH_IMG_LESSON');
            $image_resize = Image::make($file->getRealPath());
            $image_resize->resize(200,100,function($constraint){$constraint->aspectRatio(); })->encode();
            $contents            = $file->openFile()->fread($file->getSize());
            $addlesson->TEACH_IMG_LESSON =  $image_resize;
        }
        //pdf
        if($request->hasFile('DOCUMENT_LESSON')){
            $maxid = elearning_lesson::max('ID_LESSON');
            $idfile = $maxid+1;
            // $name_gen_doc = hexdec(uniqid());
            //$newFileName = 'lesson_'.$name_gen_doc.'.'.$request->DOCUMENT_LESSON->extension();
            $newFileName = 'lesson_'.$idfile.'.'.$request->DOCUMENT_LESSON->extension();
            $request->DOCUMENT_LESSON->storeAs('lesson_doc',$newFileName,'public');
            $addlesson->DOCUMENT_LESSON = $newFileName;
        }
        //video
        if($request->hasFile('upvideo_add')){
            $maxid = elearning_lesson::max('ID_LESSON');
            $idfile = $maxid+1;
            // $name_gen_video = hexdec(uniqid());
            // $newFileName = 'video_'.$name_gen_video.'.'.$request->upvideo_add->extension();
            $newFileName = 'video_'.$idfile.'.'.$request->upvideo_add->extension();
            $request->upvideo_add->storeAs('lesson_video',$newFileName,'public');
            $addlesson->VIDEO_LESSON = $newFileName;
        }

        $addlesson->save();  

        return redirect()->route('manage_lesson')->with('alert',"เพิ่มข้อมูลสำเร็จเเล้ว!");
    }

    function switchlesson(Request $request)
    {
        $id = $request->status_lesson;
        $lessonactive = elearning_lesson::find($id);
        $lessonactive->ACTIVE_LESSON = $request->onoff;
        $lessonactive->save();
    }

    public function editlesson($id){
        $info_lesson = elearning_lesson::where('ID_LESSON','=',$id)->first();
        $id_lesson_group = DB::table('elearning_lesson_group')->get();

        return view('person_elearning.elearning_manage_lesson_edit',[
            'id_lesson_group' => $id_lesson_group,
            'info_lesson' => $info_lesson
        ]);
    }

    public function updatelesson(Request $request)
    {
        $id = $request->ID_LESSON;
        $updatelesson = elearning_lesson::find($id);

        $updatelesson->ID_LESSON_GROUP     = $request->ID_LESSON_GROUP;
        $updatelesson->NAME_LESSON         = $request->NAME_LESSON;
        $updatelesson->OBJECTIVE_LESSON    = $request->OBJECTIVE_LESSON;
        $updatelesson->DETAIL_LESSON       = $request->DETAIL_LESSON;
        $updatelesson->TIME_LESSON         = $request->TIME_LESSON;       
        $updatelesson->TEACH_LESSON        = $request->TEACH_LESSON; 

         //ภาพปก
         if ($request->hasFile('picture_edit')) {
            $file                = $request->file('picture_edit');
            // $image_resize        = Image::make($file)->fit(200)->encode();
            $image_resize = Image::make($file->getRealPath());
            $image_resize->resize(200,100)->encode(); 
            $contents            = $file->openFile()->fread($file->getSize());
            $updatelesson->IMG_LESSON =  $image_resize;
        }
        //ภาพคนสอน
        if ($request->hasFile('TEACH_IMG_LESSON_edit')) {
            $file                = $request->file('TEACH_IMG_LESSON_edit');
            $image_resize = Image::make($file->getRealPath());
            $image_resize->resize(200,100,function($constraint){$constraint->aspectRatio(); })->encode();
            $contents            = $file->openFile()->fread($file->getSize());
            $updatelesson->TEACH_IMG_LESSON =  $image_resize;
        }
        //pdf
        if($request->hasFile('DOCUMENT_LESSON')){
            // $name_gen_doc = hexdec(uniqid());
            //$newFileName = 'lesson_'.$name_gen_doc.'.'.$request->DOCUMENT_LESSON->extension();
            $newFileName = 'lesson_'.$id.'.'.$request->DOCUMENT_LESSON->extension();
            $request->DOCUMENT_LESSON->storeAs('lesson_doc',$newFileName,'public');
            $updatelesson->DOCUMENT_LESSON = $newFileName;
        }
        //video
        if($request->hasFile('upvideo_edit')){
            // $name_gen_video = hexdec(uniqid());
            // $newFileName = 'video_'.$name_gen_video.'.'.$request->upvideo_add->extension();
            $newFileName = 'video_'.$id.'.'.$request->upvideo_edit->extension();
            $request->upvideo_edit->storeAs('lesson_video',$newFileName,'public');
            $updatelesson->VIDEO_LESSON = $newFileName;
        }
       
        $updatelesson->save();
        return redirect()->route('manage_lesson')->with('alert',"แก้ไขข้อมูลสำเร็จเเล้ว!");
              
    }
// จัดการชุดคำถาม
    public function manage_exam(){
        $id_lesson = DB::table('e_learning_lesson')->where('ACTIVE_LESSON','=','True')->orderBy('ID_LESSON', 'desc')->get();
        $info_exam = DB::table('e_learning_exam')->where('ACTIVE_EXAM','=','True')->orderBy('ID_EXAM', 'desc')->get();
        
        $data_exam_series = DB::table('e_learning_exam_group')
        ->leftjoin('e_learning_lesson','e_learning_exam_group.ID_LESSON','=','e_learning_lesson.ID_LESSON')
        ->get();

        return view('person_elearning.elearning_manage_exam',[
            'id_lesson' => $id_lesson,
            'info_exam' => $info_exam,
            'data_exam_series' => $data_exam_series,
        ]);   
    }
    
    public function saveexamseries(Request $request)
    {  
        $addexamseries = new elearning_exam_group();
        $addexamseries->ID_LESSON        = $request->ID_LESSON;
        $addexamseries->NAME_EXAM_GROUP  = $request->NAME_EXAM_GROUP;
        $addexamseries->SCORE_CRITERIA   = $request->SCORE_CRITERIA;
        $addexamseries->ACTIVE_EXAM_GROUP   = 'True';
        
        $addexamseries->save();  

        return redirect()->route('manage_exam')->with('alert', 'เพิ่มข้อมูลสำเร็จเเล้ว!');
    }

    public function updateexamseries(Request $request)
    {     
        $id = $request->ID_EXAM_GROUP;

        $updateexamseries = elearning_exam_group::find($id);
        $updateexamseries->ID_LESSON        = $request->ID_LESSON_edit;
        $updateexamseries->NAME_EXAM_GROUP  = $request->NAME_EXAM_GROUP_edit;
        $updateexamseries->SCORE_CRITERIA   = $request->SCORE_CRITERIA_edit;
        
        $updateexamseries->save();  

        return redirect()->route('manage_exam')->with('alert', 'แก้ไขข้อมูลสำเร็จเเล้ว!');
    }

    function switchexamseries(Request $request)
    {
        $id = $request->status_exams_series;
        $lessonactive = elearning_exam_group::find($id);
        $lessonactive->ACTIVE_EXAM_GROUP = $request->onoff;
        $lessonactive->save();
    }
//จัดการคำถาม
    public function savequestion(Request $request, $id )
    {  
        //ส่งกลับตามพาท
        $id = elearning_exam_group::where('ID_EXAM_GROUP','=',$id)->first();

        $addquestion = new elearning_exam();
        $addquestion->ID_EXAM_GROUP        = $request->ID_EXAM_GROUP;
        $addquestion->QUESTION_EXAM        = $request->QUESTION_EXAM;
        $addquestion->ACTIVE_EXAM          = 'True';

        if ($request->hasFile('QUESTION_IMG_EXAMP')) {
            $file                = $request->file('QUESTION_IMG_EXAMP');
            $image_resize = Image::make($file->getRealPath());
            $image_resize->resize(200,200,function($constraint){$constraint->aspectRatio(); })->encode();
            $contents            = $file->openFile()->fread($file->getSize());
            $addquestion->QUESTION_IMG_EXAMP =  $image_resize;

        }
    
        $addquestion->save();  
       
        return redirect()->route('detail_question',[
            'id'=>$id
        ])->with('alert', 'เพิ่มข้อมูลสำเร็จเเล้ว!');
    }

    public function detailquestion($id){
        $id_exam_series = DB::table('e_learning_exam_group')->where('ACTIVE_EXAM_GROUP','=','True')->orderBy('ID_EXAM_GROUP', 'desc')->get();
        $info_exam_series = elearning_exam_group::where('ID_EXAM_GROUP','=',$id)->first();
        $id_exam_series = DB::table('e_learning_exam_group')->where('ACTIVE_EXAM_GROUP','=','True')->get();
        $info_exam = elearning_exam::where('ID_EXAM_GROUP','=',$id)->get();
        
        return view('person_elearning.elearning_manage_exam_detail',[
            'info_exam_series' => $info_exam_series, 
            'info_exam' => $info_exam,
            'id_exam_series' => $id_exam_series,
            'id_exam_series' => $id_exam_series,
        ]);   
    }

    public function editquestion($id){
        $info_exam_series = DB::table('e_learning_exam_group')->where('ACTIVE_EXAM_GROUP','=','True')->get();
        $info_exam = elearning_exam::where('ID_EXAM','=',$id)->first();        


        return view('person_elearning.elearning_manage_exam_edit',[
            'info_exam_series' => $info_exam_series,
            'info_exam' => $info_exam,
        ]);   
    }
    public function updatequestion(Request $request , $id)
    {  
        //ส่งidของชุดคำถามกลับตามพาท
        $question = elearning_exam::where('ID_EXAM','=',$id)->first();
        $id = $question->ID_EXAM_GROUP; 

        //แสดงข้อมูลในหน้า detail
        $info_exam_series = elearning_exam_group::where('ID_EXAM_GROUP','=',$id)->first();
        $id_exam_series = DB::table('e_learning_exam_group')->get();
        $info_exam = elearning_exam::where('ID_EXAM_GROUP','=',$id)->get();


        $id_exam = $request->ID_EXAM; //idคำถามที่จะแก้ไข
        $updatequestion = elearning_exam::find($id_exam);
        $updatequestion->ID_EXAM_GROUP        = $request->ID_EXAM_GROUP;
        $updatequestion->QUESTION_EXAM        = $request->QUESTION_EXAM;

        if ($request->hasFile('QUESTION_IMG_EXAMP')) {
            $file                = $request->file('QUESTION_IMG_EXAMP');
            $image_resize = Image::make($file->getRealPath());
            $image_resize->resize(200,200,function($constraint){$constraint->aspectRatio(); })->encode();
            $contents            = $file->openFile()->fread($file->getSize());
            $updatequestion->QUESTION_IMG_EXAMP =  $image_resize;

        }

        $updatequestion->save();
        
        return redirect()->route('detail_question',[
                    'id' => $id, 
                    'info_exam_series' => $info_exam_series,
                    'info_exam' => $info_exam,
                    'id_exam_series' => $id_exam_series,
                ])->with('alert', 'แก้ไขข้อมูลสำเร็จเเล้ว!');                 
    }


    function switchquestion(Request $request)
    {
        $id = $request->status_exam;
        $lessonactive = elearning_exam::find($id);
        $lessonactive->ACTIVE_EXAM = $request->onoff;
        $lessonactive->save();
    }

//จัดการช้อยส์
    public function savechoice(Request $request ,$id)
    {  
        //ส่งidของชุดคำถามกลับตามพาท
        $id = elearning_exam::where('ID_EXAM','=',$id)->first();
       
       
        $ANSWER = $request->ANSWER;

        $addchoice = new elearning_exam_choice();
        $addchoice->ID_EXAM        = $request->ID_EXAM;
        $addchoice->EXAM_CHOICE    = $request->EXAM_CHOICE;
        $addchoice->ACTIVE_EXAM_CHOICE  = 'True';
        
        if(!empty($ANSWER)){
            if($ANSWER == 'True'){
                $addchoice->ANSWER_EXAM_CHOICE    = 'True' ;
            }else if($ANSWER == 'False'){
                $addchoice->ANSWER_EXAM_CHOICE    = 'False' ;
            }
        }      
        $addchoice->save();  

        return redirect()->route('detail_choice',[
            'id' => $id,
        ])->with('alert', 'เพิ่มข้อมูลสำเร็จเเล้ว!');
    }

    function switchchoice(Request $request)
    {
        $id = $request->status_choice;
        $choiceactive = elearning_exam_choice::find($id);
        $choiceactive->ACTIVE_EXAM_CHOICE = $request->onoff;
        $choiceactive->save();
    }

    public function detailchoice($id){

        $info_exam = elearning_exam::where('ID_EXAM','=',$id)->where('ACTIVE_EXAM','=','True')->first();
        $info_exam_choice = elearning_exam_choice::where('ID_EXAM','=',$id)->get();
        $id_exam = DB::table('e_learning_exam')->where('ACTIVE_EXAM','=','True')->where('ACTIVE_EXAM','=','True')->get();
        $id_exam_group = $info_exam->ID_EXAM_GROUP;
      
        
        return view('person_elearning.elearning_manage_exam_choice_detail',[
            'info_exam' => $info_exam,
            'info_exam_choice' => $info_exam_choice,
            'id_exam' => $id_exam,
            'id_exam_group' => $id_exam_group,
        ]);   
    }

    public function updatechoice(Request $request, $id)
    {  
        //ส่งidของชุดคำถามกลับตามพาท
        $choice = elearning_exam_choice::where('ID_EXAM','=',$id)->first();
        $id = $choice->ID_EXAM; 
        
        //id edit
        $id_choice = $request->ID_EXAM_CHOICE;
        $ANSWER = $request->ANSWER_edit;
        
        $updatechice = elearning_exam_choice::find($id_choice);
        $updatechice->ID_EXAM        = $request->ID_EXAM_edit;
        $updatechice->EXAM_CHOICE   = $request->EXAM_CHOICE_edit;
        if(!empty($ANSWER)){
            if($ANSWER == 'True'){
                $updatechice->ANSWER_EXAM_CHOICE    = 'True' ;
            }else if($ANSWER == 'False'){
                $updatechice->ANSWER_EXAM_CHOICE    = 'False' ;
            }
        }
        $updatechice->save();  

        return redirect()->route('detail_choice',[
            'id' => $id,
        ])->with('alert', 'เเก้ไขข้อมูลสำเร็จเเล้ว!');
    }

    public function information_report(Request $request){
        //dashboard
        $count_lesson_group = DB::table('elearning_lesson_group')->count();
        $count_lesson = DB::table('e_learning_lesson')->count();
        $count = DB::table('e_learning_score')
        ->where('STATUS_EXAM','=','1')
        ->groupBy('ID_EXAM_GROUP')
        ->select('ID_EXAM_GROUP')
        ->get();
        $count_std = $count->count();

        $id_lesson_group = DB::table('elearning_lesson_group')->get();

        //score
        $info_sum_score = DB::table('e_learning_score') 
        ->select(DB::raw('count(*) as score, ID_USER,e_learning_score.ID_EXAM_GROUP'),'users.name','e_learning_exam_group.NAME_EXAM_GROUP','e_learning_lesson.NAME_LESSON')
        ->leftJoin('users','users.id','=','e_learning_score.ID_USER')
        ->leftJoin('e_learning_exam_group','e_learning_exam_group.ID_EXAM_GROUP','=','e_learning_score.ID_EXAM_GROUP')
        ->leftJoin('e_learning_lesson','e_learning_lesson.ID_LESSON','=','e_learning_exam_group.ID_LESSON')
        ->groupBy('ID_USER','e_learning_score.ID_EXAM_GROUP','users.name','e_learning_exam_group.NAME_EXAM_GROUP','e_learning_lesson.NAME_LESSON')
        ->get();

        $i=0;
        $j=0;
        foreach($info_sum_score as $row){
            $data [$i] = DB::table('e_learning_score')
            ->where('SCORE','=','True')
            ->where('STATUS_EXAM','=','0')
            ->where('ID_EXAM_GROUP','=',$row->ID_EXAM_GROUP)
            ->where('ID_USER','=',$row->ID_USER)
            ->count();
            $i++;
        }

        foreach($info_sum_score as $row){
            $data2 [$j] = DB::table('e_learning_score')
            ->where('SCORE','=','True')
            ->where('STATUS_EXAM','=','1')
            ->where('ID_EXAM_GROUP','=',$row->ID_EXAM_GROUP)
            ->where('ID_USER','=',$row->ID_USER)
            ->count();
            $j++;
        }

     //chart
    $count_chart = DB::table('elearning_lesson_group')
    ->leftJoin('e_learning_lesson','e_learning_lesson.ID_LESSON_GROUP','=','elearning_lesson_group.ID_LESSON_GROU')
    ->groupBy('elearning_lesson_group.ID_LESSON_GROU','elearning_lesson_group.NAME_LESSON_GROUP')
    ->select('elearning_lesson_group.ID_LESSON_GROU','elearning_lesson_group.NAME_LESSON_GROUP')
    ->limit(5)
    ->get();
     
     $c = 0;
     foreach($count_chart as $row){
         $name[$c] = $row->NAME_LESSON_GROUP;
         $c++;
     }
     $d = 0;
     foreach($count_chart as $row){
         $data_count[$d] = DB::table('e_learning_lesson')
         ->where('ID_LESSON_GROUP','=',$row->ID_LESSON_GROU)
         ->count();
         $d++;
     }


     $sum_chart = DB::table('e_learning_score')
     ->leftJoin('e_learning_exam_group','e_learning_exam_group.ID_EXAM_GROUP','=','e_learning_score.ID_EXAM_GROUP')
     ->leftJoin('e_learning_lesson','e_learning_lesson.ID_LESSON','=','e_learning_exam_group.ID_LESSON')
     ->leftJoin('elearning_lesson_group','elearning_lesson_group.ID_LESSON_GROU','=','e_learning_lesson.ID_LESSON_GROUP')
     ->where('e_learning_score.STATUS_EXAM','=','1')
     ->groupBy('elearning_lesson_group.ID_LESSON_GROU','e_learning_score.ID_USER')
     ->select('elearning_lesson_group.ID_LESSON_GROU', DB::raw('count(*) as total') )
     ->get();

     $sum_chart1 = DB::table('e_learning_score')
     ->leftJoin('e_learning_exam_group','e_learning_exam_group.ID_EXAM_GROUP','=','e_learning_score.ID_EXAM_GROUP')
     ->leftJoin('e_learning_lesson','e_learning_lesson.ID_LESSON','=','e_learning_exam_group.ID_LESSON')
     ->leftJoin('elearning_lesson_group','elearning_lesson_group.ID_LESSON_GROU','=','e_learning_lesson.ID_LESSON_GROUP')
     ->where('e_learning_score.STATUS_EXAM','=','1')
     ->where('elearning_lesson_group.ID_LESSON_GROU','=','1')
     ->get();

 //check
        if(empty($name) && empty($data)){
            return view('person_elearning.elearning_information_report',[
                'count_lesson_group' => $count_lesson_group,
                'count_lesson' => $count_lesson,
                'id_lesson_group' => $id_lesson_group,
                'count_std' => $count_std,
                'info_sum_score' => $info_sum_score,
                'count_chart' => $count_chart,
            ]);
        }

        if(empty($name)){
            return view('person_elearning.elearning_information_report',[
                'count_lesson_group' => $count_lesson_group,
                'count_lesson' => $count_lesson,
                'id_lesson_group' => $id_lesson_group,
                'count_std' => $count_std,
                'data' => $data,
                'data2' => $data2,
                'info_sum_score' => $info_sum_score,
                'count_chart' => $count_chart,
            ]);
        }

        if(empty($data)){
            return view('person_elearning.elearning_information_report',[
                'count_lesson_group' => $count_lesson_group,
                'count_lesson' => $count_lesson,
                'id_lesson_group' => $id_lesson_group,
                'count_std' => $count_std,
                'info_sum_score' => $info_sum_score,
                'count_chart' => $count_chart,
                'name' => $name ,
                'data_count' => $data_count 
            ]);   
        }

        return view('person_elearning.elearning_information_report',[
            'count_lesson_group' => $count_lesson_group,
            'count_lesson' => $count_lesson,
            'id_lesson_group' => $id_lesson_group,
            'count_std' => $count_std,
            'data' => $data,
            'data2' => $data2,
            'info_sum_score' => $info_sum_score,
            'count_chart' => $count_chart,
            'name' => $name  ,
            'data_count' => $data_count   
        ]);
    }
    public function information_report_search(Request $request){

        $id_lesson_group_search = $request->ID_LESSON_GROU; //id หมวดหมู๋บทเรียน

        //dashboard
        $count_lesson_group = DB::table('elearning_lesson_group')->count();
        $count_lesson = DB::table('e_learning_lesson')->count();
        $count = DB::table('e_learning_score')
        ->where('STATUS_EXAM','=','1')
        ->groupBy('ID_EXAM_GROUP')
        ->select('ID_EXAM_GROUP')
        ->get();
        $count_std = $count->count();

        $id_lesson_group = DB::table('elearning_lesson_group')->get();

        //score
        if($id_lesson_group_search == ''){
            $info_sum_score = DB::table('e_learning_score') 
            ->select(DB::raw('count(*) as score, ID_USER,e_learning_score.ID_EXAM_GROUP'),'users.name','e_learning_exam_group.NAME_EXAM_GROUP','e_learning_lesson.NAME_LESSON')
            ->leftJoin('users','users.id','=','e_learning_score.ID_USER')
            ->leftJoin('e_learning_exam_group','e_learning_exam_group.ID_EXAM_GROUP','=','e_learning_score.ID_EXAM_GROUP')
            ->leftJoin('e_learning_lesson','e_learning_lesson.ID_LESSON','=','e_learning_exam_group.ID_LESSON')
            ->leftJoin('elearning_lesson_group','elearning_lesson_group.ID_LESSON_GROU','=','e_learning_lesson.ID_LESSON_GROUP')
            ->groupBy('ID_USER','e_learning_score.ID_EXAM_GROUP','users.name','e_learning_exam_group.NAME_EXAM_GROUP','e_learning_lesson.NAME_LESSON')
            ->get();

        }else{
            $info_sum_score = DB::table('e_learning_score') 
            ->select(DB::raw('count(*) as score, ID_USER,e_learning_score.ID_EXAM_GROUP'),'users.name','e_learning_exam_group.NAME_EXAM_GROUP','e_learning_lesson.NAME_LESSON')
            ->leftJoin('users','users.id','=','e_learning_score.ID_USER')
            ->leftJoin('e_learning_exam_group','e_learning_exam_group.ID_EXAM_GROUP','=','e_learning_score.ID_EXAM_GROUP')
            ->leftJoin('e_learning_lesson','e_learning_lesson.ID_LESSON','=','e_learning_exam_group.ID_LESSON')
            ->leftJoin('elearning_lesson_group','elearning_lesson_group.ID_LESSON_GROU','=','e_learning_lesson.ID_LESSON_GROUP')
            ->where('elearning_lesson_group.ID_LESSON_GROU','=',$id_lesson_group_search)
            ->groupBy('ID_USER','e_learning_score.ID_EXAM_GROUP','users.name','e_learning_exam_group.NAME_EXAM_GROUP','e_learning_lesson.NAME_LESSON')
            ->get();

        }

        $i=0;
        $j=0;
            foreach($info_sum_score as $row){
                $data [$i] = DB::table('e_learning_score')
                ->where('SCORE','=','True')
                ->where('STATUS_EXAM','=','0')
                ->where('ID_EXAM_GROUP','=',$row->ID_EXAM_GROUP)
                ->where('ID_USER','=',$row->ID_USER)
                ->count();
                $i++;
            }
    
            foreach($info_sum_score as $row){
                $data2 [$j] = DB::table('e_learning_score')
                ->where('SCORE','=','True')
                ->where('STATUS_EXAM','=','1')
                ->where('ID_EXAM_GROUP','=',$row->ID_EXAM_GROUP)
                ->where('ID_USER','=',$row->ID_USER)
                ->count();
                $j++;
         
           }  
      //chart
      $count_chart = DB::table('elearning_lesson_group')
      ->leftJoin('e_learning_lesson','e_learning_lesson.ID_LESSON_GROUP','=','elearning_lesson_group.ID_LESSON_GROU')
      ->groupBy('elearning_lesson_group.ID_LESSON_GROU','elearning_lesson_group.NAME_LESSON_GROUP')
      ->select('elearning_lesson_group.ID_LESSON_GROU','elearning_lesson_group.NAME_LESSON_GROUP')
      ->limit(5)
      ->get();
       
       $c = 0;
       foreach($count_chart as $row){
           $name[$c] = $row->NAME_LESSON_GROUP;
           $c++;
       }
       $d = 0;
       foreach($count_chart as $row){
           $data_count[$d] = DB::table('e_learning_lesson')
           ->where('ID_LESSON_GROUP','=',$row->ID_LESSON_GROU)
           ->count();
           $d++;
       }

       //check
       if(empty($name) && empty($data) && empty($data_count)){
            return view('person_elearning.elearning_information_report',[
                'count_lesson_group' => $count_lesson_group,
                'count_lesson' => $count_lesson,
                'id_lesson_group' => $id_lesson_group,
                'count_std' => $count_std,
                'info_sum_score' => $info_sum_score,
                'id_lesson_group_search'=>$id_lesson_group_search,
                'count_chart'=>$count_chart,
                ]);
        }

        if(empty($name)){
            return view('person_elearning.elearning_information_report',[
                'count_lesson_group' => $count_lesson_group,
                'count_lesson' => $count_lesson,
                'id_lesson_group' => $id_lesson_group,
                'count_std' => $count_std,
                'info_sum_score' => $info_sum_score,
                'count_chart' => $count_chart,
                'data' => $data,
                'data2' => $data2,
                'data_count'=>$data_count,
                'id_lesson_group_search'=>$id_lesson_group_search,
            ]);
        }

        if(empty($data)){
            return view('person_elearning.elearning_information_report',[
                'count_lesson_group' => $count_lesson_group,
                'count_lesson' => $count_lesson,
                'id_lesson_group' => $id_lesson_group,
                'count_std' => $count_std,
                'info_sum_score' => $info_sum_score,
                'count_chart' => $count_chart,
                'name'=>$name,
                'data_count'=>$data_count,
                'id_lesson_group_search'=>$id_lesson_group_search,
            ]);
        }

        return view('person_elearning.elearning_information_report',[
            'count_lesson_group' => $count_lesson_group,
            'count_lesson' => $count_lesson,
            'id_lesson_group' => $id_lesson_group,
            'count_std' => $count_std,
            'info_sum_score' => $info_sum_score,
            'id_lesson_group_search'=>$id_lesson_group_search,
            'data' => $data,
            'data2' => $data2,
            'name'=>$name,
            'data_count'=>$data_count,
            'count_chart'=>$count_chart,
        ]);   
    }



    
}