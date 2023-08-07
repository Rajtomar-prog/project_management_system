@extends('admin.home')
@section('page_title','Roles Management')

@section('main_headeing','User Roles')
@section('sub_headeing','Edit Role')

@section('content_section')

<div class="card-header">
    <h3 class="card-title">@yield('sub_headeing')</h3>
    <div class="float-right">
        <a class="btn btn-outline-primary btn-block btn-sm" href="{{ route('roles.index') }}"><i class="fa fa-arrow-left"></i> Back </a>
    </div>
</div>

<div class="card-body">

    @if (count($errors) > 0)
    <div class="alert alert-danger">
        <strong>Whoops!</strong> something went wrong.<br><br>
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    {!! Form::model($role, ['method' => 'PATCH','route' => ['roles.update', $role->id]]) !!}
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Name:</strong>
                {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control')) !!}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Permission:</strong>
                <hr/>
                @foreach($permission as $value)
                <label>{{ Form::checkbox('permission[]', $value->id, in_array($value->id, $rolePermissions) ? true : false, array('class' => 'name')) }}
                    {{ $value->name }}</label>
                <br />
                @endforeach
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <button type="submit" class="btn btn-primary btn-flat">Submit</button>
        </div>
    </div>
    {!! Form::close() !!}

</div>

@endsection