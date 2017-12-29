<?php

namespace App\Listeners;

use App\Events\CategorySaving as EventCategorySaving;

class CategorySaving
{
    public function handle(EventCategorySaving $event)
    {
        $event->model->slug = str_slug($event->model->name, '-');
    }
}