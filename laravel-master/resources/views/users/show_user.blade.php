
@extends('layouts.common')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Users</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item active">Users Details</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <!-- /.row -->
    <div class="flash-message">
        @foreach (['danger', 'warning', 'success', 'info'] as $msg)
            @if(Session::has('alert-' . $msg))
            <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
            @endif
        @endforeach
    </div>
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">User Details </h3>
            
            <div class="card-tools">
            </div>

          </div>
          <!-- /.card-header -->
          <div class="card-body table-responsive p-0">
            <table class="table table-hover">
                <tbody>
                  <tr>
                    <th>Name</th>
                    <td>{{$user->firstname}} {{$user->lastname}}</td>
                  </tr>
                  <tr>
                    <th>Email</th>
                    <td>{{$user->email}}</td>
                  </tr>
                  <tr>
                    <th>Mobile Number</th>
                    <td>{{empty($user->mobilenumber) ? '-' : $user->mobilenumber}}</td>
                  </tr>
                  <tr>
                    <th>Role</th>
                    <td>{{$user->role == 1 ? 'Super Admin' : ($user->role == 2 ? 'Admin' : 'User')}}</td>
                  </tr>
                  <tr>
                    <th>Categories</th>
                    <td>{{ implode(', ', $categories_names) }}</td>
                  </tr>
                  <tr>
                    <th>Image</th>
                    <td> 
                      <img src="{{ !empty($user->profile_image) && file_exists(public_path() .'/storage/'.$user->profile_image) ? URL::asset('storage'.$user->profile_image) : asset('images/no-image.jpg') }}" width="500" height="500">
                    </td>
                  </tr>
                  <tr>
                    <th></th>
                    <td class="float-right">
                      <a href="{{ route('users.index') }}" class="btn btn-danger create-event-button">Cancel</a>
                    </td>
                  </tr>
                </tbody>
            </table>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
    </div>
  </div><!-- /.container-fluid -->
</section>
<!-- /.content -->
@endsection