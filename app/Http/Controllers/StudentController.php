<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Area;
use App\Models\Room;
use App\Models\RoomRegistration;
use App\Models\Profile;
use App\User;
use Validator;
use Carbon\Carbon;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\MessageBag;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $areas = DB::select('select * from areas');
        $ttsv = Profile::where('email', Auth::user()->email)->first();
        $request->session()->put('ttsv', $ttsv);
        return view('students.area_info', [
            'areas' => $areas
        ]);
    }

    public function viewRoom($id)
    {
        $room = DB::table('rooms')->where('area_id', '=', $id)->paginate(10);
        return view('students.area_info', ['room' => $room]);
    }

    public function registRoom($id)
    {
        $student_info = DB::table('profiles')->where('email', Auth::user()->email)->first();
        $room = DB::table('rooms')->where('id', $id)->first();
        $area_id = $room->area_id;
        $area_cost = DB::table('areas')->where('id',$area_id)->value('area_cost');
        $mssv = '';
        !empty($student_info->mssv) ? $mssv = $student_info->mssv : '';
        $std_gender_id = '';
        !empty($student_info->gt_id) ? $std_gender_id = $student_info->gt_id : '';
        if ($std_gender_id == 1) {
            $std_gender = 'nam';
        } elseif ($std_gender_id == 0) {
            $std_gender = 'nu';
        } else {
            $std_gender = '';
        }
        $current_numbers = $room->current_numbers;
        $max_numbers = $room->max_numbers;
        $gender = $room->gender;
        $count = DB::table('room_registrations')->where([
            ['mssv',$mssv],
            ['status','!=','Hủy']
        ])->count();
        $count1 = DB::table('room_registrations')->where([
            ['mssv',$mssv],
            ['status','=','Hủy']
        ])->count();
        if($std_gender=="" || $mssv == ""){
            return redirect()->back()->with(['flag'=>'danger','message'=>'Vui lòng cập nhật thông tin cá nhân  ']);
        }
        else{
            if($count!=0){
                return redirect()->back()->with(['flag'=>'danger','message'=>'Sinh viên đã đăng ký ở năm nay']);
            }
            elseif($std_gender!=$gender){
                return redirect()->back()->with(['flag'=>'danger','message'=>'Giới tính không đúng']);
            }
            elseif ($current_numbers>=$max_numbers) {
                return redirect()->back()->with(['flag'=>'danger','message'=>'Phòng đã đầy']);
            }
            else{
                if($count1==0){
                    $created_at = Carbon::today()->toDateString();
                    DB::table('room_registrations')->insert(['room_id'=>$id,'mssv'=>$mssv,'name'=>Auth::user()->name, 'status'=>'Đang chờ','cost'=>$area_cost*(13-date('m')), 'created_at'=>$created_at]);
                    $current_numbers=$current_numbers + 1;
                    DB::table('rooms')->where('id',$id)->update(['current_numbers'=>$current_numbers]);
                    return redirect('student_xemdk');
                }
                else{
                    DB::table('room_registrations')->where([
                        ['mssv',$mssv]
                    ])->update(['status'=>'Đang chờ']);
                    $current_numbers = $current_numbers + 1;
                    DB::table('rooms')->where('id',$id)->update(['current_numbers'=>$current_numbers]);
                    return redirect('student_xemdk');
                }
            }
        }   

    }

    public function student_xemdk(){
        $mssv = Profile::where('email',Auth::user()->email)->value('mssv');
        $lsdk = RoomRegistration::where('mssv','=',$mssv)->get();
        $ttphong = Room::all();
        $ttkhu = Area::all();
        return view('students.student_xemdk',['lsdk'=>$lsdk,'ttphong'=>$ttphong,'ttkhu'=>$ttkhu]);
    }

    public function view_managers() {
        return view('students.view_managers');
    }
    
    public function get_student_huydk($mssv)
    {
        $updated_at = Carbon::today()->toDateString();
        $room_id = RoomRegistration::where([
            ['mssv',$mssv],
            ['status', 'Đang chờ']
        ])->value('room_id');
        $status = RoomRegistration::where([
            ['mssv',$mssv]
        ])->value('status');
        $current_numbers = Room::where('id',$room_id)->value('current_numbers');
        $current_numbers = $current_numbers - 1;
        if ($status == 'Đang chờ') {
            RoomRegistration::where([ ['mssv',$mssv] ])->update(['status'=>"Hủy"]);
            Room::where('id',$room_id)->update(['current_numbers'=>$current_numbers]);
            return redirect()->back();
        } else {
            return redirect()->back();
        }
        
    }
}
