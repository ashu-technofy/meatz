<?php

namespace Modules\Subscribe\Controllers;

use App\Http\Controllers\Controller;
use Modules\Subscribe\Mail\SubscribeMail;
use Modules\Subscribe\Models\Subscribe;

class AdminController extends Controller
{
    public function index()
    {
        $rows = Subscribe::latest()->paginate(30);
        $title = "Subscriptions";
        return view('Subscribe::index', get_defined_vars());
    }

    public function store()
    {
        $data = request()->all();
        $emails = Subscribe::pluck('email')->toArray();
        foreach ($emails as $email) {
            $when = now()->addMinutes(1);
            \Mail::to($email)->later($when, new SubscribeMail($data));
        }
        return response()->json(['url' => route('admin.subscribe.index'), 'message' => __("Message sent successfully")]);
    }

    public function destroy($id)
    {
        Subscribe::find($id)->delete();
        return response()->json(['url' => route('admin.subscribe.index'), 'message' => __("Deleted successfully")]);
    }
}
