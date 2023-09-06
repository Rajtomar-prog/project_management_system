@extends('admin.home')
@section('page_title', 'Department Management')

@section('main_headeing', 'Departments')
@section('sub_headeing', 'Show Department')

@section('content_section')

    <div class="card-header">
        <h3 class="card-title">@yield('sub_headeing')</h3>
        <div class="float-right">
            <a class="btn btn-outline-primary btn-block btn-sm" href="{{ route('departments.index') }}"><i
                    class="fa fa-arrow-left"></i> Back </a>
        </div>
    </div>

    <div class="card-body">
        <div class="row">
            <div class="table-responsive">
                <table class="table table-borderless">
                    <tbody>
                        <tr>
                            <th style="width: 150px">Name</th>
                            <td>{{ $department->name }}</td>
                        </tr>
                        <tr>
                            <th>Description</th>
                            <td> {!! $department->description !!}</td>
                        </tr>
                        <tr>
                            <th>Color</th>
                            <td>
                                <span class="badge badge-success" style="background: {{ $department->color }}">
                                    &nbsp; &nbsp;
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th>Name</th>
                            <td>
                                @if ($department->is_active == 1)
                                    <label class="badge badge-success"><i class="fa fa-check-circle" aria-hidden="true"></i>
                                        Active</label>
                                @else
                                    <label class="badge badge-danger"><i class="fa fa-ban" aria-hidden="true"></i>
                                        Inactive</label>
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection
