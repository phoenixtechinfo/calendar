@extends('layouts.common')
@push('styles') 
<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.1.0/fullcalendar.min.css' />
@endpush
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
        <h1 class="m-0 text-dark">Dashboard</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active">Dashboard</li>
        </ol>
        </div><!-- /.col -->
    </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
    <!-- Small boxes (Stat box) -->
    <div class="row">
        @if(Auth::user()->role == 1)
            <div class="{{ Auth::user()->role == 1 ? 'col-lg-3' : 'col-lg-4' }} col-6">
            <!-- small box -->
                <div class="small-box bg-info">
                    <div class="inner">
                    <h3>{{ $total_count['total_users'] }}</h3>

                    <p>Available Users</p>
                    </div>
                    <div class="icon">
                    <i class="ion ion-bag"></i>
                    </div>
                    <a href="{{ route('users.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        @endif
        <!-- ./col -->
        <div class="{{ Auth::user()->role == 1 ? 'col-lg-3' : 'col-lg-4' }} col-6">
        <!-- small box -->
            <div class="small-box bg-success">
                <div class="inner">
                <h3>{{ $total_count['total_events'] }}</h3>

                <p>Available Events</p>
                </div>
                <div class="icon">
                <i class="ion ion-stats-bars"></i>
                </div>
                <a href="{{ route('events.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="{{ Auth::user()->role == 1 ? 'col-lg-3' : 'col-lg-4' }} col-6">
        <!-- small box -->
            <div class="small-box bg-warning">
                <div class="inner">
                <h3>{{ $total_count['total_banners'] }}</h3>

                <p>Available Banners</p>
                </div>
                <div class="icon">
                <i class="ion ion-person-add"></i>
                </div>
                <a href="{{ route('banners.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="{{ Auth::user()->role == 1 ? 'col-lg-3' : 'col-lg-4' }} col-6">
        <!-- small box -->
            <div class="small-box bg-success">
                <div class="inner">
                <h3>{{ $total_count['total_category'] }}</h3>

                <p>Available Category</p>
                </div>
                <div class="icon">
                <i class="ion ion-stats-bars"></i>
                </div>
                <a href="{{ route('category.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>
    <!-- /.row -->
    <!-- Main row -->
    <div class="row">
        <!-- Left col -->
        <section class="col-lg-12 connectedSortable">
        <!-- Custom tabs (Charts with tabs)-->
        <div class="card">
            <div class="card-body">
            <div class="tab-content p-0">
            <div id='main_calendar'></div>
            </div>
            </div><!-- /.card-body -->
        </div>
        <!-- /.card -->


       
        <!-- /.card -->
        </section>
        <!-- /.Left col -->
    </div>
    <!-- /.row (main row) -->
    </div><!-- /.container-fluid -->
</section>
<!-- /.content -->
@push('scripts')
<script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.1.0/fullcalendar.min.js'></script>
<script>
    $(document).ready(function() {
        // page is now ready, initialize the calendar...
        $('#main_calendar').fullCalendar({
            // put your options and callbacks here
            events : [
                @foreach($events as $event)
                {
                    title : '{{ $event->title }}',
                    start : new Date('{{ $event->start_datetime }}'),
                    end : new Date('{{ $event->end_datetime }}'),
                    url : '{{ route('events.edit', $event->id) }}',
                    textColor : 'white',
                    color : "{{ $event->color->hexcode }}"
                },
                @endforeach
            ]
        })
    });
</script>
@endpush
@endsection
