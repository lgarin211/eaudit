@extends('template')

@section('content')
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white me-2">
                <i class="mdi mdi-home"></i>
            </span>
            Dashboard OPD TL
        </h3>
        <nav aria-label="breadcrumb">
            <ul class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">
                    <span></span>Overview <i class="mdi mdi-alert-circle-outline icon-sm text-primary align-middle"></i>
                </li>
            </ul>
        </nav>
    </div>

    <div class="row">
        <div class="col-md-4 stretch-card grid-margin">
            <div class="card bg-gradient-danger card-img-holder text-white">
                <div class="card-body">
                    <img src="{{ asset('corona/template/assets/images/dashboard/circle.svg') }}" class="card-img-absolute" alt="circle-image" />
                    <h4 class="font-weight-normal mb-3">Menu A1 <i class="mdi mdi-chart-line mdi-24px float-right"></i></h4>
                    <h2 class="mb-5">Data Dukung Rekomendasi</h2>
                    <a href="{{ route('opdTL.menuA1') }}" class="btn btn-light btn-sm">Akses Menu A1</a>
                </div>
            </div>
        </div>

        <div class="col-md-4 stretch-card grid-margin">
            <div class="card bg-gradient-info card-img-holder text-white">
                <div class="card-body">
                    <img src="{{ asset('corona/template/assets/images/dashboard/circle.svg') }}" class="card-img-absolute" alt="circle-image" />
                    <h4 class="font-weight-normal mb-3">Menu A2 <i class="mdi mdi-bookmark-outline mdi-24px float-right"></i></h4>
                    <h2 class="mb-5">Coming Soon</h2>
                    <a href="{{ route('opdTL.menuA2') }}" class="btn btn-light btn-sm">Akses Menu A2</a>
                </div>
            </div>
        </div>

        <div class="col-md-4 stretch-card grid-margin">
            <div class="card bg-gradient-success card-img-holder text-white">
                <div class="card-body">
                    <img src="{{ asset('corona/template/assets/images/dashboard/circle.svg') }}" class="card-img-absolute" alt="circle-image" />
                    <h4 class="font-weight-normal mb-3">Akses Terbatas <i class="mdi mdi-security mdi-24px float-right"></i></h4>
                    <h2 class="mb-5">Read Only</h2>
                    <p class="card-text">Anda memiliki akses terbatas untuk melihat data sesuai permission.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12 grid-margin">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Informasi Akses</h4>
                    <div class="alert alert-info">
                        <h5><i class="mdi mdi-information"></i> Panduan Penggunaan:</h5>
                        <ul class="mb-0">
                            <li><strong>Menu A1:</strong> Lihat data dukung rekomendasi (hanya baca, tidak bisa edit)</li>
                            <li><strong>Menu A2:</strong> Menu tambahan (akan segera tersedia)</li>
                            <li><strong>Upload File:</strong> Anda dapat mengunggah file pada halaman detail</li>
                            <li><strong>Akses Data:</strong> Hanya data sesuai permission Anda yang akan ditampilkan</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
