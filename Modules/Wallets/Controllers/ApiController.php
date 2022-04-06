<?php

namespace Modules\Wallets\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Common\Controllers\MyFatoora;
use Modules\User\Models\User;
use Modules\Wallets\Models\Wallet;

class ApiController extends Controller
{

    public function cards()
    {
        $data['wallet'] = auth('api')->user()->mywallet;
        $data['cards'] = Wallet::orderBy('sort' , 'asc')->get();
        return api_response('success', '', $data);
    }

    public function charge(Request $request){
        $user = auth('api')->user();
        if($id = request('card_id')){
            $card = Wallet::findOrFail($id);
            $amount = \DB::table('wallet_cards')->where('id' , $id)->first()->price;
        }else{
            $this->validate($request , ['amount' => 'required|numeric|min:1|max:500']);
            $amount = $request->amount;
        }
        $link = $this->create_payment_url($user , $amount);
        return api_response('success' , '' , ['paymentUrl' => $link]);
    }


    private function create_payment_url($user , $amount)
    {
        $data['username'] = $user->username ?? $user->first_name ?? 'Notdefined';
        $data['email'] = $user->email ?? 'info@meatzkw.com';
        $data['total'] = $amount;
        $data['paymentType'] = 1;
        $data['callback_url'] = route('wallet_checkout_callback', ['success' , 'total' => $amount]);
        $data['error_url'] = route('wallet_checkout_callback', ['payment_fail' , 'total' => $amount]);
        if(strpos($data['callback_url'] , ':8000')){
            $data['callback_url'] = str_replace('localhost:8000' , 'linekw.net/meatz' , $data['callback_url']);
            $data['error_url'] = str_replace('localhost:8000' , 'linekw.net/meatz' , $data['error_url']);
        }
        $data['order_data'] = ['user_id' => $user->id , 'amount' => $amount];
        $data['items'][] = [
            "ItemName" => __("Charge Wallet With"),
            "Quantity" => 1,
            "UnitPrice" => $amount,
        ];
        // dd($data);

        $payment = new MyFatoora;
        $link = $payment->send_payment($data);
        // dd($link);
        return $link;
    }

    public function wallet_checkout_callback(Request $request , $status){
        $myfatoorah = new MyFatoora();
        $result = $myfatoorah->callback(request('paymentId'));
        if (!$result->IsSuccess) {
            return 'failed';
        }
        $data = $result->Data->UserDefinedField;
        $data = (array) json_decode($data);
        $user = User::findOrFail($data['user_id']);
        $user->update(['wallet' => $user->wallet + $data['amount']]);

        return api_response('success' , '' , [
            'payment_id' => request('paymentId'),
            'transaction_id' => $result->Data->InvoiceReference ?? '',
            'amount' => number_format($data['amount'] , 3)
        ]);
        return 'success';
    }

}
