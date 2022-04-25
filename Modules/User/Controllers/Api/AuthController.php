<?php

namespace Modules\User\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Modules\Orders\Models\Cart;
use Modules\Orders\Models\Guest;
use Modules\User\Models\Token;
use Modules\User\Models\User;
use Modules\User\Requests\UserRequest;
use Modules\User\Resources\UserResource;

class AuthController extends Controller
{
    public function signup(UserRequest $request)
    {
        $data = request()->all();
        $data['status'] = 1;
        $user = User::create($data);
        $user->access_token = auth('api')->login($user);
        $subject = __("Welcome") . ' ' . $user->username;
        $data = [
            'title' => $subject,
            'msg' => __("You registered successfully"),
            'content' => __("You registered successfully"),
            'user' => $user
        ];
        try {
          //  Mail::send("User::emails.default", $data, function ($mail) use ($user, $subject) {
            //    $mail->to($user->email, $user->username);
               // $mail->subject($subject);
            });
        }catch(\Throwable $e){}
        return api_response('success', __('You have successfully registered !'), new UserResource($user));
    }

    public function login(Request $request)
    {
        if (($token = auth('api')->attempt([
            'email' => request('email'),
            'password' => request('password'),
        ]))) {
            return $this->get_user_data($token);
        }
        return api_response('error', __("Wrong mail or password"), null, 200);
    }

    public function get_user_data($token){
        $user = auth('api')->user();
        if ($user->status == 0) {
            // $this->send_activation_sms($user);
            return api_response('success', __('Your account not active from admin'), [
                'active' => 0,
                'code' => $user->token->token,
                'email' => $user->email,
            ]);
        }
        $user->access_token = $token;
        if (request('device_token')) {
            $user->device()->firstOrCreate([
                'device_type' => request('device_type', 'android'),
                'device_token' => request('device_token'),
            ]);
        }

        $guest = $guest = Guest::firstOrCreate(['fb_token' => request()->header('FbToken')]);
        if($guest && $guest->cart()->count()){
            Cart::where('guest_id' , $guest->id)->update(['user_id' => $user->id]);
        }

        return api_response('success', __('You Logged in Successfully'), new UserResource($user));
    }

    public function social_login(UserRequest $request){
        $this->validate($request , [
            'social_id' => 'required',
            'social_type' => 'required'
        ]);
        $user = User::whereNotNull('email')->where('email' , request('email'))->latest()->first();
        if (!$user) {
            $user = User::where([
                'social_id' => request('social_id'),
                'social_type' => request('social_type'),
            ])->latest()->first();
        }
        if ($user) {
            $current_user = $user->where('email' , request('email'))->where('id' , '!=' , $user->id)->update(['email' => null]);
            $user->update([
                'social_id' => request('social_id'),
                'social_type' => request('social_type'),
                'email' => request('email')
            ]);
            $token = auth('api')->login($user);
            return $this->get_user_data($token);
        }
        return $this->signup($request);   
    }

    
    public function activate()
    {
        $code = request('code');
        if (!$code) {
            return api_response('error', '', ['code' => 'code is required'], 422);
        }
        $code = Token::whereToken($code)->first();
        if (!($code && $code->user)) {
            return api_response('error', __("Code is not correct"));
        }
        $code->user()->update(['status' => 1]);
        $user = $code->user;
        $user->access_token = auth('api')->login($user);
        $code->delete();
        return api_response('success', __("Your account activated successfully"), new UserResource($user));
    }

    public function forget(Request $request)
    {
        $this->validate($request, [
            'email' => 'required',
        ]);
        $user = User::whereEmail(request('email'))->first();
        if (!$user) {
            return api_response('error', __("Email not found"));
        }
        $code = rand(1000, 9999);
        $user->token()->firstOrCreate(['token' => $code]);
        $message['title'] = __("Reset password");
        $message['content'] = __("Your code to reset password is : ") . $code;
        // send_sms($user->mobile, $message['content']);

        // $message['button_txt'] = __("Reset password");
        // $message['button_link'] = url('/');
        $this->send_mail($user, $message);
        return api_response('success', __("Reset password code sent to your email"), ['code' => $user->token->token, 'email' => request('email')]);
    }

    public function reset_code(Request $request)
    {
        $this->validate($request, ['code' => 'required']);
        $code = Token::whereToken(request('code'))->first();
        if (!$code) {
            return api_response('error', __("Reset code is not correct"));
        }
        return api_response('success', '', ['code_id' => $code->id, 'code' => request('code')]);

    }

    public function reset(Request $request)
    {
        $code = Token::whereToken(request('code'))->orWhere('id', request('code_id'))->first();
        if (!$code) {
            return api_response('error', __('Reset code is not valid'));
        }
        $this->validate($request, [
            'password' => 'required|min:6',
        ]);
        User::find($code->user_id)->update(['password' => request('password')]);
        $code->delete();
        return api_response('success', __('Your password changed successfully'));
    }

    private function send_mail($user, $message)
    {
        $message = json_decode(json_encode($message));
        // try {
            \Mail::send('User::emails.default', ['user' => $user, 'msg' => $message], function ($mail) use ($user, $message) {
                $mail->to($user->email, $user->name)->subject($message->title);
            });
        // } catch (\Exception $e) {
        // }
    }

    private function send_activation_sms($user)
    {
        $code = rand(10000, 99999);
        $user->token()->firstOrCreate(['token' => $code]);
        $message['title'] = __("Activation code");
        $message['content'] = __("Your activation code is : ") . $code;

        send_sms($user->mobile, $message['content']);
        // $message['button_txt'] = __("Active account");
        // $message['button_link'] = route('user.active', $user->token->token);
        // $this->send_mail($user, $message);
    }
}
