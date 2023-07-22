@extends('layout.main')

@section('content')
    <div class="container">
        {{--  ALERT  --}}
        <div class="row mt-3">
            <div class="col">
                @if (session()->has('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if (session()->has('failed'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('failed') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
            </div>
        </div>
        {{--  ALERT  --}}

        {{--  CONTENT  --}}
        <div class="row mt-3 mb-5">
            <div class="col">
                <button class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#createModal">
                    <i class=""><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                            fill="currentColor" class="bi bi-plus-lg" viewBox="0 0 16 16">
                            <path fill-rule="evenodd"
                                d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2Z" />
                        </svg></i>
                    Tambah
                </button>

                <div class="card mt-3 col-sm-6 col-md-12">
                    <div class="card-body">
                        {{-- tables --}}
                        <table id="myTable" class="table responsive nowrap table-bordered table-striped align-middle"
                            style="width:100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Judul Buku</th>
                                    <th>Kategori</th>
                                    <th>Deskripsi</th>
                                    <th>Jumlah</th>
                                    <th>File Buku</th>
                                    <th>Thumbnail</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($bukus as $buku)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $buku->judul }}</td>
                                        <td>{{ $buku->kategoris->name }}</td>
                                        <td>{{ $buku->deskripsi }}</td>
                                        <td>{{ $buku->jumlah }}</td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal"
                                                data-bs-target="#seeImage{{ $loop->iteration }}">
                                                <i class="fa-regular fa-eye me-1"></i>
                                                File
                                            </button>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal"
                                                data-bs-target="#seeImage{{ $loop->iteration }}">
                                                <i class="fa-regular fa-eye me-1"></i>
                                                Thumbnail
                                            </button>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                                data-bs-target="#editModal{{ $loop->iteration }}">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </button>
                                            <button id="delete-button" class="btn btn-danger" id="delete-button"
                                                data-bs-toggle="modal" data-bs-target="#hapusModal{{ $loop->iteration }}">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>

                                    {{--  MODAL EDIT  --}}
                                    <div class="modal fade" id="editModal{{ $loop->iteration }}" tabindex="-1"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Tambah Data Buku</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <form action="{{ route('buku.update', $buku->id) }}" method="POST"
                                                    enctype="multipart/form-data">
                                                    @method('PUT')
                                                    @csrf
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <input type="hidden" name="oldFile" value="{{ $buku->file }}">
                                                            <input type="hidden" name="oldThumnail" value="{{ $buku->thumnail }}">
                                                            <div class="mb-3">
                                                                <label for="judul" class="form-label">Judul</label>
                                                                <input type="text"
                                                                    class="form-control @error('judul') is-invalid @enderror"
                                                                    name="judul" id="judul"
                                                                    value="{{ old('judul', $buku->judul) }}"
                                                                    placeholder="Anton" autofocus required>
                                                                @error('judul')
                                                                    <div class="invalid-feedback">
                                                                        {{-- {{ $message }} --}}
                                                                    </div>
                                                                @enderror
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="kategoriId" class="form-label">Kategori</label>
                                                                <select
                                                                    class="form-select @error('kategoriId') is-invalid @enderror"
                                                                    aria-label="Default select example" name="kategoriId">
                                                                    <option selected>Pilih Kategori</option>
                                                                    @foreach ($kategoris as $kategori)
                                                                        <option value="{{ $kategori->id }}">
                                                                            {{ $kategori->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                                @error('name')
                                                                    <div class="invalid-feedback">
                                                                        {{-- {{ $message }} --}}
                                                                    </div>
                                                                @enderror
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="deskripsi" class="form-label">Deskripsi</label>
                                                                <input type="text"
                                                                    class="form-control @error('deskripsi') is-invalid @enderror"
                                                                    name="deskripsi" id="deskripsi"
                                                                    value="{{ old('deskripsi', $buku->deskripsi) }}"
                                                                    placeholder="Anton" autofocus required>
                                                                @error('deskripsi')
                                                                    <div class="invalid-feedback">
                                                                        {{-- {{ $message }} --}}
                                                                    </div>
                                                                @enderror
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="jumlah" class="form-label">Jumlah</label>
                                                                <input type="text"
                                                                    class="form-control @error('jumlah') is-invalid @enderror"
                                                                    name="jumlah" id="jumlah"
                                                                    value="{{ old('jumlah', $buku->jumlah) }}"
                                                                    placeholder="Anton" autofocus required>
                                                                @error('jumlah')
                                                                    <div class="invalid-feedback">
                                                                        {{-- {{ $message }} --}}
                                                                    </div>
                                                                @enderror
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="formFile" class="form-label">Upload
                                                                    Buku</label>
                                                                <input
                                                                    class="form-control @error('file') is-invalid @enderror"
                                                                    type="file" name="file" id="formFile">
                                                                @error('file')
                                                                    <div class="invalid-feedback">
                                                                        {{-- {{ $message }} --}}
                                                                    </div>
                                                                @enderror
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="thumnail" class="form-label">Upload
                                                                    Thumbnail</label>
                                                                <img src="{{ asset('storage/' . $buku->thumnail) }}"
                                                                    class="img-preview img-fluid mb-3 col-sm-5 d-block">
                                                                <img class="img-preview img-fluid mb-3 col-sm-5">
                                                                <input
                                                                    class="form-control @error('thumnail') is-invalid @enderror"
                                                                    type="file" name="thumnail" id="thumnail"
                                                                    onchange="previewImage()">
                                                                @error('thumnail')
                                                                    <div class="invalid-feedback">
                                                                        {{-- {{ $message }} --}}
                                                                    </div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary">Save
                                                            changes</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    {{--  MODAL EDIT  --}}

                                    {{--  MODAL Delete  --}}
                                    <div class="modal fade" id="hapusModal{{ $loop->iteration }}" tabindex="-1"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Hapus Data Buku</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <form action="{{ route('buku.destroy', $buku->id) }}" method="POST"
                                                    enctype="multipart/form-data">
                                                    @method('DELETE')
                                                    @csrf
                                                    <div class="modal-body">
                                                        <p>Apakah Anda Yakin Ingin Menghapus Data
                                                            <b>{{ $buku->judul }}</b> ini?
                                                        </p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-danger">hapus
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    {{--  MODAL Delete  --}}
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        {{--  CONTENT  --}}

        {{--  MODAL ADD  --}}
        <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Tambah Data Buku</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('buku.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                <div class="mb-3">
                                    <label for="judul" class="form-label">Judul</label>
                                    <input type="text" class="form-control @error('judul') is-invalid @enderror"
                                        name="judul" id="judul" placeholder="Anton" autofocus required>
                                    @error('judul')
                                        <div class="invalid-feedback">
                                            {{-- {{ $message }} --}}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="kategoriId" class="form-label">Kategori</label>
                                    <select class="form-select @error('kategoriId') is-invalid @enderror"
                                        aria-label="Default select example" name="kategoriId">
                                        <option selected>Pilih Kategori</option>
                                        @foreach ($kategoris as $kategori)
                                            <option value="{{ $kategori->id }}">{{ $kategori->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('name')
                                        <div class="invalid-feedback">
                                            {{-- {{ $message }} --}}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="deskripsi" class="form-label">Deskripsi</label>
                                    <input type="text" class="form-control @error('deskripsi') is-invalid @enderror"
                                        name="deskripsi" id="deskripsi" placeholder="Anton" autofocus required>
                                    @error('deskripsi')
                                        <div class="invalid-feedback">
                                            {{-- {{ $message }} --}}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="jumlah" class="form-label">Jumlah</label>
                                    <input type="text" class="form-control @error('jumlah') is-invalid @enderror"
                                        name="jumlah" id="jumlah" placeholder="Anton" autofocus required>
                                    @error('jumlah')
                                        <div class="invalid-feedback">
                                            {{-- {{ $message }} --}}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="formFile" class="form-label">Upload Buku</label>
                                    <input class="form-control @error('file') is-invalid @enderror" type="file"
                                        name="file" id="formFile">
                                    @error('file')
                                        <div class="invalid-feedback">
                                            {{-- {{ $message }} --}}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="thumnail" class="form-label">Upload Thumbnail</label>
                                    <img class="img-preview img-fluid mb-3 col-sm-5">
                                    <input class="form-control @error('thumnail') is-invalid @enderror" type="file"
                                        name="thumnail" id="thumnail" onchange="previewImage()">
                                    @error('thumnail')
                                        <div class="invalid-feedback">
                                            {{-- {{ $message }} --}}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        {{--  MODAL ADD  --}}

    </div>

@section('scripts')
    <script>
        function previewImage() {
            const image = document.querySelector('#thumnail');
            const imgPreview = document.querySelector('.img-preview');

            imgPreview.style.display = 'block';

            const oFReader = new FileReader();
            oFReader.readAsDataURL(image.files[0]);

            oFReader.onload = function(OFREvent) {
                imgPreview.src = OFREvent.target.result;
            }

            //batas

            const image1 = document.querySelector('#thumnail1');
            const imgPreview1 = document.querySelector('.img-preview1');

            imgPreview1.style.display = 'block';

            const oFReader1 = new FileReader();
            oFReader1.readAsDataURL(image1.files[0]);

            oFReader1.onload = function(OFREvent) {
                imgPreview1.src = OFREvent.target.result;
            }
        }
    </script>
@endsection
@endsection
