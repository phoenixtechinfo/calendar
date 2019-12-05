
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
                    <li class="breadcrumb-item active">Events</li>
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
            <h3 class="card-title">Events list </h3>
            
            <div class="card-tools">
            <form action="" method="get">
              <input type="hidden" value="0" name="page"/>
              <input type="hidden" value="{{request('sortBy')}}" name="sortBy"/>
              <input type="hidden" value="{{request('sortOrder')}}" name="sortOrder"/>
              <div class="input-group input-group-sm" style="width: 150px;">
                <input type="text" name="search" class="form-control float-right" placeholder="Search" value="{{ request('search') }}">

                <div class="input-group-append">
                  <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                </div>
              </div>
              </form>
              <a href="{{ route('events.create') }}" class="btn btn-primary create-event-button">Create New Event</a>
            </div>

          </div>
          <!-- /.card-header -->
          <div class="card-body table-responsive p-0">
            @if($events->currentPage() <= $events->lastPage() && $events->total())
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>
                      <a href="{{Helper::generateURLWithFilter(route('events.index'),1,'id',(request('sortOrder','asc')=='asc'?'desc':'asc'),request('search'))}}">ID </a>{!! Helper::sortingDesign('id',request('sortBy'),request('sortOrder')) !!}
                  </th>
                  <th>
                      <a href="{{Helper::generateURLWithFilter(route('events.index'),1,'title',(request('sortOrder','asc')=='asc'?'desc':'asc'),request('search'))}}">Title </a>{!! Helper::sortingDesign('title',request('sortBy'),request('sortOrder')) !!}</th>
                  <th>
                      <a href="{{Helper::generateURLWithFilter(route('events.index'),1,'description',(request('sortOrder','asc')=='asc'?'desc':'asc'),request('search'))}}">Description </a>{!! Helper::sortingDesign('description',request('sortBy'),request('sortOrder')) !!}
                  </th>
                  <th>
                      <a href="{{Helper::generateURLWithFilter(route('events.index'),1,'start_datetime',(request('sortOrder','asc')=='asc'?'desc':'asc'),request('search'))}}">Start Datetime </a>{!! Helper::sortingDesign('start_datetime',request('sortBy'),request('sortOrder')) !!}</th>
                  <th>
                      <a href="{{Helper::generateURLWithFilter(route('events.index'),1,'end_datetime',(request('sortOrder','asc')=='asc'?'desc':'asc'),request('search'))}}">End Datetime </a>{!! Helper::sortingDesign('end_datetime',request('sortBy'),request('sortOrder')) !!}
                  </th>
                  <th>
                      <a href="{{Helper::generateURLWithFilter(route('events.index'),1,'created_by',(request('sortOrder','asc')=='asc'?'desc':'asc'),request('search'))}}">Created by </a>{!! Helper::sortingDesign('created_by',request('sortBy'),request('sortOrder')) !!}</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($events as $key => $event)
                    <tr>
                        <td>{{ Helper::listIndex($events->currentPage(), $events->perPage(), $key) }}</td>
                        <td>{{$event->title}}</td>
                        <td>{{$event->description}}</td>
                        <td>{{\Carbon\Carbon::parse($event->start_datetime)->format('d-m-Y H:i:s')}}</td>
                        <td>{{\Carbon\Carbon::parse($event->end_datetime)->format('d-m-Y H:i:s')}}</td>
                        <td>{{$event->user->firstname}}</td>
                        <td>
                            <div class="row">
                              <a href="{{ route('events.edit',$event->id) }}" title="Edit" class="col-md-3 padding-0px"><i class="fa fa-edit"></i></a>
                              <form action="{{ route('events.destroy',$event->id) }}" method="POST" class="col-md-3 padding-0px">
                                @method('DELETE')
                                @csrf
                                <button type="submit" class="btn btn-link padding-0px delete-button" title="Delete Event" onClick="return confirm('Are you sure you want to remove {{ ucfirst($event->title) }} event ?')"><i class="fa fa-times"></i></button>
                              </form>
                              <form action="{{ route('events.show',$event->id) }}" method="GET" class="col-md-3 padding-0px">
                                @method('GET')
                                @csrf
                                <button type="submit" class="btn btn-link padding-0px delete-button" title="Show Event"><i class="fa fa-eye"></i></button>
                              </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
              </tbody>
            </table>
            @else
                No Record Found
            @endif
          </div>
          <!-- /.card-body -->
        </div>
        <div class="pagination-section">
            <div class="dataTables_info pagination-info">{{ Helper::paginationSummary($events->currentPage(), $events->perPage(), $events->total()) }}</div>
            {{ $events->appends(['sortBy' => request('sortBy'), 'sortOrder' => request('sortOrder'), 'search' => request('search')])->links() }}
        </div>
        <!-- /.card -->
      </div>
    </div>
  </div><!-- /.container-fluid -->
</section>
<!-- /.content -->
@endsection