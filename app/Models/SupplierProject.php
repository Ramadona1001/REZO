<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class SupplierProject extends Model
{
    protected $guarded = [];
    protected $table = 'supplier_projects';

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }
}
