<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Validator, Redirect, Toastr, DB, File;
use App\Promotion;
use App\Product;
use App\Transaction;
use App\AppliedPromotion;

class PromotionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $promotions = Promotion::where('status', '!=', '3')
                               ->orderBy('created_at', 'desc');

        $queries = [];
        $columns = [
            'promotion_title', 'status'
        ];

        foreach($columns as $column){
            if(request()->has($column) && !empty(request($column))){
                
                $promotions = $promotions->where($column, 'like', "%".request($column)."%");

                $queries[$column] = request($column);

            }
        }
        $per_page = 10;
        if(!empty(request('per_page'))){
            $per_page = request('per_page');
        }
        $promotions = $promotions->paginate($per_page)->appends($queries);

        $available = [];
        $redeemed = [];
        foreach($promotions as $promotion){
            $transaction = AppliedPromotion::select(DB::raw('COUNT(id) AS totalRedeemed'))->where('promotion_id', $promotion->id)->whereIn('status', ['1', '99'])->first();
            
            $available[$promotion->id] = (float)$promotion->quantity - (float)$transaction->totalRedeemed;
            $redeemed[$promotion->id] = $transaction->totalRedeemed;
        }

        return view('backend.promotions.index', ['promotions'=>$promotions], compact('available', 'redeemed'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $products = Product::where('status', '1')->get();
        return view('backend.promotions.create', ['products'=>$products]);
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
            'promotion_title' => 'required',
            'image' => 'required',
            'discount_code' => 'required',
            'amount_type' => 'required',
            'amount' => 'required',
            'quantity' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withInput(Input::all())->withErrors($validator);
        }

        if($request->amount_type == 'Percentage' && $request->amount > '100'){
            return Redirect::back()->withInput(Input::all())->withErrors("The discount percentage unable exceed 100");
        }

        $input = $request->all();
        $input['products'] = !empty($request->products) ? implode(',', $request->products) : '';
        $input['start_date'] = !empty($request->start_date) ? date('Y-m-d H:i:s', strtotime($request->start_date)) : '';
        $input['end_date'] = !empty($request->end_date) ? date('Y-m-d H:i:s', strtotime($request->end_date)) : '';
        $input['dow'] = !empty($request->dow) ? '1' : '0';

        $files = $request->file('image'); 
        $name = $files->getClientOriginalName();
        $exp = explode(".", $name);
        $file_ext = end($exp);
        $name = md5($name.date('Y-m-d H:i:s')).'.'.$file_ext;

        $files->move("uploads/promotions/", $name);

        $input['image'] = "uploads/promotions/".$name;

        $create = Promotion::create($input);


        Toastr::success("Promotion Create Successfully!");
        return redirect()->route('promotion.promotions.index');
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
        $promotion = Promotion::find($id);
        $products = Product::where('status', '1')->get();
        return view('backend.promotions.edit', ['promotion'=>$promotion, 'products'=>$products]);
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
            'promotion_title' => 'required',
            'discount_code' => 'required',
            'amount_type' => 'required',
            'amount' => 'required',
            'quantity' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withInput(Input::all())->withErrors($validator);
        }

        if($request->amount_type == 'Percentage' && $request->amount > '100'){
            return Redirect::back()->withInput(Input::all())->withErrors("The discount percentage unable exceed 100");
        }
        
        $input = $request->all();
        $input['products'] = !empty($request->products) ? implode(',', $request->products) : '';
        $input['start_date'] = !empty($request->start_date) ? date('Y-m-d H:i:s', strtotime($request->start_date)) : '';
        $input['end_date'] = !empty($request->end_date) ? date('Y-m-d H:i:s', strtotime($request->end_date)) : '';
        $input['dow'] = !empty($request->dow) ? '1' : '0';

        if(!empty($request->file('image'))){
            $files = $request->file('image'); 
            $name = $files->getClientOriginalName();
            $exp = explode(".", $name);
            $file_ext = end($exp);
            $name = md5($name.date('Y-m-d H:i:s')).'.'.$file_ext;

            $files->move("uploads/promotions/", $name);

            $input['image'] = "uploads/promotions/".$name;
        }
        $update = Promotion::find($id);
        $update = $update->update($input);

        Toastr::success("Promotion Updated Successfully!");
        return redirect()->route('promotion.promotions.edit', $id);
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
}
