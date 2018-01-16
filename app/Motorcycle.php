<?php
namespace App;

use App\Events\MotorcycleSaved;
use Illuminate\Database\Eloquent\Model;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia\Interfaces\HasMediaConversions;
use Spatie\MediaLibrary\Media;

class Motorcycle extends Model implements HasMediaConversions
{
    use HasMediaTrait;

    protected $fillable = [
        'title', 'description', 'phone_number', 'sold', 'user_id'
    ];

    public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('thumb')
            ->crop(Manipulations::CROP_CENTER, 400, 400)
            ->nonQueued();
    }

    public static function boot()
    {
        static::saved(function ($model) {
            event(new MotorcycleSaved($model));
        });

        parent::boot();
    }
}
