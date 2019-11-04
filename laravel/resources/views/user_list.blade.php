@extends('layouts.header')
@section('content')
<section class="content">
    <div class="box-header with-border">
        <div class="box">
            <div class="box-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="table">
                        <thead>
                            <th>Name</th>
                            <th>Register Date</th>
                            <th>Email</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    var table;
    $(document).ready(function () {
        table = $('#table').DataTable({
             "processing": true,
            "serverSide": true,
            "ajax":{
                     "url": "{{ url('user/list') }}",
                     "dataType": "json",
                     "type": "POST",
                     "data":{ _token: "{{csrf_token()}}"}
                    },
            "columns": [
                { "data": "name" },
                { "data": "date" },
                { "data": "email" },
                { "data": "options" }
            ],
            "columnDefs": [{ "orderable": false, "targets": [3] }]	 

        });
    });
    function view_record(id) {  
        $.ajax({
            url: "<?= $view ?>/" + id,
            type: "GET",
            dataType: "HTML",
            success: function (data) { 
                $('.modal-title').text('View User Details');
                $('#modal_view').modal('show');
                $("#modal_view").find('.modal-body').html(data);
            },
            error: function (jqXHR, textStatus, errorThrown) { 
               // notification('Error:', 'error', errorThrown);
            }
        });
    }
</script>
<div class="modal fade bd-example-modal-lg" id="modal_view"  role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Modal title</h4>
            </div>
            <div class="modal-body" id="modal-global">
               
            </div>
        </div>
    </div>
</div>
@endsection

