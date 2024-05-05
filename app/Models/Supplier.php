<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $guarded = [];
    protected $table = 'suppliers';

    public function contacts()
    {
        return $this->hasMany(SupplierContact::class, 'supplier_id');
    }
    
    public function projects()
    {
        return $this->hasMany(SupplierProject::class, 'supplier_id');
    }
}
