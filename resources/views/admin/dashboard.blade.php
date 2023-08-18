@extends('admin.home')
@section('page_title', 'Dashboard')

@section('main_headeing', 'Dashboard')
@section('sub_headeing', 'Dashboard V1')

@section('content_section')

    <div class="card-header">
        <h3 class="card-title">@yield('sub_headeing')</h3>
    </div>

    <div class="card-body">
        <div class="row">
            <div class="col-md-3 col-sm-6 col-12">
                <div class="info-box">
                    <span class="info-box-icon bg-info"><i class="far fa-envelope"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Messages</span>
                        <span class="info-box-number">1,410</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-12">
                <div class="info-box">
                    <span class="info-box-icon bg-success"><i class="far fa-flag"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Bookmarks</span>
                        <span class="info-box-number">410</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-12">
                <div class="info-box">
                    <span class="info-box-icon bg-warning"><i class="far fa-copy"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Uploads</span>
                        <span class="info-box-number">13,648</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-12">
                <div class="info-box">
                    <span class="info-box-icon bg-danger"><i class="far fa-star"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Likes</span>
                        <span class="info-box-number">93,139</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3 col-sm-6 col-12">
                <div class="info-box">
                    <span class="info-box-icon bg-info"><i class="far fa-envelope"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Messages</span>
                        <span class="info-box-number">1,410</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-12">
                <div class="info-box">
                    <span class="info-box-icon bg-success"><i class="far fa-flag"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Bookmarks</span>
                        <span class="info-box-number">410</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-12">
                <div class="info-box">
                    <span class="info-box-icon bg-warning"><i class="far fa-copy"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Uploads</span>
                        <span class="info-box-number">13,648</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-12">
                <div class="info-box">
                    <span class="info-box-icon bg-danger"><i class="far fa-star"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Likes</span>
                        <span class="info-box-number">93,139</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
