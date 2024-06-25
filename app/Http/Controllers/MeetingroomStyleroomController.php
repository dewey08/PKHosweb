<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Models\Meetingroomstyleroom;
use App\Models\Meetingroom_styleroom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MeetingroomStyleroomController extends Controller
{
    public function mainStyleroom(){
        $style_rooms = DB::table('meetingroom_stylerooms')->get();
        return view('admin_meeting.style-room.main',[
            'style_rooms' => $style_rooms
        ]);
    }

    public function setupStyleRoom(Request $request){
        $id = $request->room;
        $budgetactive = Meetingroom_styleroom::find($id);
        $budgetactive->STYLEROOM_STATUS = $request->onoff;
        $budgetactive->save();
    }

    public function addView(){
        return view('admin_meeting.style-room.add-view');
    }

    public function addConfig(Request $request){


        if($request->hasFile('imgroom')){
            $file = $request->file('imgroom');
            $imgRoom = $file->openFile()->fread($file->getSize());
            
        }else{
            $imgRoom = null;
        }

        $insertSql = Meetingroom_styleroom::create([
            'STYLEROOM_NAME' => $request->nameRoom,
            'STYLEROOM_IMAGE' => $imgRoom,
            'STYLEROOM_DETAIL' => $request->detailRoom,
            'STYLEROOM_STATUS' => $request->statusRoom
        ]);



        return redirect()->route('admin_meeting.style-room.main');
    }

    public function editView($id){
        $style_room = DB::table('meetingroom_stylerooms')->where('id', $id)->first();
        return view('admin_meeting.style-room.edit-view', [
            'style_room' => $style_room
        ]);
    }

    public function editConfig(Request $request){

        if($request->imgRoom != null){
            if($request->hasFile('imgRoom')){
                $file = $request->file('imgRoom');
                $img_room = $file->openFile()->fread($file->getSize());
                
            }else{
                $img_room = null;
            }
            $updateSql = DB::table('meetingroom_stylerooms')->where('id', $request->idRoom)->update([
                'STYLEROOM_NAME' => $request->nameRoom,
                'STYLEROOM_IMAGE' => $img_room,
                'STYLEROOM_DETAIL' => $request->detailRoom,
                'STYLEROOM_STATUS' => $request->statusRoom
            ]);
            return redirect()->route('admin_meeting.style-room.main');
        }else if($request->imgRoom == null){
            $updateSql = DB::table('meetingroom_stylerooms')->where('id', $request->idRoom)->update([
                'STYLEROOM_NAME' => $request->nameRoom,
                'STYLEROOM_DETAIL' => $request->detailRoom,
                'STYLEROOM_STATUS' => $request->statusRoom
            ]);
            return redirect()->route('admin_meeting.style-room.main');
        }
        else{
            return redirect()->route('admin_meeting.style-room.main');
        }       
    }

    public function deleteConfig($id){
        $deleteSql = DB::table('meetingroom_stylerooms')->where('id', '=' , $id)->delete();
        return redirect()->route('admin_meeting.style-room.main');
    }

    public function modalSelectStyleRoom(){
        $style_rooms = DB::table('meetingroom_stylerooms')->where('STYLEROOM_STATUS', '=', 'true')->get(); 
        return view('admin_meeting.style-room.modal-select-style-room',[
            'style_rooms' => $style_rooms
        ]);
    }

    public function selectStyleRoomAdd(Request $request){


        $slectStyle = Meetingroom_styleroom::where('id', '=' ,$request->id)->first();

        $output = '
        <input type="hidden" name="STYLEROOM_ID" id="STYLEROOM_ID" value="'.$slectStyle->id.'" style=" font-family: \'Kanit\', sans-serif;" readonly>
        <div class="col-lg-12">
            <div class="row">
                <div class="col-md-7">
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for=""> รูปแบบห้องประชุม :</label>
                            </div>
                        </div>
                        <div class="col-sm-5" style="margin-left:30px;">
                        <input type="text" class="form-control input-lg" name="STYLEROOM_NAME" id="STYLEROOM_NAME" value="'.$slectStyle->STYLEROOM_NAME.'" style="font-size:13px; font-family: \'Kanit\', sans-serif;" readonly>
                        </div>
                        <div class="col-sm" align="center">
                            <button type="button" class="btn btn-hero-sm btn-hero-info" data-toggle="modal" data-target=".add" style="font-size: 13px; font-family: \'Kanit\', sans-serif;">เลือกรูปแบบ</button>
                        </div>
                    </div>
                    <div class="row" style="margin-top:30px;">
                        <div class="col-sm-3">
                            <label for=""> รายละเอียด :</label>
                        </div>
                        <div class="col-sm-8" style="margin-left:30px;">
                        <textarea name="STYLEROOM_DETAIL" id="STYLEROOM_DETAIL" class="form-control" cols="100%" rows="5"></textarea>
                        </div>
                    </div>
                </div>
                <div class="col-md-5" align="left">
                    <img id="image_upload_preview" name="image_upload_preview"
                    src="data:image/png;base64,'.chunk_split(base64_encode($slectStyle->STYLEROOM_IMAGE)) .'"
                    height="180px;" width="180px;">
                </div>
            </div>
        </div>
        ';

        echo $output;
    }

    public function selectStyleRoomEdit(Request $request){

        $slectStyle = Meetingroom_styleroom::where('id', '=' ,$request->id)->first();

        $output = '
        <input type="hidden" name="STYLEROOM_ID" id="STYLEROOM_ID" value="'.$slectStyle->id.'" style=" font-family: \'Kanit\', sans-serif;" readonly>
        <div class="col-lg-12">
            <div class="row">
                <div class="col-md-7">
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for=""> รูปแบบห้องประชุม :</label>
                            </div>
                        </div>
                        <div class="col-sm-5" style="margin-left:30px;">
                        <input type="text" class="form-control input-lg" name="STYLEROOM_NAME" id="STYLEROOM_NAME" value="'.$slectStyle->STYLEROOM_NAME.'" style="font-size:13px; font-family: \'Kanit\', sans-serif;" readonly>
                        </div>
                        <div class="col-sm" align="center">
                            <button type="button" class="btn btn-hero-sm btn-hero-info" data-toggle="modal" data-target=".add" >เลือกรูปแบบ</button>
                        </div>
                    </div>
                    <div class="row" style="margin-top:30px;">
                        <div class="col-sm-3">
                            <label for=""> รายละเอียด :</label>
                        </div>
                        <div class="col-sm-8" style="margin-left:30px;">
                        <textarea name="STYLEROOM_DETAIL" id="STYLEROOM_DETAIL" class="form-control" cols="100%" rows="5"></textarea>
                        </div>
                    </div>
                </div>
                <div class="col-md-5" align="left">
                    <img id="image_upload_preview" name="image_upload_preview"
                    src="data:image/png;base64,'.chunk_split(base64_encode($slectStyle->STYLEROOM_IMAGE)) .'"
                    height="180px;" width="180px;">
                </div>
            </div>
        </div>
        ';

        echo $output;

    }


}
