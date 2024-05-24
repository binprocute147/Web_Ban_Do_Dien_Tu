@extends('app')
@section('content')
    <style>
        /* protypes */
        .protypes {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .protypes-list {
            display: flex;
            justify-content: center;
            align-items: center;
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        .protypes-item {
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            margin: 20px;
        }

        .protypes-item a {
            padding: 10px;
            border-radius: 5px;
            background: yellow;
            text-decoration: none;
            color: red;
        }

        .protypes-item a.selected {
            background: pink;
        }
    </style>
    {{-- banner --}}
    <div class="banner">
        <button class="nav-button" id="prev">
            < </button>
                <img id="banner-img" src="{{ asset('images/banners/banner0.gif') }}" alt="">
                <button class="nav-button" id="next"> > </button>
    </div>
    <img src="{{ asset('images/banners/blackFriday.gif') }}" alt="" style="width: 100%;">
    <!-- content -->
    {{-- hiển thị tên của các loại sản phẩm  --}}
    <div class="protypes">
        <ul class="protypes-list">
            @foreach ($data_protype as $protype)
                <li class="protypes-item">
                    <a href="#" data-id="{{ $protype->type_id }}">
                        <h2>{{ $protype->type_name }}</h2>
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
    {{-- sắp xếp giá , tên sản phẩm --}}
    <div class="sort-buttons">
        <button onclick="sortProducts('price', 'asc')">Giá Tăng Dần</button>
        <button onclick="sortProducts('price', 'desc')">Giá Giảm Dần</button>
        <button onclick="sortProducts('name', 'asc')">Tên A-Z</button>
        <button onclick="sortProducts('name', 'desc')">Tên Z-A</button>
    </div>
    {{-- hiển thị sản phẩm trên view  --}}
    <section class="wrapper">
        <div class="products" id="productList">
            <ul>
                @if (isset($data))
                    @foreach ($data as $row)
                        <li class="main-product">
                            <div class="img-product">
                                <a href="{{ url('ProductDetail/' . $row->product_id) }}"><img class="img-prd"
                                        src="{{ asset('/images/products/' . $row->pro_image) }}" alt=""></a>
                            </div>
                            <div class="content-product">
                                <h3 class="content-product-h3"><a href="{{ url('ProductDetail/' . $row->product_id) }}"
                                        style="text-decoration: none; color: black;">{{ $row->name }}</a></h3>
                                <div>
                                    <span class="badge text-bg-warning"><i class="bi bi-eye-fill"></i>
                                        {{ $row->product_view }}</span>
                                </div>
                                <div class="content-product-deltals">
                                    <div class="price" data-price-number="{{ $row->price }}">
                                        <span class="money">{{ number_format($row->price) }}đ</span>
                                    </div>
                                    <button type="submit" class="btn btn-cart" onclick="addToCart({{ $row->product_id }})">
                                        <i class="fa fa-cart-plus"></i> Thêm vào giỏ
                                    </button>
                                </div>
                            </div>
                        </li>
                    @endforeach
                @endif
            </ul>
        </div>
    </section>
    {{-- xem tất cả các sản phẩm  --}}
    <div class="view-all">
        <a id="loadAllProducts" href="{{ url('/index?all=true') }}">Xem tất cả sản phẩm</a>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    {{-- js của banner --}}
    <script>
        // thêm ảnh
        var images = [
            "{{ asset('images/banners/banner0.gif') }}",
            "{{ asset('images/banners/banner1.png') }}",
            "{{ asset('images/banners/banner2.png') }}",
            "{{ asset('images/banners/banner3.png') }}",
            "{{ asset('images/banners/banner4.png') }}",
            "{{ asset('images/banners/banner5.png') }}",
            "{{ asset('images/banners/banner6.png') }}",
            "{{ asset('images/banners/banner7.png') }}",
            "{{ asset('images/banners/banner8.png') }}",
            "{{ asset('images/banners/banner9.png') }}"
        ];
        var i = 0;

        function changeImage() {
            document.getElementById('banner-img').src = images[i];
        }
        document.getElementById('prev').addEventListener('click', function() {
            i = (i - 1 + images.length) % images.length;
            changeImage();
        });
        document.getElementById('next').addEventListener('click', function() {
            i = (i + 1) % images.length;
            changeImage();
        });
        setInterval(function() {
            i = (i + 1) % images.length;
            changeImage();
        }, 3000);
    </script>

    {{-- js của ảnh protypes  --}}
    <script>
        $('.protypes-item a').click(function() {
            // Loại bỏ lớp 'selected' khỏi tất cả các nút
            $('.protypes-item a').removeClass('selected');
            // Thêm lớp 'selected' vào nút được nhấp
            $(this).addClass('selected');
        });
    </script>

    {{-- js của hiển thị sản phẩm của protype  --}}
    <script>
        $(document).ready(function() {
            $('.protypes-item a').click(function(e) {
                e.preventDefault();
                var typeId = $(this).data('id');
                $.ajax({
                    url: '/product-type/' + typeId,
                    type: 'GET',
                    success: function(data) {
                        var productList = $('#productList ul');
                        productList.empty();
                        data.products.forEach(function(product) {
                            var productHTML = `
                        <li class="main-product">
                            <div class="img-product">
                                <a href="/ProductDetail/${product.id}"><img class="img-prd" src="${product.image}" alt=""></a>
                            </div>
                            <div class="content-product">
                                <h3 class="content-product-h3"><a href="/ProductDetail/${product.id}" style="text-decoration: none; color: black;">${product.name}</a></h3>
                                <div>
                                    <span class="badge text-bg-warning"><i class="bi bi-eye-fill"></i>
                                        ${product.product_view }</span>
                                </div>
                                <div class="content-product-deltals">
                                    <div class="price" data-price-number="${product.price}">
                                        <span class="money">${number_format(product.price)}đ</span>
                                    </div>
                                    <button type="submit" class="btn btn-cart" onclick="addToCart(${product.id})">
                                        <i class="fa fa-cart-plus"></i> Thêm vào giỏ
                                    </button>
                                </div>
                            </div>
                        </li>`;
                            productList.append(productHTML);
                        });
                    }
                });
            });
        });
    </script>

    {{-- js của button sắp xếp  --}}
    <script>
        $('.sort-buttons button').click(function() {
            // Loại bỏ lớp 'selected' khỏi tất cả các nút
            $('.sort-buttons button').removeClass('selected');
            // Thêm lớp 'selected' vào nút được nhấp
            $(this).addClass('selected');
        });
    </script>

    <!-- sắp xếp giá và tên các sản phẩm trong trang và chỉ sắp xếp các sản phẩm hiển thị trên trang và không sắp xếp tất cả các sản phẩm có trong database -->
    <script>
        // Lấy CSRF token từ trang
        var csrfToken = "{{ csrf_token() }}";
        // Biến toàn cục để lưu trữ ID của nhà sản xuất hiện tại
        var currentManufacturerId = null;

        // Khi người dùng nhấp vào một liên kết trong một mục nhà sản xuất
        $('.manufacturer-item a').click(function(e) {
            e.preventDefault(); // Ngăn chặn hành động mặc định của liên kết
            // Cập nhật ID nhà sản xuất hiện tại
            currentManufacturerId = $(this).data('id');
        });

        // Hàm để sắp xếp các sản phẩm
        function sortProducts(sortBy, sortOrder) {
            // Chuyển đổi danh sách sản phẩm thành một mảng
            var products = $('.main-product').toArray();
            // Sắp xếp mảng sản phẩm
            products.sort(function(a, b) {
                var aValue, bValue;
                // Nếu sắp xếp theo giá
                if (sortBy === 'price') {
                    // Lấy giá của sản phẩm a và b từ thuộc tính data-price-number
                    aValue = parseFloat($(a).find('.price').data('price-number'));
                    bValue = parseFloat($(b).find('.price').data('price-number'));
                }
                // Nếu sắp xếp theo tên
                else if (sortBy === 'name') {
                    // Lấy tên của sản phẩm a và b
                    aValue = $(a).find('.content-product-h3 a').text();
                    bValue = $(b).find('.content-product-h3 a').text();
                }
                // Nếu thứ tự là tăng dần
                if (sortOrder === 'asc') {
                    return aValue > bValue ? 1 : -1;
                }
                // Nếu thứ tự là giảm dần
                else {
                    return aValue < bValue ? 1 : -1;
                }
            });
            // Cập nhật danh sách sản phẩm trên trang
            $('.products ul').html(products);
        }
    </script>
    {{-- js hiển thị tất cả các sản phẩm --}}
    <script>
        $(document).ready(function() {
            $("#loadAllProducts").click(function(e) {
                e.preventDefault(); // Ngăn chặn hành vi mặc định của liên kết.
                var urlToLoadAllProducts = $(this).attr('href'); // Lấy URL từ thuộc tính href.

                $.ajax({
                    url: urlToLoadAllProducts,
                    type: 'GET',
                    success: function(response) {
                        $("#productList").html($(response).find("#productList").html());
                        //     $("#loadAllProducts")
                        // .hide(); // Ẩn nút "Xem tất cả sản phẩm" sau khi đã load xong dữ liệu.
                    },
                    error: function() {
                        alert("Có lỗi xảy ra, không thể tải sản phẩm");
                    }
                });
            });
        });
    </script>
@endsection
