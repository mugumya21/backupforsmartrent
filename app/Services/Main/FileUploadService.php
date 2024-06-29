<?php
/**
 * Created by PhpStorm.
 * User: eugene
 * Date: 06/04/2018
 * Time: 20:26
 */

namespace App\Services\Main;

use Illuminate\Support\Facades\Storage;
use Auth;
use App\Models\Main\Document;
use App\Models\Main\DocumentStatus;
use App\Models\Main\DocumentType;
use DB;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class FileUploadService implements iFileUploadService
{

    /**
     * @param FileUploadPost $request
     * @param int $id
     * @param string $documentTypeCode
     * @return Document
     * @throws Exception
     */
    public function upload(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);
        
        $random = rand(0, 10000);
        $ext = $request->file->getClientOriginalExtension();

        $disc = env('APP_DISC','local');
        $folderPrefix = env('DO_FOLDER_NAME','not_set');

        $documentType = DocumentType::where('code',  $request->document_type_id)->firstOrFail();
        $documentStatus = DocumentStatus::where('code', 'TEMP')->firstOrFail();
        $secretKey = $request->secret_key;

        $fileName = "{$secretKey}_{$random}.{$ext}";

        $document = new Document();
        $document->extension = $ext;
        $document->name = $request->file->getClientOriginalName();
        $document->temp_key = $request->secret_key;
        $document->mime_type = $request->file->getClientMimeType();
        $document->size = '200';
        $document->created_by = Auth::id();
        $document->document_status_id = $documentStatus->id;
        $document->document_type_id = $documentType->id;

        if ($documentTypeCode == 'TUND') {
            $request->file->storeAs("{$folderPrefix}/file/cases/temp", $fileName, $disc);
            $document->name_on_file = "{$folderPrefix}/file/cases/temp/{$fileName}";
        } 

        DB::beginTransaction();
        try {
            $document->save();
            DB::commit();
            return $document;
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function uploadTemp(FileUploadPost $request, string $documentTypeCode)
    {
        $random = rand(0, 10000);
        $ext = $request->file->getClientOriginalExtension();

        $disc = env('APP_DISC','local');
        $folderPrefix = env('DO_FOLDER_NAME','not_set');

        $documentType = DocumentType::where('code', $documentTypeCode)->firstOrFail();
        $documentStatus = DocumentStatus::where('code', 'TEMP')->firstOrFail();
     
        $document = new Document();
        $document->extension = $ext;
        $document->name = $request->file->getClientOriginalName();
        $document->temp_key = $request->secret_key;
        $document->mime_type = $request->file->getClientMimeType();
        $document->size = '200';
        $document->created_by = Auth::id();
        $document->document_status_id = $documentStatus->id;
        $document->document_type_id = $documentType->id;

        if ($documentTypeCode == 'CF') {
            $request->file->storeAs("{$folderPrefix}/file/cases/temp", $fileName, $disc);
            $document->name_on_file = "{$folderPrefix}/file/cases/temp/{$fileName}";
        } else if ($documentTypeCode == 'ID') {
            $request->file->storeAs("{$folderPrefix}/file/IncomingDocuments/temp", $fileName, $disc);
            $document->name_on_file = "{$folderPrefix}/file/IncomingDocuments/temp/{$fileName}";
        } else if ($documentTypeCode == 'ED') {
            $request->file->storeAs("{$folderPrefix}/file/cases/EmailDocuments/temp", $fileName, $disc);
            $document->name_on_file = "{$folderPrefix}/file/cases/EmailDocuments/temp/{$fileName}";
        } else if ($documentTypeCode == 'ED') {
            $request->file->storeAs("{$folderPrefix}/file/employee/LicenceDetail/temp", $fileName, $disc);
            $document->name_on_file = "{$folderPrefix}/file/employee/LicenceDetail/temp/{$fileName}";
        }

        DB::beginTransaction();
        try {
            $document->save();
            DB::commit();
            return $document;
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function delete(int $id)
    {
        DB::beginTransaction();
        try {
            $document = Document::find($id);
            $disc = env('APP_DISC', 'local');
            Storage::disk($disc)->delete("$document->name_on_file", $document->name);
            $document->delete();

            DB::commit();
            return $document;
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }


public function deletemultiple(Request $request)
{
    $disc = env('APP_DISC', 'local');
    foreach ($request['ids'] as $id){

    DB::beginTransaction();
    try {
        $document = Document::find($id);
      
        Storage::disk($disc)->delete("$document->name_on_file", $document->name);
        $document->delete();

        DB::commit();
    } catch (Exception $e) {
        DB::rollback();
        throw $e;
    }
}
}

}