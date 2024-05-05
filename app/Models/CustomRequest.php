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

class CustomRequest extends Model
{
    protected $guarded = [];

    public static $project_status=[
        'in_progress' => 'In Progress',
        'on_hold' => 'On Hold',
        'complete' => 'Complete',
        'canceled' => 'Canceled'
    ];

    public static $status_color = [
        'on_hold' => 'warning',
        'in_progress' => 'info',
        'complete' => 'success',
        'canceled' => 'danger',
    ];

    public function unit()
    {
        return $this->belongsTo(Designation::class, 'designation_id');
    }

    public function custom_positions()
    {
        return $this->hasMany(CustomRequestPosition::class, 'custom_request_id');
    }

}
