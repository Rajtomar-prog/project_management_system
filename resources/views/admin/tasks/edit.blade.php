@extends('admin.home')
@section('page_title', 'Task Management')

@section('main_headeing', 'Task')
@section('sub_headeing', 'Edit Task')

@section('content_section')
    <div class="card-header">
        <h3 class="card-title">@yield('sub_headeing')</h3>
        <div class="float-right">
            <a class="btn btn-outline-primary btn-block btn-sm" href="{{ route('tasks.index') }}"><i
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

        {!! Form::model($task, ['method' => 'PATCH', 'route' => ['tasks.update', $task->id], 'files' => true]) !!}
        <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-6">
                <div class="form-group">
                    <strong>Title<span class="text-danger">*</span></strong>
                    {!! Form::text('title', null, ['placeholder' => 'Task title', 'class' => 'form-control']) !!}
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-6">
                <div class="form-group">
                    <strong>Priority<span class="text-danger">*</span></strong>
                    {!! Form::select('priority', $priority, $task->priority, ['class' => 'form-control']) !!}
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-6">
                <div class="form-group">
                    <strong>Project<span class="text-danger">*</span></strong>
                    {!! Form::select('project_id', [null => 'Select Project'] + $projects, $task->project_id, [
                        'class' => 'form-control project',
                        'onchange' => 'get_projects_users()',
                    ]) !!}
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-6">
                <div class="form-group">
                    <strong>Assign To<span class="text-danger">*</span></strong>
                    {!! Form::select('users[]', $projectUsers, $taskUsers, [
                        'class' => 'select2 form-control',
                        'id' => 'users',
                        'multiple',
                    ]) !!}
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-6">
                <div class="form-group">
                    <strong>Due Date<span class="text-danger">*</span></strong>
                    {!! Form::date('due_date', changeDateFormat('Y-m-d', $task->due_date), [
                        'placeholder' => 'Enter due date',
                        'class' => 'form-control',
                    ]) !!}
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-6">
                <div class="form-group">
                    <strong>Task Status<span class="text-danger">*</span></strong>
                    {!! Form::select('status_id', $statuses, $task->status_id, ['class' => 'form-control']) !!}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Description<span class="text-danger">*</span></strong>
                    {!! Form::textarea('description', null, [
                        'placeholder' => 'Enter description',
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
        var path = "{{ route('get_assigned_users') }}";
        $('.project').on('change', function() {
            let projectID = $(this).val();
            $.ajax({
                type: "GET",
                headers: {
                    'X-CSRF-Token': '{{ csrf_token() }}',
                },
                data: {
                    projectID: projectID
                },
                url: path,
                success: function(response) {
                    $('#users').empty().trigger('change');
                    if (response.status) {
                        $("#users").select2({
                            data: response.data
                        });
                    }
                    console.log(response);
                }
            });
        });
    </script>
@endsection
