@extends('layouts.main')

@section('container')
<div class="row justify-content-center mt-3">
    <div class="col-lg-8">
        <div class="card user-card-full">
            <div class="col">
                <div class="card-block">
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
                                <input type="text" class="form-control rounded-top" disabled value="{{ "Rp. " . number_format($car->harga_sewa->nama,2,',','.') . '\hari' }}">
                                <label>Harga Sewa</label>
                            </div>
                        </div>
                        <div class="col-sm-6 mb-4">
                            <div class="form-floating text-white">
                                <input type="text" class="text-white form-control rounded-top {{ $car->stok == 'standby' ? 'bg-success' : 'bg-danger' }}" disabled value="{{ $car->stok }}">
                                <label>Stok</label>
                            </div>
                        </div>
                        <div class="col-sm-6 mb-4">
                            <div class="form-floating">
                                <input type="text" class="form-control rounded-top" disabled value="{{ $car->no_polisi }}">
                                <label>Plat Kendaraan</label>
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
                                <a href="{{ route('toko.index') }}" style="color: rgb(0, 0, 0);" class="mt-1 btn btn-sm btn-primary">
                                    <i class="bi bi-arrow-left-circle"></i> Back
                                </a>
                                <a href="{{ route('shop.edit', $car->slug) }}" style="color: rgb(0, 0, 0);" class=" mt-1 btn btn-sm btn-warning">
                                    <i class="bi bi-pencil-square"></i> Edit
                                </a>
                                <a href="{{ route('sharelok', $car->shop->slug) }}" style="color: rgb(0, 0, 0);" class=" mt-1 btn btn-sm btn-success">
                                    <i class="bi bi-house-fill"></i> Lokasi Toko
                                </a>
                                <form action="{{ route('shop.destroy', $car->slug) }}" method="post" id="deleteCar-form" class="d-inline">
                                    @method('delete')
                                    @csrf
                                    <button id="deleteCar" class="mt-1 btn btn-sm btn-danger text-decoration-none" style="color: rgb(0, 0, 0);"><i class="bi bi-trash-fill"></i> Hapus</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row justify-content-center mb-3">
    <div class="col-lg-8">
        <div class="card user-card-full">
            <div class="col">
                <div class="card-block">
                    <h6 class="m-b-20 p-b-5 b-b-default f-w-600">Rating : </h6>
                    @if ($review)
                        <div class="pd-rating">
                            @if ($rating >= 1)
                                <i class="bi bi-star-fill"></i>
                            @elseif ($rating >= 0.5)
                                <i class="bi bi-star-half"></i>
                            @else
                                <i class="bi bi-star"></i>
                            @endif

                            @if ($rating >= 2)
                                <i class="bi bi-star-fill"></i>
                            @elseif ($rating >= 1.5)
                                <i class="bi bi-star-half"></i>
                            @else
                                <i class="bi bi-star"></i>
                            @endif

                            @if ($rating >= 3)
                                <i class="bi bi-star-fill"></i>
                            @elseif ($rating >= 2.5)
                                <i class="bi bi-star-half"></i>
                            @else
                                <i class="bi bi-star"></i>
                            @endif

                            @if ($rating >= 4)
                                <i class="bi bi-star-fill"></i>
                            @elseif ($rating >= 3.5)
                                <i class="bi bi-star-half"></i>
                            @else
                                <i class="bi bi-star"></i>
                            @endif

                            @if ($rating >= 5)
                                <i class="bi bi-star-fill"></i>
                            @elseif ($rating >= 4.5)
                                <i class="bi bi-star-half"></i>
                            @else
                                <i class="bi bi-star"></i>
                            @endif
                            <span>{{ $rating }}</span>
                            <small class="text-black f-w-600">of {{ $review }} review</small>
                        </div>
                    @else
                        <div class="pd-rating">
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <span>5</span>
                            <small class="text-black f-w-600">of 0 review</small>
                        </div>
                    @endif
                    <h6 class="m-b-20 p-b-5 b-b-default f-w-600 mt-4">Comment :</h6>
                    @forelse ($ulasan as $ulas)
                        <div class="d-flex flex-row user-info">
                            <img class="rounded-circle" src="{{ isset($ulas->user->image) == null ? url('images/notfound.png') : asset('storage/' . $ulas->user->image) }}" width="40">
                            <div class="d-flex flex-column justify-content-start ml-2">
                                <span class="d-block font-weight-bold name">{{ $ulas->user->username }}</span>
                                <span class="date text-black-50">{{ $ulas->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                        <div class="mt-2 ml-2">
                            <p class="comment-text">{{ $ulas->komentar }}</p>
                        </div>
                    @empty
                        <div class="mt-2 ml-2">
                            <p class="comment-text text-center">Belum Ada Komentar</p>
                        </div>
                    @endforelse
                    <h6 class="b-b-default"></h6>
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
                text: 'Menghapus mobil ini ?',
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
