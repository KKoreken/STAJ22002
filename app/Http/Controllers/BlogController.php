<?php

namespace App\Http\Controllers;
use App\Http\Controllers\OrtakController;
use App\Models\Blog;
use App\Models\Categories;
use App\Models\PostLabel;
use Coderflex\LaravelTicket\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use SebastianBergmann\CodeCoverage\Report\Xml\Project;


class BlogController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
    public function __construct()
    {
        $this->ortak = new OrtakController();
    }

    public function getBlogPost(){
        $items = Blog::with('category')->get();
        return view('panel.blog.index', compact('items'));
    }
    public function addBlog ()
    {
        $cats = Categories::where('is_visible',1)->get();
        return view('panel.blog.add', compact('cats'));
    }
    public function addBlogPost (Request $request){
        $baslik             = $request->baslik;
        $url                = $this->ortak->urlOlustur($baslik);
        $item               = new Blog();
        $item->baslik       = $request->baslik;
        $item->url          = $url;
        $item->category_id  = $request->kategori;
        $item->body         = $request->text;
        $item->cover        = $request->filepath;
        $result             = $item->save();
        if($result)foreach($request->etiket as $i){
            $etiket = new PostLabel();
            $etiket->post_id= $item->id;
            $etiket->label_id= $i;
            $etiket->save();
        }
        $this->ortak->checkResult($result);
        return redirect()->route('getblog');
    }
    public function blogdetay($url){
        $item = Blog::with(['category','label'])->where('url',$url)->first();
        $sonposts = $this->ortak->son2post();
        foreach ($sonposts as $sonpost) {
            $sonpost->created_at = $this->ortak->tarihAyarla($sonpost->created_at);
        }
        $item->created_at = $this->ortak->tarihAyarla( $item->created_at);
        $result = [
            'item' => $item,
            'sonposts'=> $sonposts
        ];
        return view('blog.detail', $result);
    }
}
