@extends('admin.home')
@section('page_title','Task Status Management')

@section('main_headeing','Task Status')
@section('sub_headeing','Task Status List')

@section('content_section')

<div class="card-header">
    <h3 class="card-title">@yield('sub_headeing')</h3>
    <div class="float-right">
        @can('role-create')
        <a class="btn btn-outline-primary btn-block btn-sm" href="{{ route('status.create') }}">
            <i class="fa fa-plus"></i> New Task Status
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
                        <th>Order</th>
                        <th>Color</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($statuses as $key => $status)
                    <tr>
                        <td>{{ ++$i }}</td>
                        <td>{{ $status->name }}</td>
                        <td>{{ $status->order }}</td>
                        <td><span class="badge badge-success" style="background: {{ $status->color }}"> &nbsp; &nbsp; </span></td>
                        <td>{{ displayStatus($status->is_active) }}</td>
                        <td>
                            <a href="{{ route('status.edit',$status->id) }}" title="Edit" class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-edit"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {!! $statuses->render() !!}
        </div>
    </div>
</div>

@endsection