<?php

namespace App\Models\Main;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Helpers\FrontEndHelper;
use Carbon\Carbon;
use App\Models\Main\DocumentType;
use App\Models\Main\Document;
use Storage;

class Document extends Model
{
    use HasFactory;


    public function filename()
    {
    $document =    Document::where('id', $this->id)->first();   
    $disc = env('APP_DISC', 'local');
    $file = Storage::disk($disc)->url($document->name_on_file);
    return $file;
    }


    public function icon()
    {
       if($this->extension == 'pdf'){
        return 'assets/img/file_icons/pdf.svg';
       } else  if($this->extension == 'xls' || $this->extension == 'xlsx'){
        return 'assets/img/file_icons/xls.svg';
       } else  if($this->extension == 'doc' || $this->extension == 'docx'){
        return 'assets/img/file_icons/doc.svg';
       } else  if($this->extension == 'csv'){
        return 'assets/img/file_icons/csv.svg';
       }  if($this->extension == 'png'){
        return 'assets/img/file_icons/png.svg';
       } if($this->extension == 'jpg'){
        return 'assets/img/file_icons/jpg.svg';
       } else {
        return 'assets/img/file_icons/file.svg';
       } 
             
    }
}
