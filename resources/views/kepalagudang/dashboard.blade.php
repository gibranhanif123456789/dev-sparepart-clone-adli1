@extends('layouts.kepalagudang')

@section('title', 'Dashboard Kepala Gudang')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold">Dashboard Kepala Gudang</h3>
        <span class="badge badge-date"><i class="bi bi-calendar me-1"></i> <span id="current-date">{{ date('d F Y') }}</span></span>
    </div>

    <!-- Stats Cards -->
    <div class="row g-4 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="dashboard-card p-4">
                <div class="card-icon bg-primary bg-opacity-10 text-primary">
                    <i class="bi bi-box-arrow-in-down"></i>
                </div>
                <h4 class="stats-number">25</h4>
                <p class="stats-title">Barang Masuk</p>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="dashboard-card p-4">
                <div class="card-icon bg-danger bg-opacity-10 text-danger">
                    <i class="bi bi-box-arrow-up"></i>
                </div>
                <h4 class="stats-number">10</h4>
                <p class="stats-title">Barang Keluar</p>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="dashboard-card p-4">
                <div class="card-icon bg-success bg-opacity-10 text-success">
                    <i class="bi bi-tools"></i>
                </div>
                <h4 class="stats-number">156</h4>
                <p class="stats-title">Total Sparepart</p>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="dashboard-card p-4">
                <div class="card-icon bg-warning bg-opacity-10 text-warning">
                    <i class="bi bi-clock-history"></i>
                </div>
                <h4 class="stats-number">42</h4>
                <p class="stats-title">Transaksi Hari Ini</p>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="row">
        <div class="col-md-6">
            <div class="table-container">
                <h5><i class="bi bi-box-arrow-in-down me-2"></i>Barang Masuk Terbaru</h5>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Barang</th>
                                <th>Jumlah</th>
                                <th>Tanggal</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><span class="badge bg-primary">IN001</span></td>
                                <td>Filter Oli</td>
                                <td>30</td>
                                <td>2025-08-28</td>
                                <td><span class="badge bg-success">Selesai</span></td>
                            </tr>
                            <tr>
                                <td><span class="badge bg-primary">IN002</span></td>
                                <td>Kampas Rem</td>
                                <td>25</td>
                                <td>2025-08-27</td>
                                <td><span class="badge bg-success">Selesai</span></td>
                            </tr>
                            <tr>
                                <td><span class="badge bg-primary">IN003</span></td>
                                <td>Busi</td>
                                <td>50</td>
                                <td>2025-08-27</td>
                                <td><span class="badge bg-warning">Proses</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-end mt-3">
                    <a href="#" class="btn btn-sm btn-outline-primary">Lihat Semua <i class="bi bi-arrow-right"></i></a>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="table-container">
                <h5><i class="bi bi-box-arrow-up me-2"></i>Barang Keluar Terbaru</h5>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Barang</th>
                                <th>Jumlah</th>
                                <th>Tanggal</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><span class="badge bg-danger">OUT001</span></td>
                                <td>Kampas Rem</td>
                                <td>15</td>
                                <td>2025-08-30</td>
                                <td><span class="badge bg-success">Terkirim</span></td>
                            </tr>
                            <tr>
                                <td><span class="badge bg-danger">OUT002</span></td>
                                <td>Filter Oli</td>
                                <td>20</td>
                                <td>2025-08-29</td>
                                <td><span class="badge bg-warning">Pending</span></td>
                            </tr>
                            <tr>
                                <td><span class="badge bg-danger">OUT003</span></td>
                                <td>Oli Mesin</td>
                                <td>35</td>
                                <td>2025-08-29</td>
                                <td><span class="badge bg-success">Terkirim</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-end mt-3">
                    <a href="#" class="btn btn-sm btn-outline-primary">Lihat Semua <i class="bi bi-arrow-right"></i></a>
                </div>
            </div>
        </div>
    </div>
@endsection