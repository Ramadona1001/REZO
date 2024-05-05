<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class FreelancerProject extends Model
{
    protected $guarded = [];
    protected $table = 'freelancer_projects';

    public function freelancer()
    {
        return $this->belongsTo(Freelancer::class, 'freelancer_id');
    }
}
