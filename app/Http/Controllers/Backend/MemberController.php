<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use App\Admin;
use App\Merchant;
use App\User;
use App\Affiliate;
use App\VerifyCode;
use App\State;
use App\SettingRefferalReward;
use App\AgentLevel;
use App\SettingMerchantBonus;
use App\AffiliateCommission;
use App\AgentRebateHistory;
use App\Transaction;
use App\MemberWallet;
use App\AffiliateDual;
use Validator, Redirect, Toastr, DB, File, Auth, Hash;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::select('users.*', 'l.agent_lvl')
                             ->leftJoin('agent_levels as l', 'l.id', 'users.lvl')
                             ->whereNotIn('users.status', ['99', '3'])
                             ->orderBy('users.created_at', 'desc');

        $per_page = 10;
        if(!empty(request('per_page'))){
            $per_page = request('per_page');
        }

        $queries = [];
        $columns = [
            'code', 'member_name', 'status'
        ];
        foreach($columns as $column){
            if(request()->has($column) && !empty(request($column))){
                if($column == 'member_name'){
                    $users = $users->where(DB::raw('CONCAT(f_name, " ", l_name)'), 'like', "%".request($column)."%");
                }elseif($column == 'status'){
                    $users = $users->where('users.status', 'like', "%".request($column)."%");
                }elseif($column == 'per_page'){
                  $users = $users->paginate($per_page);
                }else{
                    $users = $users->where($column, 'like', "%".request($column)."%");
                }

                $queries[$column] = request($column);

            }
        }
        
        $users = $users->paginate($per_page)->appends($queries);

        // $users = User::where('status', '1')->get();
        // foreach($users as $user){
        //     $affs = Affiliate::select('affiliates.sort_level', 'u.f_name')
        //                      ->join('users AS u', 'u.code', 'affiliates.affiliate_id')
        //                      ->where('user_id', $user->code)
        //                      ->where('sort_level', '<=', '3')
        //                      ->orderBy('sort_level', 'asc')
        //                      ->get();
        //     foreach($affs as $aff){
        //         echo $user->f_name.': '.$aff->sort_level.' '.$aff->f_name;
        //         echo "<br>";
        //     }
        // }
        //  $users = User::where('status', '!=', '3')
        //              ->get();
        

        // foreach($users as $user){
        //     echo $check = $this->GenerateCode($user->code);
        // }

        // exit();

        return view('backend.members.index', ['users'=>$users]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $states = State::get();
        return view('backend.members.create', ['states'=>$states]);
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
            'f_name' => 'required',
            'phone' => ['required', 'unique:users'],
            'email' => ['required', 'unique:users'],
            'password' => ['required', 'min:6'],
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withInput(Input::all())->withErrors($validator);
        }

        if(!empty($request->master_id)){
            $checkmAff = Merchant::where('code', $request->master_id)->first();
            if(empty($checkmAff->id)){
                return Redirect::back()->withInput(Input::all())->withErrors("Refferal Code Not Exists");
            }
            $master_id = $checkmAff->code;
        }else{
            $master_id = "AD000001";
        }

        $input = $request->all();
        $input['country_code'] = $request->country_code;
        $input['master_id'] = $master_id;
        $input['f_name'] = htmlspecialchars(trim($request->f_name));
        $input['l_name'] = htmlspecialchars(trim($request->l_name));
        $input['gender'] = htmlspecialchars(trim($request->gender));
        $input['phone'] = htmlspecialchars(trim($request->phone));
        $input['code'] = htmlspecialchars(trim($this->MemberCode()));
        $input['email'] = htmlspecialchars(trim($request->email));
        $input['address'] = htmlspecialchars(trim($request->email));
        $input['password'] = Hash::make($request->password);
        $input['status'] = '1';

        $user = user::create($input);

        Toastr::success("$user->f_name Created!");
        return redirect()->route('member.members.index');
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
        $user = User::select('users.*', 'm.code AS master_code')
                            ->leftJoin('users AS m', 'm.code', 'users.master_id')
                            ->where('users.id', $id)
                            ->first();

        return view('backend.members.edit', ['user'=>$user]);
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
            'f_name' => 'required',
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withInput(Input::all())->withErrors($validator);
        }
        
        $input = $request->all();
        $input['f_name'] = htmlspecialchars(trim($request->f_name));
        $input['l_name'] = htmlspecialchars(trim($request->l_name));

        $user = User::find($id);
        $user_name = $user->f_name;
        $user = $user->update($input);

        Toastr::success("$user_name Updated!");
        return redirect()->route('member.members.edit', $id);
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

    public function tree($agent_code)
    {
        $user = User::where('code', $agent_code)->first();

        $userD = User::where('master_id', $agent_code)
                             ->where('status', '1')
                             ->get();

        $mdd = [];
        $mddd = [];
        $mddd1 = [];
        $mddd2 = [];
        $mddd3 = [];
        $sg  = 0;
        $tg  = 0;
        $fog  = 0;
        $fig  = 0;
        $sig  = 0;
        foreach($userD as $userdv){
            $mdd[$userdv->code] = User::where('master_id', $userdv->code)->where('status', '1')->get();
            $sg += count($mdd[$userdv->code]);

            foreach($mdd[$userdv->code] as $mddv){
                $mddd[$mddv->code] = User::where('master_id', $mddv->code)->where('status', '1')->get();
                $tg += count($mddd[$mddv->code]);

                foreach($mddd[$mddv->code] as $mdddv){
                    $mddd1[$mdddv->code] = User::where('master_id', $mdddv->code)->where('status', '1')->get();
                    $fog += count($mddd1[$mdddv->code]);

                    foreach($mddd1[$mdddv->code] as $mddddv){
                        $mddd2[$mddddv->code] = User::where('master_id', $mddddv->code)->where('status', '1')->get();
                        $fig += count($mddd2[$mddddv->code]);

                        foreach($mddd2[$mddddv->code] as $mdddddv){
                            $mddd3[$mdddddv->code] = User::where('master_id', $mdddddv->code)->where('status', '1')->get();
                            $sig += count($mddd3[$mdddddv->code]);
                        }
                    }
                }
            }
        }
        
        $fg = count($userD);
        

        $total = $fg + $sg + $tg + $fog + $fig + $sig;
        // echo $tg;
        if($total > 0){
            $fgp = round($fg / $total * 100, 2);
            $sgp = round($sg / $total * 100, 2);
            $tgp = round($tg / $total * 100, 2);

            $fogp = round($fog / $total * 100, 2);
            $figp = round($fig / $total * 100, 2);
            $sigp = round($sig / $total * 100, 2);
        }else{
            $fgp = 0;
            $sgp = 0;
            $tgp = 0;            

            $fogp = 0;
            $figp = 0;
            $sigp = 0;
        }


        return view('backend.members.tree', ['userD'=>$userD, 'user'=>$user,
                                               'fg'=>$fg, 'fgp'=>$fgp,
                                               'sg'=>$sg, 'sgp'=>$sgp,
                                               'tg'=>$tg, 'tgp'=>$tgp,
                                               'fog'=>$fog, 'fogp'=>$fogp,
                                               'fig'=>$fig, 'figp'=>$figp,
                                               'sig'=>$sig, 'sigp'=>$sigp,], compact('mdd', 'mddd', 'mddd1', 'mddd2', 'mddd3'));
    }

    public function tree_details($agent_code, $g)
    {
        if(!empty($g) && $g <= 3 && $g > 0){
            if($g == '1'){
                $generation = "1st";
            }elseif($g == '2'){
                $generation = "2nd";
            }else{
                $generation = "3th";
            }            
        }else{
            abort(404);
        }


        if($g == 1){
            $users = User::where('master_id', $agent_code)
                                 ->where('status', '1')
                                 ->get();
        }elseif($g == 2){
            $users = User::select('d.*')
                                 ->join('users AS d', 'd.master_id', 'users.code')
                                 ->where('users.master_id', $agent_code)
                                 ->where('d.status', '1')
                                 ->get();

        }else{
            $users = User::select('dd.*')
                                 ->join('users AS d', 'd.master_id', 'users.code')
                                 ->join('users AS dd', 'dd.master_id', 'd.code')
                                 ->where('users.master_id', $agent_code)
                                 ->where('dd.status', '1')
                                 ->get();
        }


        return view('backend.members.tree_details', ['generation'=>$generation, 'users'=>$users]);
    }

    public function saveMemberNewPassword(Request $request, $id)
    {
        $input = $request->all();
        $input['password'] = Hash::make($request->new_password);
        $update = User::find($id);
        $update = $update->update($input);

        Toastr::success("Password Changed!");
        return redirect()->route('member.members.edit', $id);
    }

 
   public function MemberCode()
    {
         $id = mt_rand(10000,99999);

        $generated_id = $id;

        $agent = User::get();

        foreach ($agent as $agents) {
            if ($agents->code == $generated_id) {
                return MemberCode();
            }
            else{
                return $generated_id;
            }
        }
    }

    public function pending_member()
    {

        $users = User::where('status', '99')->orderBy('created_at', 'desc');
        if(Auth::guard('merchant')->check()){
            $users = $users->where('master_id', Auth::user()->code);
        }
        $queries = [];
        $columns = [
            'merchant_name', 'code'
        ];
        foreach($columns as $column){
            if(request()->has($column) && !empty(request($column))){
                if($column == 'merchant_name'){
                    $users = $users->where(DB::raw('CONCAT(f_name, " ", l_name)'), 'like', "%".request($column)."%");
                }else{
                    $users = $users->where($column, 'like', "%".request($column)."%");
                }

                $queries[$column] = request($column);

            }
        }
        $per_page = 10;
        if(!empty(request('per_page'))){
            $per_page = request('per_page');
        }
        $users = $users->paginate($per_page)->appends($queries);

        return view('backend.members.pending', ['users'=>$users]);
    }
}
