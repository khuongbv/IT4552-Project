<?php

namespace App\Http\Controllers\Admin;
use App\Models\Role;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Gate;
use Illuminate\Support\Facades\Auth;
use App\Models\Profile;
use Illuminate\Support\Facades\DB;
use App\Models\RoomRegistration;


class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Gate::denies('admin')) {
            return back();
        }
        $profiles = Profile::all();
        $users = User::all();
        return view('pages.admin.index')->with([
            'users' => $users,
            'profiles' => $profiles
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    //    
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // 
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show($mssv)
    {
        $vien = DB::table('profiles')->join('viens', 'viens.id', '=', 'profiles.vien_id');
        $khoa = DB::table('profiles')->join('khoas', 'khoas.id', '=', 'profiles.khoa_id');
        $gt = DB::table('profiles')->join('gts', 'gts.id', '=', 'profiles.gt_id');
        $ttsv = Profile::where('mssv', $mssv)->first();
        return view('pages.admin.detail')->with([
            'ttsv' => $ttsv,
            'vien' => $vien->value('viens.name'),
            'khoa' => $khoa->value('khoas.name'),
            'gt' => $gt->value('gts.name'),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        if (Gate::denies('admin')) {
            return back();
        }
        $roles = Role::all();
        return view('pages.admin.edit')->with([
            'user' => $user,
            'roles' => $roles,
        ]);
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        if (Gate::denies('admin')) {
            return back();
        }
        $room_info = RoomRegistration::where('name', $user->name)->first();
        $ttsv = Profile::where('id', $user->id - 1)->first();
        $room_info->name = $request->name;
        $ttsv->name = $request->name;
        $ttsv->email = $request->email;
        $user->name = $request->name;
        $user->email = $request->email;
        $room_info->save();
        $ttsv->save();
        $user->save() ?  
            $request->session()->flash('success', 'User updated successfully') : 
            $request->session()->flash('error', 'User updated failed');
        return redirect()->route('admin.users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, User $user)
    {
        if (Gate::denies('admin')) {
            return back();
        }
        $old_name = $user->name;
        $ttsv = Profile::where('id', $user->id - 1)->first();
        $ttsv->delete();
        $user->roles()->detach();
        $user->delete() ?  
            $request->session()->flash('success',"Xóa $old_name thành công") : 
            $request->session()->flash('error', "Xóa $old_name thất bại");

        return redirect()->route('admin.users.index');
    }
}
