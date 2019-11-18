
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
                    <li class="breadcrumb-item active">Banners</li>
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
            <h3 class="card-title">Banners list </h3>
            
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
              <a href="{{ route('banners.create') }}" class="btn btn-primary create-event-button">Create New Banner</a>
            </div>

          </div>
          <!-- /.card-header -->
          <div class="card-body table-responsive p-0">
            @if($banners->currentPage() <= $banners->lastPage() && $banners->total())
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>
                      <a href="{{Helper::generateURLWithFilter(route('banners.index'),1,'id',(request('sortOrder','asc')=='asc'?'desc':'asc'),request('search'))}}">ID </a>{!! Helper::sortingDesign('id',request('sortBy'),request('sortOrder')) !!}
                  </th>
                  <th>
                      <a href="{{Helper::generateURLWithFilter(route('banners.index'),1,'title',(request('sortOrder','asc')=='asc'?'desc':'asc'),request('search'))}}">Title </a>{!! Helper::sortingDesign('title',request('sortBy'),request('sortOrder')) !!}</th>
                  <th>
                      <a href="{{Helper::generateURLWithFilter(route('banners.index'),1,'description',(request('sortOrder','asc')=='asc'?'desc':'asc'),request('search'))}}">Description </a>{!! Helper::sortingDesign('description',request('sortBy'),request('sortOrder')) !!}
                  </th>
                  <th>
                      <a href="{{Helper::generateURLWithFilter(route('banners.index'),1,'month',(request('sortOrder','asc')=='asc'?'desc':'asc'),request('search'))}}">Month </a>{!! Helper::sortingDesign('month',request('sortBy'),request('sortOrder')) !!}
                  </th>
                  <th>
                      <a href="{{Helper::generateURLWithFilter(route('banners.index'),1,'year',(request('sortOrder','asc')=='asc'?'desc':'asc'),request('search'))}}">Year </a>{!! Helper::sortingDesign('year',request('sortBy'),request('sortOrder')) !!}
                  </th>
                  <th>
                      <a href="{{Helper::generateURLWithFilter(route('banners.index'),1,'created_by',(request('sortOrder','asc')=='asc'?'desc':'asc'),request('search'))}}">Created by </a>{!! Helper::sortingDesign('created_by',request('sortBy'),request('sortOrder')) !!}</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($banners as $key => $banner)
                    <tr>
                        <td>{{ Helper::listIndex($banners->currentPage(), $banners->perPage(), $key) }}</td>
                        <td>{{$banner->title}}</td>
                        <td>{{$banner->description}}</td>
                        <td>{{$banner->month}}</td>
                        <td>{{$banner->year}}</td>
                        <td>{{$banner->user->firstname}}</td>
                        <td>
                            <div class="row">
                              <a href="{{ route('banners.edit',$banner->id) }}" title="Edit" class="col-md-3 padding-0px"><i class="fa fa-edit"></i></a>
                              <form action="{{ route('banners.destroy',$banner->id) }}" method="POST" class="col-md-3 padding-0px">
                                @method('DELETE')
                                @csrf
                                <button type="submit" class="btn btn-link padding-0px delete-button" title="Delete Event" onClick="return confirm('Are you sure you want to remove {{ ucfirst($banner->title) }} banner ?')"><i class="fa fa-times"></i></button>
                              </form>
                              <form action="{{ route('banners.show',$banner->id) }}" method="GET" class="col-md-3 padding-0px">
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
            <div class="dataTables_info pagination-info">{{ Helper::paginationSummary($banners->currentPage(), $banners->perPage(), $banners->total()) }}</div>
            {{ $banners->appends(['sortBy' => request('sortBy'), 'sortOrder' => request('sortOrder'), 'search' => request('search')])->links() }}
        </div>
        <!-- /.card -->
      </div>
    </div>
  </div><!-- /.container-fluid -->
</section>
<!-- /.content -->
@endsection