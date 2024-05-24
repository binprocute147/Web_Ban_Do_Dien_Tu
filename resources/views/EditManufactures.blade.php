@extends('system')
    @section('content-admin')
 <!-- BEGIN CONTENT -->
    <div id="content">
        <div id="content-header">
            <div id="breadcrumb"> <a href="{{ url('/admin') }}" title="Go to Home" class="tip-bottom current"><i class="icon-home"></i> Home</a></div>
            <h1>Edit Manufactures</h1>
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
                            <form action="{{ route('updateManu', ['id' => $data_id->manu_id]) }}" method="post" class="form-horizontal" enctype="multipart/form-data">
                            @csrf    
                            <!-- Populate this form with product details -->
                                <div class="control-group">
                                    <label class="control-label">Manu Name :</label>
                                    <div class="controls">
                                        <input type="text" class="span11" placeholder="Manu Name" name="name" value ="{{$data_id-> manu_name }}"/>
                                    </div>            
                                <div class="control-group">
                                    <label class="control-label">Manu Image :</label>
                                    <div class="controls">
                                        <img src="{{ asset('/images/manufacturers/' . $data_id-> manu_image )}}" style="width: 200px; height: 200px; background-color: #ccc; margin-bottom: 10px;" alt="">
                                        <input type="file" class="span11" name="image" />
                                    </div>
                                </div>
                                <div class="form-actions">
                                    <button type="submit" class="btn btn-success">Update Manu</button>
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