@extends('layouts.main')

@section('container')
<div class="row justify-content-center mt-5 mb-5">
    <div class="col-lg-6">
        <div class="card px-5 py-5 border border-gray-800">
            <main class="form-registration">
                <h1 class="h3 mb-3 fw-normal text-center">Edit Profil</h1>
                <form action="{{ route('profil.update', $data->slug) }}" method="post" enctype="multipart/form-data" id="editProfil-form">
                    @method('put')
                    @csrf
                    <div class="form-floating">
                        <input type="email" name="email" class="form-control rounded-top @error('email') is-invalid @enderror" id="email" placeholder="Email" value="{{ old('email',$data->email) }}">
                        <label for="email">Email</label>
                        @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-floating">
                        <input type="text" name="username" class="form-control @error('username') is-invalid @enderror" id="username" placeholder="Username" value="{{ old('username',$data->username) }}">
                        <label for="username">Username</label>
                        @error('username')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-floating">
                        <input type="number" name="no_hp" class="form-control @error('no_hp') is-invalid @enderror" id="no_hp" placeholder="No Hp" value="{{ old('no_hp', $data->no_hp) }}">
                        <label for="no_hp">No Hp</label>
                        @error('no_hp')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="card mt-2 mb-2 bg-secondary text-white text-left">
                        <div class="card-body p-2">
                            <h6 class="card-title m-0">Foto Profil</h6>
                        </div>
                    </div>
                    <div class="custom-file">
                        <input type="hidden" name="oldimg" value="{{ $data->image }}">
                        <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" id="image">
                        @error('image')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <button class="w-100 btn btn-sm btn-primary mt-3" id="editProfil">SUBMIT</button>
                </form>
            </main>
        </div>
    </div>
</div>
@endsection

@push('sweet')
    <script>
        $('#editProfil').on('click', function(e) {
            e.preventDefault();
            let id = $(this).data('id');
            Swal.fire({
                title: 'Are you sure ?',
                text: 'Ubah informasi profil ?',
                icon: 'warning',
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Confirm',
                showCancelButton: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#editProfil-form').submit();
                }
            })
        });
    </script>
@endpush
