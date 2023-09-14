@extends('admin.home')
@section('page_title', 'Task Management')

@section('main_headeing', 'Task')
@section('sub_headeing', 'Edit Task')

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

        <div class="content-wrapper kanban" style="    margin-left: 0px;">

            <section class="content pb-3">
                <div class="container-fluid h-100">


                    <div class="card card-row card-primary">
                        <div class="card-header">
                            <h3 class="card-title">To Do</h3>
                        </div>
                        <div class="card-body">
                            @for ($i = 1; $i < 5; $i++)
                                <div class="card card-light card-outline">
                                    <div class="card-header">
                                        <h5 class="card-title">Update Readme</h5>
                                        <div class="card-tools">
                                            <a href="#" class="btn btn-tool btn-link">#{{ $i }}</a>
                                            <a href="#" class="btn btn-tool">
                                                <i class="fas fa-pen"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <p>
                                            Lorem ipsum dolor sit amet, consectetuer adipiscing elit.
                                            Aenean commodo ligula eget dolor.
                                        </p>
                                    </div>
                                </div>
                            @endfor
                        </div>
                    </div>
                    <div class="card card-row card-default">
                        <div class="card-header bg-info">
                            <h3 class="card-title">
                                In Progress
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="card card-light card-outline">
                                <div class="card-header">
                                    <h5 class="card-title">Update Readme</h5>
                                    <div class="card-tools">
                                        <a href="#" class="btn btn-tool btn-link">#2</a>
                                        <a href="#" class="btn btn-tool">
                                            <i class="fas fa-pen"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <p>
                                        Lorem ipsum dolor sit amet, consectetuer adipiscing elit.
                                        Aenean commodo ligula eget dolor. Aenean massa.
                                        Cum sociis natoque penatibus et magnis dis parturient montes,
                                        nascetur ridiculus mus.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card card-row card-success">
                        <div class="card-header">
                            <h3 class="card-title">
                                Done
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="card card-primary card-outline">
                                <div class="card-header">
                                    <h5 class="card-title">Create repo</h5>
                                    <div class="card-tools">
                                        <a href="#" class="btn btn-tool btn-link">#1</a>
                                        <a href="#" class="btn btn-tool">
                                            <i class="fas fa-pen"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

    </div>

@endsection
