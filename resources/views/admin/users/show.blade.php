@extends('admin.home')
@section('page_title', 'Users Management')

@section('main_headeing', 'Users')
@section('sub_headeing', 'Show User')

@section('content_section')

    <div class="card-header">
        <h3 class="card-title">@yield('sub_headeing')</h3>
        <div class="float-right">
            <a class="btn btn-outline-primary btn-block btn-sm" href="{{ route('users.index') }}">
                <i class="fa fa-arrow-left"></i> Back
            </a>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="table-responsive">
                <table class="table">
                    <tbody>
                        <tr>
                            <th>Name</th>
                            <td>: {{ $user->name }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>: {{ $user->email }}</td>
                        </tr>
                        <tr>
                            <th>Phone Number</th>
                            <td>: {{ $user->phone_number }}</td>
                        </tr>
                        <tr>
                            <th>Departments</th>
                            <td>:
                                @if (!empty($user->departments))
                                    @foreach ($user->departments as $department)
                                        <label class="badge badge-primary">{{ $department->name }}</label>
                                    @endforeach
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Role</th>
                            <td>:
                                @if (!empty($user->getRoleNames()))
                                    @foreach ($user->getRoleNames() as $v)
                                        <label class="badge badge-success">{{ $v }}</label>
                                    @endforeach
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>: {{ displayStatus($user->is_active) }}</td>
                        </tr>
                        <tr>
                            <th>Registered Date</th>
                            <td>: {{ changeDateFormat('D, M d Y h:i A',$user->created_at) }} </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
        </div>
    </div>


@endsection
