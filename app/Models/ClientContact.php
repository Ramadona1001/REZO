<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class ClientContact extends Model
{
    protected $guarded = [];
    protected $table = 'client_contacts';

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }
}
