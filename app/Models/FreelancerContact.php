<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class FreelancerContact extends Model
{
    protected $guarded = [];
    protected $table = 'freelancer_contacts';

    public function freelancer()
    {
        return $this->belongsTo(Freelancer::class, 'freelancer_id');
    }
}
