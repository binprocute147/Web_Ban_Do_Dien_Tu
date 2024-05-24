@extends('system')
@section('content-admin')
    <!--start-top-serch-->
    <div id="search">
        <form action="{{ url('search_protype') }}" method="post">
            @csrf
            <input type="text" name="search" placeholder="Tìm kiếm loại sản phẩm..." />
            <button type="submit" class="tip-bottom" title="Search"><i class="icon-search icon-white"></i></button>
        </form>
    </div>
    <!--close-top-serch-->
    <!-- BEGIN CONTENT -->
    <div id="content">
        <div id="content-header">
            <div id="breadcrumb"> <a href="{{ url('/Dashboard') }}" title="Go to Home" class="tip-bottom current"><i
                        class="icon-home"></i> Home</a></div>
            <h1>Manage Product type</h1>
            {{-- thông báo lỗi khi không tìm thấy sản phẩm --}}
            @if (isset($error))
                <div class="error alert alert-danger">{{ $error }}</div>
            @endif

            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
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
                        <div class="widget-title"> <span class="icon"><a href="{{ url('AddProductType') }}"> <i
                                        class="icon-plus"></i>
                                </a></span>
                            <h5>Product type</h5>
                        </div>
                        <div class="widget-content nopadding">
                            <table class="table table-bordered
                                    table-striped">
                                <thead>
                                    <tr>
                                        <th>Image</th>
                                        <th>Protype Name</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data_protype as $row)
                                        <tr class="">
                                            <td width="100"><img
                                                    src="{{ asset('/images/ProductsType/' . $row->type_image) }}"></td>
                                            <td>{{ $row->type_name }}</td>

                                            <td>
                                                <a href="{{ url('/EditProductType', ['id' => $row->type_id]) }}"
                                                    class="btn
                                                    btn-success btn-mini">Edit</a>
                                                <form action="{{ route('deleteProtype', ['id' => $row->type_id]) }}"
                                                    method="post" class="delete-form">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-mini delete-button"
                                                        data-product-count="{{ $row->products()->count() }}">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="row" style="margin-left: 18px; color: red">
                                {{ $data_protype->links('pagination::bootstrap-4') }}
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
            var productCount = $(this).data('product-count');

            var confirmed;
            if (productCount > 0) {
                confirmed = confirm('Không thể xóa loại sản phẩm này vì nó có chứa ' + productCount + ' sản phẩm');
            } else {
                confirmed = confirm('Bạn muốn xóa loại sản phẩm này không?');
            }

            if (!confirmed) {
                e.preventDefault();
            }
        });
    </script>
@endsection
