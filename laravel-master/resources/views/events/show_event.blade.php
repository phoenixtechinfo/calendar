
@extends('layouts.common')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Events</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item active">Events Details</li>
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
            <h3 class="card-title">Event Details </h3>
            
            <div class="card-tools">
            </div>

          </div>
          <!-- /.card-header -->
          <div class="card-body table-responsive p-0">
            <table class="table table-hover">
                <tbody>
                  <tr>
                    <th>Title</th>
                    <td>{{$event->title}}</td>
                  </tr>
                  <tr>
                    <th>Description</th>
                    <td>{{$event->description}}</td>
                  </tr>
                  <tr>
                    <th>Start Datetime</th>
                    <td>{{ \Carbon\Carbon::parse($event->start_datetime)->format('d-m-Y H:i:s') }}</td>
                  </tr>
                  <tr>
                    <th>End Datetime</th>
                    <td>{{ \Carbon\Carbon::parse($event->end_datetime)->format('d-m-Y H:i:s') }}</td>
                  </tr>
                  <tr>
                    <th>Categories</th>
                    <td>{{  implode(', ', $categories_names) }}</td>
                  </tr>
                  <tr>
                    <th>Color</th>
                    <td>{{ $event->color->name }} <i class="fa fa-square" style="color:{{ $event->color->hexcode}}" aria-hidden="true"></i></td>
                  </tr>
                  <tr>
                    <th>Contact number</th>
                    <td>{{!empty($event->contact_no) ? $event->contact_no : '-'}}</td>
                  </tr>
                  <tr>
                    <th>created by</th>
                    <td>{{$event->user->firstname}} {{$event->user->lastname}}</td>
                  </tr>
                  <tr>
                    <th>Image</th>
                    <td> 
                      <img src="{{ !empty($event->image) && file_exists(public_path() .'/storage/'.$event->image) ? URL::asset('storage'.$event->image) : asset('images/no-image.jpg') }}" width="500" height="500">
                    </td>
                  </tr>
                  <tr>
                    <th></th>
                    <td class="float-right">
                      <a href="{{ route('events.index') }}" class="btn btn-danger create-event-button">Cancel</a>
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