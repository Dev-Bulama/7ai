<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Media;
use Illuminate\Http\Request;

class MediaController extends Controller
{
    public function index(Request $request) {
        $media = Media::latest()->paginate(32);
        return view('admin.media.index', compact('media'));
    }
    public function store(Request $request) {
        $request->validate(['file'=>'required|file|max:10240']);
        $file = $request->file('file');
        $path = $file->store('media/'.date('Y/m'), 'public');
        Media::create([
            'user_id'=>auth()->id(), 'name'=>$file->getClientOriginalName(),
            'file_name'=>$file->getClientOriginalName(), 'mime_type'=>$file->getMimeType(),
            'disk'=>'public', 'path'=>$path, 'size'=>$file->getSize(),
        ]);
        return redirect()->back()->with('success','File uploaded.');
    }
    public function destroy(Media $medium) {
        \Storage::disk('public')->delete($medium->path);
        $medium->delete();
        return redirect()->back()->with('success','File deleted.');
    }
}
