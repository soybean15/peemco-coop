<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\InteractsWithMedia;

class GeneralSetting extends Model implements HasMedia
{
    //
    use InteractsWithMedia;

    protected $fillable =[
        'address',
        'company_name'
    ];


    public function registerMediaConversions(?Media $media = null): void
    {
        $this
            ->addMediaConversion('preview')
            ->fit(Fit::Contain, 300, 300)
            ->nonQueued();
    }


    public function logo(): Attribute
    {
        return Attribute::make(
            get: function () {

                $media = $this->getMedia('logo');


                if ($media->last()) {
                    return $media->last()->getUrl();
                }

                return null;
            }
        );
    }
}
