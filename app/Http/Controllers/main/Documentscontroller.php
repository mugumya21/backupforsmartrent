<?php

namespace App\Http\Controllers\main;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Main\iDocumentService;
use App\Models\Main\Document;
use App\Models\Main\DocumentType;
use App\Models\Main\DocumentStatus;
use DB;
use Auth;
use Illuminate\Support\Facades\Storage;
use App\Helpers\FrontEndHelper;
use Response;
use App\Models\Rent\Payment;
use App\Models\Rent\Property;
use App\Models\Rent\TenantUnit;
use Illuminate\Support\Facades\Route;


class Documentscontroller extends Controller
{
    /**
     * Display a listing of the resource.
     */

     protected $documentService;

     public function __construct(iDocumentService $documentService)
     {
         $this->documentService = $documentService;

     }


    public function index(int $id, int $filetype)
    {
        $documents = $this->documentService->list($id, $filetype);
        if(Route::current()->middleware()[0]=="api"){

            $documentDetails = [];
    foreach($documents as $document){
        $app_url = url('/');
        $featuredocumentTempKey = $document->temp_key ?? null;
        if ($featuredocumentTempKey !== null) {
           $app_url = ''.$app_url.'/uploads/documents/'.$document->temp_key;
       } else {
            $app_url = '';
        }
        $documentDetails[] = [
            'id' => $document->id,
            'name' => $document->name,
            'extension' => $document->extension,
            'name_on_file' => $document->name_on_file,
            'temp_key' => $document->temp_key,
            'external_key' => $document->external_key,
            'mime_type' => $document->mime_type,
            'size' => $document->size,
            'is_featured' => $document->is_featured,
            'description' => $document->description,
            'document_type_id' => $document->document_type_id,
            'document_status_id' => $document->document_status_id,
            'created_by' => $document->created_by,
            'updated_by' => $document->updated_by,
            'created_at' => $document->created_at,
            'updated_at' => $document->updated_at,
            'app_url' => $app_url,
        ];
  }

            return response()->json(
              $documentDetails );
        }
        return view('documents.documents-table', ['documents' => $documents,'id'=>$id]);
    }


    public function gallery(int $id, int $filetype)
    {
        $images = $this->documentService->gallery($id, $filetype);
        $property = Property::findorfail($id);

        return view('rent.properties.gallery', ['images' => $images,'id'=>$id, 'filetype'=>$filetype,'property'=>$property]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(int $id, int $filetype)
    {
        $document = new Document();
        $filetype = $filetype;
        $docid = $id;
        if(Route::current()->middleware()[0]=="api"){

            return response()->json([
                'filetype' => $filetype,
                'docid' => $docid,

            ]);
        }
        return view('documents.create', ['document' => $document,'filetype'=>$filetype,'docid'=>$id]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

       $documentStatus =  DocumentStatus::where('code','SAVED')->first();
       $documentType = DocumentType::where('id',  $request->filetype)->firstOrFail();
       $id = $request->docid;


        if($request->hasFile('file')){


    foreach($request->file('file') as $file ){


        $extention = $file->getClientOriginalExtension();
        $fileName = time().'-'.rand(0,99).'.'.$extention;
        // $file->move($uploadPath, $filename);

        $uploadPath = 'uploads/documents/';

        $disc = env('APP_DISC','spaces');
        $folderPrefix = config('app.DO_FOLDER_NAME');

        // $finalImageName = $uploadPath.$filename;
        $document = new Document();
        $document->extension = $extention;
        $document->name = $file->getClientOriginalName();

        if ($documentType->code == 'PTD') {
            $file->storeAs("{$folderPrefix}/property/{$id}", $fileName, $disc);
            $document->name_on_file = "{$folderPrefix}/property/{$id}/{$fileName}";
            if($extention == 'jpeg' || $extention == 'png' || $extention == 'jpg' || $extention == 'webp')
            {
            $file->move($uploadPath, $fileName);
            }


        } else if ($documentType->code == 'TND') {
            $file->storeAs("{$folderPrefix}/tenant/{$id}", $fileName, $disc);
            $document->name_on_file = "{$folderPrefix}/tenant/{$id}/{$fileName}";
            if($extention == 'jpeg' || $extention == 'png' || $extention == 'jpg' || $extention == 'webp')
            {
            $file->move($uploadPath, $fileName);
            }

        } else if ($documentType->code == 'UND') {
            $file->storeAs("{$folderPrefix}/property/{$property_id}/unit/{$id}", $fileName, $disc);
            $document->name_on_file = "{$folderPrefix}/property/{$property_id}/unit/{$id}/{$fileName}";
            if($extention == 'jpeg' || $extention == 'png' || $extention == 'jpg' || $extention == 'webp')
            {
            $file->move($uploadPath, $fileName);
            }

        }else if ($documentType->code == 'TUND') {
            $tenantunit = TenantUnit::findorfail($id);
            $property_id = $tenantunit->property_id;
            $file->storeAs("{$folderPrefix}/property/{$property_id}/{unit}/{$id}/{tenantunit}/{$id}", $fileName, $disc);
            $document->name_on_file = "{$folderPrefix}/property/{$property_id}/unit/{$tenantunit->unit_id}/tenantunit/{$id}/{$fileName}";

            if($extention == 'jpeg' || $extention == 'png' || $extention == 'jpg' || $extention == 'webp')
            {
            $file->move($uploadPath, $fileName);
            }

        }

         if ($documentType->code == 'PAYMENTS') {
            $payment = Payment::findorfail($id);
            $property_id = $payment->property_id;
            $file->storeAs("{$folderPrefix}/property/{$property_id}/payments", $fileName, $disc);
            $document->name_on_file = "{$folderPrefix}/property/{$property_id}/payments/{$fileName}";

            if($extention == 'jpeg' || $extention == 'png' || $extention == 'jpg' || $extention == 'webp')
            {
            $file->move($uploadPath, $fileName);
            }
        }

        else if ($documentType->code == 'EMP') {
            $file->storeAs("{$folderPrefix}/employee/{$id}", $fileName, $disc);
            $document->name_on_file = "{$folderPrefix}/employee/{$id}/{$fileName}";

            if($extention == 'jpeg' || $extention == 'png' || $extention == 'jpg' || $extention == 'webp')
            {
            $file->move($uploadPath, $fileName);
            }
        }


        $document->external_key = $id;
        $document->mime_type = $file->getClientMimeType();
        $document->size = '200';
        $document->temp_key = $fileName;
        $document->created_by = Auth::id();
        $document->document_status_id = $documentStatus->id;
        $document->document_type_id = $documentType->id;
        $document->save();


    }

            DB::commit();

            return response()->json(['message' => ' <div class="alert alert-success border-2 d-flex align-items-center" style="padding: 0.2rem 1rem;"role="alert">
            <div class="bg-success me-3 icon-item"><span class="fas fa-check-circle text-white fs-3"></span></div>
            <p class="mb-0 flex-1" style="font-size: 14px;">Uploaded successfully!</p>
            <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>']);
        }
        else
        {
            return response()->json(['error' => 'File upload failed.']);
        }
    }
    public function storedocumentapi(Request $request)
    {

       $documentStatus =  DocumentStatus::where('code','SAVED')->first();
       $documentType = DocumentType::where('id',  $request->filetype)->firstOrFail();
       $id = $request->docid;


        if($request->hasFile('file')){


    $file = $request->file('file');



    $extention = $file->getClientOriginalExtension();
    $fileName = time().'-'.rand(0,99).'.'.$extention;
    // $file->move($uploadPath, $filename);

    $uploadPath = 'uploads/documents/';

    $disc = env('APP_DISC','spaces');
    $folderPrefix = config('app.DO_FOLDER_NAME');

    // $finalImageName = $uploadPath.$filename;
    $document = new Document();
    $document->extension = $extention;
    $document->name = $file->getClientOriginalName();

    if ($documentType->code == 'PTD') {
        $file->storeAs("{$folderPrefix}/property/{$id}", $fileName, $disc);
        $document->name_on_file = "{$folderPrefix}/property/{$id}/{$fileName}";
        if($extention == 'jpeg' || $extention == 'png' || $extention == 'jpg' || $extention == 'webp')
        {
        $file->move($uploadPath, $fileName);
        }


    } else if ($documentType->code == 'TND') {
        $file->storeAs("{$folderPrefix}/tenant/{$id}", $fileName, $disc);
        $document->name_on_file = "{$folderPrefix}/tenant/{$id}/{$fileName}";
        if($extention == 'jpeg' || $extention == 'png' || $extention == 'jpg' || $extention == 'webp')
        {
        $file->move($uploadPath, $fileName);
        }

    } else if ($documentType->code == 'UND') {
        $file->storeAs("{$folderPrefix}/property/{$property_id}/unit/{$id}", $fileName, $disc);
        $document->name_on_file = "{$folderPrefix}/property/{$property_id}/unit/{$id}/{$fileName}";
        if($extention == 'jpeg' || $extention == 'png' || $extention == 'jpg' || $extention == 'webp')
        {
        $file->move($uploadPath, $fileName);
        }

    }else if ($documentType->code == 'TUND') {
        $tenantunit = TenantUnit::findorfail($id);
        $property_id = $tenantunit->property_id;
        $file->storeAs("{$folderPrefix}/property/{$property_id}/{unit}/{$id}/{tenantunit}/{$id}", $fileName, $disc);
        $document->name_on_file = "{$folderPrefix}/property/{$property_id}/unit/{$tenantunit->unit_id}/tenantunit/{$id}/{$fileName}";

        if($extention == 'jpeg' || $extention == 'png' || $extention == 'jpg' || $extention == 'webp')
        {
        $file->move($uploadPath, $fileName);
        }

    }

     if ($documentType->code == 'PAYMENTS') {
        $payment = Payment::findorfail($id);
        $property_id = $payment->property_id;
        $file->storeAs("{$folderPrefix}/property/{$property_id}/payments", $fileName, $disc);
        $document->name_on_file = "{$folderPrefix}/property/{$property_id}/payments/{$fileName}";

        if($extention == 'jpeg' || $extention == 'png' || $extention == 'jpg' || $extention == 'webp')
        {
        $file->move($uploadPath, $fileName);
        }
    }

    else if ($documentType->code == 'EMP') {
        $file->storeAs("{$folderPrefix}/employee/{$id}", $fileName, $disc);
        $document->name_on_file = "{$folderPrefix}/employee/{$id}/{$fileName}";

        if($extention == 'jpeg' || $extention == 'png' || $extention == 'jpg' || $extention == 'webp')
        {
        $file->move($uploadPath, $fileName);
        }
    }


    $document->external_key = $id;
    $document->mime_type = $file->getClientMimeType();
    $document->size = '200';
    $document->temp_key = $fileName;
    $document->created_by = Auth::id();
    $document->document_status_id = $documentStatus->id;
    $document->document_type_id = $documentType->id;
    $document->save();


        if(Route::current()->middleware()[0]=="api"){

            return response()->json([
                'message' => 'document has been uploaded successfully...',

            ],201);
        }


            DB::commit();



            return response()->json(['message' => 'uploaded successfully']);
        }
        else
        {
            return response()->json(['error' => 'File upload failed.']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }


    public function setfeaturedimage(Request $request)
    {

        $changedocument = Document::where('is_featured',1)->where('external_key',$request->key)->where('document_type_id',$request->type)->first();

        if(!empty($changedocument)){
            $removefeatdocument = Document::findOrFail($changedocument->id);
            $removefeatdocument->is_featured = 0;
            $removefeatdocument->updated_by = Auth::id();
            $removefeatdocument->save();
        }


        $document = Document::findOrFail($request->id);
        $document->is_featured = 1;
        $document->updated_by = Auth::id();
        $document->save();

        DB::commit();
        if(Route::current()->middleware()[0]=="api"){

            return response()->json([
                'file' => $document->temp_key,

            ],201);
        }
        return response()->json([
            'file' => $document->temp_key,
            ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    public function download($id)
    {
        $document = Document::findOrFail($id);
        $disc = env('APP_DISC','spaces');
        if(Route::current()->middleware()[0]=="api"){

            return response()->json([
                'document_name' =>$document->name,
                'document_name_on_file' =>$document->name_on_file,


            ],200);
        }
        return Storage::disk($disc)->download("$document->name_on_file", $document->name);
    }



    public function preview($id)
    {
        $document = Document::find($id);
        $disc = env('APP_DISC','spaces');

        $file = Storage::disk($disc)->get($document->name_on_file);

        $response = Response::make($file, 200);
        if ($document->extension == 'pdf') {
            $response->header('Content-Type', 'application/pdf');
        } else if ($document->extension == 'png') {
            $response->header('Content-Type', 'application/png');
        } else if ($document->extension == 'jpeg') {
            $response->header('Content-Type', 'application/jpeg');
        } else if ($document->extension == 'jpg') {
            $response->header('Content-Type', 'application/jpg');
        } else if ($document->extension == 'docx') {
            $response->header('Content-Type', 'application/docx');
        } else if ($document->extension == 'xlsx') {
            $response->header('Content-Type', 'application/xlsx');
        } else if ($document->extension == 'xls') {
            $response->header('Content-Type', 'application/xls');
        } else if ($document->extension == 'csv') {
            $response->header('Content-Type', 'application/csv');
        } else if ($document->extension == 'mp4') {
            $response->header('Content-Type', 'application/mp4');
        } else if ($document->extension == 'mkv') {
            $response->header('Content-Type', 'application/mkv');
        }

        return $response;

    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
