
@extends('layouts.common')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Interested Users</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item active">Interested User Details</li>
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
            <h3 class="card-title">Interested User Details </h3>
            
            <div class="card-tools">
            </div>

          </div>
          <!-- /.card-header -->
          <div class="card-body table-responsive p-0">
            <table class="table table-hover">
                <tbody>
                  <tr>
                    <th>Name</th>
                    <td>{{$user->name}}</td>
                  </tr>
                  <tr>
                    <th>Email</th>
                    <td>{{$user->email}}</td>
                  </tr>
                   <tr>
                    <th>Destination</th>
                    <td>{{$user->destination}}</td>
                  </tr>
                   <tr>
                    <th>Contact Number</th>
                    <td>{{$user->contact_no}}</td>
                  </tr>
                   <tr>
                    <th>Departure City</th>
                    <td>{{$user->departure_city}}</td>
                  </tr>
                   <tr>
                    <th>Departure Date</th>
                    <td>{{\Carbon\Carbon::parse($user->departure_date)->format('d-m-Y')}}</td>
                  </tr>
                   <tr>
                    <th>Budget Per Person</th>
                    <td>{{$user->budget_per_person}}</td>
                  </tr>
                   <tr>
                    <th>No Of Person</th>
                    <td>{{$user->no_of_person}}</td>
                  </tr>
                  <tr>
                    <th></th>
                    <td>
                      <a href="{{ route('interested-users.index') }}" class="btn btn-danger create-event-button">Cancel</a>
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