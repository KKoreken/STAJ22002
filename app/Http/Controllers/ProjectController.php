<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Categories;
use App\Models\Interest;
use App\Models\PostLabel;
use App\Models\ProjectCategories;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Project;

class ProjectController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    use AuthorizesRequests, ValidatesRequests;
    public function __construct()
    {
        $this->ortak = new OrtakController();
    }
    public function getProjects(){
        $items = Project::with('category')->get();

        return view('panel.project.index', compact('items'));

    }
    public function addProject(){
        $cats = ProjectCategories::where('is_visible',1)->get();
        $labels = PostLabel::all();
        $result =[
            'cats'=>$cats,
            'labels'=>$labels
        ];
        return view('panel.project.add', $result);
    }
    public function addProjectPost(Request $request){
        dd($request->all());
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
    public function projeDetay($url){
        $item = Project::with(['category','label'])->where('url',$url)->first();
        $sonposts = $this->ortak->son2post();
        foreach ($sonposts as $sonpost) {
            $sonpost->created_at = $this->ortak->tarihAyarla($sonpost->created_at);
        }
        $item->created_at = $this->ortak->tarihAyarla( $item->created_at);
        $result = [
            'item' => $item,
            'sonposts'=> $sonposts,
        ];
        return view('blog.detail', $result);
    }


}
