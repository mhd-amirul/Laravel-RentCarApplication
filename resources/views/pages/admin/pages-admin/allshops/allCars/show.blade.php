@extends('layouts.main')

@section('container')
<div class="row justify-content-center mt-3">
    <div class="col-lg-8">
        <div class="card user-card-full">
            <div class="col">
                <div class="card-block">
                    <h6 class="m-b-20 p-b-5 b-b-default f-w-600">Toko : <a href="{{ route('profileToko', $car->shop_id) }}" class="text-black">{{ $car->shop->nm_usaha }}</a></h6>
                    <div class="d-flex justify-content-center">
                        <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner m-2" style="max-height: 400px; max-width: 400px; overflow: hidden;">
                                <div class="carousel-item active">
                                    <img src="{{ isset($car->gambar1) == null ? url('images/notfound.png') : asset('storage/' . $car->gambar1) }}" class="d-block w-100" alt="...">
                                </div>
                                <div class="carousel-item">
                                    <img src="{{ isset($car->gambar2) == null ? url('images/notfound.png') : asset('storage/' . $car->gambar2) }}" class="d-block w-100" alt="...">
                                </div>
                                <div class="carousel-item">
                                    <img src="{{ isset($car->gambar3) == null ? url('images/notfound.png') : asset('storage/' . $car->gambar3) }}" class="d-block w-100" alt="...">
                                </div>
                                <div class="carousel-item">
                                    <img src="{{ isset($car->gambar4) == null ? url('images/notfound.png') : asset('storage/' . $car->gambar4) }}" class="d-block w-100" alt="...">
                                </div>
                                <div class="carousel-item">
                                    <img src="{{ isset($car->gambar5) == null ? url('images/notfound.png') : asset('storage/' . $car->gambar5) }}" class="d-block w-100" alt="...">
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
                    <h6 class="m-b-20 p-b-5 b-b-default f-w-600 mt-5">INFORMASI MOBIL</h6>
                    <div class="row">
                        <div class="col-sm-6 mb-4">
                            <div class="form-floating">
                                <input type="text" class="form-control rounded-top" disabled value="{{ $car->merk->nama }}">
                                <label>Merk</label>
                            </div>
                        </div>
                        <div class="col-sm-6 mb-4">
                            <div class="form-floating">
                                <input type="text" class="form-control rounded-top" disabled value="{{ $car->tahun_produksi->nama }}">
                                <label>Tahun Produksi</label>
                            </div>
                        </div>
                        <div class="col-sm-6 mb-4">
                            <div class="form-floating">
                                <input type="text" class="form-control rounded-top" disabled value="{{ $car->muatan_penumpang->nama }}">
                                <label>Muatan Penumpang</label>
                            </div>
                        </div>
                        <div class="col-sm-6 mb-4">
                            <div class="form-floating">
                                <input type="text" class="form-control rounded-top" disabled value="{{ $car->kapasitas_mesin->nama }}">
                                <label>Kapasitas Mesin</label>
                            </div>
                        </div>
                        <div class="col-sm-6 mb-4">
                            <div class="form-floating">
                                <input type="text" class="form-control rounded-top" disabled value="{{ $car->kondisi_mesin->nama }}">
                                <label>Kondisi Mesin</label>
                            </div>
                        </div>
                        <div class="col-sm-6 mb-4">
                            <div class="form-floating">
                                <input type="text" class="form-control rounded-top" disabled value="{{ $car->kondisi_fisik->nama }}">
                                <label>Kondisi Fisik</label>
                            </div>
                        </div>
                        <div class="col-sm-6 mb-4">
                            <div class="form-floating">
                                <input type="text" class="form-control rounded-top" disabled value="{{ $car->jenis_bbm->nama }}">
                                <label>Jenis BBM</label>
                            </div>
                        </div>
                        <div class="col-sm-6 mb-4">
                            <div class="form-floating">
                                <input type="text" class="form-control rounded-top" disabled value="{{ $car->harga_sewa->nama }}">
                                <label>Harga Sewa</label>
                            </div>
                        </div>
                        <div class="col-sm-6 mb-4">
                            <div class="form-floating text-white">
                                <input type="text" class="form-control rounded-top {{ $car->stok == 'standby' ? 'bg-success' : 'bg-danger' }} text-white" disabled value="{{ isset($car->stok) == null ? 0 : $car->stok }}">
                                <label>Stok</label>
                            </div>
                        </div>
                        <div class="row">
                            <p class="m-b-10 f-w-600">Deskripsi</p>
                            <div class="col-sm-12 mb-4">
                                <article class="text-muted f-w-400">
                                    @if ($car->deskripsi)
                                        {!! $car->deskripsi !!}
                                    @else
                                        {!! 'Deskripsi Tidak Tersedia' !!}
                                    @endif
                                </article>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-9 mt-5">
                                <a href="{{ route('allshops.show', $car->shop->slug) }}" style="color: rgb(0, 0, 0);" class="btn btn-sm btn-primary">
                                    <i class="bi bi-arrow-left-circle"></i> Back
                                </a>
                                <a href="{{ route('editCarAdmin', $car->slug) }}" style="color: rgb(0, 0, 0);" class=" btn btn-sm btn-warning">
                                    <i class="bi bi-pencil-square"></i> Edit
                                </a>
                                <form action="{{ route('carDelete', $car->slug) }}" method="post" class="d-inline" id="deleteCar-form">
                                    @method('delete')
                                    @csrf
                                    <a href="#" class="btn btn-sm btn-danger text-decoration-none" id="deleteCar" style="color: rgb(0, 0, 0);"><i class="bi bi-trash-fill"></i> Hapus</a>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('sweet')
    <script>
        $('#deleteCar').on('click', function(e) {
            e.preventDefault();
            let id = $(this).data('id');
            Swal.fire({
                title: 'Are you sure ?',
                text: 'Hapus mobil ini ?',
                icon: 'warning',
                confirmButtonColor: '#d33',
                cancelButtonColor: '#aaa',
                confirmButtonText: 'Confirm',
                showCancelButton: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#deleteCar-form').submit();
                }
            })
        });
    </script>
@endpush
