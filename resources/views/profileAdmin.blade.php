@extends('system')
@section('content-admin')
    <title>Profile Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .body {
            font-family: Arial, sans-serif;
            background-color: #f1f1f1;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .profile-img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            margin-top: 50px;
        }

        .profile-info {
            margin-top: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            font-size: 14px;
            font-weight: bold;
            color: #333;
        }

        .form-control {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
        }

        .profile-button {
            background-color: #682773;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }

        .profile-button:hover {
            background-color: #552663;
        }
    </style>
    <div id="content">
        <div id="content-header">
            <div id="breadcrumb"> <a href="{{ url('/Dashboard') }}" title="Go to Home" class="tip-bottom current"><i
                        class="icon-home"></i> Home</a></div>
            <h1>Profile Admin</h1>
        </div>
        <div class="body">
            <div class="container">
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
                <div class="profile-header text-center">
                    <img src="https://st3.depositphotos.com/15648834/17930/v/600/depositphotos_179308454-stock-illustration-unknown-person-silhouette-glasses-profile.jpg"
                        alt="Profile Picture" class="profile-img">
                    <h2>{{ Session::get('admin')->username }}</h2>
                    <span class="text-black-50">Vai trò: {{ Session::get('admin')->role }}</span>
                </div>
                <div class="profile-info">
                    <form action="{{ route('profileAdmin') }}" method="POST" id="profileForm">
                        @csrf
                        <div class="form-group">
                            <label for="username">User Name</label>
                            <input type="text" class="form-control" id="username" name="username"
                                value="{{ Session::get('admin')->username }}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="password" name="password"
                                value="{{ Session::get('admin')->password }}" readonly>
                            <input type="checkbox" id="showPassword"> Hiển thị mật khẩu
                        </div>
                        <div class="form-group">
                            <label for="role">Role</label>
                            <input type="text" class="form-control" id="role" name="role"
                                value="{{ Session::get('admin')->role }}" readonly>
                        </div>
                        <div class="text-center">
                            <button class="profile-button" type="button" id="editButton">Chỉnh sữa thông tin cá
                                nhân</button>
                            <button class="profile-button" type="submit" id="saveButton" style="display: none;">Lưu thông
                                tin</button>
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
            document.getElementById('username').readOnly = false;
            document.getElementById('password').readOnly = false;
            document.getElementById('role').readOnly = false;

            // Hide the edit button and show the save button
            document.getElementById('editButton').style.display = 'none';
            document.getElementById('saveButton').style.display = 'block';
        });
    </script>

@endsection
