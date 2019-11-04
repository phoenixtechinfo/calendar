@extends('layouts.header')
@section('content')
<section class="content">
    <div class="box">
        <div class="box-header">
        </div>
        <div class="box-body">
            <form action="{{action('SettingsController@saveettings')}}" class="form-horizontal" method="post" enctype="multipart/form-data">
                <div class="box-body">
                    <div class="form-group required">
                        <label for="inputEmail3" class="col-sm-2 control-label ">Distance Current Location</label>
                        <div class="col-sm-6">
                            <input type="text" required class="form-control nha-input" name="distance_location" id="compliTokens" value="{{$distance_location}}">
                            <small id="emailHelp" class="form-text text-muted">Distance value input in meter.</small>
                            @if ($errors->has('distance_location'))
                                <div class="error">{{ $errors->first('distance_location') }}</div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="box-body">
                    <div class="form-group required">
                        <label for="inputEmail3" class="col-sm-2 control-label ">Distance User Search Location</label>
                        <div class="col-sm-6">
                            <input type="text" required class="form-control nha-input" name="user_search_location" id="compliTokens" value="{{$user_search_location}}">
                            <small id="emailHelp" class="form-text text-muted">Distance value input in KM.</small>
                            @if ($errors->has('user_search_location'))
                                <div class="error">{{ $errors->first('user_search_location') }}</div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="box-body">
                    <div class="form-group required">
                        <label for="inputEmail3" class="col-sm-2 control-label ">Support Email</label>
                        <div class="col-sm-6">
                            <input type="text" required class="form-control nha-input" name="support_email" id="compliTokens" value="{{$support_email}}">
                            @if ($errors->has('support_email'))
                                <div class="error">{{ $errors->first('support_email') }}</div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="box-body">
                <div class="box-footer">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <button type="submit" class="btn btn-info gene general-bg-btn">Save</button>
                </div>
            </form> 
        </div>
    </div>
</section>
@endsection
