<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'name',
        'type',
        'color',
        'icon',
        'is_default',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_default' => 'boolean',
    ];

    /**
     * Get the user that owns the category.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the transactions for the category.
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    /**
     * Get the articles for the category.
     */
    public function articles()
    {
        return $this->hasMany(Article::class, 'category_id');
    }

    /**
     * Scope a query to only include categories of a given type.
     */
    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Scope a query to only include categories for a specific user.
     */
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Get the default categories for a new user.
     */
    public static function getDefaultCategories()
    {
        return [
            // Income categories
            [
                'name' => 'Sales',
                'type' => 'income',
                'color' => '#10B981', // Green
                'icon' => 'fa-shopping-cart',
                'is_default' => true,
            ],
            [
                'name' => 'Salary',
                'type' => 'income',
                'color' => '#3B82F6', // Blue
                'icon' => 'fa-money-bill-wave',
                'is_default' => true,
            ],
            [
                'name' => 'Investment',
                'type' => 'income',
                'color' => '#8B5CF6', // Purple
                'icon' => 'fa-chart-line',
                'is_default' => true,
            ],
            // Expense categories
            [
                'name' => 'Food & Beverages',
                'type' => 'expense',
                'color' => '#F59E0B', // Amber
                'icon' => 'fa-utensils',
                'is_default' => true,
            ],
            [
                'name' => 'Transportation',
                'type' => 'expense',
                'color' => '#EF4444', // Red
                'icon' => 'fa-car',
                'is_default' => true,
            ],
            [
                'name' => 'Utilities',
                'type' => 'expense',
                'color' => '#6366F1', // Indigo
                'icon' => 'fa-bolt',
                'is_default' => true,
            ],
            [
                'name' => 'Rent',
                'type' => 'expense',
                'color' => '#EC4899', // Pink
                'icon' => 'fa-home',
                'is_default' => true,
            ],
        ];
    }
}
