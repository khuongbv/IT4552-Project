@extends('layouts.app')

@section('content')
<div class="content">

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('Thông tin người dùng') }}</div>
    
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead class=" text-primary">
                                    <th>ID</th>
                                    <th>{{ __('Tên') }}</th>
                                    <th>{{ __('MSSV') }}</th>
                                    <th>{{ __('Giới tính') }}</th>
                                    <th>{{ __('Email') }}</th>
                                    <th>{{ __('Số điện thoại') }}</th>
                                    <th>{{ __('Viện') }}</th>
                                    <th>{{ __('Khóa') }}</th>
                                    <th>{{ __('Quê quán') }}</th>

                                </thead>
                                <tbody>
                                    @foreach($profiles as $profile)
                                        <tr>
                                            <td>{{ $profile->id }}</td>
                                            <td>{{ $profile->name }}</td>
                                            <td>{{ $profile->mssv }}</td>
                                            @foreach($gts as $gt)
                                                @if ($profile->gt_id === $gt->id)
                                                <td>{{$gt->name}}</td>
                                                @endif
                                            @endforeach
                                            <td>{{ $profile->email }}</td>
                                            <td>{{ 0 . $profile->sdt }}</td>
                                            @foreach($viens as $vien)
                                                @if ($profile->vien_id === $vien->id)
                                                <td>{{$vien->name}}</td>
                                                @endif
                                            @endforeach
                                            @foreach($khoas as $khoa)
                                                @if ($profile->khoa_id === $khoa->id)
                                                <td>{{$khoa->name}}</td>
                                                @endif
                                            @endforeach
                                            <td>{{ $profile->qq}}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection