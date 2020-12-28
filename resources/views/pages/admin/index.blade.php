@extends('layouts.app')

@section('content')
<div class="content">
    <div class="container-fluid">
        @include('partials.alerts')
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('Tài khoản người dùng') }}</div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead class=" text-primary">
                                    <th scope="col">ID</th>
                                    <th scope="col">Tên tài khoản</th>
                                    <th scope="col">Tên người dùng</th>
                                    <th><th>
                                </thead>
                                <tbody>
                                    @foreach($users as $user)
                                        <tr>
                                            @if ( $user->roles()->get()->pluck('name')->toArray() !== ["admin"])
                                            <td>{{ $user->id - 1}}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>{{ $user->name }}</td>
                                            <td>
                                                <div class="row">
                                                    @foreach($profiles as $profile)
                                                    @if($profile->email === $user->email)
                                                    <a href="{{ route('admin.users.show', $profile->mssv)}}" class="btn btn-primary"><i class="material-icons">visibility</i></a>
                                                    @endif
                                                    @endforeach
                                                    <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-primary"><i class="material-icons">edit</i></a>
                                                    {{-- Modal --}}

                                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#basicExampleModal">
                                                        <i class="material-icons">delete</i>
                                                      </button>
                                                      
                                                      <!-- Modal -->
                                                      <div class="modal fade" id="basicExampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog" role="document">
                                                          <div class="modal-content">
                                                            <div class="modal-header">
                                                              <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                                                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                              </button>
                                                            </div>
                                                            <div class="modal-body">
                                                              {{ __('Bạn chắc chắn muốn xóa?')}}
                                                            </div>
                                                            <div class="modal-footer">
                                                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                {{--Form delete  --}}
                                                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="btn btn-danger">{{ __('Xóa')}}</button>
                                                                </form>
                                                            </div>
                                                          </div>
                                                        </div>
                                                      </div>



                                                    {{-- End Modal --}}
                                                </div>
                                            </td>
                                            @endif
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

