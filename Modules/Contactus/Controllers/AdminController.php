<?php

namespace Modules\Contactus\Controllers;

use App\Http\Controllers\Controller;
use Modules\Contactus\Models\Contactus;

class AdminController extends Controller
{
    public function index()
    {
        $messages = Contactus::when(request('keyword'), function ($query) {
            $word = request('keyword');
            return $query->where('first_name', 'like', "%$word%")
                ->orWhere('email', 'like', "%$word%")
                ->orWhere('mobile', 'like', "%$word%");
        })->latest()
            ->paginate(25);
        $title = "Contactus messages";
        return view('Contactus::admin.list', get_defined_vars());
    }

    public function show($id)
    {
        $message = Contactus::findOrFail($id);
        if(request('action') == 'delete'){
            $message->delete();
            return $this->index();
        }
        $message->update(['seen' => 1]);
        $title = "Message Details";
        return view('Contactus::admin.show', get_defined_vars());
    }
}
