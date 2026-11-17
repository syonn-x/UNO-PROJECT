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
        Schema::table('users', function (Blueprint $table) {
            $table->string('store_name', 150)->nullable()->after('profile_photo');
            $table->text('store_description')->nullable()->after('store_name');
            $table->string('store_city', 100)->nullable()->after('store_description');
            $table->text('store_address')->nullable()->after('store_city');
            $table->string('nik', 20)->nullable()->after('store_address');
            $table->string('id_card_photo', 255)->nullable()->after('nik');
            $table->string('bank_name', 50)->nullable()->after('id_card_photo');
            $table->string('bank_account_number', 50)->nullable()->after('bank_name');
            $table->string('bank_account_holder', 100)->nullable()->after('bank_account_number');
            $table->boolean('is_verified_owner')->default(false)->after('bank_account_holder');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
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
            ]);
        });
    }
};
