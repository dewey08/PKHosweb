<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Position;

class SetuppositionController extends Controller
{
    public function infoposition()
    {

        $infoposition = Position::orderBy('HR_POSITION_ID', 'asc')
                                     ->get();

       //dd($infoeducation);
        return view('admin.setupposition',[
            'infopositions' => $infoposition
        ]);
    }
    public function search(Request $request)
        {
            $search = $request->get('search');
            $postsearch = DB::table('hrd_position')
            ->where(function($q) use ($search){
                $q->where('HR_POSITION_ID','like','%'.$search.'%');
                $q->orwhere('HR_POSITION_NAME','like','%'.$search.'%');
            })
            ->orderby('HR_POSITION_ID','desc')
            ->get();

            $infoposition = DB::table('hrd_position')->get();
           // dd($search);
            return view('admin.setupposition',[
                'postsearchs' => $postsearch,
                'infopositions' => $infoposition
            ]);

        }
    function switchposition(Request $request)
    {
        //return $request->all();
        $id = $request->position;
        $positionactive = Position::find($id);
        $positionactive->HR_POSITION_CHECK_HOLIDAY = $request->onoff;
        $positionactive->save();
    }

    public function create(Request $request)
    {
       //dd($infoeducation);
        return view('admin.setupposition_add');

    }

    public function save(Request $request)
    {

            $addposition = new Position();
            $addposition->HR_POSITION_ID = $request->HR_POSITION_ID;
            $addposition->HR_POSITION_NAME = $request->HR_POSITION_NAME;
            $addposition->HR_POSITION_CHECK_HOLIDAY = $request->HR_POSITION_CHECK_HOLIDAY;

            $addposition->save();


            return redirect()->route('setup.indexposition');
    }




public function edit(Request $request,$id)
{
//return $request->all();

$id_in= $request->id;

$infoposition = Position::where('HR_POSITION_ID','=',$id_in)
->first();


return view('admin.setupposition_edit',[
'infoposition' => $infoposition
]);
}

public function update(Request $request)
{
    $id = $request->HR_POSITION_ID;

    $updateposition = Position::find($id);
    $updateposition->HR_POSITION_NAME = $request->HR_POSITION_NAME;

    $updateposition->save();


        return redirect()->route('setup.indexposition');
}


public function destroy($id) {

    Position::destroy($id);
    //return redirect()->action('ChangenameController@infouserchangename');
    return redirect()->route('setup.indexposition');
}



}
