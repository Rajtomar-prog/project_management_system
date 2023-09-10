@extends('admin.home')
@section('page_title', 'Project Management')

@section('main_headeing', 'Project')
@section('sub_headeing', 'Add New Project')

@section('content_section')
    <div class="card-header">
        <h3 class="card-title">@yield('sub_headeing')</h3>
        <div class="float-right">
            <a class="btn btn-outline-primary btn-block btn-sm" href="{{ route('projects.index') }}"><i
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

        {!! Form::open(['route' => 'projects.store', 'method' => 'POST']) !!}
        <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-6">
                <div class="form-group">
                    <strong>Project Name:</strong>
                    {!! Form::text('project_name', null, ['placeholder' => 'Project Name', 'class' => 'form-control']) !!}
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-6">
                <div class="form-group">
                    <strong>Client:</strong>
                    {!! Form::select('client_id', [null => 'Select Client'] + $clients, [], ['class' => 'form-control']) !!}
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-6">
                <div class="form-group">
                    <strong>Department:</strong>
                    {!! Form::select(
                        'departments[]',
                        $departments,
                        [],
                        ['class' => 'select2 form-control', 'id' => 'departments', 'multiple'],
                    ) !!}
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-6">
                <div class="form-group">
                    <strong>Assign User:</strong>
                    {!! Form::select('users[]', $users, [], ['class' => 'select2 form-control', 'id' => 'users', 'multiple']) !!}
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-6">
                <div class="form-group">
                    <strong>Budget:</strong>
                    {!! Form::text('budget', null, ['placeholder' => 'Enter budget', 'class' => 'form-control']) !!}
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-6">
                <div class="form-group">
                    <strong>Budget Type:</strong>
                    {!! Form::select(
                        'budget_type',
                        ['' => 'Choose Budget Type', 'Hourly' => 'Hourly', 'Fixed Cost' => 'Fixed Cost'],
                        null,
                        ['class' => 'form-control'],
                    ) !!}
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-6">
                <div class="form-group">
                    <strong>Currency:</strong>
                    {!! Form::select(
                        'curency',
                        ['' => 'Choose Currency', '1' => 'USD', '2' => 'INR', '3' => 'EUR', '4' => 'AUD'],
                        null,
                        ['class' => 'form-control'],
                    ) !!}
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-6">
                <div class="form-group">
                    <strong>Status:</strong>
                    {!! Form::select(
                        'status',
                        ['' => 'Choose Status', '1' => 'To Do', '2' => 'On Hold', '3' => 'In Process', '4' => 'Done'],
                        null,
                        ['class' => 'form-control'],
                    ) !!}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Description:</strong>
                    {!! Form::textarea('description', null, [
                        'placeholder' => 'Enter budget',
                        'class' => 'form-control',
                        'id' => 'summernote',
                    ]) !!}
                </div>
            </div>
            {!! Form::hidden('created_by', Auth::user()->id, ['class' => 'form-control']) !!}
            <div class="col-xs-12 col-sm-12 col-md-12">
                <button type="submit" class="btn btn-primary btn-flat">Submit</button>
            </div>
        </div>
        {!! Form::close() !!}
    </div>

@endsection


@section('additionl_js')
    <script>
        var path = "{{ url('admin/department_users') }}";
        $('#departments').on('change', function() {
            let departmentID = $(this).val();
            $.ajax({
                type: "GET",
                headers: {
                    'X-CSRF-Token': '{{ csrf_token() }}',
                },
                data: {
                    department: departmentID
                },
                url: path,
                success: function(response) {
                    console.log(response);
                    // $("#users").select2({
                    //     data: response
                    // });
                }
            });

        });
    </script>
@endsection
