<?php

namespace Modules\Common\Controllers;

class MyFatoora
{

    private $token;
    private $basURL;
    public function __construct()
    {

        $this->token = "al_YMJQMRG1mLrn7iixwFJvgFKwfuTIGYvp0-qqNZ2wGbeMYjVkdKCw6nz8RTih82crjITbWnPhi3Qk5BcKBfBo5zDiFubOtul4v3dDVeaD_caTT003kyDEWZAgsQlSI7HUh2uTNbTtwz3ik8-p6DpOZRFNDC6b_Zs1wM1v2DFoXJEM_JoHqeUJOH1OryOqJ856K44_WSHdDcHpkHYwVQU22YJvtj3wFsyVB6cJZ9Oyf8hg6os4eqIek3gjNnhJ94_ZbaMTG_Mq--OgWTv6DD54rd-ONXpkDEE_nUBPIQ7n2J1NkdmUGFs6ycbP4vfatCjBQ-lFUU0yacKLGETmmppflAH-vl-k07YRI8YA46iIvl3gYEt93B5pjMxgAgbQxgcNIMtggge-LS_U1zRceaJyHfMQQCGn7AC89wmhCT79SchtSgUQ4LrNwvDek92c6KiYfnBXUCPlmgQQx_UBI68uzGTLuRvppG2hBClY_56Fu_CVnWfG0zJf_0AHtdudjMf1dRQKexF0dKLpxE7tBkZ0yljNXrK7QlonnGeXppbxwyYsXc6gSpNPdZygvDNd2mfFexxmswO8ziCtVjOYjXq8ATZkKqnDlAI4SUvCBixDukUKFAbPpRxLUWVzdyjIH3L9J3bWlISrZ9yH0nzvwe4KK6LkhkMu7Wn59ifrGFXrIjJ3Z";
        $this->basURL = "https://api.myfatoorah.com/";

        /******** FOR TESTTTT **********/
        //$this->token = "yie3lCT-d2fFVx9sn2VrbMdQydSepThPqebndxjfy5VhWOOWO2WpghBrp1ErbW6rQEtZEfVJ9ubU0jRWbdn98zaAKnNSAJ2lql4uSl6jsVic27mN81v7o7sdMrIxBhzJumCcmxq-gZN_8Y4eXEdRkGiVNSZTvWB0J9PI2r2Zp4GFDbc2U-VU2QiOFpe8zipNxtACXqWWixwsfWsiRbOjlw2l0TsQaOYHkwXECsQNRqpVnsu-yNq7mI-WF2dTNisqcF-sYJ9HHwjGV7tz_FKQXbe8gSA4OJzoSftZ4k4sV8xHBfhE0yri5cWrEYnroomco0KoSHjYqJSmg1aqgCVBi7IZA9UT9E2T0W3EPqJrXu-WX8UeMWaOrhSlCr4qN-A2GMjid0J0wNaBAfXS0YZjfHYfTAeC6fuZQfFRUw-9OqLf4XCorB5J4nKCkc-na1sAqnN1jLwiiE19qlzHqcvHcD9fxfXrN9QfjBk-eS7ixnDw7DDsQ34VEdDWpBLQRAcIRvoI5uAjNmEEJcZ1j9-ph-g5Rg7wefr0y-0-KKZleRu-vPaWs6O_SIcUu2clIC9GLdb4qPicCv8zuQqVBGDwLvnP5a6YDOec8SfbltQQ1-fSAaAuo7JeyqWFUXdggt6su93xZSXijy8FstjuCMYa7jsMgEEb21dPe0CFXquq0S6nkubh1D_Mub_XDnFY19t4UVgDzg";
        //$this->basURL = "https://apitest.myfatoorah.com";
        /******** END FOR TESTTTT **********/
    }

    public function send_payment($data)
    {
        $mobile = request('mobile') ?? $data['mobile'] ?? '52345678';
        $data = array(
            "NotificationOption" => "ALL",
            // 'PaymentMethodId' => '2',
            'CustomerName' => $data['username'],
            'DisplayCurrencyIso' => 'KWD',
            'MobileCountryCode' => '+965',
            'CustomerMobile' => substr($mobile, 0, 7),
            'CustomerEmail' => $data['email'] ?? app_setting('email') ?? 'notdefined@email.com',
            'InvoiceValue' => $data['total'],
            'CallBackUrl' => $data['callback_url'],
            'ErrorUrl' => $data['error_url'],
            'Language' => app()->getLocale(),
            'CustomerReference' => null,
            'CustomerCivilId' => null,
            'UserDefinedField' => json_encode($data['order_data']),
            'ExpireDate' => '',
            'CustomerAddress' => array(
                'Block' => '',
                'Street' => '',
                'HouseBuildingNo' => '',
                'Address' => '',
                'AddressInstructions' => '',
            ),
            'InvoiceItems' => $data['items'],
            'suppliers' => $data['suppliers'] ?? null,
        );
        // dd($data);
        $data = json_encode($data);
        $curl = curl_init();
        $payment = array(
            CURLOPT_URL => "{$this->basURL}/v2/SendPayment",
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $data,
            CURLOPT_HTTPHEADER => array("Authorization: Bearer {$this->token}", "Content-Type: application/json"),
        );
        // dd($payment);
        curl_setopt_array($curl, $payment);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($curl);
        $err = curl_error($curl);
        // dd($response);
        $url = json_decode($response)->Data->InvoiceURL ?? null;
        if (!$url) {
            return json_decode(($response));
        }
        return $url;
    }

    public function callback($id)
    {
        $data = [
            "Key" => $id,
            "KeyType" => "PaymentId",
        ];
        $data = json_encode($data);
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "{$this->basURL}/v2/GetPaymentStatus",
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $data,
            CURLOPT_HTTPHEADER => array("Authorization: Bearer {$this->token}", "Content-Type: application/json"),
        ));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($curl);
        $response = json_decode($response);
        return $response;
    }

    public function refund_request($id, $total)
    {
        $data = array(
            "KeyType" => "PaymentId",
            "Key" => $id,
            "RefundChargeOnCustomer" => false,
            "ServiceChargeOnCustomer" => false,
            "Amount" => $total,
            "Comment" => "",
        );
        // dd($data);
        $data = json_encode($data);
        $curl = curl_init();
        $payment = array(
            CURLOPT_URL => "{$this->basURL}/v2/MakeRefund",
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $data,
            CURLOPT_HTTPHEADER => array("Authorization: Bearer {$this->token}", "Content-Type: application/json"),
        );
        // dd($payment);
        curl_setopt_array($curl, $payment);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($curl);
        $err = curl_error($curl);
        // dd($response);
        $url = json_decode($response)->Data->InvoiceURL ?? null;
        if (!$url) {
            return json_decode(($response));
        }
        return $url;
    }

    public function supplier_refund($id, $data)
    {

        $data = array(
            "Key" => $id,
            "KeyType" => "paymentid",
            // "RefundChargeOnCustomer" => true,
            // "ServiceChargeOnCustomer" => true,
            "VendorDeductAmount" => 0,
            "Comment" => "Refund order : #" . $data['order_id'],
            "Suppliers" => array_values($data['suppliers']),
        );
        // dd($data);
        $data = json_encode($data);
        $curl = curl_init();
        $payment = array(
            CURLOPT_URL => "{$this->basURL}/v2/MakeSupplierRefund",
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $data,
            CURLOPT_HTTPHEADER => array("Authorization: Bearer {$this->token}", "Content-Type: application/json"),
        );
        // dd($payment);
        curl_setopt_array($curl, $payment);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($curl);
        // dd(json_decode($response) , json_decode($data));
        $err = curl_error($curl);
        return json_decode($response);
    }

}
