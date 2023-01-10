<?php

namespace App\Models;

use Carbon\Carbon;
use Carbon\CarbonInterval;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Magazine extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'summary',
        'pdf_path',
        'thumbnail_path',
        'view_count',
        'total_time_open',
    ];

    protected $appends = [
        'average_time',
        'uploaded_at',
    ];

    /**
     * Getter for average time read value.
     *
     * @return mixed
     */
    public function getAverageTimeAttribute()
    {
        $timeRead = ' - ';
        if ($this->view_count > 0) {
            $avg = $this->total_time_open / $this->view_count;
            $timeRead = CarbonInterval::seconds($avg)->cascade()->forHumans();
        }

        return $timeRead;
    }

    /**
     * Getter for uploaded_at value.
     *
     * @return mixed
     */
    public function getUploadedAtAttribute()
    {
        return Carbon::parse($this->created_at)->format('Y-m-d');
    }
}
