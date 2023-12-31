@extends('admin.home')
@section('page_title', 'Users Management')

@section('main_headeing', 'Users')
@section('sub_headeing', 'User List')

@section('content_section')

    <div class="card-header">
        <h3 class="card-title">@yield('sub_headeing')</h3>
        @can('user-create')
        <div class="float-right">
            <a class="btn btn-outline-primary btn-block btn-sm" href="{{ route('users.create') }}"><i class="fa fa-plus"></i>
                Create New User </a>
        </div>
        @endcan
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-lg-12 col-12">

                @if ($message = Session::get('success'))
                    <div class="alert alert-success">
                        <p>{{ $message }}</p>
                    </div>
                @endif

                <table id="example" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Roles</th>
                            <th>Departments</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $key => $user)
                            <tr>
                                <td>{{ ++$i }}</td>
                                <td><img src="{{ get_profile_pic($user->id) }}" width="30px" class="img-circle"> {{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @if (!empty($user->getRoleNames()))
                                        @foreach ($user->getRoleNames() as $v)
                                            <label class="badge badge-success">{{ $v }}</label>
                                        @endforeach
                                    @endif
                                </td>
                                <td>
                                    @if (!empty($user->departments))
                                        @foreach ($user->departments as $department)
                                            <label class="badge badge-primary">{{ $department->name }}</label>
                                        @endforeach
                                    @endif
                                </td>
                                <td>{{ displayStatus($user->is_active) }}</td>
                                <td>
                                    @can('user-list')
                                    <a href="{{ route('users.show', $user->id) }}" title="View"
                                        class="btn btn-outline-info btn-sm">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @endcan
                                    @can('user-edit')
                                    <a href="{{ route('users.edit', $user->id) }}" title="Edit"
                                        class="btn btn-outline-primary btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    @endcan
                                    @can('user-delete')
                                    {!! Form::open(['method' => 'DELETE', 'route' => ['users.destroy', $user->id], 'style' => 'display:inline']) !!}
                                    {!! Form::button('<i class="fa fa-trash" aria-hidden="true"></i>', [
                                        'class' => 'btn btn-outline-danger btn-sm',
                                        'type' => 'submit',
                                    ]) !!}
                                    {!! Form::close() !!}
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {!! $data->render() !!}
            </div>
        </div>
    </div>

@endsection
