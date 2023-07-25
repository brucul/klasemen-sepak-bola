@extends('layouts.app')

@push('styles')
<style type="text/css">
    @media only screen and (max-width: 500px) {
        .select2 {
            width: 42% !important;
        }
    }
    @media only screen and (min-width: 500px) and (max-width: 600px) {
        .select2 {
            width: 44% !important;
        }
    }
    @media only screen and (min-width: 600px) {
        .select2 {
            width: 44.5% !important;
        }
    }
    .invalid-feedback {
        display: block !important;
        width: auto !important;
    }
    .valid-feedback {
        display: block !important;
        width: auto !important;
    }
</style>
@endpush

@section('content')
<div class="col-12">
    <div class="card">
        <div class="card-header justify-content-between">
            <h4>List {{$title}}</h4>
            <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Tambah {{$title}}
            </button>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#createMatch">Satu per satu</a>
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#createMatchMulti">Multiple</a>
            </div>
        </div>
        <div class="card-body row">
            <div class="col s12">
                <table id="table-match" class="display">
                    <thead>
                        <th>No</th>
                        <th>Pertandingan</th>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<div class="modal fade" id="createMatch" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white" id="title">Tambah {{$title}}</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">x</span>
                </button>
            </div>
            <form id="formMatchAdd" enctype="multipart/form-data" class="needs-validation" novalidate="" autocomplete="off">
                <div class="modal-body row">
                    <div class="form-group col-12">
                        <label for="" class="form-label">Klub<span class="text-danger">*</span></label>
                        <div class="input-group">
                            <select class="form-control select2 club_1" name="club_id_1" id="club_id_1" required>
                                <option value="" selected>Pilih Klub</option>
                                @foreach($clubs as $club)
                                <option value="{{ $club->id }}">{{ $club->name }}</option>
                                @endforeach
                            </select>
                            <div class="input-group-prepend">
                                <div class="input-group-text">VS</div>
                            </div>
                            <select class="form-control select2 club_2" name="club_id_2" id="club_id_2" required disabled>
                                <option selected>Pilih Klub</option>
                            </select>
                        </div>
                        <div class="d-flex justify-content-between">
                            <div class="message" id="message-club_id_1"></div>
                            <div class="message" id="message-club_id_2"></div>
                        </div>
                    </div>
                    <div class="form-group col-12">
                        <label for="" class="form-label">Skor<span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="number" class="form-control" name="score_1" value="0" min="0" id="score_1" required>
                            <div class="input-group-prepend">
                                <div class="input-group-text">-</div>
                            </div>
                            <input type="number" class="form-control" name="score_2" value="0" min="0" id="score_2" required>
                        </div>
                        <div class="d-flex justify-content-between">
                            <div class="message" id="message-score_1"></div>
                            <div class="message" id="message-score_2"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="createMatchMulti" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white" id="title">Tambah {{$title}}</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">x</span>
                </button>
            </div>
            <form id="formMatchAddMulti" enctype="multipart/form-data" class="needs-validation" novalidate="" autocomplete="off">
                <div class="modal-body" id="match-field" style="overflow-y: scroll; max-height: 500px;">
                    <div class="row">
                        <div class="form-group col-sm-12 col-md-8 col-lg-8">
                            <label for="" class="form-label">Klub<span class="text-danger">*</span></label>
                            <div class="input-group">
                                <select class="form-control select2 multi_club_1" name="club_id_1[0]" id="club_id_1-0" data-id='0' required>
                                    <option value="" selected>Pilih Klub</option>
                                    @foreach($clubs as $club)
                                    <option value="{{ $club->id }}">{{ $club->name }}</option>
                                    @endforeach
                                </select>
                                <div class="input-group-prepend">
                                    <div class="input-group-text">VS</div>
                                </div>
                                <select class="form-control select2 multi_club_2 multi_club_2-0" name="club_id_2[0]" id="club_id_2-0" required disabled>
                                    <option selected>Pilih Klub</option>
                                </select>
                            </div>
                            <div class="d-flex justify-content-between">
                                <div class="message" id="message-club_id_1-0"></div>
                                <div class="message" id="message-club_id_2-0"></div>
                            </div>
                        </div>
                        <div class="form-group col-sm-12 col-md-3 col-lg-3">
                            <label for="" class="form-label">Skor<span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="number" class="form-control multi_score_1" name="score_1[0]" value="0" min="0" id="score_1-0" required>
                                <div class="input-group-prepend">
                                    <div class="input-group-text">-</div>
                                </div>
                                <input type="number" class="form-control multi_score_2" name="score_2[0]" value="0" min="0" id="score_2-0" required>
                            </div>
                            <div class="">
                                <div class="message" id="message-score_1-0"></div>
                                <div class="message" id="message-score_2-0"></div>
                            </div>
                        </div>
                        <div class="form-group col-sm-12 col-md-1 col-lg-1">
                            <label for="" class="form-label">Tambah</label>
                            <button type="button" class="btn btn-info" id="btn-add"><i class="fa fa-plus"></i></button>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#table-match').DataTable({
            responsive: true,
            scrollY: '50vh',
            scrollCollapse: true,
            paging: true,
            searchable: true,
            // processing: true,
            // serverSide: true,
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            columnDefs: [
                {
                    targets: '_all',
                    defaultContent: "N/A",
                },
                {
                    width: "10%",
                    targets: 0
                }
            ],
            ajax: {
                url: "{{ route('match.json') }}",
                method: 'get'
            },
            columns: [
                {
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                },
                {
                    data: 'match',
                    name: 'match',
                    orderable: false,
                },
            ]
        });

        $('#score_1').on('change', function () {
            $(this).removeClass('is-invalid')
            $('#message-score_1').removeClass('invalid-feedback')
            $('#message-score_1').html('')
        });

        $('#score_2').on('change', function () {
            $(this).removeClass('is-invalid')
            $('#message-score_2').removeClass('invalid-feedback')
            $('#message-score_2').html('')
        });

        $('body').on('change', '.multi_score_1', function () {
            var id = $(this).attr('id')
            $('#'+id).removeClass('is-invalid')
            $('#message-'+id).removeClass('invalid-feedback')
            $('#message-'+id).html('')
        });

        $('body').on('change', '.multi_score_2', function () {
            var id = $(this).attr('id')
            $('#'+id).removeClass('is-invalid')
            $('#message-'+id).removeClass('invalid-feedback')
            $('#message-'+id).html('')
        });

        $('#club_id_1').on('change', function () {
            var club_id_1 = $(this).val()
            $('#message-club_id_1').removeClass('invalid-feedback')
            $('#message-club_id_1').html('')
            $.ajax({
                url : "{{ route('match.get-club-2') }}",
                method : "post",
                cache : false,
                data : {
                    id: club_id_1
                },
                success : function(response) {
                    if(response.success) {
                        var html = '<option value="">Pilih Klub</option>'
                        
                        if (club_id_1) {
                            $.each(response.data, function (key, item) {
                                html += '<option value="'+ item.id +'">'+ item.name +'</option>'
                            })
                            $('#club_id_2').attr('disabled', false)
                        } else {
                            $('#club_id_2').attr('disabled', true)
                        }
                        $('#club_id_2').html(html)
                    }
                },
                error: function(xhr, AbsenceType, error) {
                    $.each(xhr.responseJSON.errors, function (key, item){
                        iziToast.error({
                            title: 'Error',
                            message: item,
                            position: 'topRight'
                        })
                    })
                }
            })
        })

        $('#club_id_2').on('change', function () {
            $('#message-club_id_2').removeClass('invalid-feedback')
            $('#message-club_id_2').html('')
        })

        $('body').on('change', '.multi_club_1', function () {
            var club_id_1 = $(this).val()
            var attr_id = $(this).attr('id')
            var data_id = $(this).data('id')
            $('#message-'+attr_id).removeClass('invalid-feedback')
            $('#message-'+attr_id).html('')
            $.ajax({
                url : "{{ route('match.get-club-2') }}",
                method : "post",
                cache : false,
                data : {
                    id: club_id_1
                },
                success : function(response) {
                    if(response.success) {
                        var html = '<option value="">Pilih Klub</option>'
                        
                        if (club_id_1) {
                            $.each(response.data, function (key, item) {
                                html += '<option value="'+ item.id +'">'+ item.name +'</option>'
                            })
                            $('.multi_club_2-'+data_id).attr('disabled', false)
                        } else {
                            $('.multi_club_2-'+data_id).attr('disabled', true)
                        }
                        $('.multi_club_2-'+data_id).html(html)
                    }
                },
                error: function(xhr, AbsenceType, error) {
                    $.each(xhr.responseJSON.errors, function (key, item){
                        iziToast.error({
                            title: 'Error',
                            message: item,
                            position: 'topRight'
                        })
                    })
                }
            })
        })

        $('body').on('change', '.multi_club_2', function () {
            var attr_id = $(this).attr('id')
            $('#message-'+attr_id).removeClass('invalid-feedback')
            $('#message-'+attr_id).html('')
        })

        $('#formMatchAdd').submit( (e) => {
            e.preventDefault()

            $.ajax({
                url : "{{ route('match.store') }}",
                method : "post",
                cache : false,
                contentType: false,
                processData: false,
                data : new FormData($('#formMatchAdd').get(0)),
                success : function(response) {
                    if(response.success) {
                        $('.close').click()
                        swal('Success', response.message, 'success')
                        $('#table-match').DataTable().ajax.reload()
                    } else {
                        $('#formMatchAdd').removeClass('was-validated')
                        $('.text-warning').hide()
                        $.each(response.errors, function (key, item) {
                            if (item) {
                                $('#'+key).addClass('is-invalid')
                                $('#'+key).removeClass('is-valid')
                                $('#message-'+key).removeClass('valid-feedback')
                                $('#message-'+key).addClass('invalid-feedback')
                                $('#message-'+key).html(item[0])
                            } else {
                                $('#'+key).removeClass('is-invalid')
                                $('#'+key).addClass('is-valid')
                                $('#message-'+key).removeClass('invalid-feedback')
                                $('#message-'+key).addClass('valid-feedback')
                                $('#message-'+key).html('Looks good.')
                            }
                        })
                        // swal('Error', response.message, 'error')
                    }
                },
                error: function(xhr, AbsenceType, error) {
                    swal('Error', xhr.responseJSON.message, 'error')
                }
            })
        })

        $('#createMatch').on('hidden.bs.modal', function(e) {
            $('#formMatchAdd').get(0).reset()
            $('#formMatchAdd').removeClass('was-validated')
            $('#formMatchAdd *').filter(':input').each(function () {
                $(this).removeClass('is-invalid')
                $(this).removeClass('is-valid')
            })
            $('#club_id_1, #club_id_2').val('').trigger('change')
            $('#club_id_2').attr('disabled', true)
            $('.message').removeClass('invalid-feedback')
            $('.message').html('')
        })

        var match_count = $('.new-match').length + 1
        $('#btn-add').click((e) => {
            var html = ''
                html += '<div class="row new-match" id="match-'+match_count+'">'
                    html += '<div class="form-group col-sm-12 col-md-8 col-lg-8">'
                        html += '<label for="" class="form-label">Klub<span class="text-danger">*</span></label>'
                        html += '<div class="input-group">'
                            html += '<select class="form-control select2 multi_club_1" data-id="'+match_count+'" name="club_id_1['+match_count+']" id="club_id_1-'+match_count+'" required>'
                                html += '<option value="" selected>Pilih Klub</option>'
                                html += '@foreach($clubs as $club)'
                                html += '<option value="{{ $club->id }}">{{ $club->name }}</option>'
                                html += '@endforeach'
                            html += '</select>'
                        html += '<div class="input-group-prepend">'
                                html += '<div class="input-group-text">VS</div>'
                            html += '</div>'
                            html += '<select class="form-control select2 multi_club_2 multi_club_2-'+match_count+'" name="club_id_2['+match_count+']" id="club_id_2-'+match_count+'" required disabled>'
                                html += '<option selected>Pilih Klub</option>'
                            html += '</select>'
                        html += '</div>'
                        html += '<div class="d-flex justify-content-between">'
                            html += '<div class="message" id="message-club_id_1-'+match_count+'"></div>'
                            html += '<div class="message" id="message-club_id_2-'+match_count+'"></div>'
                        html += '</div>'
                    html += '</div>'
                    html += '<div class="form-group col-sm-12 col-md-3 col-lg-3">'
                        html += '<label for="" class="form-label">Skor<span class="text-danger">*</span></label>'
                        html += '<div class="input-group">'
                            html += '<input type="number" class="form-control multi_score_1" name="score_1['+match_count+']" value="0" min="0" id="score_1-'+match_count+'" required>'
                            html += '<div class="input-group-prepend">'
                                html += '<div class="input-group-text">-</div>'
                            html += '</div>'
                            html += '<input type="number" class="form-control multi_score_2" name="score_2['+match_count+']" value="0" min="0" id="score_2-'+match_count+'" required>'
                        html += '</div>'
                        html += '<div class="">'
                            html += '<div class="message" id="message-score_1-'+match_count+'"></div>'
                            html += '<div class="message" id="message-score_2-'+match_count+'"></div>'
                        html += '</div>'
                    html += '</div>'
                    html += '<div class="form-group col-sm-12 col-md-1 col-lg-1">'
                        html += '<label for="" class="form-label">Hapus</label>'
                        html += '<button type="button" class="btn btn-danger" id="btn-remove" data-id="'+match_count+'"><i class="fa fa-times"></i></button>'
                    html += '</div>'
                html += '</div>'
            html += '</div>'

            $('#match-field').append(html)
            $('#club_id_1-' + match_count).select2()
            $('#club_id_2-' + match_count).select2()
            match_count++
        })

        $('body').on('click', '#btn-remove', function () {
            var id = $(this).data('id')
            $('#match-'+id).remove()
            // match_count--
        })

        $('#formMatchAddMulti').submit( (e) => {
            e.preventDefault()

            $.ajax({
                url : "{{ route('match.store-multi') }}",
                method : "post",
                cache : false,
                contentType: false,
                processData: false,
                data : new FormData($('#formMatchAddMulti').get(0)),
                success : function(response) {
                    console.log(response)
                    if(response.success) {
                        $('.close').click()
                        swal('Success', response.message, 'success')
                        $('#table-match').DataTable().ajax.reload()
                    } else {
                        $('#formMatchAddMulti').removeClass('was-validated')
                        $('.text-warning').hide()
                        let index, attribute
                        $.each(response.errors, function (key, item) {
                            key = key.replace('.', '-')
                            index = key.split('-')
                            attribute = index[0].replace('_id_', ' ')
                            if (item) {
                                $('#'+key).addClass('is-invalid')
                                $('#'+key).removeClass('is-valid')
                                $('#message-'+key).removeClass('valid-feedback')
                                $('#message-'+key).addClass('invalid-feedback')
                                $('#message-'+key).html(item[0].replace(key.replace('-', '.'), attribute))
                            } else {
                                $('#'+key).removeClass('is-invalid')
                                $('#'+key).addClass('is-valid')
                                $('#message-'+key).removeClass('invalid-feedback')
                                $('#message-'+key).addClass('valid-feedback')
                                $('#message-'+key).html('Looks good.')
                            }
                        })
                        // swal('Error', response.message, 'error')
                    }
                },
                error: function(xhr, AbsenceType, error) {
                    swal('Error', xhr.responseJSON.message, 'error')
                }
            })
        })

        $('#createMatchMulti').on('hidden.bs.modal', function(e) {
            $('#formMatchAddMulti').get(0).reset()
            $('#formMatchAddMulti').removeClass('was-validated')
            $('#formMatchAddMulti *').filter(':input').each(function () {
                $(this).removeClass('is-invalid')
                $(this).removeClass('is-valid')
            })
            $('#club_id_1-0, #club_id_2-0').val('').trigger('change')
            $('#club_id_2-0').attr('disabled', true)
            $('.message').removeClass('invalid-feedback')
            $('.message').html('')
            $('.new-match').remove('')
            match_count = 1
        })
    })
</script>
@endpush