@extends('admin.home')
@section('page_title', 'My Profile')

@section('main_headeing', 'My Profile')
@section('sub_headeing', 'My Profile')

@section('content_section')

    <div class="card-body">
        <div class="row">
            <div class="col-lg-12 col-12">
                @if ($message = Session::get('success'))
                    <div class="alert alert-success">
                        <p>{{ $message }}</p>
                    </div>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">

                <div class="card card-primary card-outline">
                    <div class="card-body box-profile">
                        <div class="text-center">
                            <img class="profile-user-img img-fluid img-circle"
                                src="{{ asset('admin-assets/dist/img/user4-128x128.jpg') }}" alt="User profile picture">
                        </div>

                        <h3 class="profile-username text-center">{{ $user->name }}</h3>

                        <p class="text-muted text-center">
                            @if (!empty($user->getRoleNames()))
                                @foreach ($user->getRoleNames() as $v)
                                    <label class="badge badge-success">{{ $v }}</label>
                                @endforeach
                            @endif
                        </p>

                        <ul class="list-group list-group-unbordered mb-3">
                            <li class="list-group-item">
                                <i class="fa fa-envelope" aria-hidden="true"></i> {{ $user->email }}
                            </li>
                            <li class="list-group-item">
                                <i class="fa fa-phone-square" aria-hidden="true"></i> +91-{{ $user->phone_number }}
                            </li>
                            <li class="list-group-item text-center">
                                {{ displayStatus($user->is_active) }}
                            </li>
                        </ul>
                    </div>
                </div>

            </div>
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header p-2">
                        <ul class="nav nav-pills">
                            <li class="nav-item">
                                <a class="nav-link" href="#timeline" data-toggle="tab">Assigned Tasks</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" href="#settings" data-toggle="tab">Profile Settings</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="tab-pane" id="timeline">
                                <div class="timeline timeline-inverse">
                                    <div class="time-label">
                                        <span class="bg-danger">
                                            10 Feb. 2014
                                        </span>
                                    </div>
                                    <div>
                                        <i class="fas fa-envelope bg-primary"></i>
                                        <div class="timeline-item">
                                            <span class="time"><i class="far fa-clock"></i> 12:05</span>
                                            <h3 class="timeline-header">
                                                <a href="#">Support Team</a> sent you an email
                                            </h3>
                                            <div class="timeline-body">
                                                Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles,
                                                weebly ning heekya handango imeem plugg dopplr jibjab, movity
                                                jajah plickers sifteo edmodo ifttt zimbra. Babblely odeo kaboodle
                                                quora plaxo ideeli hulu weebly balihoo...
                                            </div>
                                            <div class="timeline-footer">
                                                <a href="#" class="btn btn-primary btn-sm">Read more</a>
                                                <a href="#" class="btn btn-danger btn-sm">Delete</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <i class="fas fa-user bg-info"></i>
                                        <div class="timeline-item">
                                            <span class="time"><i class="far fa-clock"></i> 5 mins ago</span>
                                            <h3 class="timeline-header border-0">
                                                <a href="#">Sarah Young</a> accepted your friend request
                                            </h3>
                                        </div>
                                    </div>
                                    <div>
                                        <i class="fas fa-comments bg-warning"></i>
                                        <div class="timeline-item">
                                            <span class="time"><i class="far fa-clock"></i> 27 mins ago</span>
                                            <h3 class="timeline-header">
                                                <a href="#">Jay White</a> commented on your post
                                            </h3>
                                            <div class="timeline-body">
                                                Take me to your leader!
                                                Switzerland is small and neutral!
                                                We are more like Germany, ambitious and misunderstood!
                                            </div>
                                            <div class="timeline-footer">
                                                <a href="#" class="btn btn-warning btn-flat btn-sm">View comment</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="time-label">
                                        <span class="bg-success">3 Jan. 2014</span>
                                    </div>
                                    <div>
                                        <i class="fas fa-camera bg-purple"></i>
                                        <div class="timeline-item">
                                            <span class="time"><i class="far fa-clock"></i> 2 days ago</span>
                                            <h3 class="timeline-header">
                                                <a href="#">Mina Lee</a> uploaded new photos
                                            </h3>
                                            <div class="timeline-body">
                                                <img src="https://placehold.it/150x100" alt="...">
                                                <img src="https://placehold.it/150x100" alt="...">
                                                <img src="https://placehold.it/150x100" alt="...">
                                                <img src="https://placehold.it/150x100" alt="...">
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <i class="far fa-clock bg-gray"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane active" id="settings">

                                {!! Form::model($user, [
                                    'method' => 'PATCH',
                                    'class' => 'form-horizontal',
                                    'route' => ['statuses.update', $user->id],
                                ]) !!}

                                <div class="form-group row">
                                    <label for="inputName" class="col-sm-2 col-form-label">Name</label>
                                    <div class="col-sm-10">
                                        {!! Form::text('name', null, ['placeholder' => 'Name', 'class' => 'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                                    <div class="col-sm-10">
                                        {!! Form::email('email', null, ['placeholder' => 'Enter email', 'class' => 'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputName2" class="col-sm-2 col-form-label">Phone Number</label>
                                    <div class="col-sm-10">
                                        {!! Form::text('phone_number', null, ['placeholder' => 'Enter phone number', 'class' => 'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="offset-sm-2 col-sm-10">
                                        <button type="submit" class="btn btn-outline-primary btn-sm">Submit</button>
                                    </div>
                                </div>
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('additional_css')
    <style>
        li.list-group-item.text-center label {
            width: 100%;
            padding: 10px;
        }
    </style>
@endsection
