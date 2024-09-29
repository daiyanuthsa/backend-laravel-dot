@extends('layouts.dashboard')

@section('title')
    Product
@endsection

@section('content')
    <section class="section-content section-dashboard-home" data-aos="fade-up">
        <div class="container-fluid">
            <div class="dashboard-heading">
                <h2 class="dashboard-title">Buku</h2>
                <p class="dashboard-subtitle">Kumpulan Buku Anda</p>
            </div>
            <div class="dashboard-content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <a href="{{ route('book-create') }}" class="btn btn-primary mb-3">
                                    + Tambah Buku
                                </a>
                                <div class="table-responsive">
                                    <table class="table table-hover scroll-horizontal-vertical w-100" id="crudtable">
                                        <thead>
                                            <tr>
                                                <th>Judul Buku</th>
                                                <th>Tahun</th>
                                                <th>Penulis</th>
                                                <th>Kategori</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('addon-script')
    <script>
        var datatable = $('#crudtable').DataTable({
            processing: true,
            serverSide: true,
            ordering: true,
            ajax: '{!! url()->current() !!}',
            columns: [{
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'year',
                    name: 'year'
                },
                {
                    data: 'author',
                    name: 'author'
                },
                {
                    data: 'category.name',
                    name: 'category.name'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false, // Corrected attribute name
                    width: '15%'
                },
            ],
            order: [
                [0, 'desc']
            ]
        });
    </script>
@endpush
