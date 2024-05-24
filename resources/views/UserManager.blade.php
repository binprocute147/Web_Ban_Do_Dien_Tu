@extends('system')
@section('content-admin')
    <!--start-top-serch-->
    <div id="search">
        <form action="{{ url('search_user') }}" method="post">
            @csrf
            <input type="text" name="search" placeholder="Tìm kiếm user_name..." />
            <button type="submit" class="tip-bottom" title="Search"><i class="icon-search icon-white"></i></button>
        </form>
    </div>
    <!--close-top-serch-->
    <!-- BEGIN CONTENT -->
    <div id="content">
        <div id="content-header">
            <div id="breadcrumb"> <a href="{{ url('/Dashboard') }}" title="Go to Home" class="tip-bottom current"><i
                        class="icon-home"></i> Home</a></div>
            <h1>Manage User</h1>
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
                        <div class="widget-title"> <span class="icon"><a href="{{ url('/AddUser') }}"> <i
                                        class="icon-plus"></i>
                                </a></span>
                            <h5>User</h5>
                        </div>
                        <div class="widget-content nopadding">
                            <table class="table table-bordered
                                    table-striped">
                                <thead>
                                    <tr>
                                        <th>User Id</th>
                                        <th>Username</th>
                                        <th>Password</th>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Email</th>
                                        <th>Address</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data_user as $row)
                                        <tr class="">
                                            <td>{{ $row->user_id }}</td>
                                            <td>{{ $row->user_name }}</td>
                                            <td>{{ $row->password }}</td>
                                            <td>{{ $row->first_name }}</td>
                                            <td>{{ $row->last_name }}</td>
                                            <td>{{ $row->email }}</td>
                                            <td>{{ $row->address }}</td>
                                            <td>
                                                <a href="{{ url('/EditUser', ['id' => $row->user_id]) }}"
                                                    class="btn
                                                    btn-success btn-mini">Edit</a>
                                                <form action="{{ route('deleteUser', ['id' => $row->user_id]) }}"
                                                    method="post" class="delete-form">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class='btn
                                        btn-danger btn-mini delete-button'>Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="row" style="margin-left: 18px; color: red">
                                {{ $data_user->links('pagination::bootstrap-4') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- js hiển thị hộp thoại xác nhận xóa --}}
    <script>
        $('.delete-button').click(function(e) {
            let confirmed = confirm('Bạn muốn xóa user này không?'); // hiển thị hộp thoại xác nhận

            if (!confirmed) {
                e.preventDefault(); // ngăn chặn hành vi mặc định của nút nếu người dùng nhấp vào "Cancel"
            }
        });
    </script>
    <!-- END CONTENT -->
@endsection
