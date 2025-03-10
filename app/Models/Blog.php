<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Parsedown;

class Blog extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'content', 'published_at', 'image'];
    protected $dates = ['published_at'];

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'blog_tag');
    }

    public function syncTags($tagNames)
    {
        if (is_null($tagNames) || trim($tagNames) === '') {
            $this->tags()->detach();
            return;
        }

        $tagNamesArray = array_filter(array_map('trim', explode(',', $tagNames)));
        $tagIds = [];

        foreach ($tagNamesArray as $name) {
            if (!$name)
                continue;
            $tag = Tag::firstOrCreate(['name' => $name]);
            $tagIds[] = $tag->id;
        }

        $this->tags()->sync($tagIds);
    }

    public function getParsedContentAttribute()
    {
        $parsedown = new Parsedown();
        $parsedown->setSafeMode(true);
        $content = $parsedown->text($this->content);
        // Modify links to open in new tab
        return str_replace('<a ', '<a target="_blank" rel="noopener noreferrer" ', $content);
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($blog) {
            // When a blog is deleted, also remove its image from Spaces
            if ($blog->image) {
                // Use the same CDN endpoint used when building the image URL:
                $cdnBase = rtrim(env('DO_CDN_ENDPOINT'), '/') . '/';
                $relativePath = str_replace($cdnBase, '', $blog->image);
                Storage::disk('do')->delete($relativePath);

            }

        });
    }
}
