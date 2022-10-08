<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use App\Product;
use App\ProductImage;
use App\Stock;
use App\Category;
use App\SubCategory;
use App\Brand;
use App\Cart;
use App\TransactionDetail;
use Validator, Redirect, Toastr, DB, File;

class PointMallController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $product = Product::orderBy('created_at', 'desc')
                          ->where('mall', '1')
                          ->where('status', '!=', '3');

        $queries = [];
        $columns = [
            'product_name', 'status'
        ];
        foreach($columns as $column){
            if(request()->has($column) && !empty(request($column))){
                
                $product = $product->where($column, 'like', "%".request($column)."%");

                $queries[$column] = request($column);

            }
        }
        $per_page = 10;
        if(!empty(request('per_page'))){
            $per_page = request('per_page');
        }
        $product = $product->paginate($per_page)->appends($queries);
        $quantity = [];
        foreach($product as $value){
            $quantity[$value->id] = $this->BalanceQuantity($value->id);
        }

        return view('backend.products.point_product_index', ['products' => $product], compact('quantity'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::where('status', '1')->get();
        $sub_categories = SubCategory::where('status', '1')->get();
        $brands = Brand::where('status', '1')->get();

        return view('backend.products.point_product_create', ['categories'=>$categories, 'brands'=>$brands, 'sub_categories'=>$sub_categories]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_name' => 'required',
            'category_id' => 'required',
            'description' => 'required',
            'agent_price' => 'required',
            'price' => 'required',
            'quantity' => 'required',
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withInput(Input::all())->withErrors($validator);
        }

        $input = $request->all();
        $input['product_name'] = htmlspecialchars(trim($request->product_name));
        $input['category_id'] = htmlspecialchars(trim($request->category_id));
        $input['brand_id'] = htmlspecialchars(trim($request->brand_id));
        $input['description'] = htmlspecialchars(trim($request->description));
        $input['price'] = $input['price'];
        $input['special_price'] = $input['special_price'];
        $input['agent_price'] = $input['agent_price'];
        $input['agent_special_price'] = $input['agent_special_price'];
        $input['sub_category_id'] = !empty($request->sub_category_id) ? implode(',', $request->sub_category_id) : '';
        $input['mall'] = '1';
        $create = Product::create($input);

        //Move File
        $move = ProductImage::where('status', '99')->get();

        foreach($move as $key => $value){
            $files = $value->image;
            $explode = explode('/', $files);

            if (!file_exists('uploads/'.$create->id)) {
                File::makeDirectory('uploads/'.$create->id, $mode = 0777, true, true);
            }
            
            rename($value->image, 'uploads/'.$create->id.'/'.end($explode));
            $updateI = ProductImage::find($value->id);
            $updateI = $updateI->update(['image'=>'uploads/'.$create->id.'/'.end($explode),
                                         'product_id' => $create->id, 
                                         'status'=> '1']);
        }

        $createQ = Stock::create([
                                    'type'=>'Increase',
                                    'quantity'=>$request->quantity,
                                    'product_id' => $create->id,
                                    'remark' => 'Open Stock'
                                 ]);

        Toastr::success("Product $create->product_name Create Successfully!");
        return redirect()->route('point_mall.point_malls.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $categories = Category::where('status', '1')->get();
        $sub_categories = SubCategory::where('status', '1')->get();
        $product = Product::find($id);
        if(!isset($product) && empty($product)){
            abort(404);
        }

        $brands = Brand::where('status', '1')->get();
        $stockBalance = $this->BalanceQuantity($id);

        return view('backend.products.edit', ['product'=>$product, 'categories'=>$categories, 'brands'=>$brands, 'sub_categories'=>$sub_categories,
                                              'stockBalance'=>$stockBalance]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'product_name' => 'required',
            'category_id' => 'required',
            'description' => 'required',
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withInput(Input::all())->withErrors($validator);
        }

        $input = $request->all();
        $input['product_name'] = str_replace('/','',$request->product_name);
        $input['category_id'] = htmlspecialchars(trim($request->category_id));
        $input['brand_id'] = htmlspecialchars(trim($request->brand_id));
        $input['description'] = htmlspecialchars(trim($request->description));
        $input['price'] = $input['price'];
        $input['special_price'] = $input['special_price'];
        $input['agent_price'] = $input['agent_price'];
        $input['agent_special_price'] = $input['agent_special_price'];
        $input['sub_category_id'] = implode(',', $request->sub_category_id);

        $update = Product::find($id);
        $product_name = $update->product_name;
        $update = $update->update($input);

        Toastr::success("Product $product_name Update Successfully!");
        return redirect()->route('point_mall.point_malls.edit', $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function BalanceQuantity($id)
    {
        $stockBalance = Stock::select(DB::raw('SUM(IF(type = "Increase", quantity, NULL)) AS totalStockIn'),
                                      DB::raw('SUM(IF(type = "Decrease", quantity, NULL)) AS totalStockOut'))
                                ->where('product_id', $id)
                                ->first();

        $cart = Cart::select(DB::raw('SUM(qty) AS InCart'))
                    ->where('status', '1')
                    ->where('product_id', $id)
                    ->first();

        $transaction = TransactionDetail::select(DB::raw('SUM(quantity) AS TransCart'))
                                        ->where('status', '1')
                                        ->where('product_id', $id)
                                        ->first();

        return $stockBalance->totalStockIn - $stockBalance->totalStockOut - $cart->InCart - $transaction->TransCart;
    }
}
