<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Spatie\Multitenancy\Models\Tenant as BaseModel;

class Tenant extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'domain',
        'database',
    ];

    /**
     * Get the user that owns the tenant.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected static function booted()
    {
        static::creating(function (Tenant $model) {
            $model->createDatabase();
        });
    }

    public function createDatabase()
    {
        $databaseName = $this->database;

        try {
            // Use landlord connection to create the tenant database
            DB::connection('landlord')->statement(
                "CREATE DATABASE IF NOT EXISTS `{$databaseName}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci"
            );
            Log::info("Database created successfully: {$databaseName}");
        } catch (\Exception $e) {
            Log::error("Failed to create database {$databaseName}: " . $e->getMessage());
        }
    }
}