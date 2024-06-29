<?php

namespace App\Http\Controllers;

use App\Models\Main\Document;
use App\Models\Main\DocumentType;
use App\Models\Main\DocumentStatus;
use Validator;
use DB;
use Auth;
use Illuminate\Support\Facades\Session;
use App\Models\CRM\Client;

use Illuminate\Http\Request;

class ImageUploadController extends Controller
{
    public function index()
    {
        $image = Document::orderByDesc('id')->first();
        $docid = '2';
        // dd($image->toArray());
        return view('uploader', ['image'=>$image,'docid'=>$docid]);
    }
    public function upload(Request $request)
    {
        $input = $request->all();
        $documentStatus =  DocumentStatus::where('code','CLIENTLOGO')->first();
        $documentType = DocumentType::where('code',  'CLIENTLOGO')->firstOrFail();

        $rules = ['imageUpload' => 'required'];
        $messages = [];
        $validator = Validator::make($request->all() , $rules, $messages);
        if ($validator->fails())
        {
            $arr = array( "status" => 400, "msg" => $validator->errors() ->first(), "result" => array());
        }
        else
        {
            try
            {
                if ($input['base64image'] || $input['base64image'] != '0') {
                    
                    $folderPath = public_path('uploads/clientlogos/');
                    $image_parts = explode(";base64,", $input['base64image']);
                    $image_type_aux = explode("image/", $image_parts[0]);
                    $image_type = $image_type_aux[1];
                    $image_base64 = base64_decode($image_parts[1]);
                    // $file = $folderPath . uniqid() . '.png';
                    $filename = time() . '.'. $image_type;
                    $file =$folderPath.$filename;
                    file_put_contents($file, $image_base64);

                    $document = new Document();
                    $document->extension = 'jpg';
                    $document->name = $filename;
                    $document->name_on_file = $filename;
                    $document->external_key = $request->docid;
                    $document->mime_type = 'image/jpeg';
                    $document->size = '200';
                    $document->temp_key = $filename;
                    $document->created_by = Auth::id();
                    $document->document_status_id = $documentStatus->id;
                    $document->document_type_id = $documentType->id;
                    $document->save();
                    DB::commit();

                }

                Session::flash('success','');
            }
            catch(\Illuminate\Database\QueryException $ex)
            {
               
            }
            catch(Exception $ex)
            {
               
            }
        }
     
       
        $client = Client::findorfail($request->docid);
        return redirect()->route('crm.clients.show', $client);
    }
}
