<?php

namespace App\Observers;

use App\Models\Tag;
use Illuminate\Support\Str;

class TagObserver
{
    /**
     * Handle the Tag "created" event.
     */
    public function created(Tag $tag): void
    {
        $tag->slug = Str::slug($tag->title);

    }

    /**
     * Handle the Tag "updated" event.
     */
    public function updated(Tag $tag): void
    {
        //
    }

    /**
     * Handle the Tag "deleted" event.
     */
    public function deleted(Tag $tag): void
    {
        //
    }

    /**
     * Handle the Tag "restored" event.
     */
    public function restored(Tag $tag): void
    {
        //
    }

    /**
     * Handle the Tag "force deleted" event.
     */
    public function forceDeleted(Tag $tag): void
    {
        //
    }
}
