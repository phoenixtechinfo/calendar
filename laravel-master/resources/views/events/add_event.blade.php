@extends('layouts.common')
@section('content')
<!-- Content Header (Page header) -->

<section class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
        <h1>Create Event Form</h1>
        </div>
        <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active">create event</li>
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
                <h3 class="card-title">Event Creation</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-remove"></i></button>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <form class="cmxform edit-profile-form form-horizontal form-label-left" id="createEventForm" method="POST" action="{{ route('events.store') }}" enctype="multipart/form-data" >
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Title</label>
                                <input id="title" class="form-control  @error('title') is-invalid @enderror" name="title" type="text" value="{{ old('title') }}"   placeholder="Title" >
                                @error('title')
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
                                <label>Description</label>
                                <textarea id="description" class="form-control  @error('description') is-invalid @enderror" name="description" type="text"  required="required" placeholder="Description" >{{ old('description') }}</textarea>
                                @error('description')
                                    <span class="invalid-feedback has-error" role="alert">
                                    <strong class="help-block">{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Date and time range:</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                    </div>
                                    <input type="text" class="form-control col-md-12 @error('datetime') is-invalid @enderror" name="datetime" type="text" value="{{ old('datetime') }}"  required="required"  class="form-control float-right" id="reservationtime">
                                    @error('datetime')
                                        <span class="invalid-feedback has-error" role="alert">
                                        <strong class="help-block">{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            <!-- /.input group -->
                            <label id="reservationtime-error" class="error" for="reservationtime"></label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Categories</label>
                                <select class="select2" name="category[]" multiple="multiple" data-placeholder="Select Categories" style="width: 100%;">
                                    @foreach($categories as $key => $category)
                                        <option value = "{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                @error('category')
                                    <span class="invalid-feedback has-error" role="alert">
                                    <strong class="help-block">{{ $message }}</strong>
                                    </span>
                                @enderror
                            <!-- /.input group -->
                                <label id="category[]-error" class="error" for="category[]"></label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Contact Number</label>
                                <input id="contact_number" class="form-control  @error('contact_number') is-invalid @enderror" name="contact_number" type="text" value="{{ old('contact_number') }}"  required="required" placeholder="Contact Number" >
                                @error('contact_number')
                                    <span class="invalid-feedback has-error" role="alert">
                                    <strong class="help-block">{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Color</label>
                                <select id="color_id" class="form-control  @error('color_id') is-invalid @enderror" name="color_id" value="{{ old('color_id') }}" style="width: 100%;">
                                    @foreach($colors as $key => $color)
                                        <option value="{{ $color->id }}">{{ $color->name }}</option>
                                    @endforeach
                                </select>
                                @error('color_id')
                                    <span class="invalid-feedback has-error" role="alert">
                                    <strong class="help-block">{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <!-- /.form-group -->
                        <!-- /.form-group -->
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label>Interester in</label>&nbsp&nbsp
                            <input type="checkbox" name="interested" checked data-bootstrap-switch>
                        </div>
                    </div><br><br>
                    <div class="row">
                        <div class="col-md-3 imgUp">
                            <div class="imagePreview"></div>
                        <label class="btn img-btn">Upload<input type="file" name="image" class="uploadFile img" value="Upload Photo" style="width: 0px;height: 0px;overflow: hidden;">
                        </label>
                        </div><!-- col-2 -->
                        @error('image')
                            <span class="invalid-feedback has-error" role="alert" style="display:block">
                                <strong class="help-block">{{ $message }}</strong>
                                </span>
                            @enderror
                    </div>    
                    <input type="hidden" class="start_date" name="start_date" value="">
                    <input type="hidden" class="end_date" name="end_date" value="">
                    <div class="row" style="margin-top:15px;">
                        <div class="col-md-6  float-right">
                            <button class="btn btn-success" id="send" type="submit">Save</button>
                            <a href="{{ route('events.index') }}" class="btn btn-danger create-user-button">Cancel</a>
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
    $('#reservationtime').daterangepicker({
      timePicker: true,
      timePicker24Hour: true,
      startDate: moment().startOf('hour'),
      buttonClasses: ['btn btn-success apply-btn'],
      locale: {
        format: 'MM/DD/YYYY hh:mm A'
      }
    });
    $( "#reservationtime" ).val('');
    $('#reservationtime').on('hide.daterangepicker', function(ev, picker) {
        var startDate = picker.startDate;
        var endDate = picker.endDate;
        $('.start_date').val(startDate);
        $('.end_date').val(endDate);
    });
    
    //Initialize Select2 Elements
    $('.select2').select2()

    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })

    $("input[data-bootstrap-switch]").each(function(){
      $(this).bootstrapSwitch('state', $(this).prop('checked'));
    });

    // validate signup form on keyup and submit
    $("#createEventForm").validate({
            rules: {
                title: {
                    required : true
                },
                description: {
                    required : true
                },
                color_id: {
                    required: true,
                },
                contact_number: {
                    required: true,
                },
                datetime: {
                    required: true,
                },
                'category[]': {
                    required: true
                },
            },
            messages: {
                title: {
                    required: "Please enter the title",
                },
                description: {
                    required: "Please enter the description",
                },
                color_id: {
                    required: "Please choose the color"
                },
                contact_number: {
                    required: "Please enter the contact numner"
                },
                datetime: {
                    required: "Please select the event duration",
                },
                'category[]': {
                    required: "Please select the categories",
                },
            }
        });

    $(document).on("change",".uploadFile", function()
    {
    		var uploadFile = $(this);
        var files = !!this.files ? this.files : [];
        if (!files.length || !window.FileReader) return; // no file selected, or no FileReader support
        if (/^image/.test( files[0].type)){ // only image file
            var reader = new FileReader(); // instance of the FileReader
            reader.readAsDataURL(files[0]); // read the local file
 
            reader.onloadend = function(){ // set image data as background of div
                //alert(uploadFile.closest(".upimage").find('.imagePreview').length);
                uploadFile.closest(".imgUp").find('.imagePreview').css("background-image", "url("+this.result+")");
            }
        }
    });
  })
</script>
@endpush