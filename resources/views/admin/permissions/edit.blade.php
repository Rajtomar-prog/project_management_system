@extends('admin.home')
@section('page_title', 'Permission Management')

@section('main_headeing', 'Permission')
@section('sub_headeing', 'Edit Permission')

@section('content_section')
    <div class="card-header">
        <h3 class="card-title">@yield('sub_headeing')</h3>
        <div class="float-right">
            <a class="btn btn-outline-primary btn-block btn-sm" href="{{ route('permissions.index') }}"><i
                    class="fa fa-arrow-left"></i> Back </a>
        </div>
    </div>

    <div class="card-body">

        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Whoops!</strong> Something went wrong.<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {!! Form::model($permission, ['method' => 'PATCH','route' => ['permissions.update', $permission->id]]) !!}
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Name<span class="text-danger">*</span></strong>
                        {!! Form::text('name', null, ['placeholder' => 'Permission Name', 'class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Guard Name<span class="text-danger">*</span></strong>
                        {!! Form::select(
                            'guard_name',
                            ['web' => 'Web'],
                            null,
                            ['class' => 'form-control'],
                        ) !!}
                    </div>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-12">
                    <button type="submit" class="btn btn-primary btn-flat">Submit</button>
                </div>
            </div>
        {!! Form::close() !!}
    </div>

@endsection
