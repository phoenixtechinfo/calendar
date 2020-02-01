@extends('layouts.common')
@section('content')
<!-- Content Header (Page header) -->

<section class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
        <h1>Edit Event Form</h1>
        </div>
        <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active">edit event</li>
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
                <h3 class="card-title">Event Edition</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-remove"></i></button>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <form class="cmxform edit-profile-form form-horizontal form-label-left" id="editEventForm" method="post" action="{{ route('events.update', $events->id) }}" enctype="multipart/form-data" >
                    @method('PATCH') 
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Title</label>
                                <input id="title" class="form-control  @error('title') is-invalid @enderror" name="title" type="text" value="{{$events->title}}"   placeholder="Title" >
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
                                <textarea id="description" class="form-control  @error('description') is-invalid @enderror" name="description" type="text"  required="required" placeholder="Description" >{{$events->description}}</textarea>
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
                                <select class="select2" name="category[]" multiple="multiple" value="[1]" data-placeholder="Select Categories" style="width: 100%;">
                                    @foreach($categories as $key => $category)
                                        <option value = "{{ $category->id }}" {{ in_array($category->id, $selected_categories) ? "selected='selected'":"" }}>
                                            {{ $category->name }}
                                        </option>
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
                                <input id="contact_number" class="form-control  @error('contact_number') is-invalid @enderror" name="contact_number" type="text" value="{{ $events->contact_no }}"   placeholder="Contact Number" >
                                @error('contact_number')
                                    <span class="invalid-feedback has-error" role="alert">
                                    <strong class="help-block">{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
						<div class="col-md-6">
                            <div class="form-group">
                               <label>Whatsapp Number</label>
                                <input id="whatsapp" class="form-control  @error('whatsapp') is-invalid @enderror" name="whatsapp" type="text" value="{{ $events->whatsapp }}"   placeholder="Whatsapp Number" >
                                @error('whatsapp')
                                    <span class="invalid-feedback has-error" role="alert">
                                    <strong class="help-block">{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
						<div class="col-md-6">
                            <div class="form-group">
                                <label>Messenger</label>
                                <input id="messenger" class="form-control  @error('messenger') is-invalid @enderror" name="messenger" type="text" value="{{ $events->messenger }}"   placeholder="Messenger Number" >
                                @error('messenger')
                                    <span class="invalid-feedback has-error" role="alert">
                                    <strong class="help-block">{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
						<div class="col-md-6">
                            <div class="form-group">
                                <label>Email</label>
                                <input id="email" class="form-control  @error('email') is-invalid @enderror" name="email" type="text" value="{{ $events->email }}"   placeholder="Email" >
                                @error('email')
                                    <span class="invalid-feedback has-error" role="alert">
                                    <strong class="help-block">{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Color</label>
                                <select id="color_id" class="form-control  @error('color_id') is-invalid @enderror" name="color_id" value="{{ $events->color_id }}" style="width: 100%;">
                                    @foreach($colors as $key => $color)
                                        <option value="{{ $color->id }}" style="color: {{ $color->hexcode }}; font-weight: bold" {{$events->color_id == $color->id ? 'selected="selected"' : ''}}>{{ $color->name }}</option>
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
                            <label>Script</label>
                            <textarea id="script" class="form-control  @error('script') is-invalid @enderror" name="script" type="text" value="{{ old('script') }}" placeholder="Script" >{{ $events->script }}</textarea>
                                @error('script')
                                    <span class="invalid-feedback has-error" role="alert">
                                    <strong class="help-block">{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
                    </div><br>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Show Interested Button</label>
                                <select name="show_interested" class="form-control" style="width: 100%;">
                                    <option value="0" {{$events->show_interested_btn == '0' ? 'selected="selected"' : ''}}>No</option>
                                    <option value="1" {{$events->show_interested_btn == '1' ? 'selected="selected"' : ''}}>Yes</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <br>
                    <!-- <div class="row">
                        <div class="col-md-12">
                            <label>Interester in</label>&nbsp&nbsp
                            <input type="checkbox" name="interested" {{$events->interested_flag == 1 ? 'checked' : ''}} data-bootstrap-switch>
                        </div>
                    </div><br><br> -->
                    <div class="row">
                        <div class="col-md-3 imgUp">
                            <div class="imagePreview">
                            </div>
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
    @php
        if($events->image != null && file_exists(public_path() .'/storage/'.$events->image)) {
            $result = URL::asset('storage'.$events->image);
        } else {
            $result = asset('images/no-image.jpg');
        }
    @endphp
    $('.uploadFile').closest(".imgUp").find('.imagePreview').css("background-image", "url({{$result}}");
    $('#reservationtime').daterangepicker({
      timePicker: true,
      timePicker24Hour: true,
      startDate: moment('{{$events->start_datetime}}'),
      endDate: moment('{{$events->end_datetime}}'),
      buttonClasses: ['btn btn-success apply-btn'],
      locale: {
        format: 'DD/MM/YYYY hh:mm:ss a'
      }
    });
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
    $("#editEventForm").validate({
            rules: {
                title: {
                    required : true
                },
                description: {
                    required : false
                },
                color_id: {
                    required: true,
                },
                contact_number: {
                    required: false,
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