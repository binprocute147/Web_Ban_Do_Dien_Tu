@extends('app')
@section('content')
    {{-- thông báo lỗi khi không tìm thấy sản phẩm --}}
    @if (isset($error))
        <p class="error">{{ $error }}</p>
    @endif

    {{-- banner --}}
    <div class="banner">
        <button class="nav-button" id="prev">
            < </button>
                <img id="banner-img" src="{{ asset('images/banners/banner0.gif') }}" alt="">
                <button class="nav-button" id="next"> > </button>
    </div>
    <img src="{{ asset('images/banners/blackFriday.gif') }}" alt="" style="width: 100%;">
    <!-- content -->
    {{-- hiển thị ảnh của các nhà sản xuất  --}}
    <div class="manufacturers">
        <ul class="manufacturer-list">
            @foreach ($data_manu as $manu)
                <li class="manufacturer-item">
                    <a href="#" data-id="{{ $manu->manu_id }}" data-image="{{ $manu->pro_image }}"
                        data-name="{{ $manu->name }}">
                        <img src="{{ asset('/images/manufacturers/' . $manu->manu_image) }}" alt="">
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
    <div class="hot-product">
        <h1>Sản phẩm mới nhất</h1>
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
                                    <button type="submit" class="btn btn-cart"
                                        onclick="addToCart({{ $row->product_id }})">
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

    {{-- js ajax để hiển thị products mà không cần tải lại trang --}}
    <script>
        $(document).ready(function() {
            $('.manufacturer-item a').click(function(e) {
                e.preventDefault();
                var typeId = $(this).data('id');
                // Ẩn phần "Sản phẩm mới nhất"
                $('.hot-product').hide();

                $.ajax({
                    url: '/manufacturer/' + typeId,
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
                            // console.log(productHTML);
                            productList.append(productHTML);
                        });
                    }
                });
            });
        });
    </script>

    {{-- js của ảnh manufacturers  --}}
    <script>
        $('.manufacturer-item a').click(function(e) {
            e.preventDefault(); // Ngăn chặn hành động mặc định của liên kết
            // Loại bỏ lớp 'selected' khỏi tất cả các ảnh
            $('.manufacturer-item img').removeClass('selected');
            // Thêm lớp 'selected' vào ảnh được nhấp
            $(this).find('img').addClass('selected');
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

@endsection
