@extends('app')
@section('content')
    <title>Profile User</title>
    <script type='text/javascript' src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>
    <style>
        ::-webkit-scrollbar {
            width: 8px;
        }

        /* Track */
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        /* Handle */
        ::-webkit-scrollbar-thumb {
            background: #888;
        }

        /* Handle on hover */
        ::-webkit-scrollbar-thumb:hover {
            background: #555;
        }

        body {
            background: rgb(99, 39, 120)
        }

        .form-control:focus {
            box-shadow: none;
            border-color: #BA68C8
        }

        .profile-button {
            background: rgb(99, 39, 120);
            box-shadow: none;
            border: none
        }

        .profile-button:hover {
            background: #682773
        }

        .profile-button:focus {
            background: #682773;
            box-shadow: none
        }

        .profile-button:active {
            background: #682773;
            box-shadow: none
        }

        .back:hover {
            color: #682773;
            cursor: pointer
        }

        .labels {
            font-size: 11px
        }

        .add-experience:hover {
            background: #BA68C8;
            color: #fff;
            cursor: pointer;
            border: solid 1px #BA68C8
        }
    </style>
    </head>

    <body className='snippet-body'>
        <div class="container rounded bg-white mt-5 mb-5">
            <div class="row">
                <div class="col-md-3 border-right">
                    <div class="d-flex flex-column align-items-center text-center p-3 py-5"><img class="rounded-circle mt-5"
                            width="150px"
                            src="https://st3.depositphotos.com/15648834/17930/v/600/depositphotos_179308454-stock-illustration-unknown-person-silhouette-glasses-profile.jpg"><span
                            class="font-weight-bold">{{ Session::get('user')->last_name }}
                            {{ Session::get('user')->first_name }}</span><span
                            class="text-black-50">{{ Session::get('user')->email }}</span><span> </span></div>
                </div>
                <div class="col-md-5 border-right">
                    {{-- hiển thị thông báo cập nhật thành công  --}}
                    @if (session('status'))
                        <div class="alert alert-success" style="color: green">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{-- Hiển thị lỗi  --}}
                    @if ($errors->any())
                        <div class="alert alert-danger" style="color: red">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="p-3 py-5">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="text-right">Profile User</h4>
                        </div>
                        <form action="{{ route('profileUser') }}" method="POST" id="profileForm">
                            @csrf
                            <div class="row mt-2">
                                <div class="col-md-6"><label class="labels">First Name</label>
                                    <input type="text" class="form-control" id="firstname" name="firstname"
                                        value="{{ Session::get('user')->first_name }}" readonly>
                                </div>
                                <div class="col-md-6"><label class="labels">Last Name</label>
                                    <input type="text" class="form-control" id="lastname" name="lastname"
                                        value="{{ Session::get('user')->last_name }}" readonly><br>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-12"><label class="labels">Address</label><input type="text"
                                        class="form-control" id="address" name="address"
                                        value="{{ Session::get('user')->address }}" readonly></div>
                                <div class="col-md-12"><label class="labels">Email</label><input type="email"
                                        class="form-control" id="email" name="email"
                                        value="{{ Session::get('user')->email }}" readonly><br></div>
                                <div class="col-md-12"><label class="labels">User Name</label>
                                    <input type="text" class="form-control" id="username" name="username"
                                        value="{{ Session::get('user')->user_name }}" readonly>
                                </div>
                                <div class="col-md-12"><label class="labels">Pass Word</label>
                                    <input type="password" class="form-control" id="password" name="password"
                                        value="{{ Session::get('user')->password }}" readonly>
                                    <input type="checkbox" id="showPassword"> Hiển thị mật khẩu
                                </div>
                            </div>
                            <div class="mt-5 text-center">
                                <button class="btn btn-primary profile-button" type="button" id="editButton">Chỉnh sửa
                                    thông
                                    tin cá nhân</button>
                                <button class="btn btn-primary profile-button" type="submit" id="saveButton"
                                    style="display: none;">Lưu Thông Tin</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script type='text/javascript'
            src='https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/js/bootstrap.bundle.min.js'></script>
        </script>
        <script>
            // hiển thị mật khẩu
            document.getElementById('showPassword').addEventListener('change', function() {
                var passwordField = document.getElementById('password');
                if (this.checked) {
                    passwordField.type = 'text';
                } else {
                    passwordField.type = 'password';
                }
            });

            document.getElementById('editButton').addEventListener('click', function() {
                // Enable the form fields
                document.getElementById('firstname').readOnly = false;
                document.getElementById('lastname').readOnly = false;
                document.getElementById('address').readOnly = false;
                document.getElementById('email').readOnly = false;
                document.getElementById('username').readOnly = false;
                document.getElementById('password').readOnly = false;

                // Hide the edit button and show the save button
                document.getElementById('editButton').style.display = 'none';
                document.getElementById('saveButton').style.display = 'block';
            });
        </script>
    @endsection
