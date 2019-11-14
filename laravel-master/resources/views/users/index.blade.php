
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
                    <li class="breadcrumb-item active">Users</li>
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
            <h3 class="card-title">Users list </h3>
            
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
              <a href="{{ route('users.create') }}" class="btn btn-primary create-event-button">Create New User</a>
            </div>

          </div>
          <!-- /.card-header -->
          <div class="card-body table-responsive p-0">
            @if($users->currentPage() <= $users->lastPage() && $users->total())
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>
                      <a href="{{Helper::generateURLWithFilter(route('users.index'),1,'id',(request('sortOrder','asc')=='asc'?'desc':'asc'),request('search'))}}">ID </a>{!! Helper::sortingDesign('id',request('sortBy'),request('sortOrder')) !!}
                  </th>
                  <th>
                      <a href="{{Helper::generateURLWithFilter(route('users.index'),1,'name',(request('sortOrder','asc')=='asc'?'desc':'asc'),request('search'))}}">Name </a>{!! Helper::sortingDesign('name',request('sortBy'),request('sortOrder')) !!}</th>
                    <th>
                      <a href="{{Helper::generateURLWithFilter(route('users.index'),1,'email',(request('sortOrder','asc')=='asc'?'desc':'asc'),request('search'))}}">Email </a>{!! Helper::sortingDesign('email',request('sortBy'),request('sortOrder')) !!}</th>
                  <th>
                      <a href="{{Helper::generateURLWithFilter(route('users.index'),1,'role',(request('sortOrder','asc')=='asc'?'desc':'asc'),request('search'))}}">Role </a>{!! Helper::sortingDesign('role',request('sortBy'),request('sortOrder')) !!}
                  </th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($users as $key => $user)
                    <tr>
                        <td>{{ Helper::listIndex($users->currentPage(), $users->perPage(), $key) }}</td>
                        <td>{{ $user->firstname }} {{ $user->lastname }}</td>
                        <td>{{$user->email}}</td>
                        <td>{{$user->role == 1 ? 'Super Admin' : ($user->role == 2 ? 'Admin' : 'User')}}</td>
                        <td>
                            <div class="row">
                              <a href="{{ route('users.edit',$user->id) }}" title="Edit" class="col-md-3 padding-0px"><i class="fa fa-edit"></i></a>
                              <form action="{{ route('users.destroy',$user->id) }}" method="POST" class="col-md-3 padding-0px">
                                @method('DELETE')
                                @csrf
                                <button type="submit" class="btn btn-link padding-0px delete-button" title="Delete User" onClick="return confirm('Are you sure you want to remove {{ ucfirst($user->firstname) }} user ?')"><i class="fa fa-times"></i></button>
                              </form>
                              <form action="{{ route('users.show',$user->id) }}" method="GET" class="col-md-3 padding-0px">
                                @method('GET')
                                @csrf
                                <button type="submit" class="btn btn-link padding-0px delete-button" title="Show User"><i class="fa fa-eye"></i></button>
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
            <div class="dataTables_info pagination-info">{{ Helper::paginationSummary($users->currentPage(), $users->perPage(), $users->total()) }}</div>
            {{ $users->appends(['sortBy' => request('sortBy'), 'sortOrder' => request('sortOrder'), 'search' => request('search')])->links() }}
        </div>
        <!-- /.card -->
      </div>
    </div>
  </div><!-- /.container-fluid -->
</section>
<!-- /.content -->
@endsection