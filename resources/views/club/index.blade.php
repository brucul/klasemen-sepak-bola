@extends('layouts.app')
@section('content')
<div class="col-12">
    <div class="card">
        <div class="card-header justify-content-between">
            <h4>List {{$title}}</h4>
            <button type="button" data-toggle="modal" data-target="#createClub" class="btn btn-primary">
                <i class="fa fa-plus me-0"></i> Tambah {{$title}}
            </button>
        </div>
        <div class="card-body row">
            <div class="col s12">
                <table id="table-club" class="display">
                    <thead>
                        <th>No</th>
                        <th>Nama Klub</th>
                        <th>Kota Klub</th>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<div class="modal fade" id="createClub" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white" id="title">Tambah {{$title}}</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">x</span>
                </button>
            </div>
            <form id="formClubAdd" enctype="multipart/form-data" class="needs-validation" novalidate="" autocomplete="off">
                <div class="modal-body row">
                    <div class="form-group col-12">
                        <label for="name" class="form-label">Nama Klub<span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="name" placeholder="Masukan Nama Klub" id="name" required>
                        <div class="" id="message-name"></div>
                    </div>
                    <div class="form-group col-12">
                        <label for="city" class="form-label">Kota Klub<span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="city" placeholder="Masukan Nama Klub" id="city" required>
                        <div class="" id="message-city"></div>
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

        $('#table-club').DataTable({
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
                }
            ],
            ajax: {
                url: "{{ route('club.json') }}",
                method: 'get'
            },
            columns: [
                {
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                },
                {
                    data: 'name',
                    name: 'name',
                },
                {
                    data: 'city',
                    name: 'city',
                }
            ]
        });

        $('#formClubAdd').submit( (e) => {
            e.preventDefault()

            $.ajax({
                url : "{{ route('club.store') }}",
                method : "post",
                cache : false,
                contentType: false,
                processData: false,
                data : new FormData($('#formClubAdd').get(0)),
                success : function(response) {
                    if(response.success) {
                        $('.close').click()
                        swal('Success', response.message, 'success')
                        $('#table-club').DataTable().ajax.reload()
                    } else {
                        $('#formClubAdd').removeClass('was-validated')
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

        $('#createClub').on('hidden.bs.modal', function(e) {
            $('#formClubAdd').get(0).reset()
            $('#formClubAdd').removeClass('was-validated')
            $('#formClubAdd *').filter(':input').each(function () {
                $(this).removeClass('is-invalid')
                $(this).removeClass('is-valid')
            })
            $('.text-warning').show()
        })
    })
</script>
@endpush