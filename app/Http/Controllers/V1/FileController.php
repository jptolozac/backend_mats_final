<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Models\Noticia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;

class FileController extends Controller
{
    private $disk = "public";
    public function storeFile(Request $request, string $id){
        $archivo = $request->file('archivo');
        $nombre = $archivo->hashName();

        $archivo->storeAs('/noticias', $nombre, $this->disk);

        //dd($archivo->getClientOriginalName());

        if($this->modificarNoticia($id, $nombre)){
            return response()->json([
                "message" => "archivo cargado correctamente",
                "archivo" => $nombre
            ], 200);
        }

        return response()->json([
            "message" => "no se pudo cargar el archivo"
        ], 409);
    }

    public function downloadFile(int $id){
        $consulta = DB::select("SELECT archivo from noticias where id = {$id}");
        $nombre = $consulta[0]->archivo;
        //dd($nombre);
        $ruta = 'public/noticias/' . $nombre;

        if(Storage::disk($this->disk)->exists('noticias/' . $nombre)){
            //return Storage::disk($this->disk)->download('noticias/' . $nombre);
            $rutaArchivo = 'noticias/' . $nombre;
            $archivo = Storage::disk($this->disk)->get($rutaArchivo);

            // Obtener el tipo de contenido del archivo (mime type)
            $tipoContenido = Storage::disk($this->disk)->mimeType($rutaArchivo);

            // Crear una respuesta con el archivo y el tipo de contenido
            return Response::make($archivo, 200, [
                'Content-Type' => $tipoContenido,
                'Content-Disposition' => 'inline; filename="' . $nombre . '"',
            ]);
        }
        return response('No se encuentra el archivo', 404);
    }
    public function modificarNoticia(string $id, string $archivo){
        return (Noticia::where('id', '=', $id)->update(['archivo' => $archivo]));
    }
}
