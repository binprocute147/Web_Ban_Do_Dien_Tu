@extends('app')
@section('content')
    <!-- content -->
    <section class="py-5">
        <div class="container">
            <div class="row gx-5">
                <aside class="col-lg-6">
                    <div class="border rounded-4 mb-3 d-flex justify-content-center">
                        <a data-fslightbox="mygalley" class="rounded-4" target="_blank" data-type="image" href="">
                            <img style="max-width: 100%; max-height: 100vh; margin: auto;" class="rounded-4 fit"
                                src="{{ asset('/images/products/' . $product->pro_image) }}" alt="{{ $product->name }}" />
                        </a>
                    </div>
                </aside>
                <main class="col-lg-6">
                    <div class="ps-lg-3">
                        <h4 class="title text-dark">
                            {{ $product->name }}
                        </h4>
                        <div class="d-flex flex-row my-3">
                            <div class="text-warning mb-1 me-2">
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                                <span class="ms-1">
                                    4.5
                                </span>
                            </div>
                            <span class="text-muted"><i
                                    class="fas fa-shopping-basket fa-sm mx-1"></i>{{ $product->sold_quantity }} Đã
                                bán</span>
                        </div>

                        <div class="mb-3">
                            <span class="h5">{{ number_format($product->price) }}đ</span>
                        </div>

                        <div class="mb-3">
                            <span class="h5"> Nhà sản xuất: {{ $product->manufacturer->manu_name }}</span>
                        </div>

                        <div class="mb-3">
                            <span class="h5"> Loại sản phẩm: {{ $product->Protype->type_name }}</span>
                        </div>
                        <p>
                            {{ $product->description }}
                        </p>
                        <hr />
                        <button class="btn btn-primary shadow-0 btn-cart" type="submit" class="btn btn-cart"
                            onclick="addToCart({{ $product->product_id }})">
                            <i class="me-1 fa fa-shopping-basket"></i> Thêm vào giỏ
                        </button>
                        <a href="#" class="btn btn-light border border-secondary py-2 icon-hover px-3"> <i
                                class="me-1 fa fa-heart fa-lg"></i> Save </a>
                    </div>
                </main>
            </div>
        </div>
    </section>
    <!-- content -->
    <section class="bg-light border-top py-4">
        <div class="container">
            <div class="row gx-4">
                <div class="col-lg-8 mb-4">
                    <div class="border rounded-2 px-3 py-2 bg-white">
                        <!-- Pills navs -->
                        <ul class="nav nav-pills nav-justified mb-3" id="ex1" role="tablist">
                            <li class="nav-item d-flex" role="presentation">
                                <a class="nav-link d-flex align-items-center justify-content-center w-100 active"
                                    id="ex1-tab-1" data-mdb-toggle="pill" href="#ex1-pills-1" role="tab"
                                    aria-controls="ex1-pills-1" aria-selected="true">Mô tả sản phẩm</a>
                            </li>
                        </ul>
                        <!-- Pills navs -->

                        <!-- Pills content -->
                        <div class="tab-content" id="ex1-content">
                            <div class="tab-pane fade show active" id="ex1-pills-1" role="tabpanel"
                                aria-labelledby="ex1-tab-1">
                                <p>
                                    {{ $product->description }} <br> <br>
                                    {{ $product->description }}
                                </p>
                            </div>
                        </div>
                        <!-- Pills content -->
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="px-0 border rounded-2 shadow-0">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Sản Phẩm Tương Tự</h5>
                                <div class="d-flex mb-3">
                                    <a href="{{ url('ProductDetail/' . $product->product_id) }}" class="me-3">
                                        <img src="{{ asset('/images/products/' . $product->pro_image) }}"
                                            alt="{{ $product->name }}" style="min-width: 96px; height: 96px;"
                                            class="img-md img-thumbnail" />
                                    </a>
                                    <div class="info">
                                        <a href="#" class="nav-link mb-1">
                                            {{ $product->name }}
                                        </a>
                                        <strong class="text-dark"> {{ number_format($product->price) }}đ</strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- review product --}}
    <section class="py-5 bg-light border-top">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="border rounded-2 px-3 py-2 bg-white">
                        <h2>Đánh Giá Sản Phẩm</h2>
                        <hr>
                        <div id="reviews">
                            @if (optional($product->reviews)->count())
                                @foreach ($product->reviews->sortByDesc('created_at') as $review)
                                    <h5><i class="fa fa-user" aria-hidden="true"></i>
                                        {{ $review->user->last_name ?? 'Người dùng không xác định' }}
                                        {{ $review->user->first_name ?? '' }}
                                    </h5>
                                    <div class="d-flex">
                                        <p class="pe-5">{{ $review->content }}</p>
                                        <p>{{ $review->created_at->format('d/m/Y H:i:s') }}</p>
                                    </div>
                                @endforeach
                            @else
                                <p>Hiện tại chưa có đánh giá nào cho sản phẩm này.</p>
                            @endif
                        </div>
                        <form id="review-form">
                            <div class="form-group mb-3">
                                <label class="pb-2" for="review-text">Nội dung đánh giá:</label>
                                <textarea class="form-control" id="review-text" rows="5" placeholder="Viết đánh giá của bạn..."></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary shadow-0" id="submit-review">Gửi đánh
                                giá</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- js hiển thị thông báo khi người dùng chưa đăng nhập mà viết đánh giá --}}
    <script>
        $(document).ready(function() {
            $(document).on('click', '#review-text', function(e) {
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

    <script>
        $(document).ready(function() {
            $('#submit-review').click(function(e) {
                e.preventDefault();
                var reviewText = $('#review-text').val();
                var productId = {{ $product->product_id }};
                $.ajax({
                    url: '/review',
                    type: 'post',
                    data: {
                        content: reviewText,
                        product_id: productId,
                        _token: '{{ csrf_token() }}' 
                    },
                    success: function(response) {
                        alert('Đánh giá của bạn đã được gửi!');
                        $('#review-text').val(''); 
                        var reviewHtml = '<h5><i class="fa fa-user" aria-hidden="true"></i> ';
                        @if (session()->has('user'))
                            reviewHtml +=
                                '{{ session()->get('user')->last_name }} {{ session()->get('user')->first_name }}';
                        @else
                            reviewHtml += 'Khách hàng';
                        @endif
                        reviewHtml += '</h5>' +
                            '<div class="d-flex">' +
                            '<p class="pe-5">' + reviewText + '</p>' +
                            '<p>' + new Date().toLocaleString('vi-VN', {
                                hour12: false
                            }) +
                            '</p>' +
                            '</div>';
                        $('#reviews').prepend(
                            reviewHtml); 
                            console.log(reviewHtml)
                    },
                    error: function(error) {
                        // Xử lý khi có lỗi xảy ra
                        console.log(error);
                        Swal.fire({
                            title: 'Thông báo!',
                            text: 'Có lỗi xảy ra . Vui lòng thử lại',
                            icon: 'warning',
                            confirmButtonText: 'Đồng ý'
                        });
                    }
                });
            });
        });
    </script>
@endsection
