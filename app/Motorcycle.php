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

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'description', 'phone_number', 'sold', 'user_id'
    ];

    /**
     * Register a new media conversion to generate thumbnail.
     *
     * @param Media|null $media
     */
    public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('thumb')
            ->crop(Manipulations::CROP_CENTER, 400, 400)
            ->nonQueued();
    }

    /**
     * User owns this motorcycle.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Motorcycle boot.
     */
    public static function boot()
    {
        static::saved(function ($model) {
            event(new MotorcycleSaved($model));
        });

        parent::boot();
    }
}
