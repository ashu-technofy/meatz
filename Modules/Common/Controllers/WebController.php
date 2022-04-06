<?php

namespace Modules\Common\Controllers;

use App\Http\Controllers\Controller;
use Modules\Common\Models\Section;
use Modules\Common\Models\Setting;
use Modules\Pages\Models\Page;
use Modules\Services\Models\Service;
use Modules\Sliders\Models\Slider;

class WebController extends Controller
{

    public function index()
    {
        $features = Section::where('type' , 'features')->orderBy('sort' , 'asc')->get();
        $about = Section::where('type' , 'about')->first()->content;
        return view('Common::web.home', get_defined_vars());
    }

    public function policy()
    {
        $page = Page::where('type', 'policy')->first() ?? new Page;
        $socials = Setting::socials()->get();
        return view('Common::policy', get_defined_vars());
    }
}
