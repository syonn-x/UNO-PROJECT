<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 2. Categories
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->unique();
            $table->text('description')->nullable();
            $table->timestamps();
        });

        // 3. Rental Items
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('owner_id')->constrained('users')->onUpdate('cascade')->onDelete('restrict');
            $table->foreignId('category_id')->constrained('categories')->onUpdate('cascade')->onDelete('restrict');
            $table->string('name', 150);
            $table->text('description');
            $table->decimal('price_per_day', 12, 2);
            $table->enum('condition', ['new', 'like_new', 'good', 'fair'])->default('good');
            $table->string('location', 255);
            $table->enum('status', ['available', 'unavailable', 'hidden'])->default('available');
            $table->timestamps();

            $table->index('owner_id');
            $table->index('category_id');
            $table->index('status');
        });

        // 4. Multiple Item Photos
        Schema::create('item_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_id')->constrained('items')->onUpdate('cascade')->onDelete('cascade');
            $table->string('image_url', 255);
            $table->timestamps();

            $table->index('item_id');
        });

        // 5. Availability Calendar
        Schema::create('availability', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_id')->constrained('items')->onUpdate('cascade')->onDelete('cascade');
            $table->date('start_date');
            $table->date('end_date');
            $table->enum('status', ['available', 'booked', 'blocked'])->default('available');
            $table->timestamps();

            $table->index(['item_id', 'start_date', 'end_date']);
        });

        // 6. Rental Bookings
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_id')->constrained('items')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('renter_id')->constrained('users')->onUpdate('cascade')->onDelete('restrict');
            $table->date('start_date');
            $table->date('end_date');
            $table->unsignedInteger('total_days');
            $table->decimal('total_price', 12, 2);
            $table->enum('status', ['pending', 'confirmed', 'completed', 'cancelled'])->default('pending');
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index('item_id');
            $table->index('renter_id');
            $table->index('status');
            $table->index(['start_date', 'end_date']);
        });

        // 7. Reviews
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->unique()->constrained('bookings')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('item_id')->constrained('items')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedTinyInteger('rating');
            $table->text('comment')->nullable();
            $table->timestamps();

            $table->index('item_id');
            $table->index('user_id');
        });

        // 8. Favorites
        Schema::create('favorites', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('item_id')->constrained('items')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();

            $table->unique(['user_id', 'item_id']);
            $table->index('item_id');
        });

        // 9. Notifications
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onUpdate('cascade')->onDelete('cascade');
            $table->string('title', 150);
            $table->text('message');
            $table->string('type', 50)->default('general');
            $table->boolean('is_read')->default(false);
            $table->timestamps();

            $table->index(['user_id', 'is_read']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
        Schema::dropIfExists('favorites');
        Schema::dropIfExists('reviews');
        Schema::dropIfExists('bookings');
        Schema::dropIfExists('availability');
        Schema::dropIfExists('item_images');
        Schema::dropIfExists('items');
        Schema::dropIfExists('categories');
    }
};
