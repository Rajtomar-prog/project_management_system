@extends('admin.home')
@section('page_title','Permission Management')

@section('main_headeing','Permission')
@section('sub_headeing','Permission List')

@section('content_section')

<div class="card-header">
    <h3 class="card-title">@yield('sub_headeing')</h3>
    <div class="float-right">
        @can('permission-create')
        <a class="btn btn-outline-primary btn-block btn-sm" href="{{ route('permissions.create') }}">
            <i class="fa fa-plus"></i> New Permission
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

            <table id="" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Name</th>
                        <th>Gaurd Name</th>
                        <th width="200px">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($permissions as $key => $permission)
                    <tr>
                        <td>{{ ++$i }}</td>
                        <td>{{ $permission->name }}</td>
                        <td>{{ $permission->guard_name }}</td>
                        <td>
                            {{-- <a href="{{ route('permissions.show',$permission->id) }}" title="View" class="btn btn-outline-info btn-sm">
                                <i class="fas fa-eye"></i>
                            </a> --}}
                            @can('permission-edit')
                            <a href="{{ route('permissions.edit',$permission->id) }}" title="Edit" class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-edit"></i>
                            </a>
                            @endcan
                            @can('permission-delete')
                            {!! Form::open(['method' => 'DELETE','route' => ['permissions.destroy', $permission->id],'style'=>'display:inline']) !!}
                            {!! Form::button('<i class="fa fa-trash" aria-hidden="true"></i>', ['class' => 'btn btn-outline-danger btn-sm','type' => 'submit']) !!}
                            {!! Form::close() !!}
                            @endcan
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {!! $permissions->links() !!}
        </div>
    </div>
</div>

@endsection