@extends('layouts.main')

@section('container')
<div class="row justify-content-center mt-5">
    <div class="col-lg-12">
        <div class="card px-4 py-4 border border-grey-500">
            <h2 class="m-b-20 p-b-5 b-b-default mt-3 text-center">DASHBOARD ADMIN</h2>
            <div class="row justify-content-center">
                <div class="col-lg-2">
                    <div class="card text-white bg-dark">
                        <div class="card-body">
                            <div class="pt-1">
                                <a class="text-white fs-6" href="{{ route('allusers.index') }}">
                                    <i class="mr-2 bi bi-person-fill"> Pengguna</i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="card text-white bg-secondary">
                        <div class="card-body">
                            <div class="pt-1">
                                <a class="text-white fs-6" href="{{ route('allshops.index') }}">
                                    <i class="mr-2 bi bi-house-fill"> Toko</i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="card text-white bg-danger">
                        <div class="card-body">
                            <div class="pt-1">
                                <a class="text-white fs-6" href="{{ route('allkriteria.index') }}">
                                    <i class="mr-2 bi bi-card-list"> Kriteria</i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="card text-white bg-warning">
                        <div class="card-body">
                            <div class="pt-1">
                                <a class="text-white fs-6" href="{{ route('allalternatif.index') }}">
                                    <i class="mr-2 bi bi-blockquote-right"> Alternatif</i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- <div class="col-lg-2">
                    <div class="card text-white bg-primary">
                        <div class="card-body">
                            <div class="pt-1">
                                <a class="text-white fs-6" href="{{ route('laporan') }}">
                                    <i class="mr-2 bi bi-blockquote-right"> Laporan</i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div> --}}
            </div>
        </div>
    </div>
</div>
<div class="row justify-content-center">
    <div class="col-lg-12">
        <div class="card px-5 py-5 border border-grey-500">
            <div class="row justify-content-center">
                <div class="col-sm-12">
                    <h4 class="m-b-20 p-b-5 b-b-default mt-3">Pendaftar Toko : </h4>
                    <form action="{{ route('dashboard.index') }}">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="search.." name="searchms" value="{{ request('searchms') }}">
                            <button class="btn btn-secondary" type="submit">Search</button>
                        </div>
                    </form>
                </div>
                <div class="col-lg-12">
                    <table class="table table-responsive table-hover">
                        <thead>
                            <tr class="text-center">
                                <th scope="col">User ID</th>
                                <th scope="col">Nama Pemilik</th>
                                <th scope="col">Nama Usaha</th>
                                <th scope="col">NIK</th>
                                <th scope="col">Waktu daftar</th>
                                <th scope="col">Status</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($makeshop as $ms)
                                <tr class="text-center">
                                    <td>{{ $ms->user_id }}</td>
                                    <td>{{ $ms->nm_pu }}</td>
                                    <td>{{ $ms->nm_usaha }}</td>
                                    <td>{{ $ms->nik }}</td>
                                    <td>{{ $ms->created_at }}</td>
                                    <td>{{ $ms->status }}</td>
                                    <td>
                                        <a href="{{ route('dashboard.show',$ms->slug) }}" class="btn-sm btn-info"><i class="bi bi-eye-fill" style="color: rgb(0, 0, 0);"></i></a>
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
                 {{-- <div class="col">
                    <a href="{{ route('AddAllImage',1) }}" class="btn btn-sm btn-danger">Add All Image</a>
                </div> --}}
            </div>
        </div>
    </div>
</div>
@endsection
