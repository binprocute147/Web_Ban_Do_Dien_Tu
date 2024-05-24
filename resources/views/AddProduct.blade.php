    @extends('system')
    @section('content-admin')
        <!-- BEGIN CONTENT -->

        <div id="content">
            <div id="content-header">
                <div id="breadcrumb"> <a href="{{ url('/admin') }}" title="Go to Home" class="tip-bottom current"><i
                            class="icon-home"></i> Home</a></div>
                <h1>Add Product</h1>
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
                            <div class="widget-content nopadding">
                                <form action="{{ route('addProduct') }}" method="POST" class="form-horizontal"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="control-group">
                                        <label class="control-label">Name :</label>
                                        <div class="controls">
                                            <input type="text" class="span11" placeholder="Product Name"
                                                name="name" />
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Manufacturer :</label>
                                        <div class="controls">
                                            <select name="manu_id" class="span11">
                                                @foreach ($data_manu as $row)
                                                    <option value ="{{ $row->manu_id }}" name ="manu_id">
                                                        {{ $row->manu_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="control-group">
                                        <label class="control-label">Product Type :</label>
                                        <div class="controls">
                                            <select name="type_id" class="span11">
                                                @foreach ($data_protype as $row)
                                                    <option value="{{ $row->type_id }}" name="type_id">{{ $row->type_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Sold Quantity :</label>
                                        <div class="controls">
                                            <input type="text" class="span11" placeholder="Sold Quantity" value="0"
                                                name="sold_quantity" />
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">View :</label>
                                        <div class="controls">
                                            <input type="text" class="span11" placeholder="View" name="product_view" value="0"/>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Description :</label>
                                        <div class="controls">
                                            <textarea class="span11" name="description" rows="6"></textarea>
                                        </div>
                                    </div>

                                    <div class="control-group">
                                        <label class="control-label">Price (VND) :</label>
                                        <div class="controls">
                                            <input type="number" class="span11" placeholder="Price" name="price" />
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Image :</label>
                                        <div class="controls">
                                            <input type="file" class="span11" name="image" required />
                                        </div>
                                    </div>
                                    <div class="form-actions">
                                        <button type="submit" class="btn btn-success">Add Product</button>
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
