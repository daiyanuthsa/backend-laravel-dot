@extends('layouts.dashboard')

@section('title')
    Product
@endsection

@section('content')
    <section class="section-content section-dashboard-home" data-aos="fade-up">
        <div class="container-fluid">
            <div class="dashboard-heading">
                <h2 class="dashboard-title">Update Product</h2>
                <p class="dashboard-subtitle">Update Product Details</p>
            </div>
            <div class="dashboard-content">
                <div class="row">
                    <div class="col-md-12">
                        @if ($errors->any())
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif
                        <div class="card">
                            <div class="card-body">
                                <form action="{{ route('book.update', $item->id) }}" method="post"
                                    enctype="multipart/form-data">
                                    @method('PUT')
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="name">
                                                    Product Name
                                                </label>
                                                <input type="text" name="name" class="form-control"
                                                    value="{{ $item->name }}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="name">
                                                    Tahun Terbit
                                                </label>
                                                <select name="year" class="form-control" required>
                                                    <option value="{{ $item->year }}" selected hidden>{{ $item->year }}
                                                    </option>
                                                    @for ($year = 1900; $year <= date('Y'); $year++)
                                                        <option value="{{ $year }}"
                                                            {{ $year == date('Y') ? 'selected' : '' }}>{{ $year }}
                                                        </option>
                                                    @endfor
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="name">
                                                    Product Category
                                                </label>
                                                <select name="category_id" class="form-control" required>
                                                    <option value="{{ $item->category_id }}" selected>
                                                        {{ $item->category->name }}</option>
                                                    @foreach ($categories as $category)
                                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="name">
                                                    Penulis Buku
                                                </label>
                                                <input type="text" value="{{ $item->author }}" name="author"
                                                    class="form-control" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col text-right">
                                            <button type="submit" class="btn btn-success px-5">
                                                Update
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection


@push('addon-script')
@endpush
