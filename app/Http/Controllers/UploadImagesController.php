<?php

namespace App\Http\Controllers;

use App\Upload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class UploadImagesController extends Controller
{

    private $images_path;

    public function __construct()
    {
        $this->images_path = public_path('/uploads/');
    }

    /**
     * Display all of the images.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $images = Upload::all();
        return view('uploaded-images', compact('images'));
    }

    /**
     * Show the form for creating uploading new images.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('upload');
    }

    /**
     * Saving images cropped.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $imagem = $_FILES['croppedImage']['tmp_name'];

        $image_name = md5(time() + random_int(1, 10)) . '.png';

        if (!is_dir($this->images_path)) { // verifica se existe a pasta upload
            mkdir($this->images_path, 0777, true); // cria a pasta caso não exista
        };

        $image = Upload::create(['filename' => $image_name]);

        $path = $this->images_path . $image_name;

        move_uploaded_file($imagem, $path);

        return response()->json(['success' => 'done', 'image' => $image, 'teste' => $imagem]);
    }

    /**
     * Remove the images from the storage.
     *
     * @param Request $request
     */
    public function destroy(Request $request)
    {
        $uploaded_image = Upload::find($request->input('id'));

        if (empty($uploaded_image)) {
            return Response::json(['message' => 'Sorry file does not exist'], 400);
        }

        $image_path = $this->images_path . $uploaded_image->filename;

        if (file_exists($image_path)) {
            unlink($image_path);
        }

        if (!empty($uploaded_image)) {
            $uploaded_image->delete();
        }

        return Response::json(['message' => 'File successfully delete'], 200);
    }
}