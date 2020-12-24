@extends('layouts.fe')
<style>
    @media(max-width: 760px) {
        .chat {
            display: none;
        }

        .full {
            width: 100%;
        }
    }

</style>
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 full">
            <div class="row-6">
                <div class="card">
                    <form id="form-postingan" action="{{ route('postingan.store') }}" method="post">
                        @csrf
                        <div class="card-body">
                            <textarea name="isi" id="isi" cols="30" rows="10"
                                class="form-control">Write Something ...</textarea>
                            <p></p>
                            <div class="row">
                                <div class="col-9 form-inline">
                                    <div class="form-group mb-2">
                                        <label for="staticEmail2" class="sr-only">Email</label>
                                        <input type="text" class="form-control" id="nama" name="nama"
                                            placeholder="Nama Kamu">
                                    </div>
                                    <div class="form-group mx-sm-3 mb-2">
                                        <label for="inputPassword2" class="sr-only">Password</label>
                                        <input type="password" class="form-control" id="key" name="key"
                                            placeholder="Kata Kunci Kamu">
                                    </div>

                                </div>
                                <div class="col-sm form-inline">
                                    <div class="card ">
                                        <button class="btn btn-primary">POST</button>
                                    </div>
                                    <div class="card">
                                        <button class="btn btn-danger">Clear</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="row-6">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title">Recent Post ...</div>
                        @foreach ($data as $item)
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title">
                                    <h4>{{ $item->nama }}</h4>On {{ $item->created_at }}
                                </div>Says :

                                <div class="card-text">
                                    <h4>{{ $item->isi }}</h4>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col">
                                        <button class="btn btn-primary"
                                            onclick="like('{{ $item->UUID }}')">{{ $item->like }} Like</button>
                                        <button class="btn btn-primary"> 22 Komentar</button>
                                        <button class="btn btn-primary"
                                            onclick="editConfirm('{{ $item->UUID }}')">Edit</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>
        {{-- <div class="col-md-4 chat">
            <div class="row-2">
                <div class="card" style="height:50%; width:100%; ">
                    <div class="card-body">
                        <iframe src="https://vue-chat-app-1507.firebaseapp.com/" width="100%" height="100%"
                            scrolling="no">
                            <p>Your browser does not support iframes.</p>
                        </iframe>



                    </div>

                </div>
            </div>
            <div class="row-4">
                <div class="card">
                    <div class="card-title">
                        test
                    </div>
                </div>
            </div>

        </div> --}}
    </div>
</div>

<script>
    function like(UUID) {
        $.ajax({
            method: "PUT",
            headers: {
                'X-CSRF-Token': '{{ csrf_token() }}',
            },
            url: '/postingan/' + UUID,
            data: {
                            'type': 'like'
                        },
            success: function (response) {
                window.location.href = window.location

            }
        });
    }

    function editConfirm(UUID) {
        console.log(UUID);
        Swal.fire({
            title: 'Warning',
            text: 'Edit membutuhkan kode kunci, pastikan anda memiliki atau mengingat kode kunci. Lanjutkan ?',
            icon: 'warning',
            confirmButtonText: 'Okey'
        }).then(() => {
            Swal.fire({
                title: 'Enter your password',
                input: 'password',
                inputLabel: 'Password',
                inputPlaceholder: 'Enter your password',
                inputAttributes: {
                    maxlength: 10,
                    autocapitalize: 'off',
                    autocorrect: 'off'
                }
            }).then((v) => {
                if (v.value != '') {
                    $.ajax({
                        method: "POST",
                        headers: {
                            'X-CSRF-Token': '{{ csrf_token() }}',
                        },
                        url: '{{ route('cek.postingan') }}',
                        data: {
                            'key': v.value,
                            'UUID': UUID
                        },
                        success: function (response) {
                            if (response == 'true') {
                                Swal.fire({
                                    input: 'textarea',
                                    inputLabel: 'isi',
                                    inputPlaceholder: 'Type your message here...',
                                    inputAttributes: {
                                        'aria-label': 'Type your message here'
                                    },
                                    showCancelButton: true
                                }).then((v) => {
                                    $.ajax({
                                        method: "PUT",
                                        headers: {
                                            'X-CSRF-Token': '{{ csrf_token() }}',
                                        },
                                        url: '/postingan/' + UUID,
                                        data: {
                                            'isi': v.value
                                        },
                                        success: function (response) {
                                            if (response == 'true') {
                                                Swal.fire({
                                                    title: 'success',
                                                    text: 'Edit Berhasil',
                                                    icon: 'success',
                                                    confirmButtonText: 'Okey'
                                                }).then(() => {
                                                    window
                                                        .location
                                                        .href =
                                                        window
                                                        .location;
                                                });
                                            }

                                        }
                                    });
                                })
                            } else {
                                Swal.fire(`Kode Salah `);
                            }



                        }
                    });
                } else {
                    Swal.fire(`Kode Kosong`)

                }




                console.log(v.value);

            })



        });
    }

</script>
@endsection
