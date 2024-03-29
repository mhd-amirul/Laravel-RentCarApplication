@extends('layouts.main')

@section('container')
<div class="row justify-content-center mt-5" style="margin-bottom: 7cm">
    <div class="col-lg-10">
        <div class="card px-4 py-4 border border-grey-500">
            <h2 class="m-b-20 p-b-5 b-b-default mt-3 text-center">DISCOUNT CAR</h2>
            <div class="row">
                <div class="col-sm-12">
                    <a href="{{ route('toko.index') }}" class="mt-1 btn btn-dark"><i class="bi bi-arrow-left-circle"></i> Back</a>
                    <a href="{{ route('dcadd') }}" class="mt-1 btn btn-primary"><i class="bi bi-file-earmark-plus"></i> Tambah</a>
                </div>
            </div>
            <div class="row d-flex justify-content-start mt-3">
                <div class="col-lg-12">
                    <table class="table table-responsive table-hover">
                        <thead>
                            <tr class="text-center">
                                <th scope="col">No. </th>
                                <th scope="col">BL</th>
                                <th scope="col">Merk</th>
                                <th scope="col">Discount</th>
                                <th scope="col">Created At</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($diskon as $h)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    @foreach ($cars as $car)
                                        @if ($car->id == $h->car_id)
                                            <td>{{ $car->no_polisi }}</td>
                                            <td>{{ $car->merk->nama }}</td>
                                        @endif
                                    @endforeach
                                    <td>{{ $h->discount }} %</td>
                                    <td>{{ $h->created_at }}</td>
                                    <td>
                                        <a href="{{ route('dcedit', $h->id) }}" class="btn-sm btn-warning" style="color: rgb(0, 0, 0);"><i class="bi bi-pencil-square"></i></i></a>
                                        <form action="{{ route('dcdelete', $h->id) }}" method="post" class="d-inline" id="deleteDisk-form-{{ $h->id }}">
                                            @method('delete')
                                            @csrf
                                            <a href="#" class="btn-sm btn-danger text-decoration-none" id="deleteDisk" data-id="{{ $h->id }}" style="color: rgb(0, 0, 0);"><i class="bi bi-trash-fill"></i></a>
                                        </form>
                                    </td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center h3">DATA KOSONG</td>
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
        $(document).on('click', '#deleteDisk', function(e) {
            e.preventDefault();
            let id = $(this).data('id');
            Swal.fire({
                title: 'Are you sure ?',
                text: "Hapus mobil ?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#deleteDisk-form-'+id).submit();
                }
            })
        });
    </script>
@endpush
