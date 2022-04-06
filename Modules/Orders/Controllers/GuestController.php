<?php

namespace Modules\Orders\Controllers;

use App\Http\Controllers\Controller;
use Modules\Orders\Models\Guest;

class GuestController extends Controller
{
    public function index()
    {
        $rows = Guest::active()->when(request('keyword') , function($query){
            $word = request('keyword');
            return $query->where('username' , 'like' , "%$word%")
            ->orWhere('email' , 'like' , "%$word%")
            ->orWhere('mobile' , 'like' , "%$word%");
        })->latest()->paginate(25);
        $title = "المستخدمين الغير مسجلين";
        return view("Orders::admin.guests.index", get_defined_vars());
    }

    public function show($id)
    {
        $guest = Guest::findOrFail($id);
        $title = "المستخدمين الغير مسجلين";
        $name = 'guests';
        return view("Orders::admin.guests.show", get_defined_vars());
    }

    public function destroy($id)
    {
        Guest::findOrFail($id)->delete();
        return response()->json(['url' => route('admin.guests.index'), 'message' => 'تم الحذف بنجاح']);
    }
}
