<?php

namespace Modules\Common\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $table = 'app_settings';

    protected $fillable = ['key', 'value', 'image', 'type'];

    // protected $casts = ['value' => 'array'];
    protected $hidden = ['created_at', 'updated_at'];

    public function scopeContacts($query)
    {
        return $query->whereType('contacts');
    }

    public function scopeSocials($query)
    {
        return $query->whereIn('key', ['whatsapp', 'facebook', 'twitter', 'instagram']);
    }

    public function setValueAttribute($value)
    {
        if (is_array($value)) {
            foreach ($value as $lang => $val) {
                if (is_array($val)) {
                    dd($val , $value);
                    $rows[$lang] = json_encode($val);
                } elseif (is_uploaded_file($val)) {
                    $rows[$lang] = $val->store('uploads/settings');
                } else {
                    $rows[$lang] = $val;
                }
            }
            $value = json_encode($rows);
        } else {
            if (is_uploaded_file($value)) {
                $value = $value->store('uploads/settings');
            }
        }
        $this->attributes['value'] = $value;
    }

    public function getValueAttribute($value)
    {
        if (json_decode($value) && strpos(request()->url(), 'admin') === false) {
            $locale = app()->getLocale();
            //test commit 
            return json_decode($value)->$locale ?? json_decode($value)->all ?? $value;
        }
        return json_decode($value) ?? $value;
    }

    public function setImageAttribute($image)
    {
        $this->attributes['image'] = $image->store("uploads/settings");
    }

    public function getImageAttribute($image)
    {
        return $image ? url($image) : url('placeholders/icon.png');
    }
}
