<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use \Carbon\Carbon;

class Staff extends Model
{
    use HasFactory;

    /**
     * Relationship inverse of Department
     *
     * @return BelongsTo
     */
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    /**
     * years_employed attribute
     *
     * @return string
     */
    public function getYearsEmployedAttribute(): string
    {
        $employmentPeriod = Carbon::parse($this->hire_date)->diffInYears(Carbon::now());

        return $employmentPeriod . " year(s)";
    }
}
