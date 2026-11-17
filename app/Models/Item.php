<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'owner_id',
        'category_id',
        'name',
        'description',
        'price_per_day',
        'condition',
        'location',
        'status',
    ];

    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        static::deleting(function (Item $item) {
            $item->images()->delete();
            $item->availability()->delete();
            $item->favorites()->delete();
            $item->reviews()->delete();

            foreach ($item->bookings as $booking) {
                $booking->review()?->delete();
                $booking->delete();
            }
        });
    }

    protected function casts(): array
    {
        return [
            'price_per_day' => 'decimal:2',
        ];
    }

    /**
     * Item owner.
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    /**
     * Category of the item.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Gallery images.
     */
    public function images(): HasMany
    {
        return $this->hasMany(ItemImage::class);
    }

    /**
     * Primary first image.
     */
    public function primaryImage(): HasOne
    {
        return $this->hasOne(ItemImage::class)->oldestOfMany();
    }

    /**
     * Availability schedules.
     */
    public function availability(): HasMany
    {
        return $this->hasMany(Availability::class);
    }

    /**
     * Bookings made on this item.
     */
    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * Reviews given to this item.
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Users who favorited this item.
     */
    public function favorites(): HasMany
    {
        return $this->hasMany(Favorite::class);
    }

    /**
     * Calculate average rating.
     */
    public function getAvgRatingAttribute(): float
    {
        return (float) ($this->reviews()->avg('rating') ?? 5.0);
    }

    /**
     * Helper for display image.
     */
    public function getImageUrlAttribute(): string
    {
        $img = $this->images->first();

        return $img ? $img->image_url : 'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?w=600&auto=format&fit=crop&q=80';
    }
}
