@extends('layouts.main')

@section('container')
<div class="row justify-content-center mt-5">
    <div class="col-lg-9">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-center">
                    <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner m-2" style="max-height: 450px; max-width: 450px;">
                            <div class="carousel-item active">
                                <img src="{{ isset($shop->foto_usaha) == null ? url('images/notfound.png') : asset('storage/' . $shop->foto_usaha) }}" class="d-block w-100" alt="...">
                            </div>
                            <div class="carousel-item">
                                <img src="{{ isset($shop->pas_foto) == null ? url('images/notfound.png') : asset('storage/' . $shop->pas_foto) }}" class="d-block w-100" alt="...">
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
                <h6 class="m-b-20 p-b-5 b-b-default mt-3">INFORMASI TOKO</h6>
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
                            <input type="text" class="form-control rounded-top" id="nm_pu" value="+62 {{ $shop->user->no_hp }}">
                            <label for="nm_pu">No Hp</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-10 mt-5">
                            <a href="{{ route('sharelok', $shop->slug) }}" class="mr-1 mt-1 btn btn-primary">
                                <i class="mr-2 bi bi-house-fill"></i> Cek Lokasi Toko
                            </a>
                            <a href="tel:{{ '+62'.$shop->user->no_hp }}" class="mr-1 mt-1 btn btn-primary">
                                <i class="mr-2 bi bi-telephone-fill"></i> Telpon
                            </a>
                            <a href="https://web.whatsapp.com/send?phone={{ '62'.$shop->user->no_hp }}&text=Hi%2C%20Saya%20lihat%20iklan%20kendaraan%20Anda%20di%20RentCar.com%20dan%20saya%20ingin%20mengetahui%20lebih%20lanjut%20tentang%20Mobil%20tersebut%20Terima%20kasih%20" target="_blank" class="mr-1 mt-1 btn btn-success">
                                <i class="mr-2 bi bi-whatsapp"></i> WA Pemilik
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-9">
        <div class="card px-5 py-5">
            <h3>DAFTAR MOBIL</h3>
            <table class="table table-responsive table-hover">
                <thead>
                    <tr class="text-center">
                        <th scope="col">No</th>
                        <th scope="col">Merk</th>
                        <th scope="col">Tahun</th>
                        <th scope="col">Seater</th>
                        <th scope="col">Stok</th>
                        <th scope="col">Harga Sewa</th>
                        <th scope="col">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse ($car as $car)
                    <tr class="text-center">
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td>{{ $car->merk->nama }}</td>
                        <td>{{ $car->tahun_produksi->nama }}</td>
                        <td>{{ $car->muatan_penumpang->nama }}</td>
                        <td>{{ $car->stok }}</td>
                        <td>{{ "Rp. " . number_format($car->harga_sewa->nama,2,',','.') }}/hari</td>
                        <td>
                            <a href="{{ route('detailMobil', $car->slug) }}" class="btn-sm btn-info"><i class="bi bi-eye-fill" style="color: rgb(0, 0, 0);"></i></a>
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
@endsection
