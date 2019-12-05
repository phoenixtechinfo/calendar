@extends('layouts.common')
@push('styles')
<style>
    .imagePreview {
    width: 100%;
    height: 180px;
    background-position: center center;
  background:url(http://cliquecities.com/assets/no-image-e3699ae23f866f6cbdf8ba2443ee5c4e.jpg);
  background-color:#fff;
    background-size: cover;
  background-repeat:no-repeat;
    display: inline-block;
  box-shadow:0px -3px 6px 2px rgba(0,0,0,0.2);
}
.img-btn
{
  display:block;
  border-radius:0px;
  box-shadow:0px 4px 6px 2px rgba(0,0,0,0.2);
  margin-top:-5px;
  background-color: #007bff;
}
.imgUp
{
  margin-bottom:15px;
}
.del
{
  position:absolute;
  top:0px;
  right:15px;
  width:30px;
  height:30px;
  text-align:center;
  line-height:30px;
  background-color:rgba(255,255,255,0.6);
  cursor:pointer;
}
.imgAdd
{
  width:30px;
  height:30px;
  border-radius:50%;
  background-color:#4bd7ef;
  color:#fff;
  box-shadow:0px 0px 2px 1px rgba(0,0,0,0.2);
  text-align:center;
  line-height:30px;
  margin-top:0px;
  cursor:pointer;
  font-size:15px;
}
.custom-err {
    color: #E74C3C;
    font-size: 13px;
    font-weight: 400
}
</style>
@endpush
@section('content')
<!-- Content Header (Page header) -->

<section class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
        <h1>Create Banner Form</h1>
        </div>
        <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active">Create Banner</li>
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
                <h3 class="card-title">Banner Creation</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-remove"></i></button>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <form class="cmxform edit-profile-form form-horizontal form-label-left" id="createBannerForm" method="POST" action="{{ route('banners.store') }}" enctype="multipart/form-data" >
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
                                <textarea id="description" class="form-control  @error('description') is-invalid @enderror" name="description" type="text"  placeholder="Description" >{{ old('description') }}</textarea>
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
                                <label>Month</label>
                                <select id="month" class="form-control  @error('month') is-invalid @enderror" name="month" value="{{ old('month') }}" style="width: 100%;">
                                    <option value="january" selected="selected">January</option>
                                    <option value="february">February</option>
                                    <option value="march">March</option>
                                    <option value="april">April</option>
                                    <option value="may">May</option>
                                    <option value="june">June</option>
                                    <option value="july">July</option>
                                    <option value="august">August</option>
                                    <option value="september">September</option>
                                    <option value="october">October</option>
                                    <option value="november">November</option>
                                    <option value="december">December</option>
                                </select>
                                @error('month')
                                    <span class="invalid-feedback has-error" role="alert">
                                    <strong class="help-block">{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Year</label>
                                <input id="year" class="form-control  @error('year') is-invalid @enderror" name="year" type="text" value="{{ old('year') }}"   placeholder="year" >
                                @error('year')
                                    <span class="invalid-feedback has-error" role="alert">
                                    <strong class="help-block">{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <!-- /.form-group -->
                        <!-- /.form-group -->
                    </div><br><br>
                    <label id="image-error" class="custom-err error" for="image"></label>
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
                            <a href="{{ route('banners.index') }}" class="btn btn-danger create-user-button">Cancel</a>
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
    $("#createBannerForm").validate({
            rules: {
                title: {
                    required : true
                },
                description: {
                    required : true
                },
                month: {
                    required: true,
                },
                year: {
                    required: true,
                },
                image: {
                    required: true,
                },
            },
            messages: {
                title: {
                    required: "Please enter the title",
                },
                description: {
                    required: "Please enter the description",
                },
                month: {
                    required: "Please choose the month"
                },
                year: {
                    required: "Please enter the year in 4 digit"
                },
                image: {
                    required: "Please select the image",
                }
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