<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class DitoNumber extends Model
{
    use HasFactory;

    protected $fillable = [
        'producer',
        'brand',
        'production_date',
        'dito_number',
        'is_not_interesting',
        'is_selection_completed',
    ];

    public function germanDismantlers()
    {
        return $this->belongsToMany(GermanDismantler::class)
            ->wherePivot('deleted_at', null);
    }

    public function carParts(): HasMany
    {
        return $this->hasMany(CarPart::class);
    }

    public function engineTypes(): HasManyThrough
    {
        return $this->hasManyThrough(EngineType::class, GermanDismantler::class,);
    }

    public function getFormattedDateAttribute()
    {
        // Get the original date value from the model
        $date = $this->attributes['production_date'];
        $dateToReturn = $date;


        // Check the format of the date and apply the necessary rules to
        // format it correctly
        if (preg_match('/^\d{2}-\w{3}$/', $date)) {
            // Date is in the format "05-dec"
            // Replace the month with the equivalent number and return the formatted date
            $dateToReturn = preg_replace('/^\d{2}-\w{3}$/', $this->monthToNumber($date), $date);
        } elseif (preg_match('/^\d{2}>$/', $date)) {
            // Date is in the format "08>"
            // Return the date as is
            $dateToReturn = $date;
        } elseif (preg_match('/^\d{4}-\d{4}$/', $date)) {
            // Date is in the format "2007-2017"
            // Return the formatted date with the last two digits of the years
            $dateToReturn = substr($date, 2, 2) . '-' . substr($date, -2);
        } elseif (preg_match('/^\d{4}-\d{5}$/', $date)) {
            // Date is in the format "2005-2013"
            // Return the formatted date with the last two digits of the years
            $dateToReturn = substr($date, 2, 2) . '-' . substr($date, -2);
        } elseif (preg_match('/^\w{3}-\d{2}$/', $date)) {
            // Date is in the format "sep-13"
            // Replace the month with the equivalent number and $dateToReturn = the formatted date
            $dateToReturn = $this->monthToNumber($date) . substr($date, -2, 0);
        } elseif ($date === '0') {
            // Date is zero
            // Return zero
            $dateToReturn = '';
        } else {
            // Date is in an unknown format
            // Return the date as is
            // $dateToReturn = 'unknown';
        }

        return $dateToReturn;

    }

    private function monthToNumber($date)
    {
        // Replace the month with the equivalent number
        $date = preg_replace('/jan/', '01', $date);
        $date = preg_replace('/feb/', '02', $date);
        $date = preg_replace('/mar/', '03', $date);
        $date = preg_replace('/apr/', '04', $date);
        $date = preg_replace('/maj/', '05', $date);
        $date = preg_replace('/jun/', '06', $date);
        $date = preg_replace('/jul/', '07', $date);
        $date = preg_replace('/aug/', '08', $date);
        $date = preg_replace('/sep/', '09', $date);
        $date = preg_replace('/okt/', '10', $date);
        $date = preg_replace('/nov/', '11', $date);
        $date = preg_replace('/dec/', '12', $date);

        return $date;
    }

    public function getNewNameAttribute()
    {
        return strtolower(str_replace(' ', '', "$this->product$this->brand$this->formatted_date"));
    }
}
