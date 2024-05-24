    @extends('system')
    @section('content-admin')
        <!-- BEGIN CONTENT -->

        <div id="content">
            <div id="content-header">
                <div id="breadcrumb"> <a href="{{ url('/admin') }}" title="Go to Home" class="tip-bottom current"><i
                            class="icon-home"></i> Home</a></div>
                <h1>Add User</h1>
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
            <div class="container-fluid">
                <hr>
                <div class="row-fluid">
                    <div class="span12">
                        <div class="widget-box">
                            <div class="widget-content nopadding">
                                <form action="{{ route('addUser') }}" method="POST" class="form-horizontal"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="control-group">
                                        <label class="control-label">User Name :</label>
                                        <div class="controls">
                                            <input type="text" class="span11" placeholder="User Name" name="name" />
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Password :</label>
                                        <div class="controls">
                                            <input type="password" class="span11" placeholder="Password" name="pass" />
                                        </div>
                                    </div>

                                    <div class="control-group">
                                        <label class="control-label">Firstname:</label>
                                        <div class="controls">
                                            <input type="text" class="span11" placeholder="User Name" name="first" />
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Lastname :</label>
                                        <div class="controls">
                                            <input type="text" class="span11" placeholder="User Name" name="last" />
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Email :</label>
                                        <div class="controls">
                                            <input type="text" class="span11" placeholder="Email" name="email" />
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Address :</label>
                                        <div class="controls">
                                            <input type="text" class="span11" placeholder="Address" name="address" />
                                        </div>
                                    </div>
                                    <div class="form-actions">
                                        <button type="submit" class="btn btn-success">Add User</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END CONTENT -->
    @endsection
