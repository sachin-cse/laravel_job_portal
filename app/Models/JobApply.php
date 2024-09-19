<?php

namespace App\Models;

use App\Models\SaveJobs;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JobApply extends Model
{
    use HasFactory;

    protected $table='jobs';

    protected $primaryKey = 'id';


    protected $fillable = [
        'user_id',
        'job_title',
        'job_short_description',
        'job_description',
        'job_location',
        'job_mode',
        'job_type',
        'job_package',
        'job_notice_period',
        'job_technologies',
        'job_status',
        'job_experience',
        'job_start_time',
        'job_end_time'
    ];

    public function savedJobs(){
        return $this->belongsTo(SaveJobs::class,'job_id', 'id');
    }
}
