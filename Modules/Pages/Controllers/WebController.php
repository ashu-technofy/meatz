<?php

namespace Modules\Pages\Controllers;

use App\Http\Controllers\Controller;
use Modules\Pages\Models\Page;

class WebController extends Controller
{
    public function show($slug)
    {
        $id = explode('-', $slug)[0];
        $page = $info = Page::find($id) ?? Page::where('type' , $slug)->firstOrFail();
        return view('Common::web.layout.page', get_defined_vars());
    }

    public function about(){
        $page = $info = Page::where('type' , 'about')->firstOrFail();
        return view('Pages::index', get_defined_vars());
    }

    public function terms(){
        $page = $info = Page::where('type' , 'terms')->firstOrFail();
        return view('Pages::index', get_defined_vars());
    }
}
