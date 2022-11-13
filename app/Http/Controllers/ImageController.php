<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Image;
class ImageController extends Controller
{
    public function imageUpload()
    {
        return view('image-upload');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function imageUploadPost(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'title' => 'required',
            'description' => 'required'
        ]);
       
        $imageName = time().'.'.$request->image->extension();  
     
        $request->image->move(public_path('images'), $imageName);
        
        /* Store $imageName name in DATABASE from HERE */
        $data = $request->all();
      
        $data['image'] = $imageName;
        Image::create($data);
        return back()
            ->with('success','You have successfully upload image.')
            ->with('image',$imageName); 
    }
    public function index(){
        $images = Image::all();
       
        return view('menu',[
            'images' => $images
        ]);
    }
}