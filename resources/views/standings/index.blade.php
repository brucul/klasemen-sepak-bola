@extends('layouts.app')
@section('content')
<div class="col-12">
    <div class="card">
        <div class="card-header justify-content-between">
            <h4>{{$title}}</h4>
        </div>
        <div class="card-body row">
            <div class="col s12">
                <table id="table-standings" class="display">
                    <thead>
                        <th>No</th>
                        <th>Nama Klub</th>
                        <th>Ma</th>
                        <th>Me</th>
                        <th>S</th>
                        <th>K</th>
                        <th>GM</th>
                        <th>GK</th>
                        <th>Point</th>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')

<script type="text/javascript">
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#table-standings').DataTable({
            responsive: true,
            scrollY: '50vh',
            scrollCollapse: true,
            paging: true,
            searchable: true,
            // processing: true,
            serverSide: true,
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
                url: "{{ route('standings.json') }}",
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
                    orderable: false
                },
                {
                    data: 'match',
                    name: 'match',
                },
                {
                    data: 'win',
                    name: 'win',
                },
                {
                    data: 'draw',
                    name: 'draw',
                },
                {
                    data: 'lose',
                    name: 'lose',
                },
                {
                    data: 'goals_for',
                    name: 'goals_for',
                },
                {
                    data: 'goals_against',
                    name: 'goals_against',
                },
                {
                    data: 'point',
                    name: 'point',
                },
            ]
        });
    })
</script>
@endpush