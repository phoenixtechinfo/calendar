@extends('layouts.header')
@section('content')
<section class="content">
    <div class="box-header with-border">
        <div class="box">
            <div class="box-body">
                <div class="table-responsive">
                    <table class="table" id="table_content">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">Page Title</th>
<!--                                <th scope="col">Content</th>-->
                                <th scope="col">Update Date</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($contents as $content)
                            <tr>
                                <td>{{ $content->page_title }}</td>
<!--                                <td>{!! $content->content !!}</td>-->
                                <td>{{ date('Y-m-d', strtotime($content->updated_at)) }}</td>
                                <td>
                                    <a href="javascript:void(0)" onclick="edit_record({{$content->id}})"><i title='View' class='fa fa-edit text-primary' style='font-size: 20px;'></i></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    $(function () {
        CKEDITOR.replace('inputtitle');
        $('#table_content').DataTable({
            "order": [[ 0, "desc" ]],
            'columnDefs': [ {
                'targets': [2], /* column index */
                'orderable': false, /* true or false */
            }]
        });
    });
</script>
<div aria-hidden="true" aria-labelledby="myModalLabel" class="modal fade bd-example-modal-lg" id="modal_view" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button aria-hidden="true" class="close" data-dismiss="modal" type="button">×</button>
                <h4 class="modal-title" id="myModalLabel"> Modal title</h4>
            </div>
            <div class="modal-body" id="modal-global">
                <form class="form-horizontal" id="form">
                    <div class="box-body">
                        {{ @csrf_field() }}
                        <input name="id" type="hidden">
                        <div class="form-group">
                            <label class="col-sm-1 control-label" for="inputtitle">Title</label>
                            <div class="col-sm-10">
                                <input class="form-control" name="title" placeholder="enter title" required="" type="text">
                                    <span class="help-block"></span>
                                </input>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-1 control-label" for="inputtitle">Content</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" id="inputtitle" name="content" placeholder="enter content" required="" rows="5"></textarea>
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="box-footer">
                            <button class="btn btn-info general-bg-btn" onclick="save()" type="button">Save</button>
                        </div>
                    </div>
                    <!-- /.box-body -->
                    <!-- /.box-footer -->
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    function edit_record(id) { 
        $.ajax({
            url: "<?= $edit ?>/" + id,
            type: "GET",
            dataType: "json",
            success: function (data) { 
                $('.form-group').removeClass('has-error');
                $('#form').trigger("reset");
                $('.help-block').empty();
                $('#modal_view').modal('show');
                $('.modal-title').text('Edit Content');
                $("input[name='id']").val(data.id);
                $("input[name='title']").val(data.page_title);
                $("input[name='title']").attr('disabled',true);
                CKEDITOR.instances['inputtitle'].setData(data.content);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                $('.top-right').notify({
                    message: { text: 'Error'},
                    type:'danger'
                }).show();
            }
        });
    }
    function save() { 
        $('#btnSave').text('Saving...');
        $('#btnSave').attr('disabled', true);
        for (instance in CKEDITOR.instances) {
            CKEDITOR.instances[instance].updateElement();
        }
        var formData = new FormData($('#form')[0]);
        
        $.ajax({ 
            url: "<?= $update ?>",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            dataType: "JSON",
            success: function (data) {                                                                      
                if (data.status) {
                    $('.top-right').notify({
                        message: { text: data.message },
                        type:'success'
                    }).show();
                    $('#modal_view').modal('hide');
                    reload_table();
                } else {
                    if (data.inputerror.length) {
                        for (var i = 0; i < data.inputerror.length; i++) {
                            $('[name="' + data.inputerror[i] + '"]').closest('.form-group').addClass('has-error');
                            $('[name="' + data.inputerror[i] + '"]').nextAll('.help-block').text(data.error_string[i]);
                        }
                    } else {
                        $('.top-right').notify({
                            message: { text: data.message },
                            type:'danger'
                        }).show();
                    }
                }
                $('#btnSave').text('save');
                $('#btnSave').attr('disabled', false);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                $('.top-right').notify({
                    message: { text: data.message },
                    type:'danger'
                }).show();
                $('#btnSave').text('save');
                $('#btnSave').attr('disabled', false);
            }
        });
    }
</script>
@endsection
