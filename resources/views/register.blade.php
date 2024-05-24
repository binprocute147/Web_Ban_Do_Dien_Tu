<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
</head>

<body>
    <form class="form" action="{{ route('register') }}" method="post" id="registerForm">
        {{-- hiển thị lỗi khi đăng ký không thành công --}}
        @if (session('error'))
            <div class="alert alert-danger">
                <p style="color: red; text-align: center">{{ session('error') }}</p>
            </div>
        @endif

        @csrf
        <p class="title">Register </p>
        <div class="flex">
            <label>
                <input required="" placeholder="" type="text" class="input" style="width: 145px;"
                    name="first_name">
                <span>Firstname</span>
            </label>

            <label>
                <input required="" placeholder="" type="text" class="input" style="width: 160px;"
                    name="last_name">
                <span>Lastname</span>
            </label>
        </div>

        <label>
            <input required="" placeholder="" type="text" class="input" name="address">
            <span>Address</span>
        </label>
        <label>
            <input required="" placeholder="" type="email" class="input" name="email">
            <span>Email</span>
        </label>
        <label>
            <input required="" placeholder="" type="text" class="input" name="user_name">
            <span>User Name</span>
        </label>
        <label>
            <input required="" placeholder="" type="password" class="input" name="password">
            <span>Password</span>
        </label>
        <button class="submit">Đăng Ký</button>
        <p class="signin">Already have an acount ? <a href="{{ url('/login') }}">Sign in</a> </p>
    </form>

</body>
{{-- js xóa dữ liệu khi load lại trang --}}
<script>
    window.onload = function() {
        document.getElementById('registerForm').reset();
    }
</script>

</html>
