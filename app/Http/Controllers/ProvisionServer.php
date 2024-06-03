<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Manufacturer;
use App\Models\Product;
use App\Models\Protype;
use App\Models\User;
use App\Models\Admin;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class ProvisionServer extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function page(Request $request, $page = "index")
    {
        // Kiểm tra xem người dùng có muốn xem tất cả sản phẩm không
        if ($request->query('all') == 'true') {
            $products = Product::orderBy('created_at', 'desc')->get();
        } else {
            $products = Product::orderBy('created_at', 'desc')->paginate(10);
        }

        // lấy dữ liệu của bảng manu , phân trang nếu manu có nhiều dữ liệu 
        $manufacture = Manufacturer::orderBy('created_at', 'desc')->paginate(10);
        // lấy dữ liệu của bảng protype , phân trang nếu manu có nhiều dữ liệu 
        $protype = Protype::orderBy('created_at', 'desc')->paginate(10);
        // lấy dữ liệu của bảng user , phân trang nếu user có nhiều dữ liệu 
        $user = User::orderBy('created_at', 'desc')->paginate(10);
        // truyền biến vào các view 
        return view($page, ['data' => $products, 'data_manu' => $manufacture, 'data_protype' => $protype, 'data_user' => $user]);
    }

    // hiển thị trang dashboard đầu tiên khi truy cập vào admin
    public function admin($admin = "Dashboard")
    {
        if ($admin === "Dashboard") {
            return $this->getStatistics();
        }

        return view($admin);
    }

    // hiển thị form đăng nhập
    public function showLoginForm()
    {
        return view('login');
    }

    // hiển thị các sản phẩm của từng nhà sản xuất 
    public function showManufacturerProducts($id)
    {
        $manufacturer = Manufacturer::with('manu_product')->find($id);
        if (!$manufacturer) {
            return response()->json(['error' => 'Nhà sản xuất không tồn tại'], 404);
        }
        $products = [];
        foreach ($manufacturer->manu_product as $product) {
            $products[] = [
                'id' => $product->product_id,
                'name' => $product->name,
                'price' => $product->price,
                'image' => '/images/products/' . $product->pro_image,
                'product_view' => $product->product_view,
            ];
        }

        return response()->json(['products' => $products]);
    }

    // hiện thị sản phẩm của protypes
    public function showProductsByType($id)
    {
        $productType = Protype::find($id)->products;
        $products = [];
        foreach ($productType as $product) {
            $products[] = [
                'id' => $product->product_id,
                'name' => $product->name,
                'price' => $product->price,
                'image' => '/images/products/' . $product->pro_image,
                'product_view' => $product->product_view,
            ];
        }

        return response()->json(['products' => $products]);
    }


    // sắp xếp theo giá , tên sản phẩm 
    public function sortProducts(Request $request)
    {
        $sortBy = $request->get('sort_by');
        $sortOrder = $request->get('sort_order');
        $manufacturerId = $request->get('manufacturer_id');

        if ($manufacturerId) {
            $manufacturer = Manufacturer::with([
                'manu_product' => function ($query) use ($sortBy, $sortOrder) {
                    $query->orderBy($sortBy, $sortOrder);
                }
            ])->find($manufacturerId);
            $products = $manufacturer->manu_product;
        } else {
            if ($sortBy === 'price') {
                $products = Product::orderBy('price', $sortOrder)->get();
            } elseif ($sortBy === 'name') {
                $products = Product::orderBy('name', $sortOrder)->get();
            } else {
                $products = Product::orderBy('product_id')->get();
            }
        }

        $html = '';
        foreach ($products as $product) {
            // Build HTML structure for each product
            $html .= '<li class="main-product">';
            $html .= '<div class="img-product">';
            $html .= '<a href="/ProductDetail"><img class="img-prd" src="/images/products/' . $product->pro_image . '" alt=""></a>';
            $html .= '</div>';
            $html .= '<div class="content-product">';
            $html .= '<h3 class="content-product-h3"><a href="/ProductDetail" style="text-decoration: none;">' . $product->name . '</a></h3>';
            $html .= '<div class="content-product-deltals">';
            $html .= '<div class="price" data-price-number="' . $product->price . '">';
            $html .= '<span class="money">' . number_format($product->price) . 'đ</span>';
            $html .= '</div>';
            $html .= '<button type="submit" class="btn btn-cart" onclick="addToCart(' . $product->product_id . ')">
            <i class="fa fa-cart-plus"></i> Thêm vào giỏ
        </button>';
            $html .= '</div>';
            $html .= '</div>';
            $html .= '</li>';
        }
        return response()->json(['html' => $html]);
    }


    // hàm tìm kiếm sản phẩm trang index
    public function search(Request $request)
    {
        try {
            $search = $request->input('search');
            $products = Product::where('name', 'like', '%' . $search . '%')->get();
            $manufacture = Manufacturer::orderBy('manu_id')->paginate(10);

            if ($products->isEmpty()) {
                return view('index', ['error' => 'Không tìm thấy sản phẩm có tên "' . $search . '"', 'data' => [], 'data_manu' => $manufacture]);
            } else {
                return view('index', ['data' => $products, 'data_manu' => $manufacture]);
            }
        } catch (\Exception $e) {
            // Có lỗi xảy ra, truyền thông báo lỗi vào view
            return view('index', ['error' => 'Có lỗi xảy ra: ' . $e->getMessage(), 'data' => [], 'data_manu' => $manufacture]);
        }
    }


    // hàm tìm kiếm sản phẩm trang admin
    public function searchAdmin(Request $request)
    {
        try {
            $search = $request->input('search');
            $products = Product::where('name', 'like', '%' . $search . '%')->paginate(10);

            if ($products->isEmpty()) {
                return view('admin', ['error' => 'Không tìm thấy sản phẩm có tên "' . $search . '"', 'data' => $products,]);
            } else {
                return view('admin', ['data' => $products]);
            }
        } catch (\Exception $e) {
            return view('admin', ['error' => 'Có lỗi xảy ra: ' . $e->getMessage(), 'data' => [],]);
        }
    }

    // hàm tìm kiếm nhà sản xuất trang admin
    public function searchManu(Request $request)
    {
        try {
            $searchTerm = $request->input('search');
            $manufacturers = Manufacturer::where('manu_name', 'like', '%' . $searchTerm . '%')->paginate(10);
            if ($manufacturers->isEmpty()) {
                return view('manufactures', ['error' => 'Không tìm thấy nhà sản xuất có tên "' . $searchTerm . '"', 'data_manu' => $manufacturers,]);
            } else {
                return view('manufactures', ['data_manu' => $manufacturers]);
            }
        } catch (\Exception $e) {

            return view('manufactures', ['error' => 'Có lỗi xảy ra: ' . $e->getMessage(), 'data_manu' => [],]);
        }
    }

    // hàm tìm kiếm loại sản phẩm trang admin
    public function searchProtype(Request $request)
    {
        try {
            $searchProtype = $request->input('search');
            $protype = Protype::where('type_name', 'like', '%' . $searchProtype . '%')->paginate(10);
            if ($protype->isEmpty()) {
                return view('ProductType', ['error' => 'Không tìm thấy loại sản phẩm có tên "' . $searchProtype . '"', 'data_protype' => $protype,]);
            } else {
                return view('ProductType', ['data_protype' => $protype]);
            }
        } catch (\Exception $e) {

            return view('ProductType', ['error' => 'Có lỗi xảy ra: ' . $e->getMessage(), 'data_protype' => [],]);
        }
    }

    // hàm tìm kiếm user trang admin
    public function searchUser(Request $request)
    {
        try {
            $searchUser = $request->input('search');
            $user = User::where('user_name', 'like', '%' . $searchUser . '%')->paginate(10);
            if ($user->isEmpty()) {
                return view('UserManager', ['error' => 'Không tìm thấy user có user_name có tên"' . $searchUser . '"', 'data_user' => $user,]);
            } else {
                return view('UserManager', ['data_user' => $user]);
            }
        } catch (\Exception $e) {

            return view('UserManager', ['error' => 'Có lỗi xảy ra: ' . $e->getMessage(), 'data_user' => [],]);
        }
    }

    //Add product
    public function addProduct()
    {
        $manu = Manufacturer::all();
        $type = Protype::all();
        return view('AddProduct', ['data_manu' => $manu, 'data_protype' => $type]);
    }
    public function storeProduct(Request $request)
    {
        try {
            $product = new Product();
            $product->name = $request->input('name');
            $product->manu_id = $request->input('manu_id');
            $product->type_id = $request->input('type_id');
            $product->price = $request->input('price');
            $product->sold_quantity = $request->input('sold_quantity');
            $product->product_view = $request->input('product_view');
            $product->description = $request->input('description');

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $extension = $file->getClientOriginalExtension();
                $filename = time() . '.' . $extension;

                // Kiểm tra xem file có phải là hình ảnh không
                if (!in_array($extension, ['jpg', 'jpeg', 'png', 'gif'])) {
                    return redirect()->back()->with(['error' => 'Chỉ được phép tải lên các file hình ảnh']);
                }

                $product->pro_image = $filename;
            }

            $product->save();

            if ($request->hasFile('image')) {
                $file->move('images/products/', $filename);
            }

            return redirect()->back()->with(['success' => 'Thêm dữ liệu sản phẩm thành công']);
        } catch (\Exception $e) {
            // Xử lý nếu có lỗi xảy ra trong quá trình thêm
            return redirect()->back()->with(['error' => 'Thêm dữ liệu sản phẩm không thành công ' . $e->getMessage()]);
        }
    }

    //Delete Product
    public function deleteProduct(Request $request, $id)
    {
        try {
            $product = Product::find($id);
            $img = 'images/products/' . $product->pro_image;
            if (File::exists($img)) {
                File::delete($img);
            }
            $product->delete();
            // Sau khi xóa thành công
            return redirect()->back()->with(['success' => 'Xóa dữ liệu sản phẩm thành công']);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => 'Xóa dữ liệu sản phẩm không thành công ' . $e->getMessage()]);
        }
    }

    //Edit Product
    public function editProduct($id)
    {
        $product = Product::findOrFail($id);
        $manu = Manufacturer::all();
        $type = Protype::all();
        return view('EditProduct', ['product' => $product, 'data_manu' => $manu, 'data_protype' => $type]);
    }

    public function updateProduct(Request $request, $id)
    {
        try {
            $product = Product::findOrFail($id);

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $extension = $file->getClientOriginalExtension();

                // Kiểm tra xem file có phải là hình ảnh không
                if (!in_array($extension, ['jpg', 'jpeg', 'png', 'gif'])) {
                    return redirect()->back()->with(['error' => 'Chỉ được phép tải lên các file hình ảnh']);
                }

                $anhCu = 'images/products/' . $product->pro_image;
                if (File::exists($anhCu)) {
                    File::delete($anhCu);
                }

                $filename = time() . '.' . $extension;
                $file->move('images/products/', $filename);
                $product->pro_image = $filename;
            }

            $product->name = $request->input('name');
            $product->manu_id = $request->input('manu_id');
            $product->type_id = $request->input('type_id');
            $product->sold_quantity = $request->input('sold_quantity');
            $product->product_view = $request->input('product_view');
            $product->description = $request->input('description');
            $product->price = $request->input('price');

            $product->save();
            return redirect()->back()->with(['success' => 'Cập nhật dữ liệu sản phẩm thành công']);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => 'Cập nhật dữ liệu sản phẩm không thành công ' . $e->getMessage()]);
        }
    }

    //Add Protype
    public function addProType()
    {
        $type = Protype::all();
        return view('AddProductType', ['data_protype' => $type]);
    }
    public function storeProtype(Request $request)
    {
        try {
            $protype = new Protype();
            $protype->type_name = $request->input('name');

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $extension = $file->getClientOriginalExtension();

                // Kiểm tra xem file có phải là hình ảnh không
                if (!in_array($extension, ['jpg', 'jpeg', 'png', 'gif'])) {
                    return redirect()->back()->with(['error' => 'Chỉ được phép tải lên các file hình ảnh']);
                }

                $filename = time() . '.' . $extension;
                $file->move('images/ProductsType/', $filename);
                $protype->type_image = $filename;
            }

            $protype->save();
            return redirect()->back()->with(['success' => 'Thêm dữ liệu loại sản phẩm thành công']);
        } catch (\Exception $e) {
            // Xử lý nếu có lỗi xảy ra trong quá trình thêm
            return redirect()->back()->with(['error' => 'Thêm dữ liệu loại sản phẩm không thành công ' . $e->getMessage()]);
        }
    }

    //Delete Protype
    public function deleteProtype(Request $request, $id)
    {
        try {
            $protype = Protype::find($id);
            // Kiểm tra xem Protype có chứa sản phẩm nào không
            if ($protype->products()->count() > 0) {
                return redirect()->back()->with(['error' => 'Không thể xóa loại sản phẩm này vì nó có chứa ' . $protype->products()->count() . ' sản phẩm']);
            }

            $img = 'images/ProductsType/' . $protype->type_image;
            if (File::exists($img)) {
                File::delete($img);
            }
            $protype->delete();
            // Sau khi xóa thành công
            return redirect()->back()->with(['success' => 'Xóa dữ liệu loại sản phẩm thành công']);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => 'Xóa dữ liệu loại sản phẩm không thành công ' . $e->getMessage()]);
        }
    }


    //Edit Protype
    public function editProtype($id)
    {
        $protype = Protype::find($id);
        return view('EditProductType', ['data_id' => $protype]);
    }

    public function updateProtype(Request $request, $id)
    {
        try {
            $protype = Protype::findOrFail($id);

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $extension = $file->getClientOriginalExtension();

                // Kiểm tra xem file có phải là hình ảnh không
                if (!in_array($extension, ['jpg', 'jpeg', 'png', 'gif'])) {
                    return redirect()->back()->with(['error' => 'Chỉ được phép tải lên các file hình ảnh']);
                }

                $anhCu = 'images/ProductsType/' . $protype->type_image;
                if (File::exists($anhCu)) {
                    File::delete($anhCu);
                }

                $filename = time() . '.' . $extension;
                $file->move('images/ProductsType/', $filename);
                $protype->type_image = $filename;
            }

            $protype->type_name = $request->input('name');
            $protype->save();
            return redirect()->back()->with(['success' => 'Cập nhật dữ liệu loại sản phẩm thành công']);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => 'Cập nhật dữ liệu loại sản phẩm không thành công ' . $e->getMessage()]);
        }
    }

    // add manu
    public function addManu()
    {
        $manu = Manufacturer::all();
        return view('AddManufactures', ['data_manu' => $manu]);
    }
    public function storeManu(Request $request)
    {
        try {
            $manu = new Manufacturer();
            $manu->manu_name = $request->input('name');
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $extension = $file->getClientOriginalExtension();

                // Kiểm tra xem file có phải là hình ảnh không
                if (!in_array($extension, ['jpg', 'jpeg', 'png', 'gif'])) {
                    return redirect()->back()->with(['error' => 'Chỉ được phép tải lên các file hình ảnh']);
                }

                $filename = time() . '.' . $extension;
                $file->move('images/manufacturers/', $filename);
                $manu->manu_image = $filename;
            }
            $manu->save();
            return redirect()->back()->with(['success' => 'Thêm dữ liệu nhà sản xuất thành công']);
        } catch (\Exception $e) {
            // Xử lý nếu có lỗi xảy ra trong quá trình thêm
            return redirect()->back()->with(['error' => 'Thêm dữ liệu nhà sản xuất không thành công ' . $e->getMessage()]);
        }
    }

    //Delete Manu
    public function deleteManu(Request $request, $id)
    {
        try {
            $manu = Manufacturer::find($id);
            // Kiểm tra xem Manufacturer có chứa sản phẩm nào không
            if ($manu->manu_product()->count() > 0) {
                return redirect()->back()->with(['error' => 'Không thể xóa nhà sản xuất này vì nó có chứa ' . $manu->manu_product()->count() . ' sản phẩm']);
            }

            $img = 'images/manufacturers/' . $manu->manu_image;
            if (File::exists($img)) {
                File::delete($img);
            }
            $manu->delete();
            // Sau khi xóa thành công
            return redirect()->back()->with(['success' => 'Xóa dữ liệu nhà sản xuất thành công']);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => 'Xóa dữ liệu nhà sản xuất không thành công ' . $e->getMessage()]);
        }
    }


    //Edit Manu
    public function editManu($id)
    {
        $manu = Manufacturer::find($id);
        return view('EditManufactures', ['data_id' => $manu]);
    }

    public function updateManu(Request $request, $id)
    {
        try {
            $manu = Manufacturer::findOrFail($id);

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $extension = $file->getClientOriginalExtension();

                // Kiểm tra xem file có phải là hình ảnh không
                if (!in_array($extension, ['jpg', 'jpeg', 'png', 'gif'])) {
                    return redirect()->back()->with(['error' => 'Chỉ được phép tải lên các file hình ảnh']);
                }

                $anhCu = 'images/manufacturers/' . $manu->manu_image;
                if (File::exists($anhCu)) {
                    File::delete($anhCu);
                }

                $filename = time() . '.' . $extension;
                $file->move('images/manufacturers/', $filename);
                $manu->manu_image = $filename;
            }

            $manu->manu_name = $request->input('name');
            $manu->save();
            return redirect()->back()->with(['success' => 'Cập nhật dữ liệu nhà sản xuất thành công']);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => 'Cập nhật dữ liệu nhà sản xuất không thành công ' . $e->getMessage()]);
        }
    }

    //addUser
    public function addUser()
    {
        $user = User::all();
        return view('AddUser', ['data_user' => $user]);
    }

    public function storeUser(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email|regex:/@gmail\.com$/',
            ], [
                'email.regex' => 'Email phải có đuôi @gmail.com',
            ]);

            $user = new User();
            $user->first_name = $request->input('first');
            $user->last_name = $request->input('last');
            $user->address = $request->input('address');
            $user->email = $request->input('email');
            $user->user_name = $request->input('name');
            $user->password = Hash::make($request->input('pass')); // Mã hóa mật khẩu

            $user->save();
            return redirect()->back()->with(['success' => 'Thêm dữ liệu user thành công']);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Xử lý nếu có lỗi xảy ra trong quá trình xác thực
            return redirect()->back()->withErrors($e->validator)->withInput();
        } catch (\Exception $e) {
            // Xử lý nếu có lỗi xảy ra trong quá trình thêm
            return redirect()->back()->with(['error' => 'Thêm dữ liệu user không thành công ' . $e->getMessage()]);
        }
    }


    //Delete User
    public function deleteUser(Request $request, $id)
    {
        try {
            $user =  User::find($id);
            $user->delete();
            // Sau khi xóa thành công
            return redirect()->back()->with(['success' => 'Xóa dữ liệu user thành công']);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => 'Xóa dữ liệu user không thành công ' . $e->getMessage()]);
        }
    }

    //Edit User
    public function editUser($id)
    {
        $user = User::findOrFail($id);
        return view('EditUser', ['user' => $user]);
    }

    public function updateUser(Request $request, $id)
    {
        try {
            $request->validate([
                'email' => 'required|email|regex:/@gmail\.com$/',
            ], [
                'email.regex' => 'Email phải có đuôi @gmail.com',
            ]);

            $user = User::findOrFail($id);
            $user->first_name = $request->input('first');
            $user->last_name = $request->input('last');
            $user->address = $request->input('address');
            $user->email = $request->input('email');
            $user->user_name = $request->input('name');
            $user->password = Hash::make($request->input('pass')); // Mã hóa mật khẩu

            $user->save();
            return redirect()->back()->with(['success' => 'Cập nhật dữ liệu user thành công']);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => 'Cập nhật dữ liệu user không thành công ' . $e->getMessage()]);
        }
    }

    // Hiển thị chi tiết sản phẩm
    public function showproduct($id)
    {
        $product = Product::findOrFail($id);
        return view('productDetail', compact('product'));
    }

    // hàm tăng product_view mỗi khi người dùng nhấn vào xem chi tiết sản phẩm 
    public function incrementView($id)
    {
        $product = Product::findOrFail($id);
        $product->product_view += 1;
        $product->save();

        return response()->json(['product_view' => $product->product_view]);
    }


    // xử lí register
    public function register(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'address' => 'required',
            'email' => 'required|email|regex:/@gmail\.com$/',
            'user_name' => 'required',
            'password' => 'required',
        ], [
            'email.regex' => 'Email phải có đuôi @gmail.com',
        ]);

        $user = new User;
        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name');
        $user->address = $request->input('address');
        $user->email = $request->input('email');
        $user->user_name = $request->input('user_name');
        $user->password = Hash::make($request->input('password'));
        $user->save();


        $request->session()->put('username', $user->user_name);
        $request->session()->put('password', $request->input('password'));

        return redirect()->route('login');
    }

    //xử lí login 
    public function login(Request $request)
    {
        $username = $request->input('username');
        $password = $request->input('password');

        $user = User::where('user_name', $username)->first();
        $admin = Admin::where('username', $username)->first();

        if ($user && Hash::check($password, $user->password)) {
            // Lưu thông tin người dùng vào session
            $request->session()->put('user', $user);

            // Lấy giỏ hàng từ cơ sở dữ liệu nếu có
            $cart = DB::table('carts')->where('user_id', $user->user_id)->first();
            if ($cart) {
                // Lấy các sản phẩm trong giỏ hàng từ bảng cart_product
                $cartProducts = DB::table('cart_product')
                    ->join('products', 'cart_product.product_id', '=', 'products.product_id')
                    ->where('cart_product.cart_id', $cart->cart_id)
                    ->select('products.*', 'cart_product.quantity', 'cart_product.created_at')
                    ->get();

                // Lưu thông tin giỏ hàng vào session
                $cartData = [];
                foreach ($cartProducts as $cartProduct) {
                    $cartData[$cartProduct->product_id] = [
                        'name' => $cartProduct->name,
                        'price' => $cartProduct->price,
                        'image' => $cartProduct->pro_image,
                        'quantity' => $cartProduct->quantity,
                        'added_at' => $cartProduct->created_at,
                    ];
                }

                session()->put('cart', $cartData);
            }

            // Chuyển hướng đến trang chính (index)
            return redirect()->route('index');
        } else if ($admin && Hash::check($password, $admin->password)) {
            // The user is an admin, redirect them to the admin page
            $request->session()->put('admin', $admin);
            return redirect()->route('Dashboard');
        } else {
            // Authentication failed, redirect back to the login page
            return redirect()->route('login')->with('error', 'Sai tên đăng nhập hoặc mật khẩu');
        }
    }

    // xử lí logout 
    public function logout(Request $request)
    {
        $request->session()->flush();
        return redirect()->route('login');
    }

    // update profileUser
    public function updateProfile(Request $request)
    {
        // Validate the request data
        $request->validate([
            'firstname' => 'required|max:50',
            'lastname' => 'required|max:50',
            'address' => 'required|max:100',
            'email' => 'required|email|max:100|ends_with:@gmail.com',
            'username' => 'required|max:50',
            'password' => 'required|max:255',
        ], [
            'email.ends_with' => 'Email phải có đuôi @gmail.com',
        ]);

        // Find the user in the database
        $user = User::find(Session::get('user')->user_id);

        // Update the user's information
        $user->first_name = $request->firstname;
        $user->last_name = $request->lastname;
        $user->address = $request->address;
        $user->email = $request->email;
        $user->user_name = $request->username;
        $user->password = Hash::make($request->password); // mã hóa mật khẩu

        // Save the changes
        $user->save();

        // Update the user information in the session
        $request->session()->put('user', $user);

        // Add a flash message to the session
        session()->flash('status', 'Thông tin cá nhân đã được cập nhật thành công!');

        return redirect()->route('profileUser');
    }

    // update profileAdmin
    public function updateProfileAdmin(Request $request)
    {
        // Validate the request data
        $request->validate([
            'username' => 'required|max:50',
            'password' => 'required|max:255',
            'role' => 'required|max:50',
        ]);

        // Find the user in the database
        $admin = Admin::find(Session::get('admin')->admin_id);

        // Update the user's information
        $admin->username = $request->username;
        $admin->password = Hash::make($request->password); // mã hóa mật khẩu
        $admin->role = $request->role;

        // Save the changes
        $admin->save();

        // Update the user information in the session
        $request->session()->put('admin', $admin);

        // Add a flash message to the session
        session()->flash('status', 'Thông tin cá nhân đã được cập nhật thành công!');

        return redirect()->route('profileAdmin');
    }

    // thêm sản phẩm vào giỏ hàng 
    public function addToCart(Request $request, $id)
    {
        $product = Product::find($id);
        $user = session('user');

        // Tìm giỏ hàng của người dùng hiện tại
        $cart = DB::table('carts')->where('user_id', $user->user_id)->first();

        if (!$cart) {
            // Nếu người dùng chưa có giỏ hàng, tạo một giỏ hàng mới
            $cart_id = DB::table('carts')->insertGetId([
                'user_id' => $user->user_id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } else {
            $cart_id = $cart->cart_id;
        }

        // Kiểm tra xem sản phẩm đã có trong giỏ hàng chưa
        $cartProduct = DB::table('cart_product')
            ->where('cart_id', $cart_id)
            ->where('product_id', $id)
            ->first();

        // Lưu thông tin sản phẩm vào session
        $cart = session()->get('cart', []);
        $message = '';
        if ($cartProduct) {
            // Nếu sản phẩm đã có trong giỏ hàng, tăng số lượng
            DB::table('cart_product')
                ->where('cart_id', $cart_id)
                ->where('product_id', $id)
                ->increment('quantity');

            // Cập nhật thông tin sản phẩm trong session giỏ hàng
            $cart[$id]['quantity']++;
            $message = 'Sản phẩm đã được thêm vào giỏ hàng';
        } else {
            // Nếu sản phẩm chưa có trong giỏ hàng, thêm sản phẩm mới
            DB::table('cart_product')->insert([
                'cart_id' => $cart_id,
                'product_id' => $id,
                'quantity' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Nếu sản phẩm chưa có trong giỏ hàng, thêm sản phẩm mới
            $cart[$id] = [
                'name' => $product->name,
                'price' => $product->price,
                'image' => $product->pro_image,
                'quantity' => 1,
                'added_at' => now(),
            ];
            $message = 'Sản phẩm đã được thêm vào giỏ hàng';
        }
        session()->put('cart', $cart);

        return response()->json(['message' => $message]);
    }

    // update quantity cart
    public function updateCartQuantity(Request $request, $productId)
    {
        $quantity = $request->input('quantity');

        // Update quantity in database
        DB::table('cart_product')
            ->where('product_id', $productId)
            ->update(['quantity' => $quantity]);

        // Update session cart
        $cart = session()->get('cart', []);
        $cart[$productId]['quantity'] = $quantity;
        session()->put('cart', $cart);

        return response()->json(['success' => true]);
    }
    // update updateCartTotals
    public function updateCartTotals($id, Request $request)
    {
        $cart = session('cart', []);
        $item = $cart[$id];
        $subtotal = $item['price'] * $request->input('quantity');
        $total = array_reduce(
            $cart,
            function ($carry, $item) {
                return $carry + $item['price'] * $item['quantity'];
            },
            0
        );

        return response()->json([
            'subtotal' => number_format($subtotal) . ' ₫',
            'total' => number_format($total) . ' ₫'
        ]);
    }

    // delete product cart 
    public function deleteFromCart($productId)
    {
        // Delete from database
        DB::table('cart_product')
            ->where('product_id', $productId)
            ->delete();

        // Update session cart
        $cart = session()->get('cart', []);
        unset($cart[$productId]);
        session()->put('cart', $cart);

        return response()->json(['success' => true]);
    }

    // delete all product cart
    public function deleteAllFromCart()
    {
        // Delete all from database
        DB::table('cart_product')->delete();

        // Update session cart
        session()->forget('cart');

        return response()->json(['success' => true]);
    }

    // abate all product cart 
    public function checkout()
    {
        // Update sold_quantity in database
        $cart = session()->get('cart', []);
        foreach ($cart as $id => $details) {
            DB::table('products')
                ->where('product_id', $id)
                ->increment('sold_quantity', $details['quantity']);
        }

        // Delete all from database
        DB::table('cart_product')->delete();

        // Update session cart
        session()->forget('cart');

        return response()->json(['success' => true]);
    }

    // DashBoard
    public function getStatistics()
    {
        // Tính tổng danh thu
        $totalRevenue = DB::table('products')
            ->sum(DB::raw('price * sold_quantity'));

        // Tính tổng số lượng đã bán
        $totalSoldQuantity = DB::table('products')
            ->sum('sold_quantity');

        // Tìm sản phẩm bán chạy nhất
        $bestSellingProduct = DB::table('products')
            ->orderBy('sold_quantity', 'desc')
            ->first();

        return view('Dashboard', [
            'totalRevenue' => $totalRevenue,
            'totalSoldQuantity' => $totalSoldQuantity,
            'bestSellingProduct' => $bestSellingProduct,
        ]);
    }

    // review product
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,product_id',
            'content' => 'required',
        ]);

        $review = new Review;
        $review->product_id = $request->product_id;
        $review->user_id = session()->get('user')->user_id;
        $review->content = $request->content;
        $review->save();

        return response()->json([
            'message' => 'Đánh giá đã được lưu thành công!',
            'review' => $review,
            'user' => $review->user,
            'created_at' => $review->created_at->format('d/m/Y H:i:s'),
        ]);
    }
}
