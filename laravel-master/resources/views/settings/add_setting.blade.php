@extends('layouts.common')
@section('content')
<!-- Content Header (Page header) -->

<section class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
        <h1>Add Setting Form</h1>
        </div>
        <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active">Add Setting</li>
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
                <h3 class="card-title">Settings</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-remove"></i></button>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <form class="cmxform edit-profile-form form-horizontal form-label-left" id="addSettingForm" method="POST" action="{{ route('settings.store') }}" enctype="multipart/form-data" >
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Key</label>
                                <input id="key" class="form-control  @error('key') is-invalid @enderror" name="key" type="text" value="{{ old('key') }}"   placeholder="Key" >
                                @error('key')
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
                                <label>Value</label>
                                <textarea id="value" class="form-control  @error('value') is-invalid @enderror" name="value" type="text"  placeholder="value" >{{ old('value') }}</textarea>
                                @error('value')
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
                            <a href="{{ route('settings.index') }}" class="btn btn-danger create-user-button">Cancel</a>
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

    // validate signup form on keyup and submit
    $("#addSettingForm").validate({
            rules: {
                key: {
                    required : true
                },
                value: {
                    required : true
                }
            },
            messages: {
                key: {
                    required: "Please enter the key",
                },
                value: {
                    required: "Please enter the value",
                }
            }
        });
  })
</script>
@endpush