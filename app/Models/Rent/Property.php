<?php

namespace App\Models\Rent;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Models\Main\DocumentType;
use App\Models\Main\Document;
use Storage;
use Illuminate\Support\Facades\Auth;

class Property extends Model
{
    use HasFactory;
 public function canedit()
    {
        if(Auth::user()->hasDirectPermission('edit_property')){
            return true;
        }
        else{
            return false;
        }
    }
    public function candelete()
    {
        if(Auth::user()->hasDirectPermission('delete_property')){
            return true;
        }
        else{
            return false;
        }
    }

    public function createdDate()
    {
        return $this->created_at->format('d/m/Y');
    }

    public function totalunits()
    {
        return $this->units->count();
    }


    public function monthlycollections()
    {
        $start = Carbon::now()->startOfMonth();
        $end = Carbon::now()->endOfMonth();
        $total = $this->tenantunits()->whereBetween('from_date', [$start, $end])->sum('converted_discount_amount');

        return $total;
    }
      public function monthlycollectionsDisp()
    {
        return number_format($this->monthlycollections(), 0);
    }

    public function unpaidrent()
    {

        $total = $this->tenantunits->reduce(function ($carry, $item) {

                return $carry + $item->arrearsbalance();

        });

        return $total;
    }


    public function totalexpenses()
    {
        $total = $this->expenses->reduce(function ($carry, $item) {
                return $carry + $item->converted_amount;
        });
        return $total;
    }


    public function unpaidrentDisp()
    {
        return number_format($this->unpaidrent(), 0);
    }

    public function totalexpensesDisp()
    {
        return number_format($this->totalexpenses(), 0);
    }



    public function occupiedunitspercentage()
    {
    return ($this->occupiedunits()->count() / 100) * $this->totalunits();
    }

    public function occupiedunits()
    {
        return $this->units->where('is_available','=', 0);
    }

    public function availableunitspercentage()
    {
    return ($this->availableunits()->count() / 100) * $this->totalunits();
    }

    public function availableunits()
    {
        return $this->units->where('is_available','=', 1);
    }

    public function documenttype()
    {
      $type =   DocumentType::where('code','PTD')->first();
      return $type;
    }


    public function documents()
    {
      $documents =   Document::where('external_key', $this->id)->where('document_type_id', $this->documenttype()->id)->first();
      return $documents;
    }

    public function featuredImage()
    {

    $document =   Document::where('external_key', $this->id)->where('is_featured', 1)->first();
    return $document;

    }

    public function gallery()
    {
      $images =   Document::where('external_key', $this->id);
      $images =  $images->where('extension', 'png')->orwhere('extension', 'jpg')->orwhere('extension', 'webp')->get();

      return $images;
    }



    public function projectedtenatunitstotal(string $period, $months, $years)
    {

        $total = $this->tenantunits->reduce(function ($carry, $item) use($period,$months,$years) {
            return $carry + $item->tenantunitsprojectionstotal($period,$months,$years);

    });

    return $total;

    }


    public function propertyType()
    {
        return $this->belongsTo(PropertyType::class);
    }

    public function category()
    {
        return $this->belongsTo(PropertyCategory::class,'property_category_id');
    }

    public function expenses()
    {
        return $this->hasMany(Expense::class,'property_id');
    }

    public function tenantunits()
    {
        return $this->hasMany(TenantUnit::class,'property_id');
    }

    public function units()
    {
        return $this->hasMany(Unit::class);
    }

}