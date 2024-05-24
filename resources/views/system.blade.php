
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Website bán đồ điện tử</title>
    <meta charset="UTF-8" />
    <!-- Thêm thư viện jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" href="{{ asset('images/logo.png') }}" type="image/icon type">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/bootstrap-responsive.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/uniform.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/font-awesome.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/matrix-style.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/matrix-media.css') }}" />
    <link href="{{ asset('font-awesome/css/font-awesome.css') }}" rel="stylesheet" />
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,800' rel='stylesheet' type='text/css'>
    <style type="text/css">
        ul.pagination {
            list-style: none;
            float: right;
        }

        ul.pagination li.active {
            font-weight: bold
        }

        ul.pagination li {
            display: flex;
            padding: 10px
        }
        
        /* css thông báo lỗi khi tìm sản phẩm */
        .error {
            color: red;
            text-align: center;
            font-family: 'Times New Roman', Times, serif;

        }
    </style>
</head>
<body>
    <!--Header-part-->
    <div id="header">
        <h1><a href="{{ url('/admin') }}"><img src="./images/logo.png" alt="logo"></a></h1>
    </div>
    <!--close-Header-part-->
    <!--top-Header-menu-->
    <div id="user-nav" class="navbar navbar-inverse">
        <ul class="nav">
            <li class="dropdown" id="profile-messages"><a title="" href="#" data-toggle="dropdown" data-target="#profile-messages" class="dropdown-toggle"><i class="icon icon-user"></i> <span class="text">Welcome Super Admin</span><b class="caret"></b></a>
                <ul class="dropdown-menu">
                    <li><a href="{{ url('/profileAdmin')}}"><i class="icon-user"></i> My Profile</a></li>
                    <li class="divider"></li>
                    <li><a href="#"><i class="icon-check"></i> My Tasks</a></li>
                    <li class="divider"></li>
                    <li><a href="{{ url('/logout') }}"><i class="icon-key"></i> Log
                            Out</a></li>
                </ul>
            </li>
            <li class="dropdown" id="menu-messages"><a href="#" data-toggle="dropdown" data-target="#menu-messages" class="dropdown-toggle"><i class="icon icon-envelope"></i>
                    <span class="text">Messages</span> <span class="label label-important">5</span> <b class="caret"></b></a>
                <ul class="dropdown-menu">
                    <li><a class="sAdd" title="" href="#"><i class="icon-plus"></i> new message</a></li>
                    <li class="divider"></li>
                    <li><a class="sInbox" title="" href="#"><i class="icon-envelope"></i> inbox</a></li>
                    <li class="divider"></li>
                    <li><a class="sOutbox" title="" href="#"><i class="icon-arrow-up"></i> outbox</a></li>
                    <li class="divider"></li>
                    <li><a class="sTrash" title="" href="#"><i class="icon-trash"></i> trash</a></li>
                </ul>
            </li>
            <li class=""><a title="" href="#"><i class="icon icon-cog"></i>
                    <span class="text">Settings</span></a></li>
            <li class=""><a title="" href="{{ url('/logout') }}"><i class="icon
                            icon-share-alt"></i> <span class="text">Logout</span></a>
            </li>
        </ul>
    </div>
    <!--start-top-serch-->
    {{-- <div id="search">
        <form action="result.html" method="get">
            <input type="text" placeholder="Search here..." />
            <button type="submit" class="tip-bottom" title="Search"><i class="icon-search icon-white"></i></button>
        </form>
    </div> --}}
    <!--close-top-serch-->
    
    <!--sidebar-menu-->
    <div id="sidebar"> <a href="#" class="visible-phone"><i class="icon
                    icon-th"></i>Tables</a>
        <ul>
            <li><a href="{{ url('/Dashboard') }}"><i class="icon icon-home"></i> <span>Dashboard</span></a>
            </li>
            <li> <a href="{{ url('admin') }}"><i class="icon icon-th-list"></i>
                <span>Products</span></a></li>
            <li> <a href="{{ url('Manufactures') }}"><i class="icon icon-th-list"></i>
                    <span>Manufactures</span></a></li>
            <li> <a href="{{ url('/ProductType') }}"><i class="icon icon-th-list"></i>
                    <span>Product type</span></a></li>
            <li> <a href="{{ url('/UserManager') }}"><i class="icon icon-th-list"></i>
                    <span>Users</span></a></li>

        </ul>
    </div> <!-- BEGIN CONTENT -->
     @yield('content-admin')
    <div class="row-fluid">
        <div id="footer" class="span12"> 2024 &copy; BIN DINO</div>
    </div>
    <!--end-Footer-part-->
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/jquery.ui.custom.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/jquery.uniform.js') }}"></script>
    <script src="{{ asset('js/select2.min.js') }}"></script>
    <script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/matrix.js') }}"></script>
    <script src="{{ asset('js/matrix.tables.js') }}"></script>
</body>

</html>