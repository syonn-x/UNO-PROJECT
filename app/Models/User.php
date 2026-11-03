<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'profile_photo',
        'store_name',
        'store_description',
        'store_city',
        'store_address',
        'nik',
        'id_card_photo',
        'bank_name',
        'bank_account_number',
        'bank_account_holder',
        'is_verified_owner',
        'role',
        'status',
        'email_verified_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_verified_owner' => 'boolean',
        ];
    }

    /**
     * Check if user has admin role.
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user has owner role.
     */
    public function isOwner(): bool
    {
        return $this->role === 'owner';
    }

    /**
     * Check if user has renter role.
     */
    public function isRenter(): bool
    {
        return $this->role === 'renter' || $this->role === 'user';
    }

    /**
     * Get human-readable role label.
     */
    public function getRoleLabelAttribute(): string
    {
        return match ($this->role) {
            'admin' => 'Administrator',
            'owner' => 'Mitra Rental (Owner)',
            'renter' => 'Penyewa (Renter)',
            default => 'Pengguna',
        };
    }

    /**
     * Check if user is recognized as owner.
     */
    public function getIsOwnerAttribute(): bool
    {
        return $this->role === 'owner' || (bool) $this->is_verified_owner;
    }

    /**
     * Get owner verification status.
     */
    public function getOwnerStatusAttribute(): string
    {
        if ($this->is_verified_owner || $this->role === 'owner') {
            return 'approved';
        }

        if (! empty($this->id_card_photo)) {
            return 'pending';
        }

        return 'unregistered';
    }

    /**
     * Accessor for owner store name.
     */
    public function getOwnerStoreNameAttribute(): ?string
    {
        return $this->store_name ?: ($this->name.' Rental');
    }

    /**
     * Accessor for owner address.
     */
    public function getOwnerAddressAttribute(): ?string
    {
        return $this->store_address;
    }

    /**
     * Get user avatar URL safely, supporting local uploaded storage, remote URLs, and UI Avatars fallback.
     */
    public function getAvatarUrlAttribute(): string
    {
        if (! empty($this->profile_photo)) {
            if (str_starts_with($this->profile_photo, 'http://') || str_starts_with($this->profile_photo, 'https://')) {
                return $this->profile_photo;
            }

            return asset('storage/'.ltrim($this->profile_photo, '/'));
        }

        return 'https://ui-avatars.com/api/?name='.urlencode($this->name).'&background=0284c7&color=fff&bold=true';
    }

    /**
     * Get KTP photo URL safely supporting storage, public uploads, and external URLs.
     */
    public function getIdCardPhotoUrlAttribute(): ?string
    {
        if (empty($this->id_card_photo)) {
            return null;
        }

        if (str_starts_with($this->id_card_photo, 'http://') || str_starts_with($this->id_card_photo, 'https://')) {
            return $this->id_card_photo;
        }

        if (str_starts_with($this->id_card_photo, 'storage/')) {
            return asset($this->id_card_photo);
        }

        return asset('storage/'.ltrim($this->id_card_photo, '/'));
    }

    /**
     * Check if user account is active.
     */
    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    /**
     * Items owned by this user.
     */
    public function items(): HasMany
    {
        return $this->hasMany(Item::class, 'owner_id');
    }

    /**
     * Bookings made by this user (as renter).
     */
    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class, 'renter_id');
    }

    /**
     * Reviews given by this user.
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class, 'user_id');
    }

    /**
     * Favorites saved by this user.
     */
    public function favorites(): HasMany
    {
        return $this->hasMany(Favorite::class, 'user_id');
    }

    /**
     * Notifications received by this user.
     */
    public function userNotifications(): HasMany
    {
        return $this->hasMany(Notification::class, 'user_id');
    }
}
