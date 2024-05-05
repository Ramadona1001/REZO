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

class ProjectService extends Model
{
    protected $guarded = [];

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }
    
    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }

}
