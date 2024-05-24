@extends('system')
@section('content-admin')
<!-- BEGIN CONTENT -->
<div id="content">
    <div id="content-header">
        <div id="breadcrumb"> <a href="{{ url('/admin') }}" title="Go to Home" class="tip-bottom current"><i class="icon-home"></i> Home</a></div>
        <h1>Edit User</h1>
        @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif

        @if(session('error'))
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
                    <div class="widget-content nopadding">
                        <form action="{{ route('updateUser', ['id' =>$user->user_id]) }}" method="post" class="form-horizontal" enctype="multipart/form-data">
                            <!-- Populate this form with product details -->
                            @csrf
                            <div class="control-group">
                                <label class="control-label">User Name :</label>
                                <div class="controls">
                                    <input type="text" class="span11" placeholder="User Name" name="name" value="{{ $user->user_name }}" />
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Password :</label>
                                <div class="controls">
                                    <input type="password" class="span11" placeholder="Password" name="pass" value="{{$user->password}}" />
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label">Firstname:</label>
                                <div class="controls">
                                    <input type="text" class="span11" placeholder="First Name" name="first" value="{{$user->first_name}}" />
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Lastname :</label>
                                <div class="controls">
                                    <input type="text" class="span11" placeholder="Last Name" name="last" value="{{$user->last_name}}" />
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Email :</label>
                                <div class="controls">
                                    <input type="text" class="span11" placeholder="Email" name="email" value="{{$user->email}}"  />
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Address :</label>
                                <div class="controls">
                                    <input type="text" class="span11" placeholder="Address" name="address" value="{{$user->address}}" />
                                </div>
                            </div>
                            <div class="form-actions">
                                <button type="submit" class="btn btn-success">Update User</button>
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