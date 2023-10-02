@extends('admin.home')
@section('page_title','Users Management')

@section('main_headeing','Users')
@section('sub_headeing','Create New User')

@section('content_section')

<div class="card-header">
    <h3 class="card-title">@yield('sub_headeing')</h3>
    <div class="float-right">
        <a class="btn btn-outline-primary btn-block btn-sm" href="{{ route('users.index') }}"><i class="fa fa-arrow-left"></i> Back </a>
    </div>
</div>
<div class="card-body">
    @if (count($errors) > 0)
    <div class="alert alert-danger">
        <strong>Whoops! </strong>Something went wrong.<br><br>
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    {!! Form::open(array('route' => 'users.store','method'=>'POST','files' => true)) !!}
    <div class="row">
        <div class="col-xs-6 col-sm-6 col-md-6">
            <div class="form-group">
                <strong>Name<span class="text-danger">*</span></strong>
                {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control')) !!}
            </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-6">
            <div class="form-group">
                <strong>Email<span class="text-danger">*</span></strong>
                {!! Form::text('email', null, array('placeholder' => 'Email','class' => 'form-control')) !!}
            </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-6">
            <div class="form-group">
                <strong>Password<span class="text-danger">*</span></strong>
                {!! Form::password('password', array('placeholder' => 'Password','class' => 'form-control')) !!}
            </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-6">
            <div class="form-group">
                <strong>Confirm Password<span class="text-danger">*</span></strong>
                {!! Form::password('confirm-password', array('placeholder' => 'Confirm Password','class' => 'form-control')) !!}
            </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-6">
            <div class="form-group">
                <strong>Phone Number<span class="text-danger">*</span></strong>
                {!! Form::text('phone_number', null, array('placeholder' => 'Phone Number','class' => 'form-control')) !!}
            </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-6">
            <div class="form-group">
                <strong>Department</strong>
                {!! Form::select('departments[]', $departments,[], array('class' => 'select2 form-control','multiple')) !!}
            </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-6">
            <div class="form-group">
                <strong>Role<span class="text-danger">*</span></strong>
                {!! Form::select('roles[]', $roles,[], array('class' => 'select2 form-control','multiple')) !!}
            </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-6">
            <div class="form-group">
                <strong>Status<span class="text-danger">*</span></strong>
                {!! Form::select('is_active', array('1' => 'Active','0' => 'Inactive'),null, array('class' => 'form-control')) !!}
            </div>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-6">
            <div class="form-group">
                <label class="col-form-label">Profile Picture<span class="text-danger">*</span></label>
                {!! Form::file('profile_pic', null, ['placeholder' => 'Choose Profile Pic', 'class' => 'form-control']) !!}  
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <button type="submit" class="btn btn-primary btn-flat">Submit</button>
        </div>
    </div>
    {!! Form::close() !!}
</div>

@endsection