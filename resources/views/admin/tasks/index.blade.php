@extends('admin.home')
@section('page_title', 'Task Management')

@section('main_headeing', 'Kanban Board')
@section('sub_headeing', 'Kanban Board')

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

        <div class="card">
            <div class="card-body text-center">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="form-group  align-center ">
                            {!! Form::open(['route' => 'tasks.index', 'method' => 'GET', 'class' => 'form-inline']) !!}

                            {!! Form::select('project_id', [null => 'Select Project'] + $projects, $project_id, [
                                'class' => 'form-control project',
                            ]) !!}

                            {{-- <div class="col-sm-4">
                            {!! Form::select('users[]', [], [], ['class' => 'select2 form-control', 'id' => 'users', 'multiple']) !!}
                            </div> --}}
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
                                                        <a href="#" class="btn btn-tool btn-link">#{{ $key+1 }}</a>
                                                        <button type="button" class="btn btn-tool get-task-detail"
                                                            data-toggle="modal" data-target="#modal-lg"
                                                            data-task_id="{{ $task['task_id'] }}">
                                                            <i class="fas fa-pen"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                    {!! $task['description'] !!}
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
    </style>
@endsection


@section('additionl_js')
    <script>
        var path = "{{ route('get_task_detail') }}";
        $('.get-task-detail').on('click', function() {
            let task_id = $(this).data('task_id');

            $.ajax({
                type: "GET",
                headers: {'X-CSRF-Token': '{{ csrf_token() }}',},
                data: {task_id: task_id},
                url: path,
                // contentType: "application/json; charset=utf-8",
                // datatype: "json",
                success: function(response) {

                    if (response) {
                        $('.model_data').html('');
                        $('.model_data').html(response);
                        //$('#task_description').html(response.task.description);
                    }
                    //console.log(response);
                }
            });
        });

        var path_comment = "{{ route('add_comment') }}";
        
        $('body').on('click', '#add_comment', function (){
            let task_id = $("input[name=task_id]").val();
            let comment = $("textarea[name=comment]").val();
            $.ajax({
                type: "GET",
                headers: {'X-CSRF-Token': '{{ csrf_token() }}',},
                data: {task_id: task_id, comment:comment},
                url: path_comment,
                success: function(response) {

                    if (response.status) {
                        $('#comment_msg').html('');
                        $('.model_data').html(response);
                        //$('#task_description').html(response.task.description);
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
    </script>
@endsection
