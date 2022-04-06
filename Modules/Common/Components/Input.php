<?php

namespace Modules\Common\Components;

use Illuminate\View\Component;

class Input extends Component
{
    public $name;
    public $model;
    public $input;
    public $lang;
    public $value;
    public $required;
    public $mytitle;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($name, $model, $input, $lang)
    {
        $this->name = $name;
        $this->model = $model;
        $this->input = $input;
        $this->lang = $lang;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        // dd('sdds');
        if ($this->name == 'store_id' && auth('stores')->check()) return '';
        if ($this->name == 'images[]') {
            $component = 'images';
            $this->mytitle = __("Images");
        } else {
            if($this->name == 'map'){
                return view('Common::components.map');
            }

            $this->mytitle = app()->getLocale() == 'ar' ? $this->input['title'] : ucfirst(str_replace('[]', '', $this->name));

            $component = $this->input['type'] ?? 'input';
            if(in_array($component , ['file' , 'email' , 'text'])){
                $component = 'input';
            }
            $this->name == 'image[]' ? $component = 'image' : '';
            $this->required = (isset($this->input['empty'])) || ($this->model->id && in_array($component, ['image', 'password'])) ? '' : 'required';
            if (isset($this->input['setting'])) {
                $this->required = isset($this->input['required']) ? 'required' : '';
                $this->value = $this->model->where('key', $this->name)->first()->value->{$this->lang} ?? '';
                if (!isset($this->input['multiple'])) {
                    $this->name =  "{$this->name}[{$this->lang}]";
                } else {
                    $this->value = $this->model->where('key', str_replace("[]", "", $this->name))->first()->value ?? [];
                }
            } else {
                $name = str_replace("[]", "", $this->name);
                if (strpos($name, "[") !== false) {
                    $all = explode("[", $name);
                    $name = $all[0];
                    $object = str_replace("]", "", $all[1]);
                    $this->value = $this->model->$name["$object"] ?? $this->model->$name->$object ?? null;
                } else {
                    $this->value = $this->model->{$name} ?? '';
                }
                if ($this->lang != 'all') {
                    if (is_array($this->value)) {
                        $this->value = $this->value[$this->lang] ?? '';
                    } elseif (is_object($this->value)) {
                        $this->value = $this->value->{$this->lang} ?? '';
                    }
                    $this->name =  "{$this->name}[{$this->lang}]";
                }
            }
        }
        $this->mytitle = str_replace('_', ' ', ucfirst($this->mytitle));
        return view('Common::components.' . $component);
    }
}
