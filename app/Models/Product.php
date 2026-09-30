<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

#[Fillable([
    'name',
    'slug',
    'label',
    'short_description',
    'description',
    'features',
    'image',
    'icon',
    'is_published',
    'display_order',
])]
class Product extends Model
{
    use HasFactory;

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true);
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('display_order')->orderBy('id');
    }

    /**
     * Feature bullet points, one per line.
     *
     * @return array<int, string>
     */
    public function featureList(): array
    {
        return collect(explode("\n", (string) $this->features))
            ->map(fn (string $line) => trim($line))
            ->filter()
            ->values()
            ->all();
    }

    public function imageUrl(): ?string
    {
        return $this->image ? Storage::disk('public')->url($this->image) : null;
    }

    /**
     * The public page that describes this product.
     */
    public function detailUrl(): string
    {
        return match ($this->slug) {
            'risk-assessment' => route('products.risk-assessment'),
            'ai-image-analysis' => route('products.image-analysis'),
            default => route('products'),
        };
    }

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
        ];
    }
}
