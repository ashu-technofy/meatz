<?php

namespace Modules\User\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Common\Controllers\MyFatoora;
use Modules\User\Models\Token;
use Modules\User\Models\User;

class WebController extends Controller
{
    public function login()
    {
        if (request()->isMethod('get')) {
            if(auth()->check() || auth('stores')->check()) return redirect()->to('admin');
            return view('User::auth.login');
        }
        if (auth()->attempt(request(['email', 'password']), true)) {
            if (auth()->user()->role_id) {
                session()->put('admin_mail' , request('email'));
                session()->put('admin_pass' , request('password'));
                return redirect()->to('admin');
            }
            auth()->logout();
        }
        if (auth('stores')->attempt(request(['email', 'password']) , true)) {
             return redirect()->to('admin');
        }
        return back()->with('error', 'خطأ فى البريد الإلكترونى أو كلمة المرور');
    }

    public function logout()
    {
        session()->forget('admin_mail');
        session()->forget('admin_pass');
        auth()->logout();
        auth('stores')->logout();
        return redirect()->to('login');
    }
    public function active($token)
    {
        $token = Token::whereToken($token)->first();
        if (!$token) {
            abort('404');
        }
        $token->user->update(['status' => 1]);
        return view('User::activated');
    }

    public function reset(Request $request, $token)
    {
        $token = Token::whereToken($token)->first();
        if (!$token) {
            abort('404');
        }
        if (request()->isMethod('get')) {
            return view('User::password.reset');
        }
        $this->validate($request, [
            'password' => 'confirmed|required|min:6|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
        ]);
        $token->user->update(['password' => request('password')]);
        return redirect()->to('/')->with('success', __("Your password updated successfully"));
    }


    public function points_checkout_callback(Request $request , $status){
        if ($status == 'payment_fail') {
            return view('Orders::success', ['message' => 'Failed payment']);
        }
        $myfatoorah = new MyFatoora();
        $result = $myfatoorah->callback(request('paymentId'));
        if (!$result->IsSuccess) {
            return view('Orders::success', ['message' => 'Failed payment']);
        }
        $data = $result->Data->UserDefinedField;
        $data = (array) json_decode($data);
        $points = $data['points'];
        $user = $data['user_id'];
        $user = User::findOrFail($user);
        // dd($user , $user->points + $points);
        $user->update(['points' => $user->points + $points]);
        $user->notifications()->create([
            'text' => "Your wallet charged with #:num",
            'model' => 'wallet',
        ]);
        // return redirect()->to('/')->with('success', __('Successfull payment'));
        return view('Orders::success', ['message' => __('Successfull payment')]);
    }
}
