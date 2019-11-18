@extends('layouts.common')
@section('content')
<!-- Content Header (Page header) -->

<section class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
        <h1>Edit Color Form</h1>
        </div>
        <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active">Edit Color</li>
        </ol>
        </div>
    </div>
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <!-- SELECT2 EXAMPLE -->
        <div class="card card-default">
            <div class="card-header">
                <h3 class="card-title">Colors</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-remove"></i></button>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <form class="cmxform form-horizontal form-label-left" id="editColorForm" method="POST" action="{{ route('colors.update', $color->id) }}" enctype="multipart/form-data" >
                    @method('PATCH') 
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>name</label>
                                <input id="name" class="form-control  @error('name') is-invalid @enderror" name="name" type="text" value="{{ $color->name }}"   placeholder="Name" >
                                @error('name')
                                    <span class="invalid-feedback has-error" role="alert">
                                    <strong class="help-block">{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Role</label>
                                <select id="created_for" class="form-control  @error('created_for') is-invalid @enderror" name="created_for" value="{{ old('created_for') }}" style="width: 100%;">
                                    @if(Auth::user()->role == 1)
                                        <option value="super admin" {{ $color->created_for == "super admin" ? 'selected="selected"' : '' }}>Super Admin</option>
                                    @endif
                                    <option value="admin" {{ $color->created_for == "admin" ? 'selected="selected"' : '' }}>Admin</option>
                                    <option value="user" {{ $color->created_for == "user" ? 'selected="selected"' : '' }}>User</option>
                                </select>
                                @error('created_for')
                                    <span class="invalid-feedback has-error" role="alert">
                                    <strong class="help-block">{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Hexcode</label> 
                                <input id="hexcode color3" class="form-control colorpicker  @error('hexcode') is-invalid @enderror" name="hexcode" type="text" value="{{ $color->hexcode }}"   placeholder="Hexcode" >
                                @error('hexcode')
                                    <span class="invalid-feedback has-error" role="alert">
                                    <strong class="help-block">{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row" style="margin-top:15px;">
                        <div class="col-md-6  float-right">
                            <button class="btn btn-success" id="send" type="submit">Save</button>
                            <a href="{{ route('colors.index') }}" class="btn btn-danger create-user-button">Cancel</a>
                        </div>
                    </div>
                </form>
                </div>
            </div>
        </div>
</section>
<!-- /.content -->
@endsection
@push('scripts')
<script>
  $(function () {

    var colorpickers = KellyColorPicker.attachToInputByClass('colorpicker', {alpha_slider : true, size : 200});	
    // validate signup form on keyup and submit
    $("#editColorForm").validate({
            rules: {
                name: {
                    required : true
                },
                hexcode: {
                    required : true
                },
                created_for: {
                    required : true
                }
            },
            messages: {
                name: {
                    required: "Please enter the name",
                },
                hexcode: {
                    required: "Please enter the hexcode",
                },
                created_for: {
                    required: "Please select the option",
                }
            }
        });
  })
</script>
@endpush