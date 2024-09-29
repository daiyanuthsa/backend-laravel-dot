@extends('layouts.admin')

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
                                <form action="{{ route('product.update', $item->id) }}" method="post"
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
                                                    Product Owner
                                                </label>
                                                <select name="users_id" class="form-control" required>
                                                    <option value="{{ $item->users_id }}" selected>{{ $item->user->name }}
                                                    </option>
                                                    @foreach ($users as $user)
                                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="name">
                                                    Product Category
                                                </label>
                                                <select name="categories_id" class="form-control" required>
                                                    <option value="{{ $item->categories_id }}" selected>
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
                                                    Product Price
                                                </label>
                                                <input type="number" name="price" value="{{ $item->price }}"
                                                    class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="name">
                                                    Product Description
                                                </label>
                                                <textarea name="description" id="editor">{!! $item->description !!}</textarea>
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
    <script src="https://cdn.ckeditor.com/ckeditor5/40.2.0/classic/ckeditor.js"></script>
    <script>
        ClassicEditor.create(document.querySelector("#editor"))
            .then((editor) => {
                console.log(editor);
            })
            .catch((error) => {
                console.error(error);
            });
    </script>
@endpush
