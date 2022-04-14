<?php

namespace Modules\Common\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HelperController extends Controller
{
    protected $model;
    protected $name;
    protected $myname;
    protected $list;
    protected $inputs;
    protected $lang_inputs;
    protected $method;
    protected $action;
    protected $can_delete = true;
    protected $paginate = true;
    protected $can_add = true;
    protected $queries = [];
    protected $more_actions = [];

    protected function form_builder()
    {}

    protected function list_builder()
    {}

    protected function index()
    {
        $this->list_builder();
        if (!isset($this->rows)) {
            $this->rows = $this->model;
        }
        if (auth('stores')->check()) {
            $this->rows = $this->rows->forStore();
        }
        $queries = request()->query();

        $fillables = $this->model->getFillable();
        foreach (request()->query() as $key => $value) {

            if (in_array($key, $fillables)) {
                $this->rows = $this->rows->when(request()->has($key), function ($query) use ($key, $value) {
                    return $query->where($key, $value);
                });
            }
        }
        if ($word = request('keyword')) {
            $keys = $this->model->getFillable();
            $this->rows = $this->rows->where(function ($query) use($word , $keys) {
                $endcoded_word = str_replace('"', "", json_encode($word));
                $endcoded_word = addslashes($endcoded_word);
                $query->where('id', $word);
                foreach ($keys as $index => $key) {
                    $query->orWhere(function ($query) use ($key, $word, $endcoded_word) {
                        return $query->where($key, 'like', '%' . $word . '%')->orWhere($key, 'like', '%' . $endcoded_word . '%');
                    });
                }
                $searchable_relations = $this->model->searchable_relations ?? [];
                // dd($searchable_relations);
                foreach ($searchable_relations as $relation) {
                    $query->orWhereHas($relation, function ($query) use ($word) {
                        return $query->search($word);
                    });
                }
            });
        }
        $this->rows = $this->rows->latest()->paginate(25);

        session()->put('current_title', $this->title);
        return view('Common::admin.list', get_object_vars($this));
    }

    public function create()
    {

        if($this->name == 'subcategories'){
           if(count($this->inputs)){
            foreach($this->inputs as $key => $value){
               
                if(isset($value['type']) && ($value['type'] == "select")){
                  foreach($this->inputs[$key]['values'] as $values_key => $values_def){
                  
                      $this->inputs[$key]['values'][$values_key] = $values_def->{session()->get('current_locale')};
                  }
                }
             }
           }
        }

        $this->form_builder();
        if (auth('stores')->check() && $this->name == 'stores') {
            abort('404');
        }
        $this->method = 'post';
        if(auth('stores')->check() && $this->name == 'copons'){
        $this->action = route($this->name . ".store");
        }else{
        $this->action = route("admin." . $this->name . ".store");
        }
       
        return view('Common::admin.form', get_object_vars($this));
    }

    protected function store(Request $request)
    {
        $data = request()->all();
        if (!auth()->check()) {
            $data['store_id'] = auth('stores')->user()->id ?? null;
        }
        // dd($data);
        $model = $this->model->create($data);
        if ($images = request('images')) {
            foreach ($images as $image) {
                $model->images()->create(['image' => $image]);
            }
        }
        foreach ($this->more_actions as $action) {
            $this->{$action}($model);
        }
        return response()->json(['url' => route('admin.' . $this->name . '.index', $this->queries), 'message' => __("Info saved successfully")]);
    }

    protected function edit($id)
    {
        $this->form_builder();
        if (auth('stores')->check()) {
            $this->model = $this->model->forStore();
        }
        $this->model = $this->model->findOrFail($id);
        $this->method = 'put';
        if(auth('stores')->check() && $this->name == 'copons'){
         $this->action = route( $this->name . ".update", $id);
        }else{
        $this->action = route("admin." . $this->name . ".update", $id);
        }
        return view('Common::admin.form', get_object_vars($this) ,['id'=>$id]);
    }

    protected function update(Request $request, $id)
    {
        if (auth('stores')->check()) {
            $this->model = $this->model->forStore();
        }
        $data = request()->all();
        if (!auth()->check()) {
            $data['store_id'] = auth('stores')->user()->id ?? null;
        }

        $this->model = $this->model->findOrFail($id);
        $this->model->update($data);
        if ($images = request('images')) {
            foreach ($images as $image) {
                $this->model->images()->create(['image' => $image]);
            }
        }
        foreach ($this->more_actions as $action) {
            $this->{$action}($this->model);
        }
        if(auth('stores')->check() && $this->name == 'copons'){
        return response()->json(['url' => route( $this->name . '.index', $this->queries), 'message' => __("Info saved successfully")]);
         
        }else{
        return response()->json(['url' => route('admin.' . $this->name . '.index', $this->queries), 'message' => __("Info saved successfully")]);
        }
    }

    public function destroy($id)
    {
        if (auth('stores')->check()) {
            $this->model = $this->model->forStore();
        }

        $this->model->findOrFail($id)->delete();
        $this->queries = array_merge($this->queries , request()->except(['_token' , '_method']));
        if(auth('stores')->check() && $this->name == 'copons'){
           return response()->json(['url' => route($this->name . '.index', $this->queries), 'message' => __("Deleted successfully")]);
        }else{
          return response()->json(['url' => route('admin.' . $this->name . '.index', $this->queries), 'message' => __("Deleted successfully")]);
        }
    }
}
