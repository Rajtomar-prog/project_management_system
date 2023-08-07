@extends('admin.home')
@section('page_title','Roles Management')

@section('main_headeing','User Roles')
@section('sub_headeing','Role List')

@section('content_section')

<div class="card-header">
    <h3 class="card-title">@yield('sub_headeing')</h3>
    <div class="float-right">
        @can('role-create')
        <a class="btn btn-outline-primary btn-block btn-sm" href="{{ route('roles.create') }}">
            <i class="fa fa-plus"></i> New Role
        </a>
        @endcan
    </div>
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
                        <th width="200px">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($roles as $key => $role)
                    <tr>
                        <td>{{ ++$i }}</td>
                        <td>{{ $role->name }}</td>
                        <td>
                            <a href="{{ route('roles.show',$role->id) }}" title="View" class="btn btn-outline-info btn-sm">
                                <i class="fas fa-eye"></i>
                            </a>
                            @can('role-edit')
                            <a href="{{ route('roles.edit',$role->id) }}" title="Edit" class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-edit"></i>
                            </a>
                            @endcan
                            @can('role-delete')
                            {!! Form::open(['method' => 'DELETE','route' => ['roles.destroy', $role->id],'style'=>'display:inline']) !!}
                            {!! Form::button('<i class="fa fa-trash" aria-hidden="true"></i>', ['class' => 'btn btn-outline-danger btn-sm','type' => 'submit']) !!}
                            {!! Form::close() !!}
                            @endcan
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {!! $roles->render() !!}
        </div>
    </div>
</div>

@endsection