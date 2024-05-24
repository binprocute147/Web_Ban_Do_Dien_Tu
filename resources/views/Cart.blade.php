@extends('app')
@section('content')
<link rel="stylesheet" href="{{ asset('css/gioHang.css') }}">
<section style="min-height: 85vh">
    <table class="listSanPham">
        <tbody>
            <tr>
                <th>STT</th>
                <th>Sản phẩm</th>
                <th>Giá</th>
                <th>Số lượng</th>
                <th>Thành tiền</th>
                <th>Thời gian</th>
                <th>Xóa</th>
            </tr>
            {{-- đặt giá trị mặc định cho total --}}
            @php
            $total = 0;
            @endphp

            @if (session('cart'))
            @php
            $total = array_reduce(
            session('cart', []),
            function ($carry, $item) {
            return $carry + $item['price'] * $item['quantity'];
            },
            0,
            );
            @endphp

            @foreach (session('cart') as $id => $details)
            
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td class="noPadding imgHide">
                    <a target="_blank" href="{{ url('ProductDetail/' . $id) }}" style="text-decoration: none; color: black;" title="Xem chi tiết">
                        {{ $details['name'] }}
                        <img src="{{ asset('/images/products/' . $details['image']) }}">
                    </a>
                </td>
                <td class="alignRight">{{ number_format($details['price']) }} ₫</td>
                <td class="soluong">
                    <button class="decrease" data-id="{{ $id }}"><i class="fa fa-minus"></i></button>
                    <input class="quantityInput" type="number" value="{{ $details['quantity'] }}" data-id="{{ $id }}">
                    <button class="increase" data-id="{{ $id }}"><i class="fa fa-plus"></i></button>

                </td>
                <td class="alignRight subtotal"> <span>{{ number_format($details['price'] * $details['quantity']) }} ₫</span></td>
                <td style="text-align: center">{{ $details['added_at'] }}</td>
                <td class="noPadding">
                    <i class="fa fa-trash delete-product" data-id="{{ $id }}"></i>
                </td>
            </tr>
            @endforeach
            @else
            <tr>
                <td colspan="7">Bạn chưa có sản phẩm nào trong giỏ hàng</td>
            </tr>
            @endif
            <tr style="font-weight:bold; text-align:center">
                <td colspan="4">TỔNG TIỀN: </td>
                <td class="alignRight total">{{ number_format($total) }} ₫</td>
                <td class="thanhtoan">
                    <a href="#" class="checkout" style="text-decoration: none; color: black;">Thanh Toán</a>
                </td>
                <td class="xoaHet">
                    <a style="text-decoration: none; color: black;" class="delete-all">Xóa hết</a>
                </td>
            </tr>
        </tbody>
    </table>
</section> <!-- End Section -->

<script>
    $(document).on('click', '.increase', function() {
        var productId = $(this).data('id');
        var input = $(this).siblings('.quantityInput');
        var quantity = parseInt(input.val());
        input.val(quantity + 1);
        updateCart(productId, quantity + 1);
        updateSubtotal(productId, quantity + 1);
        
    });

    $(document).on('click', '.decrease', function() {
        var productId = $(this).data('id');
        var input = $(this).siblings('.quantityInput');
        var quantity = parseInt(input.val());
        if (quantity > 1) {
            input.val(quantity - 1);
            updateCart(productId, quantity - 1);
            updateSubtotal(productId, quantity - 1);
            
        }
    });

    $(document).on('input', '.quantityInput', function() {
        var productId = $(this).data('id');
        var quantity = parseInt($(this).val());
        updateCart(productId, quantity);
        updateSubtotal(productId, quantity);
    });

    function updateCart(productId, quantity) {
        var token = "{{ csrf_token() }}";
        console.log('updateCart called with productId:', productId, 'and quantity:', quantity);

        $.ajax({
            url: '/update-cart/' + productId,
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': token
            },
            data: {
                quantity: quantity
            },
            success: function(response) {
                updateCartTotals(productId, quantity);
                location.reload();
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    }

    function updateCartTotals(productId, quantity) {
        $.ajax({
            url: '/update-cart-totals/' + productId,
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            data: {
                quantity: quantity
            },
            success: function(response) {
                $('tr[data-id="' + productId + '"]').find('.alignRight.subtotal').text(response.subtotal);
                $('.total').text(response.total);

            },
            error: function(xhr, status, error) {
                console.error(error);
            }

        });
    }

    function updateSubtotal(productId, quantity) {
        if (!productId || quantity === undefined) {
            console.error('Invalid parameters for updateSubtotal()');
            return;
        }

        var $row = $('tr[data-id="' + productId + '"]');
        if ($row.length === 0) {
            console.error('Could not find product with ID:', productId);
            return;
        }

        var pricePerItem = parseFloat($row.data('price'));
        if (isNaN(pricePerItem)) {
            console.error('Invalid price for product with ID:', productId);
            return;
        }

        var subtotal = pricePerItem * quantity;
        $row.find('.alignRight.subtotal').text(subtotal.toLocaleString('it-IT') + ' ₫');
        updateTotal(); // Cập nhật tổng tiền sau khi cập nhật thành tiền của sản phẩm
    }

    function updateTotal() {
        var total = $('.subtotal').toArray().reduce(function(carry, item) {
            return carry + parseFloat($(item).text().replace(' ₫', ''));
        }, 0);
        $('.total').text(total.toLocaleString('it-IT') + ' ₫');
    }

    // xóa sản phẩm 
    $(document).on('click', '.delete-product', function() {
        var productId = $(this).data('id');

        var userConfirmation = confirm("Bạn có muốn xóa sản phẩm này khỏi giỏ hàng không?");

        if (userConfirmation) {
            $.ajax({
                url: '/delete-from-cart/' + productId,
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function(response) {
                    console.log(response);
                    window.location.reload();
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        }
    });

    // xóa tất cả sản phẩm trong giỏ hàng
    $(document).on('click', '.delete-all', function() {
        if ($('tr').has('.delete-product').length === 0) {
            alert("Không có sản phẩm để xóa");
            return;
        }

        var userConfirmation = confirm("Bạn có muốn xóa tất cả sản phẩm trong giỏ hàng không?");

        if (userConfirmation) {
            $.ajax({
                url: '/delete-all-from-cart',
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function(response) {
                    console.log(response);
                    window.location.reload();
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        }
    });

    // thanh toán 
    $(document).on('click', '.checkout', function() {
        if ($('tr').has('.delete-product').length === 0) {
            alert("Không có sản phẩm để thanh toán");
            return;
        }

        var userConfirmation = confirm("Thanh toán giỏ hàng");

        if (userConfirmation) {
            $.ajax({
                url: '/checkout',
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function(response) {
                    console.log(response);
                    Swal.fire(
                        'Thành công!',
                        'Các sản phẩm đã được gửi và vui lòng chờ nhân viên liên hệ xác nhận',
                        'success'
                    ).then((result) => {
                        location.reload();
                    });
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        }
    });
</script>
@endsection