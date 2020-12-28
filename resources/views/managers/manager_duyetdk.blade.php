@extends('layouts.app')
@section('content')
    <div class="content">
        @if(Auth::user()->hasRole('admin'))
        <div class="container">
            <h3 style="">
                <i class="fa fa-arrow-circle-o-right"></i>
                    Danh sách sinh viên đăng ký phòng        
            </h3>
            @if(count($list)==0)
                <h4 class="thongbaoNull">Danh sách sinh viên đăng ký trống</h4>
            @else
            <table class="table table-bordered table-striped datatable" id="table_export">
                <tr>
                    <th>Mssv</th>
                    <th>Họ tên</th>
                    <th>Phòng</th>
                    <th>Trạng thái đăng ký</th>
                    <th>Ngày đăng ký</th>
                    <th>Xem thông tin</th>
                    <th>Chấp nhận</th>
                    <th>Hủy bỏ</th>
                </tr>
                @foreach($list as $l)
                <tr>
                    <td>{{$l->mssv}}</td>
                    <td>{{$l->name}}</td>
                    <td>
                        @foreach($ttphong as $t)
                            @if($t->id==$l->room_id)
                                @if($t->area_id==1)
                                    B1-{{$t->room_number}}
                                @elseif($t->area_id==2)
                                    B2-{{$t->room_number}}
                                @else
                                    B3-{{$t->room_number}}
                                @endif
                            @endif
                        @endforeach
                    </td>
                    <td>{{$l->status}}</td>
                    <td>{{$l->created_at}}</td>
                    <td><a href="{{ route('get_manager_ttsv', $l->mssv) }}"><button type="button" class="btn btn-primary">Xem thông tin</button></a></td>
                    <td><a href="{{ route('get_manager_duyetdk', $l->mssv) }}"><button type="button" class="btn btn-primary">Duyệt</button></a></td>
                    <td><a href="{{ route('get_manager_huydk', $l->mssv) }}"><button type="button" class="btn btn-primary">Hủy</button></a></td>
                </tr>
                @endforeach
            </table>
            @endif
        </div>
        @endif
    </div>
    
@endsection