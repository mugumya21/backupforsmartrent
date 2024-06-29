<?php
/**
 * Created by PhpStorm.
 * User: eugene
 * Date: 05/04/2018
 * Time: 20:45
 */

namespace App\Services\Main;

use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use App\Models\Main\Document;
use App\Services\Main\iDocumentService;
use DB;
use Illuminate\Http\Request;

class DocumentService implements iDocumentService
{
    
    public function create(Request $request)
    {

    
            DB::commit();
        
       
    }

    public function get(int $id)
    {
       
    }

    public function list(int $id, int $filetype)
    {
        $documents = Document::where('external_key',$id)->where('document_type_id',$filetype);
        return $documents->latest()->orderBy('id', 'desc')->get();
    }


    public function gallery(int $id, int $filetype)
    {
        $images =   Document::where('external_key',  $id)->where('document_type_id',  $filetype)->where('extension','png')->orwhere('external_key',  $id)->where('document_type_id', $filetype)->where('extension','jpg')->orwhere('external_key',  $id)->where('document_type_id',  $filetype)->where('extension','jpeg')->orwhere('external_key',  $id)->where('document_type_id',  $filetype)->where('extension','webp');
  
        return $images->get();
    }

}
