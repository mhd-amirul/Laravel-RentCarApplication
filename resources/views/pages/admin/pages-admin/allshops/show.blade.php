@extends('layouts.main')

@section('container')

<div class="row justify-content-center mt-5">
    <div class="col-lg-9">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-center">
                    <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner m-2" style="max-height: 450px; max-width: 450px; overflow: hidden;">
                            <div class="carousel-item active">
                                <img src="{{ isset($shop->foto_usaha) == null ? url('images/notfound.png') : asset('storage/' . $shop->foto_usaha) }}" class="d-block w-100" alt="...">
                            </div>
                            <div class="carousel-item">
                                <img src="{{ isset($shop->pas_foto) == null ? url('images/notfound.png') : asset('storage/' . $shop->pas_foto) }}" class="d-block w-100" alt="...">
                            </div>
                            <div class="carousel-item">
                                <img src="{{ isset($shop->img_siu) == null ? url('images/notfound.png') : asset('storage/' . $shop->img_siu) }}" class="d-block w-100" alt="...">
                            </div>
                            <div class="carousel-item">
                                <img src="{{ isset($shop->img_ktp) == null ? url('images/notfound.png') : asset('storage/' . $shop->img_ktp) }}" class="d-block w-100" alt="...">
                            </div>
                        </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                    </div>
                </div>
                <h6 class="m-b-20 p-b-5 b-b-default f-w-600 mt-5">Information :</h6>
                <div class="row">
                    <div class="col-sm-6 mb-4">
                        <div class="form-floating">
                            <input type="text" class="form-control rounded-top" id="nm_pu" value="{{ $shop->nm_pu }}">
                            <label for="nm_pu">Nama Pemilik</label>
                        </div>
                    </div>
                    <div class="col-sm-6 mb-4">
                        <div class="form-floating">
                            <input type="text" class="form-control rounded-top" id="nm_pu" value="{{ $shop->nm_usaha }}">
                            <label for="nm_pu">Nama Usaha</label>
                        </div>
                    </div>
                    <div class="col-sm-6 mb-4">
                        <div class="form-floating">
                            <input type="text" class="form-control rounded-top" id="nm_pu" value="{{ $shop->alamat }}">
                            <label for="nm_pu">Alamat</label>
                        </div>
                    </div>
                    <div class="col-sm-6 mb-4">
                        <div class="form-floating">
                            <input type="text" class="form-control rounded-top" id="nm_pu" value="{{ $shop->nik }}">
                            <label for="nm_pu">NIK</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-9 mt-5">
                            <a href="{{ route('allshops.index')}}" style="color: rgb(0, 0, 0);" class="mt-1 btn btn-sm btn-primary">
                                <i class="bi bi-arrow-left-circle"></i> Back
                            </a>
                            <a href="{{ route('allshops.edit', $shop->slug) }}" class="mt-1 btn btn-sm btn-warning">
                                <i class="bi bi-pencil-square"></i> Edit Toko
                            </a>
                            @if ($shop->longitude != null && $shop->latitude != null)
                                <a href="{{ route('sharelok', $shop->slug) }}" style="color: rgb(0, 0, 0);" class="mt-1 btn btn-sm btn-success">
                                    <i class="bi bi-house-fill"></i> Lokasi Toko
                                </a>
                            @endif
                            <form action="{{ route('allshops.destroy', $shop->slug) }}" method="post" class="d-inline" id="deleteShop-form">
                                @method('delete')
                                @csrf
                                <a href="#" class="mt-1 btn btn-sm btn-danger text-decoration-none" id="deleteShop" style="color: rgb(0, 0, 0);"><i class="bi bi-trash-fill"></i> Hapus</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-9">
        <div class="card px-5 py-5">
            <h4 class="m-b-20 p-b-5 b-b-default ">DAFTAR MOBIL</h4>
            <div class="row">
                <div class="col">
                    @if ($shop->longitude != null && $shop->latitude != null)
                        <a href="{{ route('addCarAdmin',$shop->slug) }}" class="btn btn-sm btn-primary mb-2">Tambah Mobil</a>
                    @else
                        <p class="mb-21 mt-2"></p>
                    @endif
                </div>
            </div>

            <form action="">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="search.." name="search" value="{{ request('search') }}">
                    <button class="btn btn-primary" type="submit">Search</button>
                </div>
            </form>

            <div class="row justify-content-center">
                <div class="col-sm-12">
                    <table class="table table-responsive table-hover">
                        <thead>
                            <tr class="text-center">
                                <th scope="col">No</th>
                                <th scope="col">Merk</th>
                                <th scope="col">No Polisi</th>
                                <th scope="col">Tahun Produksi</th>
                                <th scope="col">Stok</th>
                                <th scope="col">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse ($car as $car)
                            <tr class="text-center">
                                <th scope="row">{{ $car->id }}</th>
                                <td>{{ $car->merk->nama }}</td>
                                <td>{{ $car->no_polisi }}</td>
                                <td>{{ $car->tahun_produksi->nama }}</td>
                                <td>{{ $car->stok }}</td>
                                <td>
                                    <a href="{{ route('showCarAdmin', $car->slug) }}" class="btn-sm btn-info"><i class="bi bi-eye-fill" style="color: rgb(0, 0, 0);"></i></a>
                                    <form action="{{ route('carDelete', $car->slug) }}" method="post" class="d-inline" id="{{ $car->slug }}">
                                        @method('delete')
                                        @csrf
                                        <a href="#" style="color: rgb(0, 0, 0);" class="btn-sm btn-danger text-decoration-none" data-id="{{ $car->slug }}" id="deleteCar"><i class="bi bi-trash-fill"></i></a>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center h3">DATA KOSONG</td>
                            </tr>
                            @endforelse
                            </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('sweet')
    <script>
        $('#deleteShop').on('click', function(e) {
            e.preventDefault();
            let id = $(this).data('id');
            Swal.fire({
                title: 'Are you sure ?',
                text: 'Hapus toko ini ?',
                icon: 'warning',
                confirmButtonColor: '#d33',
                cancelButtonColor: '#aaa',
                confirmButtonText: 'Confirm',
                showCancelButton: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#deleteShop-form').submit();
                }
            })
        });

        $(document).on('click', '#deleteCar', function(e) {
            e.preventDefault();
            let id = $(this).data('id');
            Swal.fire({
                title: 'Are you sure ?',
                text: "Hapus mobil ini ?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#'+id).submit();
                }
            })
        });
    </script>
@endpush
