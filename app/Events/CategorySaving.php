<?php
namespace App\Events;
use Illuminate\ {
Queue\SerializesModels,
Database\Eloquent\Model
};
class CategorySaving
{
    use SerializesModels;
    public $model;
    public function __construct(Model $model)
    {
        $this->model = $model;
    }
}