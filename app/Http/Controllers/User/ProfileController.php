<?php

namespace App\Http\Controllers\User;
use App\Models\Profile;
use App\Models\Vien;
use App\Models\Khoa;
use App\Models\Gt;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\ValidateProfile;



class ProfileController extends Controller
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
        $vien = DB::table('profiles')->join('viens', 'viens.id', '=', 'profiles.vien_id');
        $khoa = DB::table('profiles')->join('khoas', 'khoas.id', '=', 'profiles.khoa_id');
        $gt = DB::table('profiles')->join('gts', 'gts.id', '=', 'profiles.gt_id');
        $ttsv = Profile::where('email', Auth::user()->email)->first();
        return view('users.profile.index', [
            'ttsv' => $ttsv,
            'vien' => $vien->value('viens.name'),
            'khoa' => $khoa->value('khoas.name'),
            'gt' => $gt->value('gts.name'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $viens = Vien::all();
        $khoas = Khoa::all();
        $gts = Gt::all();
        return view('users.profile.create')->with([
            'viens' => $viens,
            'khoas' => $khoas,
            'gts' => $gts
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ValidateProfile $request)
    {
        $image = $request->file('image');

        $new_name = rand() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('uploads'), $new_name);
        $form_data = [
            'name'  => Auth::user()->name,
            'mssv' => $request->mssv,
            'sdt' => $request->sdt,
            'khoa_id' => $request->khoa_id,
            'gt_id' => $request->gt_id,
            'vien_id' => $request->vien_id,
            'image' => $new_name,
            'qq' => $request->qq,
            'email' => Auth::user()->email,
        ];
        Profile::create($form_data);
        return redirect()->route('user.profile.index')->with('success', 'Thêm dữ liệu thành công');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Profile $profile)
    {
        $viens = Vien::all();
        $khoas = Khoa::all();
        $gts = Gt::all();
        return view('users.profile.edit')->with([
            'profile' => $profile,
            'viens' => $viens,
            'khoas' => $khoas,
            'gts' => $gts
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Profile $profile)
    {
        $image_name = $request->hidden_image;
        $image = $request->file('image');
        if($image != '')
        {
            unlink(public_path('uploads') . '/' . $image_name);
            $request->validate([
                'mssv'  =>  'required|numeric|min:8',
                'sdt' =>  'required|numeric|min:10',
                'qq' =>  'required|string',
                'khoa_id' => 'required',
                'gt_id' => 'required',
                'vien_id' => 'required',
            ]);

            $image_name = rand() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads'), $image_name);
        }
        else
        {
            $request->validate([
                'mssv'  =>  'required|min:8',
                'sdt' =>  'required|min:10',
                'qq' =>  'required|string',
                'khoa_id' => 'required',
                'gt_id' => 'required',
                'vien_id' => 'required',
            ]);
        }

        $form_data = [
            'mssv' => $request->mssv,
            'sdt' => $request->sdt,
            'khoa_id' => $request->khoa_id,
            'gt_id' => $request->gt_id,
            'vien_id' => $request->vien_id,
            'image' => $image_name,
            'qq' => $request->qq,
        ];
        Profile::whereId($profile->id)->update($form_data) ?  
            $request->session()->flash('success', 'Cập nhật thành công') : 
            $request->session()->flash('error', 'Cập nhật thất bại');
        return redirect()->route('user.profile.index');
    }

}
