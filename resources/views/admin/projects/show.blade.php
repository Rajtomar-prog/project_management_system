@extends('admin.home')
@section('page_title', 'Project Management')

@section('main_headeing', 'Projects')
@section('sub_headeing', 'Show Project')

@section('content_section')

    <div class="card-header">
        <h3 class="card-title">@yield('sub_headeing')</h3>
        <div class="float-right">
            <a class="btn btn-outline-primary btn-block btn-sm" href="{{ route('projects.index') }}">
                <i class="fa fa-arrow-left"></i> Back
            </a>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="table-responsive">
                <table class="table">
                    <tbody>
                        <tr>
                            <th>Project Name</th>
                            <td>: {{ $project->project_name }}</td>
                        </tr>
                        <tr>
                            <th>Client Name</th>
                            <td>: {{ getUserNameById($project->client_id) }}</td>
                        </tr>
                        <tr>
                            <th>Budget</th>
                            <td>: {{ currencyName($project->curency) }} {{ $project->budget }}</td>
                        </tr>
                        <tr>
                            <th>Budget Type</th>
                            <td>: {{ $project->budget_type }}</td>
                        </tr>
                        <tr>
                            <th>Currency</th>
                            <td>: {{ currencyName($project->curency) }}</td>
                        </tr>
                        <tr>
                            <th>Created By</th>
                            <td>: {{ getUserNameById($project->created_by) }}</td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>: {{ projectStatus($project->status) }}</td>
                        </tr>
                        <tr>
                            <th>Departments</th>
                            <td>:
                                @if (!empty($project->departments))
                                    @foreach ($project->departments as $department)
                                        <label class="badge badge-primary">{{ $department->name }}</label>
                                    @endforeach
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Assigned Users</th>
                            <td>:
                                @if (!empty($project->users))
                                    @foreach ($project->users as $user)
                                        <label class="badge badge-warning">{{ $user->name }}</label>
                                    @endforeach
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Created Date</th>
                            <td>: {{ changeDateFormat('D, M d Y h:i A',$project->created_at) }} </td>
                        </tr>
                        <tr>
                            <th>Description</th>
                            <td>: {!! $project->description !!}</td>
                        </tr>
                        
                    </tbody>
                </table>
            </div>
            
        </div>
    </div>


@endsection
