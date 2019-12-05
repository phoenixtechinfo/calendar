@extends('layouts.common')
@section('content')
<!-- Content Header (Page header) -->

<section class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
        <h1>Edit User Form</h1>
        </div>
        <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active">Edit User</li>
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
                <h3 class="card-title">User Edition</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-remove"></i></button>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <form class="cmxform edit-profile-form form-horizontal form-label-left" id="editUserForm" method="POST" action="{{ route('users.update', $user->id) }}" enctype="multipart/form-data" >
                    @method('PATCH') 
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>First Name</label>
                                <input id="firstname" class="form-control  @error('firstname') is-invalid @enderror" name="firstname" type="text" value="{{ $user->firstname }}"   placeholder="First Name" >
                                @error('firstname')
                                    <span class="invalid-feedback has-error" role="alert">
                                    <strong class="help-block">{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Last Name</label>
                                <input id="lastname" class="form-control  @error('lastname') is-invalid @enderror" name="lastname" type="text" value="{{ $user->lastname }}"   placeholder="Last Name" >
                                @error('lastname')
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
                                <label>Email</label>
                                <input id="email" class="form-control  @error('email') is-invalid @enderror" name="email" type="text"  placeholder="Email" value="{{ $user->email }}">
                                @error('email')
                                    <span class="invalid-feedback has-error" role="alert">
                                    <strong class="help-block">{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Mobile Number</label>
                                <input id="mobilenumber" class="form-control  @error('mobilenumber') is-invalid @enderror" name="mobilenumber" type="number"  placeholder="Mobile Number" value="{{ $user->mobilenumber }}" />
                                @error('mobilenumber')
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
                                <label>Role</label>
                                <select id="color" class="form-control  @error('role') is-invalid @enderror" name="role" style="width: 100%;">
                                    @if(Auth::user()->role == 1)
                                        <option value="1" {{ $user->role == 1 ? 'selected="selected"' : '' }}>Super Admin</option>
                                    @endif
                                    <option value="2" {{ $user->role == 2 ? 'selected="selected"' : '' }}>Admin</option>
                                    <option value="3" {{ $user->role == 3 ? 'selected="selected"' : '' }}>User</option>
                                </select>
                                @error('color')
                                    <span class="invalid-feedback has-error" role="alert">
                                    <strong class="help-block">{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Categories</label>
                                <select class="select2" id="select_category" name="category[]" multiple="multiple" value="[1]" data-placeholder="Select Categories" style="width: 100%;">
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
                                <label>Password</label><a id="popoverData" class="btn float-right" href="#" data-content='Atleast 1 Uppercase<br/>Atleast 1 Lowercase<br>Atleast 1 Special Character<br>Atleast 1 digit<br>8-16 Characters' rel="popover" data-placement="left" data-html="true" data-trigger="hover"><i class="fa fa-info-circle " aria-hidden="true"></i></a>
                                <input id="password" class="form-control  @error('password') is-invalid @enderror" name="password" type="password"  placeholder="Password" >
                                @error('password')
                                    <span class="invalid-feedback has-error" role="alert">
                                    <strong class="help-block">{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Confirm Password</label>
                                <input id="password_confirmation" class="form-control  @error('password_confirmation') is-invalid @enderror" name="password_confirmation" type="password" placeholder="Confirm Password" >
                                @error('password_confirmation')
                                    <span class="invalid-feedback has-error" role="alert">
                                    <strong class="help-block">{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                   <br><br>
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
                            <a href="{{ route('users.index') }}" class="btn btn-danger create-user-button">Cancel</a>
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
  $('#popoverData').popover();
  $(function () {
    @php
        if($user->profile_image != null && file_exists(public_path() .'/storage/'.$user->profile_image)) {
            $result = URL::asset('storage'.$user->profile_image);
        } else {
            $result = asset('images/no-image.jpg');
        }
    @endphp
    $('.uploadFile').closest(".imgUp").find('.imagePreview').css("background-image", "url({{$result}}");
    var value = $("#password").val();
    $('.select2').select2()
    $.validator.addMethod("checklower", function(value) {
    return /[a-z]/.test(value);
    });
    $.validator.addMethod("checkupper", function(value) {
    return /[A-Z]/.test(value);
    });
    $.validator.addMethod("checkdigit", function(value) {
    return /[0-9]/.test(value);
    });
    $.validator.addMethod("checkspecialchar", function(value) {
    return /[ !@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/.test(value);
    });
    $.validator.addMethod("checkmobilenumber", function(value) {
        return /^04[0-9]{8}$/.test(value);
    });

    // validate signup form on keyup and submit
        $("#editUserForm").validate({
            rules: {
                firstname: {
                    required : true
                },
                lastname: {
                    required : true
                },
                password: {
                    required: false,
                    minlength: {
                        param: 8, 
                        depends: function(element) {
                          return ($("#password").val() != '');
                        }
                    },
                    maxlength: {
                        param: 16, 
                        depends: function(element) {
                          return ($("#password").val() != '');
                        }
                    },
                    checklower: {
                        depends: function(element) {
                          return ($("#password").val() != '');
                        }
                    },
                    checkupper: {
                        depends: function(element) {
                          return ($("#password").val() != '');
                        }
                    },
                    checkdigit: {
                        depends: function(element) {
                          return ($("#password").val() != '');
                        }
                    },
                    checkspecialchar: {
                        depends: function(element) {
                          return ($("#password").val() != '');
                        }
                    },
                },
                password_confirmation: {
                    required: false,
                    equalTo: "#password"
                },
                email: {
                    required: true,
                    email: true
                },
                mobilenumber: {
                    required : true,
                    maxlength : 10
                },
                'category[]': {
                    required : true
                },
            },
            messages: {
                firstname: {
                    required: "Please enter your firstname",
                },
                lastname: {
                    required: "Please enter your lastname",
                },
                password: {
                    checkspecialchar: "Need atleast 1 special character alphabet",
                    checklower: "Need atleast 1 lowercase alphabet",
                    checkupper: "Need atleast 1 uppercase alphabet",
                    checkdigit: "Need atleast 1 digit"
                },
                password_confirmation: {
                    equalTo: "Please enter the same password as above"
                },
                email: {
                    required: "Please enter a valid email address",
                    email: "Please enter a valid email address"
                },
                mobilenumber: {
                    required: "Please enter your mobile number",
                    minlength: "Please enter 10 digit mobile number",
                },
                'category[]': {
                    required: "Please enter category ",
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