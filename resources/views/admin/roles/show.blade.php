@extends('admin.home')
@section('page_title','Roles Management')

@section('main_headeing','User Roles')
@section('sub_headeing','Show Role')

@section('content_section')

<div class="card-header">
    <h3 class="card-title">@yield('sub_headeing')</h3>
    <div class="float-right">
        <a class="btn btn-outline-primary btn-block btn-sm" href="{{ route('roles.index') }}"><i class="fa fa-arrow-left"></i> Back </a>
    </div>
</div>
<div class="card-body">
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Name:</strong>
                {{ $role->name }}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Permissions:</strong>
                @if(!empty($rolePermissions))
                @foreach($rolePermissions as $v)
                <label class="badge badge-success">{{ $v->name }},</label>
                @endforeach
                @endif
            </div>
        </div>
    </div>
</div>

@endsection