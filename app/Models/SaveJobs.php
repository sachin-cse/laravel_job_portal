<?php

namespace App\Models;

use App\Models\JobApply;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SaveJobs extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $table='saved_jobs';

    protected $primaryKey = 'id';

    
    protected $fillable = [
        'user_id',
        'job_id',
        'job_name',
        'job_description',
        'flag'
    ];

    public function jobs(){
        return $this->hasOne(JobApply::class, 'id', 'job_id');
    }
}
