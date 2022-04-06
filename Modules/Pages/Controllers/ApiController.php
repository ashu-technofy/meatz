<?php

namespace Modules\Pages\Controllers;

use App\Http\Controllers\Controller;
use Modules\Pages\Models\Page;

class ApiController extends Controller
{

    public function index($id = null)
    {
        if ($id) {
            $page_info = Page::find($id);
            if(\Config::get('app.locale') == 'ar'){
                $pages['id'] = $page_info['id'];
                $pages['type'] = $page_info['type'];
                $pages['title'] = $page_info['title'];
                $pages['content'] = '<div style="text-align:right; dir:rtl;">' . $page_info['content'] . '</div>';
                $pages['image'] = $page_info['image'];
            }else{
                $pages = $page_info;
            }
        } else {
            $pages = Page::get(['id', 'title' , 'image']);
        }
        return api_response('success', '', $pages);
    }

    public function about()
    {
        $page_info = Page::whereType('about')->first();
        if(\Config::get('app.locale') == 'ar'){
            $page['id'] = $page_info['id'];
            $page['type'] = $page_info['type'];
            $page['title'] = $page_info['title'];
            $page['content'] = '<div style="text-align:right; dir:rtl;">' . $page_info['content'] . '</div>';
            $page['image'] = $page_info['image'];
        }else{
            $page = $page_info;
        }
        return api_response('success', '', $page);
    }

    public function privacy_policy()
    {
        $page_info = Page::whereType('policy')->first();
        if(\Config::get('app.locale') == 'ar'){
            $page['id'] = $page_info['id'];
            $page['type'] = $page_info['type'];
            $page['title'] = $page_info['title'];
            $page['content'] = '<div style="text-align:right; dir:rtl;">' . $page_info['content'] . '</div>';
            $page['image'] = $page_info['image'];
        }else{
            $page = $page_info;
        }
        return api_response('success', '', $page);
    }

    public function policy()
    {
        $page_info = Page::whereType('policy')->first();
        if(\Config::get('app.locale') == 'ar'){
            $page['id'] = $page_info['id'];
            $page['type'] = $page_info['type'];
            $page['title'] = $page_info['title'];
            $page['content'] = '<div style="text-align:right; dir:rtl;">' . $page_info['content'] . '</div>';
            $page['image'] = $page_info['image'];
        }else{
            $page = $page_info;
        }
        return api_response('success', '', $page);
    }

    public function terms()
    {
        $page_info = Page::whereType('terms')->first();
        if(\Config::get('app.locale') == 'ar'){
            $page['id'] = $page_info['id'];
            $page['type'] = $page_info['type'];
            $page['title'] = $page_info['title'];
            $page['content'] = '<div style="text-align:right; dir:rtl;">' . $page_info['content'] . '</div>';
            $page['image'] = $page_info['image'];
        }else{
            $page = $page_info;
        }
        return api_response('success', '', $page);
    }
}
