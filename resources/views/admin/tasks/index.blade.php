@extends('admin.home')
@section('page_title', 'Task Management')

@section('main_headeing', 'Kanban Board')
@section('sub_headeing', 'Kanban Board')

@section('additional_css')
    <style>
        .settings-box {
            padding: 10px;
        }

        .settings-box .jumbotron {
            padding: 0.1rem 1rem;
            margin-bottom: 0.4rem;
        }

        .info-table tr td {
            padding: 0px;
        }


        .widget .panel-body {
            padding: 0px;
        }

        .widget .list-group {
            margin-bottom: 0;
        }

        .widget .panel-title {
            display: inline
        }

        .widget .label-info {
            float: right;
        }

        .widget li.list-group-item {
            border-radius: 0;
            border: 0;
            border-top: 1px solid #ddd;
        }

        .widget li.list-group-item:hover {
            background-color: rgba(86, 61, 124, .1);
        }

        .widget .mic-info {
            color: #666666;
            font-size: 1rem;
        }

        .widget .action {
            margin-top: 5px;
        }

        .widget .comment-text {
            font-size: 1rem;
        }

        .widget .btn-block {
            border-top-left-radius: 0px;
            border-top-right-radius: 0px;
        }

        .assignee .list-group-item {
            padding: 2px;
            border: none;
        }

        ::-webkit-scrollbar {
            width: 5px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        ::-webkit-scrollbar-thumb {
            background: #888;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #555;
        }

        .user-dp {
            width: 40px;
            height: 40px;
            border: 2px solid #fff;
            border-radius: 40px;
        }

        ul.list-group.assignee li {
            background-color: transparent;
            padding: 0;
        }

        ul.list-group.assignee {
            flex-direction: row;
        }

        ul.list-group.assignee li:not(:first-child) {
            z-index: 1;
            margin-right: -10px;
            right: 10px;
        }

        ul.list-group.assignee li:first-child {
            z-index: 2;
        }

        .content-wrapper.kanban ::-webkit-scrollbar {
            width: 5px;
            height: 5px;
        }

        .content-wrapper.kanban ::-webkit-scrollbar-thumb {
            background: #888;
        }

        .content-wrapper.kanban ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        .assignee-section {
            padding: 0px;
            display: flex;
        }

        .assignee-section btn {
            border: none;
            background: transparent;
        }

        .assign_task_users {
            display: none;
            margin-top: 10px;
        }

        .status-section {
            display: none;
            margin: 10px;
        }

        .description-block {
            margin: 0px;
            text-align: justify;
        }
    </style>
@endsection

@section('content_section')
    <div class="card-header">
        <h3 class="card-title">@yield('sub_headeing')</h3>
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

        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
        @endif

        <div class="card">
            <div class="card-body text-center">
                <div class="container">
                    <div class="row justify-content-end">
                        <div class="form-group align-center" style="margin-bottom: 0;">
                            {!! Form::open(['route' => 'tasks.index', 'method' => 'GET', 'class' => 'form-inline']) !!}

                            {!! Form::select('project_id', [null => 'Select Project'] + $projects, $project_id, [
                                'class' => 'form-control project',
                            ]) !!}

                            {{-- {!! Form::select('users[]', [], [], ['class' => 'select2 form-control', 'id' => 'users', 'multiple']) !!} --}}

                            <button type="submit" class="btn btn-default btn-flat">
                                <i class="fa fa-filter" aria-hidden="true"></i>
                            </button>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="content-wrapper kanban" style="margin-left: 0px;">
            <section class="content pb-3">
                <div class="container-fluid h-100">

                    @foreach ($statusData as $status)
                        <div class="card card-row card-default">
                            <div class="card-header" style="background: {{ $status['color'] }};color:#ffff;">
                                <h3 class="card-title">
                                    {{ $status['name'] }}
                                </h3>
                            </div>
                            <div class="card-body">
                                @if (!empty($status['tasks']))
                                    @foreach ($status['tasks'] as $key => $task)
                                        @if ($task['task_name'])
                                            <div class="card card-light card-outline">
                                                <div class="card-header">
                                                    <h5 class="card-title">{{ $task['task_name'] }}</h5>
                                                    <div class="card-tools">
                                                        <input type="hidden" class="selected_proejct"
                                                            value="{{ $task['project_id'] }}">
                                                        <a href="#"
                                                            class="btn btn-tool btn-link">#{{ $key + 1 }}</a>
                                                        <button type="button" class="btn btn-tool get-task-detail"
                                                            data-toggle="modal" data-target="#modal-lg"
                                                            data-task_id="{{ $task['task_id'] }}"
                                                            onclick="task_detail({{ $task['task_id'] }})">
                                                            <i class="fas fa-pen"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                    {!! $task['description'] !!}
                                                </div>
                                                <div class="card-footer">
                                                    <div class="row">
                                                        <div class="col-sm-9 border-right">
                                                            <div class="description-block">
                                                                <span class="description-texts">
                                                                    <i class="fa fa-calendar" aria-hidden="true"></i>
                                                                    {{ changeDateFormat('M d, Y h:i A', $task['created_at']) }}
                                                                </span>
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-3">
                                                            <div class="description-block">
                                                                <span class="description-text">
                                                                    <div class="action text-center">

                                                                        <a href="{{ route('tasks.edit', $task['task_id']) }}"
                                                                            title="Edit" class="btn badge badge-info">
                                                                            <i class="fas fa-edit" aria-hidden="true"></i>
                                                                        </a>

                                                                        {!! Form::open([
                                                                            'method' => 'DELETE',
                                                                            'route' => ['tasks.destroy', $task['task_id']],
                                                                            'style' => 'display:inline',
                                                                        ]) !!}
                                                                        {!! Form::button('<i class="fa fa-trash" aria-hidden="true"></i>', [
                                                                            'class' => 'btn badge badge-danger',
                                                                            'type' => 'submit',
                                                                            'onclick'=> 'return confirm("Are you sure?")'
                                                                        ]) !!}
                                                                        {!! Form::close() !!}
                                                                    </div>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    @endforeach

                </div>
            </section>
        </div>
    </div>

    <div class="modal fade" id="modal-lg">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title"><i class="fa fa-tasks" aria-hidden="true"></i> Task Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body model_data">

                </div>
            </div>
        </div>
    </div>

@endsection

@section('additionl_js')
    <script>
        function task_detail(task_id) {
            var project_id = $('.selected_proejct').val();
            var path = "{{ route('get_task_detail') }}";
            $.ajax({
                type: "GET",
                headers: {
                    'X-CSRF-Token': '{{ csrf_token() }}',
                },
                data: {
                    task_id: task_id,
                    project_id: project_id
                },
                url: path,
                success: function(response) {
                    if (response) {
                        $('.model_data').html('');
                        $('.model_data').html(response);
                    }
                }
            });
        }

        $('body').on('click', '#add_comment', function() {
            let task_id = $("input[name=task_id]").val();
            let comment = $("textarea[name=comment]").val();
            var path_comment = "{{ route('add_comment') }}";
            $.ajax({
                type: "GET",
                headers: {
                    'X-CSRF-Token': '{{ csrf_token() }}',
                },
                data: {
                    task_id: task_id,
                    comment: comment
                },
                url: path_comment,
                success: function(response) {
                    if (response.status) {
                        task_detail(task_id);
                    }
                    console.log(response);
                },
                error: function(reject) {
                    var response = $.parseJSON(reject.responseText);
                    $.each(response.errors, function(key, val) {
                        $("#" + key + "_error").text(val[0]);
                    });
                }
            });
        });

        $('body').on('click', '.delete_comment', function() {
            var id = $(this).data("id");
            var task_id = $(this).data("task_id");
            var path_delete = "{{ route('destroy_comment') }}";
            $.ajax({
                type: "GET",
                headers: {
                    'X-CSRF-Token': '{{ csrf_token() }}',
                },
                data: {
                    id: id,
                    task_id: task_id
                },
                url: path_delete,
                success: function(response) {
                    if (response.status) {
                        task_detail(task_id);
                    }
                }
            });
        });

        $('body').on('click', '.assign_task_user', function() {
            $('.assign_task_users').toggle('slow');
        });

        $('body').on('click', '.display-status', function() {
            $('.status-section').toggle('slow');
        });

        $('body').on('change', '.change_task_status', function() {
            var id = $(this).val();
            var task_id = $(this).data("task_id");
            var path_delete = "{{ route('change_task_status') }}";
            $.ajax({
                type: "GET",
                headers: {
                    'X-CSRF-Token': '{{ csrf_token() }}',
                },
                data: {
                    id: id,
                    task_id: task_id
                },
                url: path_delete,
                success: function(response) {
                    if (response.status) {
                        location.reload();
                    }
                }
            });
        });

        $('body').on('change', '#update_assignee', function() {
            let userIds = $(this).val();
            let task_id = $(this).data("task_id");
            let path = "{{ route('update_assignee') }}";
            $.ajax({
                type: "GET",
                headers: {
                    'X-CSRF-Token': '{{ csrf_token() }}',
                },
                data: {
                    userIds: userIds,
                    task_id: task_id
                },
                url: path,
                success: function(response) {
                    console.log(response);
                    if (response.status) {
                        task_detail(task_id);
                    }
                }
            });
        });
    </script>
@endsection
