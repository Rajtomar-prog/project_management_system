@extends('admin.home')
@section('page_title', 'Department Management')

@section('main_headeing', 'Department')
@section('sub_headeing', 'Edit Department')

@section('content_section')
    <div class="card-header">
        <h3 class="card-title">@yield('sub_headeing')</h3>
        <div class="float-right">
            <a class="btn btn-outline-primary btn-block btn-sm" href="{{ route('departments.index') }}"><i
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

        <form action="{{ route('departments.update',$department->id) }}" method="POST">
            @csrf 
            @method('PUT')
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Name<span class="text-danger">*</span></strong>
                        <input type="text" name="name" value="{{ $department->name }}" class="form-control" placeholder="Name">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Description<span class="text-danger">*</span></strong>
                        <textarea id="summernote" class="form-control" name="description" placeholder="Enter description">{{ $department->description }}</textarea>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Color<span class="text-danger">*</span></strong>
                        <input type="color" value="{{ $department->color }}" name="color" class="form-control">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Status<span class="text-danger">*</span></strong>
                        <select name="is_active" class="form-control">
                            <option value="1" @if($department->is_active==1) selected @endif>Active</option>
                            <option value="0" @if($department->is_active==0) selected @endif>Inactive</option>
                        </select>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <button type="submit" class="btn btn-primary btn-flat">Submit</button>
                </div>
            </div>
        </form>
    </div>

@endsection
