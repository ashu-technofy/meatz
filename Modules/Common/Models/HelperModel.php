<?php

namespace Modules\Common\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Products\Models\Product;
use Modules\User\Models\Rate;
use Modules\User\Models\User;

class HelperModel extends Model
{

    protected $hidden = ['created_at', 'updated_at'];
    /**
     * Common relation for all models
     */

    public function scopeForStore($query)
    {
        return $query->where('store_id', auth('stores')->user()->id);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Common setter
     * @image
     * @name
     * @brief
     */

    public function scopeSeen($query)
    {
        return $query->where('seen', 1);
    }

    public function scopeNotseen($query)
    {
        return $query->where('seen', null);
    }

    public function scopeMain($query)
    {
        return $query->where('parent_id', null);
    }

    public function getNameAttribute($name)
    {
        if (json_decode($name) && strpos(request()->url(), 'admin') === false) {
            $locale = app()->getLocale();
            return json_decode($name)->$locale ?? $name ?? '#';
        }
        return json_decode($name);
    }

    public function getBriefAttribute($brief)
    {
        if ($brief) {
            if (json_decode($brief) && strpos(request()->url(), 'admin') === false) {
                $locale = app()->getLocale();
                return strip_tags(json_decode($brief)->$locale);
            }
            return json_decode($brief);
        } else {
            return mb_substr(strip_tags($this->content), 0, 80) . '...';
        }
    }

    public function getTitleAttribute($title)
    {
        if (json_decode($title) && strpos(request()->url(), 'admin') === false) {
            $locale = app()->getLocale();
            return json_decode($title)->$locale;
        }
        return json_decode($title);
    }

    public function getSlugAttribute($slug)
    {
        if ($slug) {
            return $slug;
        }

        if ($this->name) {
            if (is_object($this->name)) {
                return $this->id . '-' . str_replace(['/', ' '], '-', $this->name->{app()->getLocale()});
            } elseif (is_string($this->name)) {
                return $this->id . '-' . str_replace(['/', ' '], '-', $this->name);
            } elseif (is_array($this->name)) {
                return $this->id . '-' . str_replace(['/', ' '], '-', $this->name[app()->getLocale()]);
            }
        } elseif ($this->title) {
            if (is_object($this->title)) {
                return $this->id . '-' . str_replace(['/', ' '], '-', $this->title->{app()->getLocale()});
            } elseif (is_string($this->title)) {
                return $this->id . '-' . str_replace(['/', ' '], '-', $this->title);
            } elseif (is_array($this->title)) {
                return $this->id . '-' . str_replace(['/', ' '], '-', $this->title[app()->getLocale()]);
            }
        }
    }

    public function getLinkAttribute($link)
    {
        if ($link) {
            return $link;
        }

        return route($this->table . '.show', $this->slug);
    }

    public function getContentAttribute($content)
    {
        if (json_decode($content) && strpos(request()->url(), 'admin') === false) {
            $locale = app()->getLocale();
            return "<meta name='viewport' content='initial-scale=1.0' />" . json_decode($content)->$locale;
            // return strip_tags(str_replace(["&nbsp;", "\r\n\r\nsss"], [" ", ""], json_decode($content)->$locale));
        }
        return json_decode($content) ?? '';
    }

    public function setImageAttribute($image)
    {
        if (is_uploaded_file($image)) {
            $this->attributes['image'] = $image->store("uploads/" . $this->table);
        }
    }

    public function getImageAttribute($image)
    {
        if((!$image) && $this->images()->first()){
            return url($this->images()->first()->image);
        }
        return $image ? url($image) : url('placeholders/' . $this->table . '.png');
    }

    public function setBannerAttribute($banner)
    {
        $this->attributes['banner'] = $banner->store("uploads/" . $this->table);
    }

    public function getBannerAttribute($banner)
    {
        return $banner ? url($banner) : url('placeholders/banner.png');
    }

    public function rates()
    {
        return $this->morphMany(Rate::class, 'rated')->select('id', 'user_id', 'rate');
    }

    public function getRateAttribute()
    {
        // return 0;
        if ($count = $this->rates()->count()) {
            return round(($this->rates()->sum('rate') / (5 * $count)) * 5, 1);
        }
        return 0;
    }

    public function notifications()
    {
        return $this->morphMany(Notification::class, 'notified');
    }

    public function getCreatedAtAttribute($created_at)
    {
        return date('Y-m-d', strtotime($created_at));
    }

    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }
}
