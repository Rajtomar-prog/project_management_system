@extends('admin.home')
@section('page_title', 'Project Management')

@section('main_headeing', 'Projects')
@section('sub_headeing', 'Project List')

@section('content_section')

    <div class="card-header">
        <h3 class="card-title">@yield('sub_headeing')</h3>
        <div class="float-right">
            @can('department-create')
                <a class="btn btn-outline-primary btn-block btn-sm" href="{{ route('projects.create') }}">
                    <i class="fa fa-plus"></i> New Project
                </a>
            @endcan
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-lg-12 col-12">

                @if ($message = Session::get('success'))
                    <div class="alert alert-success">
                        <p>{{ $message }}</p>
                    </div>
                @endif

                <table id="" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Project Name</th>
                            <th>Client Name</th>
                            <th>Created By</th>
                            <th>Departments</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($projects as $key => $project)
                            <tr>
                                <td>{{ ++$i }}</td>
                                <td>{{ $project->project_name }}</td>
                                <td>{{ getUserNameById($project->client_id) }} </td>
                                <td>{{ getUserNameById($project->created_by) }} </td>
                                <td>
                                    @if (!empty($project->departments))
                                        @foreach ($project->departments as $department)
                                            <label class="badge badge-primary">{{ $department->name }}</label>
                                        @endforeach
                                    @endif
                                </td>
                                <td>{{ projectStatus($project->status) }}</td>
                                <td>
                                    <a href="{{ route('projects.show', $project->id) }}" title="View"
                                        class="btn btn-outline-info btn-sm">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                    <a href="{{ route('projects.edit', $project->id) }}" title="Edit"
                                        class="btn btn-outline-primary btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    {!! Form::open([
                                        'method' => 'DELETE',
                                        'route' => ['projects.destroy', $project->id],
                                        'style' => 'display:inline',
                                    ]) !!}
                                    {!! Form::button('<i class="fa fa-trash" aria-hidden="true"></i>', [
                                        'class' => 'btn btn-outline-danger btn-sm',
                                        'type' => 'submit',
                                    ]) !!}
                                    {!! Form::close() !!}

                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {!! $projects->links() !!}
            </div>
        </div>
    </div>

@endsection
