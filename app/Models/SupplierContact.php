<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class SupplierContact extends Model
{
    protected $guarded = [];
    protected $table = 'supplier_contacts';

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }
}
