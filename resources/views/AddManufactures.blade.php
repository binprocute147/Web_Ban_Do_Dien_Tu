@extends('system')
    @section('content-admin')
<!-- BEGIN CONTENT -->
        <div id="content">
            <div id="content-header">
                <div id="breadcrumb"> <a href="{{url('/admin')}}" title="Go to Home"
                        class="tip-bottom current"><i class="icon-home"></i>
                        Home</a></div>
                <h1>Add a Manufacture</h1>
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
                            <div class="widget-title"> <span class="icon"> <i
                                        class="icon-align-justify"></i> </span>
                                <h5>Manufacture info</h5>
                            </div>
                            <div class="widget-content nopadding">

                                <!-- BEGIN USER FORM -->
                                <form action="{{ route('addManu') }}" method="post"

                                    class="form-horizontal"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="control-group">
                                        <label class="control-label">Name :</label>
                                        <div class="controls">
                                            <input type="text" class="span11"
                                                placeholder="Manufacture name"
                                                name="name" /> *
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Choose
                                            another logo :</label>
                                        <div class="controls">
                                            <input type="file" name="image"
>
                                        </div>
                                    </div>

                                    <div class="form-actions">
                                        <button type="submit" class="btn
                                            btn-success">Add Manu</button>
                                    </div>
                                </form>
                                <!-- END USER FORM -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END CONTENT -->
        @endsection