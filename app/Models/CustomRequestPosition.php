<?php

namespace App\Models;

use App\Models\User;
use App\Models\Utility;
use App\Models\TaskFile;
use App\Models\Task;
use App\Models\TaskStage;
use Carbon\Carbon;
use App\Models\ProjectTask;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class CustomRequestPosition extends Model
{
    protected $guarded = [];
    protected $table = 'custom_request_positions';

    public function custom_request()
    {
        return $this->belongsTo(CustomRequest::class, 'custom_request_id');
    }
    
    public function position()
    {
        return $this->belongsTo(Position::class, 'position_id');
    }

}
