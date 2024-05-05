<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Freelancer extends Model
{
    protected $guarded = [];
    protected $table = 'freelancers';

    public function contacts()
    {
        return $this->hasMany(FreelancerContact::class, 'freelancer_id');
    }
    
    public function projects()
    {
        return $this->hasMany(FreelancerProject::class, 'freelancer_id');
    }
}
