
@extends('layouts.common')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Banners</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item active">Banners Details</li>
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
            <h3 class="card-title">Banner Details </h3>
            
            <div class="card-tools">
            </div>

          </div>
          <!-- /.card-header -->
          <div class="card-body table-responsive p-0">
            <table class="table table-hover">
                <tbody>
                  <tr>
                    <th>Title</th>
                    <td>{{$banner->title}}</td>
                  </tr>
                  <tr>
                    <th>Description</th>
                    <td>{{$banner->description}}</td>
                  </tr>
                  <tr>
                    <th>Month</th>
                    <td>{{$banner->month}}</td>
                  </tr>
                  <tr>
                    <th>Year</th>
                    <td>{{$banner->year}}</td>
                  </tr>
                  <tr>
                    <th>created by</th>
                    <td>{{$banner->user->firstname}} {{$banner->user->lastname}}</td>
                  </tr>
                  <tr>
                    <th>Image</th>
                    <td> 
                      <img src="{{ !empty($banner->image) && file_exists(public_path() .'/storage/'.$banner->image) ? URL::asset('storage'.$banner->image) : asset('images/no-image.jpg') }}" width="500" height="500">
                    </td>
                  </tr>
                  <tr>
                    <th></th>
                    <td>
                      <a href="{{ route('banners.index') }}" class="btn btn-danger create-event-button">Cancel</a>
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