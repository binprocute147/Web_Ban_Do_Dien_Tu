@extends('system')
@section('content-admin')
    <!--start-top-serch-->
    <div id="search">
        <form action="{{ url('search_products_admin') }}" method="post">
            @csrf
            <input type="text" name="search" placeholder="Tìm kiếm sản phẩm..." />
            <button type="submit" class="tip-bottom" title="Search"><i class="icon-search icon-white"></i></button>
        </form>
    </div>
    <!--close-top-serch-->
    <!-- BEGIN CONTENT -->
    <div id="content">
        <div id="content-header">
            <div id="breadcrumb"> <a href="{{ url('/Dashboard') }}" title="Go to Home" class="tip-bottom current"><i
                        class="icon-home"></i> Home</a></div>
            <h1>Manage Products</h1>
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            {{-- thông báo lỗi khi không tìm thấy sản phẩm --}}
            @if (isset($error))
                <div class="error alert alert-danger">{{ $error }}</div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
        </div>
        <div class="container-fluid">
            <hr>
            <div class="row-fluid">
                <div class="span12">
                    <div class="widget-box">
                        <div class="widget-title"> <span class="icon"><a href="{{ url('/AddProduct') }}"> <i
                                        class="icon-plus"></i>
                                </a></span>
                            <h5>Products</h5>
                        </div>
                        <div class="widget-content nopadding">
                            <table class="table table-bordered
                                    table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Image</th>
                                        <th>Name</th>
                                        <th>Manufactures</th>
                                        <th>Product type</th>
                                        <th>Sold Quantity</th>
                                        <th>View</th>
                                        <th>Description</th>
                                        <th>Price (VND)</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- hiển thị thông tin sản phẩm trên trang --}}
                                    @foreach ($data as $row)
                                        <tr class=''>
                                            <td>{{ $row->product_id }}</td>
                                            <td width='250'>
                                                <img src="{{ asset('/images/products/' . $row->pro_image) }} " />
                                            </td>

                                            <td>{{ $row->name }}</td>
                                            <td>{{ $row->manufacturer->manu_name }}</td>
                                            <td>{{ optional($row->protype)->type_name }}</td>
                                            <td>{{ $row->sold_quantity }}</td>
                                            <td>{{ $row->product_view }}</td>
                                            <td>{{ $row->description }}</td>
                                            <td>{{ number_format($row->price) }}</td>
                                            <td><a href="{{ url('/EditProduct', ['id' => $row->product_id]) }}"
                                                    class='btn
                                        btn-success btn-mini'>Edit</a>
                                                <form action="{{ route('deleteProduct', ['id' => $row->product_id]) }}"
                                                    method = "post" class="delete-form">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type = "submit"
                                                        class='btn
                                        btn-danger btn-mini delete-button'>Delete</button>
                                                </form>

                                            </td>

                                        </tr>
                                    @endforeach
                                    {{-- kết thúc vòng lặp --}}
                                </tbody>
                            </table>
                            {{-- phân trang  --}}
                            <div class="row" style="margin-left: 18px; color: red">
                                {{ $data->links('pagination::bootstrap-4') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END CONTENT -->
    {{-- js hiển thị hộp thoại xác nhận xóa --}}
    <script>
        $('.delete-button').click(function(e) {
            let confirmed = confirm('Bạn muốn xóa sản phẩm này không?'); // hiển thị hộp thoại xác nhận

            if (!confirmed) {
                e.preventDefault(); // ngăn chặn hành vi mặc định của nút nếu người dùng nhấp vào "Cancel"
            }
        });
    </script>
@endsection
