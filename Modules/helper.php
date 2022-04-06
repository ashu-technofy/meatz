<?php

use Modules\Stores\Models\Store;
use Modules\Stores\Models\StorePeriod;

function boolean_vals()
{
    return ['No', 'Yes'];
}
function page_types()
{
    return [
        'page' => "Normal page",
        'terms' => "Policy & Rules",
        'policy' => 'Privacy plolicy',
        'return_policy' => "Return policy",
        'about' => 'About',
        'contact' => 'Contactus',
    ];
}

function hours($index = null)
{
    $hours = [
        '0' => '12:00 ' . __('am'),
        '1' => '01:00 ' . __('am'),
        '2' => '02:00 ' . __('am'),
        '3' => '03:00 ' . __('am'),
        '4' => '04:00 ' . __('am'),
        '5' => '05:00 ' . __('am'),
        '6' => '06:00 ' . __('am'),
        '7' => '07:00 ' . __('am'),
        '8' => '08:00 ' . __('am'),
        '9' => '09:00 ' . __('am'),
        '10' => '10:00 ' . __('am'),
        '11' => '11:00 ' . __('am'),
        '12' => '12:00 ' . __('pm'),
        '13' => '01:00 ' . __('pm'),
        '14' => '02:00 ' . __('pm'),
        '15' => '03:00 ' . __('pm'),
        '16' => '04:00 ' . __('pm'),
        '17' => '05:00 ' . __('pm'),
        '18' => '06:00 ' . __('pm'),
        '19' => '07:00 ' . __('pm'),
        '20' => '08:00 ' . __('pm'),
        '21' => '09:00 ' . __('pm'),
        '22' => '10:00 ' . __('pm'),
        '23' => '11:00 ' . __('pm'),
    ];
    return $index ? $hours[$index] : $hours;
}

function week_days()
{
    $days = [
        'Mon',
        'Tue',
        'Wed',
        'Thu',
        'Fri',
        'Sat',
        'Sun',
    ];
    foreach ($days as $day) {
        $mydays[$day] = __($day);
    }
    return $mydays;
}

function days_off()
{
    $days = [
        'Fri',
        'Sat',
    ];
    foreach ($days as $day) {
        $mydays[$day] = __($day);
    }
    return $mydays;
}

function weekdays_index($index)
{
    $days = [
        'Monday',
        'Tuesday',
        'Wednesday',
        'Thursday',
        'Friday',
        'Saturday',
        'Sunday',
    ];
    return array_search($index, $days) + 1;
}

function sidebar()
{
    if (auth('stores')->user()) {
        return store_sidebar();
    }
    $menu = [];
    $menu_files = glob(base_path("Modules/**/Views/admin/menu.php"));
    // dd($menu_files);
    foreach ($menu_files as $file) {
        $content = str_replace("<?php", "", file_get_contents($file));
        eval($content);
    }
    foreach ($menu as $group => $menu) {
        if (strpos($group, '*') !== false) {
            $group = str_replace("*", "", $group);
            $links[$group] = [
                'title' => __($group),
                'links' => $menu,
            ];
        } else {
            $links[] = [
                'title' => __($group),
                'links' => $menu,
            ];
        }
    }
    // dd($links);
    $roles = auth()->user()->role->roles;
    // dd($roles);
    foreach ($links as $key => $link) {
        if (is_string($key)) {
            if (!in_array($key, $roles)) {
                unset($links[$key]);
            }
        } elseif (isset($link['links'])) {
            $sub_links = $link['links'];
            foreach ($sub_links as $ken => $len) {
                if (!in_array($ken, $roles)) {
                    unset($sub_links[$ken]);
                }
            }
            if (count($sub_links)) {
                $link['links'] = $sub_links;
                $links[$key] = $link;
            } else {
                unset($links[$key]);
            }
        }
    }
    return $links;
}

function admin_roles()
{
    $modules = glob(base_path("Modules/*"));
    foreach ($modules as $module) {
        $module = array_reverse(explode('/', $module))[0];
        if (strpos($module, '.php') === false) {
            $roles[] = $module;
        }
    }
    foreach ($roles as $role) {
        if (!in_array($role, ['Addresses'])) {
            $rows[$role] = $role;
        }
    }
    return $rows;
}

function order_statuses()
{
    return [
        'Pending',
        'On the way',
        'Delivered',
        'Canceled',
    ];
}

function send_fcm($tokens, $platfrom, $message, $order_id, $product_id = null, $credits = null, $topic = null, $title = null)
{
    // dd($tokens, $message, $order_id);
    ob_start();
    $url = "https://fcm.googleapis.com/fcm/send";
    $serverKey = "AAAAvNU0MMU:APA91bEFFNlvJu6ep4ZaanTsWF0DbDkFz0t5-hyMERNlgwxqwihhCooXOoV1XVPu8Hg4RpGEhI7_npIJlwAYlCPamZhN0ZyCdypIlTI-dcnDiDhsSCQNvGa6isGAddfC70OSYzmWvQGU";
    // dd($tokens , $message);
    if (!$credits) {
        $type = 'manager';
        if ($order_id) {
            $type = 'order';
        } elseif ($product_id) {
            $type = 'product';
        }
        $id = $order_id ?? $product_id;
        $notification = array(
            'text' => $message,
            'title' => $title ?? app_setting('title'),
            'body' => $message,
            'type' => $type,
            'id' => $id ?? '10101',
            'sound' => 'default',
            'badge' => '1',
            'click_action' => $type,
        );
    } else {
        $notification = array(
            'text' => $message,
            'title' => $title ?? app_setting('title'),
            'body' => $message,
            'type' => 'credits',
            'credits' => $credits,
            'sound' => 'default',
            'badge' => '1',
            'click_action' => "FLUTTER_NOTIFICATION_CLICK",
            'id' => "",
        );
    }
    $tokens = (array) $tokens;
    if ($platfrom == 'android') {
        // $notification = array_unique($notification);
    } else {
        $notification['alert'] = [
            "title" => app_setting('title'),
            "body" => $message,
            "text" => $message,
            "action-loc-key" => "PLAY",
        ];
    }
    if ($topic) {
        $arrayToSend = array(
            'to' => "/topics/$topic",
            // 'registration_ids' => $tokens,
            'notification' => $notification,
            'data' => $notification,
            'priority' => 'high',
        );
    } else {
        $arrayToSend = array(
            'registration_ids' => $tokens,
            'notification' => $notification,
            'data' => $notification,
            'priority' => 'high',
        );
    }

    // dd($notification);

    // if ($platfrom == 'ios') {
    //     $arrayToSend = array(
    //         'registration_ids' => $tokens,
    //         'notification' => $notification,
    //         'data' => ['click_action' => "FLUTTER_NOTIFICATION_CLICK" , "id" => $id],
    //         'priority' => 'high',
    //     );
    // } else {
    //     // return true;
    //     $arrayToSend = array(
    //         'registration_ids' => $tokens,
    //         'data' => $notification,
    //         'priority' => 'high',
    //     );
    // }
    $json = json_encode($arrayToSend);
    $headers = array();
    $headers[] = 'Content-Type: application/json';
    $headers[] = 'Authorization: key=' . $serverKey;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    //Send the request
    $response = curl_exec($ch);
    if (request('testi')) {
        dd($response, $tokens, $notification, $arrayToSend, $platfrom);
    }
    //Close request
    if ($response === false) {
        // die('FCM Send Error: ' . curl_error($ch));
    }
    // dd($json);
    curl_close($ch);
    ob_end_clean();
    return true;
}

function send_sms($mobile, $message)
{
    return 'success';
}

function app_setting($key)
{
    $row = \Modules\Common\Models\Setting::where('key', $key)->first();
    $locale = app()->getLocale();
    if (!$row) {
        return null;
    }

    if ((!is_object($row->value)) && $value = json_decode($row->value)) {
        if (is_array($value)) {
            return $value;
        }

        if (is_string($value) || is_numeric($value)) {
            return $value;
        }

        return $value->all ?? $value->{$locale} ?? $value->ar ?? '';
    }
    $value = $row->value->all ?? $row->value->{$locale} ?? $row->value->ar ?? $row->value ?? '';
    if ($value && is_string($value) && (strpos($value, 'jpg') !== false || strpos($value, 'jpeg') !== false || strpos($value, 'png') !== false || strpos($value, 'svg') !== false)) {
        return url($value);
    }
    return $value;
}

function round_me($val, $length = 2)
{
    $val = (float) sprintf('%0.2f', $val);
    return $val < 0 ? 0 : $val;
}

function get_month($index)
{
    $months = array(
        'Jan',
        'Feb',
        'Mar',
        'Apr',
        'May',
        'Jun',
        'Jul',
        'Aug',
        'Sep',
        'Oct',
        'Nov',
        'Dec',
    );
    return $months[$index];
}

function distance($lat1, $lon1, $lat2, $lon2, $unit)
{
    $theta = $lon1 - $lon2;
    $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
    $dist = acos($dist);
    $dist = rad2deg($dist);
    $miles = $dist * 60 * 1.1515;
    $unit = strtoupper($unit);

    if ($unit == "K") {
        return number_format(($miles * 1.609344), 2);
    } elseif ($unit == "N") {
        return ($miles * 0.8684);
    } else {
        return $miles;
    }
}

function format_price($price)
{
    return number_format($price, 3);
}

// function getip()
// {
//     $ip = $_SERVER['REMOTE_ADDR'];
//     $ip = "41.36.109.127";
//     try {
//         $result = file_get_contents("https://api.ipgeolocationapi.com/geolocate/" . $ip);
//         $geoip = json_decode($result);
//         $location = ['country' => $geoip->name, 'lat' => $geoip->geo->latitude, 'lng' => $geoip->geo->longitude];
//     } catch (\Throwable $th) {
//         $location = null;
//     }
// }

function get_client_ip()
{
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP')) {
        $ipaddress = getenv('HTTP_CLIENT_IP');
    } elseif (getenv('HTTP_X_FORWARDED_FOR')) {
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    } elseif (getenv('HTTP_X_FORWARDED')) {
        $ipaddress = getenv('HTTP_X_FORWARDED');
    } elseif (getenv('HTTP_FORWARDED_FOR')) {
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    } elseif (getenv('HTTP_FORWARDED')) {
        $ipaddress = getenv('HTTP_FORWARDED');
    } elseif (getenv('REMOTE_ADDR')) {
        $ipaddress = getenv('REMOTE_ADDR');
    } else {
        $ipaddress = 'UNKNOWN';
    }

    return $ipaddress;
}

function social_types()
{
    return [
        'facebook' => 'Facebook',
        'twitter' => 'Twitter',
        'google-plus-g' => 'Google plus',
        'instagram' => 'Instagram',
        'snapchat-ghost' => 'Snapchat',
        'whatsapp' => 'whatsapp',
        'mobile' => "Mobile",
        'email' => "Email",
    ];
}
function socials()
{
    return \Modules\Common\Models\Setting::whereIn('key', array_keys(social_types()))->where('value', '!=', null)->get();
}

function pages()
{
    return \Modules\Pages\Models\Page::get();
}

function date_range($stores)
{
    $stores = Store::whereIn('id', $stores)->get();
    $days_off = $rows = [];
    foreach ($stores as $store) {
        $rows[] = $store->days_off ?? [];
    }
    foreach ($rows as $row) {
        $days_off = array_merge($days_off, $row);
    }
    // dd($days_off , $stores);
    $days = [];
    for ($i = 0; $i < 5; $i++) {
        $time = strtotime("+$i days");
        if ($i == 0) {
            $days['start'] = date('d M', $time);
        } elseif ($i == 4) {
            $days['end'] = date('d M', $time);
            $days['year'] = date('Y', $time);
        }
        $weekday = date('D', $time);
        $days['days'][] = [
            'weekday' => __($weekday),
            'day' => date('d', $time),
            'date' => date('Y-m-d', $time),
            'today' => date('Y-m-d') == date('Y-m-d', $time) ? 1 : 0,
            'active' => !in_array($weekday, $days_off) ? 1 : 0,
        ];
    }
    return $days;
}

function store_periods($store)
{
    // if ($store) {
    //     $periods = $store->periods()->orderBy('from', 'asc')->get(['id', 'from', 'to']) ?? [];
    // }
    // if (!$store || !count($periods)) {
    //     $periods = StorePeriod::whereNull('store_id')->orderBy('from', 'asc')->get(['id', 'from', 'to']) ?? [];
    // }
    $periods = StorePeriod::whereNull('store_id')->orderBy('from', 'asc')->get(['id', 'from', 'to']) ?? [];
    $rows = [];
    foreach ($periods as $row) {
        $rows[] = [
            'id' => $row['id'],
            'from' => hours($row['from']),
            'to' => hours($row['to']),
            'active' => $row['from'] >= date('H') ? 1 : 0,
        ];
    }
    return $rows;
}

function mydd($data)
{
    if (request()->header('testic') || isset($_COOKIE['testic'])) {
        dd($data);
    }
}

function get_supplier_arr($order, $refund = false)
{
    $suppliers = [];
    $items = $order->items;
    $key = $refund ? "SupplierDeductedAmount" : "InvoiceShare";
    foreach ($items as $item) {
        if ($item->product && ($store = $item->product->store) && $store->supplier_code) {
            $sup_total = $suppliers[$store->supplier_code][$key] ?? 0;
            $suppliers[$store->supplier_code] = [
                "SupplierCode" => (int) $store->supplier_code,
                $key => $item->total + $sup_total,
            ];
        } else {
            $sup_total = $suppliers[app_setting('supplier_code')][$key] ?? 0;
            $suppliers[app_setting('supplier_code')] = [
                "SupplierCode" => (int) app_setting('supplier_code'),
                $key => $item->total + $sup_total
            ];
        }
    }
    return $suppliers;
}
