@extends('system')
@section('content-admin')
<!-- BEGIN CONTENT -->
<div id="content">
    <div id="content-header">
        <div id="breadcrumb"> <a href="{{ url('/Dashboard') }}" title="Go to Home" class="tip-bottom current"><i
                    class="icon-home"></i> Home</a></div>
        <h1>Edit Product</h1>
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
                        <form action="{{ route('updateProduct', ['id' => $product->product_id]) }}" method="post"
                            class="form-horizontal" enctype="multipart/form-data">
                            <!-- Populate this form with product details -->
                            @csrf
                            <div class="control-group">
                                <label class="control-label">Name :</label>
                                <div class="controls">
                                    <input type="text" class="span11" placeholder="Product Name" name="name"
                                        value="{{ $product->name }}" />
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Manufacturer :</label>
                                <div class="controls">
                                    <select name="manu_id" class="span11">
                                        @foreach($data_manu as $row)
                                        <option value="{{$row->manu_id}}" @if( $row->manu_id == $product->manu_id)
                                            selected @endif>{{ $row->manu_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Product Type :</label>
                                <div class="controls">
                                    <select name="type_id" class="span11">
                                        @foreach($data_protype as $row)
                                        <option value="{{$row->type_id}}" @if( $row->type_id == $product->type_id)
                                            selected @endif>{{ $row->type_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label">Sold Quantity :</label>
                                <div class="controls">
                                    <input type="text" class="span11" placeholder="Sold Quantity" name="sold_quantity"
                                        value="{{ $product->sold_quantity }}" />
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label">View :</label>
                                <div class="controls">
                                    <input type="text" class="span11" placeholder="View" name="product_view"
                                        value="{{ $product->product_view }}" />
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label">Description :</label>
                                <div class="controls">
                                    <textarea class="span11" name="description"
                                        rows="6">{{ $product->description }}</textarea>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Price (VND) :</label>
                                <div class="controls">
                                    <input type="number" class="span11" placeholder="Price" name="price"
                                        value="{{ $product->price }}" />
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Image :</label>
                                <div class="controls">
                                    <img src="{{ asset('/images/products/' . $product->pro_image) }}" alt=""
                                        style="width: 200px; height: 200px; background-color: #ccc; margin-bottom: 10px;">
                                    <input type="file" class="span11" name="image" />
                                </div>
                            </div>
                            <div class="form-actions">
                                <button type="submit" class="btn btn-success">Update Product</button>
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