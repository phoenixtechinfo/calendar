
@extends('layouts.common')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Colors</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item active">Colors</li>
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
            <h3 class="card-title">Colors list </h3>
            
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
              <a href="{{ route('colors.create') }}" class="btn btn-primary create-event-button">Add New Color</a>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body table-responsive p-0">
            @if($colors->currentPage() <= $colors->lastPage() && $colors->total())
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>
                      <a href="{{Helper::generateURLWithFilter(route('colors.index'),1,'id',(request('sortOrder','asc')=='asc'?'desc':'asc'),request('search'))}}">ID </a>{!! Helper::sortingDesign('id',request('sortBy'),request('sortOrder')) !!}
                  </th>
                  <th>
                      <a href="{{Helper::generateURLWithFilter(route('colors.index'),1,'name',(request('sortOrder','asc')=='asc'?'desc':'asc'),request('search'))}}">Name </a>{!! Helper::sortingDesign('name',request('sortBy'),request('sortOrder')) !!}</th>
                  <th>
                      <a href="{{Helper::generateURLWithFilter(route('colors.index'),1,'hexcode',(request('sortOrder','asc')=='asc'?'desc':'asc'),request('search'))}}">Hexcode </a>{!! Helper::sortingDesign('hexcode',request('sortBy'),request('sortOrder')) !!}
                  </th>
                  <th>
                      <a href="{{Helper::generateURLWithFilter(route('colors.index'),1,'created_for',(request('sortOrder','asc')=='asc'?'desc':'asc'),request('search'))}}">Created For </a>{!! Helper::sortingDesign('created_for',request('sortBy'),request('sortOrder')) !!}
                  </th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($colors as $key => $color)
                    <tr>
                        <td>{{ Helper::listIndex($colors->currentPage(), $colors->perPage(), $key) }}</td>
                        <td>{{$color->name}}</td>
                        <td>{{$color->hexcode}} <i class="fa fa-square" style="color:{{$color->hexcode}}" aria-hidden="true"></i></td>
                        <td>{{$color->created_for}}</td>
                        <td>
                            <div class="row">
                              <a href="{{ route('colors.edit',$color->id) }}" title="Edit" class="col-md-3 padding-0px"><i class="fa fa-edit"></i></a>
                              <form action="{{ route('colors.destroy', $color->id) }}" method="POST" class="col-md-3 padding-0px">
                                @method('DELETE')
                                @csrf
                                <button type="submit" class="btn btn-link padding-0px delete-button" title="Delete Color" onClick="return confirm('Are you sure you want to remove {{ ucfirst($color->name) }} colors ?')"><i class="fa fa-times"></i></button>
                              </form>
                              <form action="{{ route('colors.show', $color->id) }}" method="GET" class="col-md-3 padding-0px">
                                @method('GET')
                                @csrf
                                <button type="submit" class="btn btn-link padding-0px delete-button" title="Show Color"><i class="fa fa-eye"></i></button>
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
            <div class="dataTables_info pagination-info">{{ Helper::paginationSummary($colors->currentPage(), $colors->perPage(), $colors->total()) }}</div>
            {{ $colors->appends(['sortBy' => request('sortBy'), 'sortOrder' => request('sortOrder'), 'search' => request('search')])->links() }}
        </div>
        <!-- /.card -->
      </div>
    </div>
  </div><!-- /.container-fluid -->
</section>
<!-- /.content -->
@endsection