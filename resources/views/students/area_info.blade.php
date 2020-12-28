@extends('layouts.app')

@section('content')
    @if (Session::get('ttsv') === null)
        <script>window.location = "/user/profile/create";</script>
    @endif
    <div class="content">
        <div class="container">
            @if(isset($room))
                <div class="list_phong">
                    <h3 style="">
                        <i class="fa fa-arrow-circle-o-right"></i>
                        Danh sách phòng
                    </h3>
                    @if(Session::has('flag'))
                        <div class="error" style="color: red;"><p>{{Session::get('message')}}</p></div>
                    @endif
                    <table class="table table-bordered table-striped datatable" id="table_export">
                        <tr>
                            <th>Số phòng</th>
                            <th>Số người hiện tại</th>
                            <th>Số người tối đa</th>
                            <th>Giới tính</th>
                            <th>Đăng ký</th>
                        </tr>
                        @foreach($room as $room_info)
                            <tr>
                                <td>{{$room_info->room_number}}</td>
                                <td>{{$room_info->current_numbers}}</td>
                                <td>{{$room_info->max_numbers}}</td>
                                <td>@if($room_info->gender=="nam")
                                        {{"Nam"}}
                                    @else {{"Nữ"}}
                                    @endif
                                </td>
                                <td><a href="{{ route('regist_room', $room_info->id) }}"><button type="button" class="btn btn-primary">Đăng ký</button></a></td>
                            </tr>
                        @endforeach
                    </table>
                </div>
                <div class="row">
                    <div class="col-xs-6 col-left"></div>
                    <div class="col-xs-6 col-right">
                        <div class="dataTables_paginate paging_bootstrap">
                            {!! $room->links() !!}
                        </div>
                    </div>
                </div>
            @else
            <h3>Danh sách khu ở</h3>
            <table class="table">
                <thead class="thead-light">
                    <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Tên khu ở</th>
                    <th scope="col">Giá phòng</th>
                    <th scope="col">Danh sách phòng</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($areas as $list_area)
                        <tr>
                            <th scope="row">{{$list_area->id}}</th>
                            <td>{{$list_area->area_name}}</td>
                            <td>{{$list_area->area_cost}}</td>
                            <td><a href="{{ route('room_info', $list_area->id) }}"><button type="button" class="btn btn-primary">Xem</button></a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @endif 
    </div>

    </div>
@endsection
