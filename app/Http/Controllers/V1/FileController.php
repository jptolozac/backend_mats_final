<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    private $disk = "public";
    public function storeFile(Request $request){
        $archivo = $request->file('archivo');
        $nombre = $archivo->hashName();

        $archivo->storeAs('/noticias', $nombre, $this->disk);

        //dd($archivo->getClientOriginalName());

        return response()->json([
            "message" => "archivo cargado correctamente",
            "archivo" => $nombre
        ], 200);
    }

    public function downloadFile($id){
        $consulta = DB::select("SELECT archivo from noticias where id = {$id}");
        $nombre = $consulta[0]->archivo;
        //dd($nombre);

        if(Storage::disk($this->disk)->exists('noticias/' . $nombre)){
            return Storage::disk($this->disk)->download('noticias/' . $nombre);
        }
        return response('No se encuentra el archivo', 404);
    }
}
