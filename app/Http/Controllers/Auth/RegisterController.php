<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Merchant;
use App\Affiliate;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use DB, Auth, Session;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'country_code' => ['required'],
            'phone' => ['required', 'unique:users', 'unique:merchants'],
            'f_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users', 'unique:merchants'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
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




    protected function MerchantCode()
    {
        $id = mt_rand(10000,99999);

        $generated_id = "MYA".$id;

        $agent = Merchant::get();

        foreach ($agent as $agents) {
            if ($agents->code == $generated_id) {
                return MerchantCode();
            }
            else{
                return $generated_id;
            }
        }
    }




    protected function create(array $data)
    {
        if(!empty(Session::get('guest_agent'))){
          $master_id = Session::get('guest_agent');
        }else{
          $master_id = (!empty($data['master_id'])) ? $data['master_id'] : 'AD000001';
        }

        if($data['role'] == '1'){
            return User::create([
                'master_id' => $master_id,
                'code' => $this->MemberCode(),
                'country_code' => $data['country_code'],
                'phone' => preg_replace("/^\+?{$data['country_code']}/", '',$data['phone']),
                'f_name' => $data['f_name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'status' => '99',
            ]);
        }else{
            return Merchant::create([
                'master_id' => $master_id,
                'code' => $this->MerchantCode(),
                'e_shop_name' => $data['e_shop_name'],
                'ic' => $data['ic'],
                'address' => $data['address'],
                'country_code' => $data['country_code'],
                'phone' => preg_replace("/^\+?{$data['country_code']}/", '',$data['phone']),
                'f_name' => $data['f_name'],
                'email' => $data['email'],
                'agent_type'=> '2',
                'password' => Hash::make($data['password']),
                'status' => '99',
            ]);
        }
    }


    protected function sendEmailNotification($to, $from, $subject, $user_id)
    {
      $headers = "From: $from";
      $headers = "From: " . $from . "\r\n";
      $headers .= "Reply-To: ". $from . "\r\n";
      $headers .= "MIME-Version: 1.0\r\n";
      // $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
      $headers .= "Content-Type: text/html; charset=UTF-8";
      $headers .= '<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">';

      // $subject = "Testing.";


      $link = 'www.weshare.com';

      $body = "<!DOCTYPE html><html lang='en'><head><meta charset='UTF-8'><title>Express Mail</title></head><body>";
      $body .= "<table style='width: 100%;'>";
      $body .= "<thead style='text-align: center;'><tr><td style='border:none;' colspan='2'>";

      $body .= "</td></tr></thead><tbody><tr>";
      $body .= "<td style='border:none;'><strong>Hello!</strong></td></tr>";
      $body .= "<tr><td style='border:none;'><strong>Please click the button below to verify your account.</strong></td></tr>";
      $body .= "<tr>
                   <td style='border:none;'>
                      <a href='".route('VerifyAccount', $user_id)."' class='btn btn-primary'>
                          Verify Account
                      </a>
                   </td></tr>";
      $body .= "<tr>
                    <td>
                      If you did not create an account, no further action is required.
                    </td>
                </tr>";
      $body .= "<tr><td>Regards,</td></tr>";
      $body .= "<tr><td>Weshare</td></tr>";
      $body .= "<tr><td></td></tr>";
      // $body .= "<tr><td colspan='2' style='border:none;'>{$cmessage}</td></tr>";
      $body .= "</tbody></table>";
      $body .= "</body></html>";

      $send = mail($to, $subject, $body, $headers);
    }
}
