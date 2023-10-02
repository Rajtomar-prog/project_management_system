@extends('admin.home')
@section('page_title','Task Status Management')

@section('main_headeing','Task Status')
@section('sub_headeing','Create New Task Status')

@section('content_section')

<div class="card-header">
    <h3 class="card-title">@yield('sub_headeing')</h3>
    <div class="float-right">
        <a class="btn btn-outline-primary btn-block btn-sm" href="{{ route('status.index') }}"><i class="fa fa-arrow-left"></i> Back </a>
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

    {!! Form::model($status, ['method' => 'PATCH','route' => ['status.update', $status->id]]) !!}
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Name<span class="text-danger">*</span></strong>
                {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control')) !!}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Order<span class="text-danger">*</span></strong>
                {!! Form::select('order', $order,$status->order, array('class' => 'form-control')) !!}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Color<span class="text-danger">*</span></strong>
                {!! Form::color('color', null, array('placeholder' => 'Color','class' => 'form-control')) !!}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Status<span class="text-danger">*</span></strong>
                {!! Form::select('is_active', array('1' => 'Active','0' => 'Inactive'),null, array('class' => 'form-control')) !!}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <button type="submit" class="btn btn-outline-primary btn-sm">Submit</button>
        </div>
    </div>
    {!! Form::close() !!}
</div>

@endsection