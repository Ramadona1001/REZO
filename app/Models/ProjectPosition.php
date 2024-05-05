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

class ProjectPosition extends Model
{
    protected $guarded = [];
    protected $table = 'project_positions';

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }
    
    public function position()
    {
        return $this->belongsTo(Position::class, 'position_id');
    }

}
