@extends('layouts.app')

@section('content')
<div class="content">
    <div class="container">
        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('user.profile.update', $profile) }}" enctype="multipart/form-data">
                    <!-- Grid row -->
                    @csrf
                    @method('PUT')
                    <div class="form-row">
                    <!-- Grid column -->
                        <div class="col-md-6">
                            <!-- Material input -->
                            <div class="md-form form-group">
                            <input type="text" class="form-control  @error('sdt') is-invalid @enderror" id="sdt" name="sdt" value={{ $profile->sdt }}>
                            @error('sdt')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <label for="sdt">Số điện thoại</label>
                            </div>
                        </div>
                        <!-- Grid column -->
                    
                        <!-- Grid column -->
                        <div class="col-md-6">
                            <!-- Material input -->
                            <div class="md-form form-group">
                            <input type="text" class="form-control @error('mssv') is-invalid @enderror" id="mssv" name="mssv" value="{{$profile->mssv}}">
                            @error('mssv')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <label for="mssv">Mã số sinh viên</label>
                            </div>
                        </div>
                    <!-- Grid column -->
                    </div>
                    <!-- Grid row -->
                
                    <!-- Grid row -->
                    <div class="row">
                    <!-- Grid column -->
                        <div class="col-md-12">
                            <!-- Material input -->
                            <div class="md-form form-group">
                            <input type="text" class="form-control @error('qq') is-invalid @enderror" id="qq" name="qq" value="{{$profile->qq}}">
                            @error('qq')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <label for="qq">Quê quán</label>
                            </div>
                        </div>
                    <!-- Grid column -->
                
                    <!-- Grid column -->

                        <div class="col-md-12">
                            <!-- Material input -->
                            <div class="md-form form-group">
                                <select class="custom-select custom-select-md @error('vien_id') is-invalid @enderror" name="vien_id">
                                    <option value="" selected>{{ __('Viện') }}</option>
                                    @foreach($viens as $vien)
                                    <option value="{{$vien->id}}" {{$vien->id == $profile->vien_id ? 'selected' : ''}}>{{ $vien->name }}</option>
                                    @endforeach
                                </select>
                                @error('vien_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        
                    <!-- Grid column -->
                    </div>
                    <!-- Grid row -->
                
                    <!-- Grid row -->
                    <div class="form-row">
                    <!-- Grid column -->
                        <div class="col-md-5">
                            <!-- Material input -->
                            <div class="md-form form-group">
                                <select class="custom-select custom-select-md @error('gt_id') is-invalid @enderror" name="gt_id">
                                    <option value="" selected>{{ __('Giới tính') }}</option>
                                    @foreach($gts as $gt)
                                    <option value="{{ $gt->id}}" {{$gt->id == $profile->gt_id ? 'selected' : ''}}>{{ $gt->name }}</option>
                                    @endforeach
                                </select>
                                @error('gt_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <!-- Grid column -->
                    
                        <!-- Grid column -->
                        <div class="col-md-5">
                            <!-- Material input -->
                            <div class="md-form form-group">
                                <select class="custom-select custom-select-md @error('khoa_id') is-invalid @enderror" name="khoa_id">
                                    <option value="" selected>Khóa</option>
                                    @foreach($khoas as $khoa)
                                    <option value="{{ $khoa->id}}" {{$khoa->id == $profile->khoa_id ? 'selected' : ''}}>{{ $khoa->name }}</option>
                                    @endforeach
                                  </select>
                                @error('khoa_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <!-- Grid column -->
                        <div class="col-md-12">
                            <div class="md-form form-group">
                                <div class="file-field">
                                    <div class="btn btn-primary btn-sm float-left">
                                    <label for="image">Select files</label>
                                    <input type="file" name="image" id="image" multiple/>
                                    <img src="{{ URL::to('/') }}/uploads/{{ $profile->image }}" class="img-thumbnail" width="100" />
                                    <input type="hidden" name="hidden_image" value="{{ $profile->image }}" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        </div>
                    <!-- Grid row -->
                    <button type="submit" class="btn btn-primary btn-md">{{ __('Sửa')}}</button>
                </form>
              <!-- Extended material form grid -->
            </div>
          <!-- Extended material form grid -->
        </div>
</div>
@endsection
