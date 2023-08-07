@extends('admin.home')
@section('page_title','Departments Management')

@section('main_headeing','Departments')
@section('sub_headeing','Department List')

@section('content_section')

<div class="card-header">
    <h3 class="card-title">@yield('sub_headeing')</h3>
    <div class="float-right">
        @can('department-create')
        <a class="btn btn-outline-primary btn-block btn-sm" href="{{ route('departments.create') }}">
            <i class="fa fa-plus"></i> New Department
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
                        <th>Color</th>
                        <th>Status</th>
                        <th width="200px">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($departments as $key => $department)
                    <tr>
                        <td>{{ ++$i }}</td>
                        <td>{{ $department->name }}</td>
                        <td><span class="badge badge-success" style="background: {{ $department->color }}"> {{ $department->color }} </span></td>
                        <td>
                            @if($department->is_active==1)
                            <label class="badge badge-success"><i class="fa fa-check-circle" aria-hidden="true"></i> Active</label>
                            @else
                            <label class="badge badge-danger"><i class="fa fa-ban" aria-hidden="true"></i> Inactive</label>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('departments.show',$department->id) }}" title="View" class="btn btn-outline-info btn-sm">
                                <i class="fas fa-eye"></i>
                            </a>
                            @can('department-edit')
                            <a href="{{ route('departments.edit',$department->id) }}" title="Edit" class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-edit"></i>
                            </a>
                            @endcan
                            @can('department-delete')
                            {!! Form::open(['method' => 'DELETE','route' => ['departments.destroy', $department->id],'style'=>'display:inline']) !!}
                            {!! Form::button('<i class="fa fa-trash" aria-hidden="true"></i>', ['class' => 'btn btn-outline-danger btn-sm','type' => 'submit']) !!}
                            {!! Form::close() !!}
                            @endcan
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {!! $departments->links() !!}
        </div>
    </div>
</div>

@endsection