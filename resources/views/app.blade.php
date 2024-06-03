<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- thêm token vào header --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Website bán đồ điện tử</title>
    {{-- thêm thư viện ajax --}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    {{-- bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    {{-- font --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css" />
    <!-- Google Fonts Roboto -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" />
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"
        integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <style>
        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
            font-family: 'Muli', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol', 'Noto Color Emoji';
        }

        li {
            list-style: none;
        }

        /* header */
        nav {
            padding: 15px;
            width: 100%;
            display: flex;
            background: #f1df11;
        }

        nav .content-nav {
            display: flex;
            line-height: 2rem;
            flex-direction: row;
            justify-content: flex-end;
            width: 60%;
        }

        nav .content-nav ul {
            display: flex;
        }

        nav .content-nav ul li a {
            text-decoration: none;
            color: #43433e;
            text-transform: uppercase;
            padding: 0 15px;
            font-weight: 800;
        }

        nav .content-nav ul li a:hover {
            color: #fff;
        }

        .content-nav form {
            position: relative;
        }

        .content-nav form input {
            border: none;
            background: #fff;
            padding: 7px;
            outline: none;
            border-radius: 12px;
        }

        .content-nav form button {
            padding: 5px;
            border-radius: 12px;
            position: absolute;
            right: 0;
            top: 2px;
            border: none;
            outline: none;
            background: #fff;
        }

        /* modal */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            padding-top: 100px;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0, 0, 0);
            background-color: rgba(0, 0, 0, 0.4);
        }

        .modal-content {
            margin: 0 auto;
            width: 50%;
            position: relative;
            display: flex;
            flex-direction: column;
            background-color: #fff;
            background-clip: padding-box;
            border: 1px solid rgba(0, 0, 0, .2);
            border-radius: .3rem;
            outline: 0;

        }

        .modal-body {
            padding: 1rem;
        }



        .btn {
            cursor: pointer;
            outline: none;
            font-weight: 400;
            line-height: 1.25;
            text-align: center;
            white-space: nowrap;
            vertical-align: middle;
            border: 1px solid transparent;
            padding: .5rem 1rem;
            font-size: 1rem;
            border-radius: .25rem;
            transition: all .2s ease-in-out;
        }

        .btn-secondary {
            color: #292b2c;
            background-color: #fff;
            border-color: #ccc;
        }

        .btn-primary {
            color: #fff;
            background-color: #0275d8;
            border-color: #0275d8;
        }

        .modal-header {
            align-items: center;
            display: flex;
            justify-content: space-between;
            border-bottom: 1px solid #aaaaaa;
            padding: 1rem;
        }

        h5.modal-title {
            font-size: 1.5rem;
        }

        .close {
            color: #aaaaaa;
            font-size: 28px;
            font-weight: bold;
            display: flex;
            flex-direction: row;
            justify-content: flex-end;
        }

        .close:hover,
        .close:focus {
            color: #000;
            text-decoration: none;
            cursor: pointer;
        }

        #cart {
            font-size: 15px;
            color: #fff;
            background: #c7b200;
            border: 1px solid transparent;
            border-radius: 10px;
            outline: none;
            margin-left: 1rem;
            padding: 12px;
            cursor: pointer;
        }

        #cart:hover {
            border-color: #fff;
        }

        #login {
            font-size: 15px;
            color: #fff;
            background: #c7b200;
            border: 1px solid transparent;
            border-radius: 10px;
            outline: none;
            margin-left: 1rem;
            padding: 12px;
            cursor: pointer;
        }

        #login:hover {
            border-color: #fff;
        }

        /* css drop menu khi người dùng đăng nhập thành công */
        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropbtn {
            font-size: 15px;
            color: #fff;
            background: #c7b200;
            border: 1px solid transparent;
            border-radius: 10px;
            outline: none;
            margin-left: 1rem;
            padding: 12px;
            cursor: pointer;
        }

        .dropbtn:hover {
            border-color: #fff;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            min-width: 180px;
            box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
            padding: 12px 16px;
            z-index: 1;
            border-radius: 10px;
        }

        .info_user {
            color: black;
            text-decoration: none;
        }

        .info_user:hover {
            color: green;
        }

        .logout {
            color: black;
            text-decoration: none;
        }

        .logout:hover {
            color: green;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }


        /* css thông báo lỗi khi tìm sản phẩm */
        .error {
            color: red;
            text-align: center;
            font-family: 'Times New Roman', Times, serif;

        }

        /* banner */
        .banner {
            position: relative;
            width: 100%;
            overflow: hidden;
        }

        .banner img {
            width: 100%;
            height: auto;
            object-fit: cover;
        }

        .nav-button {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(0, 0, 0, 0.404);
            color: white;
            border: none;
            font-size: 2em;
            padding: 10px;
            cursor: pointer;
            border-radius: 5px;
        }

        #prev {
            left: 10px;
        }

        #next {
            right: 10px;
        }

        /* content */
        .hot-product h1 {
            text-align: center;
            background: orangered;
            border-radius: 10px;
            padding: 3px;
        }

        /* manufacturers */
        .manufacturers {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            padding: 0;
            margin: 0;
        }

        .manufacturer-list {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
            list-style: none;
            padding: 0;
            width: 100%;
        }

        .manufacturer-item {
            flex: 1 0 18%;
            /* Điều chỉnh tỷ lệ này để thay đổi số lượng manufacturers trên mỗi hàng */
            max-width: 18%;
            /* Điều chỉnh tỷ lệ này để thay đổi số lượng manufacturers trên mỗi hàng */
            margin: 1%;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
            overflow: hidden;
            border-radius: 10px;
        }

        .manufacturer-item img {
            width: 100%;
            height: 100%;
            /* Đặt chiều cao cố định để ảnh luôn đối xứng với khung hình */
            display: block;
            object-fit: cover;
            /* Đảm bảo ảnh luôn đối xứng với khung hình, không quan tâm đến tỷ lệ khung hình */
        }

        .manufacturer-item img.selected {
            border: 5px solid pink;
            /* Đường viền màu hồng */
        }


        /* css sắp xếp  */
        .sort-buttons {
            text-align: center;
            /* Đặt các nút ở giữa trang */
            margin-bottom: 20px;
            /* Thêm khoảng cách dưới các nút */
        }

        .sort-buttons button {
            background-color: #4CAF50;
            /* Màu nền của nút */
            border: none;
            /* Loại bỏ viền */
            color: white;
            /* Màu chữ của nút */
            padding: 15px 32px;
            /* Đệm trên dưới và trái phải của nút */
            text-align: center;
            /* Căn lề chữ ở giữa nút */
            text-decoration: none;
            /* Loại bỏ gạch chân */
            display: inline-block;
            /* Hiển thị nút trên cùng một hàng */
            font-size: 16px;
            /* Kích thước chữ của nút */
            margin: 4px 2px;
            /* Khoảng cách giữa các nút */
            cursor: pointer;
            /* Thay đổi con trỏ khi di chuột qua nút */
            border-radius: 5px;
        }

        .sort-buttons button:hover {
            background-color: #45a049;
            /* Thay đổi màu nền khi di chuột qua nút */
        }

        .sort-buttons button.selected {
            background-color: #FFC0CB;
            /* Màu hồng */
        }

        /* wrapper */
        .wrapper {
            padding: 2rem;
        }

        .products ul {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            /* Đảm bảo các sản phẩm đối xứng với trang */
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .products ul .main-product {
            margin-bottom: 2rem;
            width: 23%;
            text-align: center;
            /* Điều chỉnh tỷ lệ này để thay đổi số lượng sản phẩm trên mỗi hàng */
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        }

        .products ul .img-product img {
            height: 200px;
        }

        .content-product .content-product-h3 {
            padding: .5rem 0;
            overflow: hidden;
            color: #222;
            font-weight: 500;
            font-size: 16px;
            max-height: 50px;
            min-height: 50px;
            text-align: center;
            line-height: 19px;
            margin: 0 0 5px;
        }

        .content-product .content-product-deltals {
            display: flex;
            justify-content: center;
            padding-top: 1rem;
        }

        .main-product .content-product .content-product-deltals .price {
            color: #c7b200;
            font-weight: 700;
            margin-right: 1rem;
            vertical-align: middle;
            font-size: 20px;
        }

        .content-product .content-product-deltals .price .money {
            vertical-align: middle;
        }

        .content-product .content-product-deltals .btn-cart {
            background: #f1df11;
            border-radius: 5px;
            color: #fff;
            font-weight: 500;
        }

        .content-product .content-product-deltals .btn-cart:hover {
            background: #c7b200;
        }

        /* CSS cho hiển thị tất cả sản phẩm */
        .view-all {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100px;

        }

        .view-all a {
            text-decoration: none;
            background: yellow;
            padding: 10px;
            color: red;
            border-radius: 10px;
        }

        .view-all a:hover {
            background: red;
            color: yellow;
        }

        .icon-hover:hover {
            border-color: #3b71ca !important;
            background-color: white !important;
            color: #3b71ca !important;
        }

        .icon-hover:hover i {
            color: #3b71ca !important;
        }

        /* footer */
        .bg-footer {
            background: #f1df11 !important;
        }
    </style>
</head>

<body>

    <!-- header -->
    <header>
        <nav>
            <div class="img-nav">
                <a href="{{ url('/') }}"><img src="{{ asset('images/logo.png') }}" alt="Logo" /></a>
            </div>
            <div class="content-nav ">
                <ul>
                    <li><a href="{{ url('/') }}">Trang Chủ</a></li>
                    <li><a href="{{ url('/products') }}">Sản Phẩm</a></li>
                    <li><a href="{{ url('/Contact') }}">Liên Hệ</a></li>
                    <li><a href="{{ url('/Introduce') }}">Giới Thiệu</a></li>
                </ul>
                {{-- thêm action và method --}}
                <form action="{{ url('search_products') }}" method="POST">
                    @csrf
                    <input type="text" name="search" placeholder="Tìm kiếm sản phẩm..." />
                    <button type="submit">
                        <a href=""><i class="fa fa-search" aria-hidden="true"></i></a>
                    </button>
                </form>
            </div>
            <!-- The Modal -->
            <button id="cart">
                <i class="fa fa-shopping-basket" aria-hidden="true"></i>
                <a style="text-decoration: none" href="{{ url('/Cart') }}">Giỏ Hàng</a>
            </button>

            {{-- hiển thị tên user_name của người dùng khi đăng nhập thành công  --}}
            @if (Session::has('user'))
                <div class="dropdown ">
                    <button class="dropbtn">Chào , <i class="fa fa-user" style="padding-right: 3px;"
                            aria-hidden="true"></i> {{ Session::get('user')->user_name }}</button>
                    <div class="dropdown-content">
                        <a class="info_user" href="{{ url('/profileUser') }}"><i class="fa fa-user"
                                style="padding-right: 3px;" aria-hidden="true"></i>Thông tin cá nhân</a>
                        <a class="logout" href="{{ url('/logout') }}"><i class="fa fa-sign-out"
                                style="padding-right: 3px;" aria-hidden="true"></i>Đăng xuất</a>
                    </div>
                </div>
            @else
                <button id="login">
                    <i class="fa fa-user" aria-hidden="true"></i>
                    <a style="text-decoration: none" href="{{ url('/login') }}">Đăng Nhập</a>
                </button>
            @endif
        </nav>
    </header>

    @yield('content')
    <!-- footer -->
    <footer class="text-center text-lg-start text-muted bg-footer mt-3 bg-footer">
        <!-- Section: Links  -->
        <section class="">
            <div class="container text-center text-md-start pt-4 pb-4">
                <!-- Grid row -->
                <div class="row mt-3">
                    <!-- Grid column -->
                    <div class="col-12 col-lg-3 col-sm-12 mb-2">
                        <!-- Content -->
                        <a href="" target="_blank" class="text-dark h2 text-decoration-none ">
                            Bin Dino
                        </a>
                        <p class="mt-1 text-dark">
                            © 2024 Copyright: Bin Dino
                        </p>
                    </div>
                    <!-- Grid column -->

                    <!-- Grid column -->
                    <div class="col-6 col-sm-4 col-lg-2">
                        <!-- Links -->
                        <h6 class="text-uppercase text-dark fw-bold mb-2">
                            Store
                        </h6>
                        <ul class="list-unstyled mb-4">
                            <li><a class="text-dark text-decoration-none" href="#">About us</a></li>
                            <li><a class="text-dark text-decoration-none" href="#">Find store</a></li>
                            <li><a class="text-dark text-decoration-none" href="#">Categories</a></li>
                            <li><a class="text-dark text-decoration-none" href="#">Blogs</a></li>
                        </ul>
                    </div>
                    <!-- Grid column -->

                    <!-- Grid column -->
                    <div class="col-6 col-sm-4 col-lg-2">
                        <!-- Links -->
                        <h6 class="text-uppercase text-dark fw-bold mb-2">
                            Information
                        </h6>
                        <ul class="list-unstyled mb-4">
                            <li><a class="text-dark text-decoration-none" href="#">Help center</a></li>
                            <li><a class="text-dark text-decoration-none" href="#">Money refund</a></li>
                            <li><a class="text-dark text-decoration-none" href="#">Shipping info</a></li>
                            <li><a class="text-dark text-decoration-none" href="#">Refunds</a></li>
                        </ul>
                    </div>
                    <!-- Grid column -->

                    <!-- Grid column -->
                    <div class="col-6 col-sm-4 col-lg-2">
                        <!-- Links -->
                        <h6 class="text-uppercase text-dark fw-bold mb-2">
                            Support
                        </h6>
                        <ul class="list-unstyled mb-4">
                            <li><a class="text-dark text-decoration-none" href="#">Help center</a></li>
                            <li><a class="text-dark text-decoration-none" href="#">Documents</a></li>
                            <li><a class="text-dark text-decoration-none" href="#">Account restore</a></li>
                            <li><a class="text-dark text-decoration-none" href="#">My orders</a></li>
                        </ul>
                    </div>
                    <!-- Grid column -->

                    <!-- Grid column -->
                    <div class="col-12 col-sm-12 col-lg-3">
                        <!-- Links -->
                        <h6 class="text-uppercase text-dark fw-bold mb-2">Newsletter</h6>
                        <p class="text-dark">Stay in touch with latest updates about our products and offers</p>
                        <div class="input-group mb-3">
                            <input type="email" class="form-control border" placeholder="Email" aria-label="Email"
                                aria-describedby="button-addon2" />
                            <button class="btn btn-light border shadow-0" type="button" id="button-addon2"
                                data-mdb-ripple-color="dark">
                                Gửi
                            </button>
                        </div>
                    </div>
                    <!-- Grid column -->
                </div>
                <!-- Grid row -->
            </div>
        </section>
        <!-- Section: Links  -->

        <div class="">
            <div class="container">
                <div class="d-flex justify-content-between py-4 border-top">
                    <!--- payment --->
                    <div>
                        <i class="fab fa-lg fa-cc-visatext-dark"></i>
                        <i class="fab fa-lg fa-cc-amextext-dark"></i>
                        <i class="fab fa-lg fa-cc-mastercardtext-dark"></i>
                        <i class="fab fa-lg fa-cc-paypaltext-dark"></i>
                    </div>
                    <!--- payment --->

                    <!--- language selector --->
                    <div class="dropdown dropup">
                        <a class="dropdown-toggletext-dark text-decoration-none text-dark" href="#"
                            id="Dropdown" role="button" data-mdb-toggle="dropdown" aria-expanded="false"> <i
                                class="flag-united-kingdom flag m-0 me-1 "></i>English </a>

                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="Dropdown">
                            <li>
                                <a class="dropdown-item" href="#"><i
                                        class="flag-united-kingdom flag"></i>English <i
                                        class="fa fa-check text-success ms-2"></i></a>
                            </li>
                        </ul>
                    </div>
                    <!--- language selector --->
                </div>
            </div>
        </div>
    </footer>
    <!-- Footer -->

    {{-- thêm thư viện SweetAlert2 --}}
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- js hiển thị thông báo khi người dùng chưa đăng nhập mà chọn vào giỏ hàng và thêm vào giỏ hàng --}}
    <script>
        $(document).ready(function() {
            $(document).on('click', '#cart, .btn-cart , .buy-now', function(e) {
                @if (!Session::has('user'))
                    e.preventDefault();
                    Swal.fire({
                        title: 'Thông báo!',
                        text: 'Bạn cần đăng nhập để thực hiện chức năng này',
                        icon: 'warning',
                        confirmButtonText: 'Đồng ý'
                    });
                @endif
            });
        });
    </script>

    {{-- js cập nhật product_view mà không cần tải lại trang --}}
    <script>
        $(document).ready(function() {
            $(".img-product a").click(function(e) {
                e.preventDefault();

                var url = $(this).attr('href');

                $.ajax({
                    url: '/product/' + url.split('/').pop() + '/view',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(data) {
                        $('.bi-eye-fill').next().text(data.product_view);
                    }
                });

                window.location.href = url;
            });
        });
    </script>

    {{-- Hiển thị thông báo thêm vào giỏ hàng thành công --}}
    <script>
        function addToCart(id) {
            $.ajax({
                url: "{{ url('add-to-cart') }}/" + id,
                method: 'POST',
                data: {
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Thành công',
                        text: response.message,
                    })
                }
            });
        }
    </script>

    {{-- format price --}}
    <script>
        function number_format(price) {
            return price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }
    </script>
</body>
