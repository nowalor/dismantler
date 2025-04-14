<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Storage;

use Parsedown;

class Blog extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'content', 'published_at', 'image', 'language'];
    protected $casts = [
        'published_at' => 'datetime',
    ];

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);

    }

    public function syncTags(?string $tagNames): void
    {
        if (is_null($tagNames) || trim($tagNames) === '') {
            $this->tags()->detach();
            return;
        }

        $tagNamesArray = array_filter(array_map('trim', explode(',', $tagNames)));
        $tagIds = [];

        foreach ($tagNamesArray as $name) {
            if (!$name) {
                continue;
            }
            $tag = Tag::firstOrCreate(['name' => $name]);
            $tagIds[] = $tag->id;
        }

        $this->tags()->sync($tagIds);
    }

    public function getParsedContentAttribute(): string
    {
        $parsedown = new Parsedown();
        $parsedown->setSafeMode(true);

        $content = $parsedown->text($this->content);

        // Make links open in new tabs
        return str_replace('<a ', '<a target="_blank" rel="noopener noreferrer" ', $content);
    }

    public function getFormattedPublishedAtAttribute()
    {
        return $this->published_at ? $this->published_at->format('Y-m-d') : null;
    }
}
