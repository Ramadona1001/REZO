<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $guarded = [];
    protected $table = 'clients';

    public function contacts()
    {
        return $this->hasMany(ClientContact::class, 'client_id');
    }
    
    public function projects()
    {
        return $this->hasMany(Project::class, 'client_id');
    }
}
