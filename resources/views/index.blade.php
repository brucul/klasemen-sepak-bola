@extends('layouts.app')
@section('content')
<div class="col-12 mb-4">
    <div class="hero bg-light text-primary">
        <div class="hero-inner">
            <h2>Selamat Datang</h2>
            <p class="lead">Semoga Hari Anda Selalu Menyenangkan.</p>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-lg-6 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-info">
                    <i class="fas fa-user-gear"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Total Klub</h4>
                    </div>
                    <div class="card-body">
                        {{ $club->count() }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-danger">
                    <i class="fas fa-file-lines"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Total Pertandingan</h4>
                    </div>
                    <div class="card-body">
                        {{ $match->count() }}
                    </div>
                </div>
            </div>
        </div>              
    </div>
</div>
@endsection