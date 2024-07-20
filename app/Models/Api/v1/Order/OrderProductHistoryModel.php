<?php

namespace App\Models\Api\v1\Order;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderProductHistoryModel extends Model
{
    use HasFactory;

    protected $table = 'order_product_history';
    protected $guarded = [];

    protected $primaryKey = null;
    public $incrementing = false;

    public function setImageAttribute($value)
    {
        $path = parse_url($value, PHP_URL_PATH);
        $pathWithoutSlash = substr($path, 1);
        $this->attributes['image'] = $pathWithoutSlash;
    }

    public function setCategoryAttribute($value)
    {
        $this->attributes['category'] = json_encode($value);
    }

    public function getImageAttribute($value)
    {
        return !is_null($value) ? url('') . "/$value" : null;
    }
}
