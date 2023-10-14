@extends('admin.home')
@section('page_title', 'Setting Management')

@section('main_headeing', 'Setting')
@section('sub_headeing', 'Setting')

@section('content_section')

    <div class="card-header">
        <h3 class="card-title">@yield('sub_headeing')</h3>
        <div class="float-right">
            <a class="btn btn-outline-primary btn-block btn-sm" href="{{ route('users.index') }}"><i
                    class="fa fa-arrow-left"></i> Back </a>
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

        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
        @endif

        {!! Form::model($setting, ['method' => 'PATCH', 'route' => ['settings.update', $setting->id], 'files' => true]) !!}
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6">
                <div class="form-group">
                    <strong>Name<span class="text-danger">*</span></strong>
                    {!! Form::text('app_name', null, ['placeholder' => 'App Name', 'class' => 'form-control']) !!}
                </div>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6">
                <div class="form-group">
                    <strong>Company name<span class="text-danger">*</span></strong>
                    {!! Form::text('company_name', null, ['placeholder' => 'Company name', 'class' => 'form-control']) !!}
                </div>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6">
                <div class="form-group">
                    <strong>Company email<span class="text-danger">*</span></strong>
                    {!! Form::text('company_email', null, ['placeholder' => 'Company email', 'class' => 'form-control']) !!}
                </div>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6">
                <div class="form-group">
                    <strong>Company phone<span class="text-danger">*</span></strong>
                    {!! Form::text('company_phone', null, ['placeholder' => 'Company phone', 'class' => 'form-control']) !!}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Address<span class="text-danger">*</span></strong>
                    {!! Form::text('address', null, ['placeholder' => 'Address', 'class' => 'form-control']) !!}
                </div>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6">
                <div class="form-group">
                    <strong>App Logo<span class="text-danger">*</span></strong>
                    {!! Form::file('app_logo', null, ['placeholder' => 'Choose App Logo', 'class' => 'form-control']) !!}
                </div>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6">
                <div class="form-group">
                    <strong>Favicon<span class="text-danger">*</span></strong>
                    {!! Form::file('favicon', null, ['placeholder' => 'Choose favicon', 'class' => 'form-control']) !!}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <button type="submit" class="btn btn-primary btn-flat">Submit</button>
            </div>
        </div>
        {!! Form::close() !!}
    </div>

@endsection
