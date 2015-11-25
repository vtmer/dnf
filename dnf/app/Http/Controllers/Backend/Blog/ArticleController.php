<?php namespace App\Http\Controllers\Backend\Blog;

use App\Models\Backend\blog\Article as ArticleModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Backend\blog\Category as CategoryModel;
use App\Models\Backend\blog\Tag as TagModel;
use App\Models\Backend\blog\ArticleTag as ArticleTagModel;
use App\Models\Backend\User as UserModel;
use App\Models\Backend\System\Action as ActionModel;
use Request;
use Input;
use Auth;
use Lang;
use App\Component\Js;
use App\Component\Acl;
use App\Http\Requests\ArticleRequest;
use App\Http\Controllers\Backend\BaseController;

class ArticleController extends BaseController{


    /**
     * 属性：用户id
     * var int
     */
    protected $usersId;


    public function __construct()
    {
	parent::__construct();
	$user = Auth::id();
    }

    /**
     * 页面：文章列表
     * @return Resonpse
     */
    public function getArticles()
    {
     $datas = ArticleModel::all();
 	 return view('backend.blog.index',compact('datas'));
    }
    /**
     * 页面 ：文章添加页面
     * @return Response
     */
    public function _create()
    {
        return  view('backend.blog.create',[
         'formUrl'=>route('backend_blog_articles_create'),
         'categorys' => CategoryModel::all(),
         'tags' => TagModel::all(),
     ]);
    }

     /**
     * 页面：回收站文章列表
     * @return Response
     */

    public function getTrashedArticles()
    {
        $datas = ArticleModel::onlyTrashed()->get();
        return view('backend.blog.trashed',compact('datas'));
    }

    /**
     * 页面：文章编辑页面
     * @return Response
     */
    public function update()
    {
        $id = Request::get('id',false);

        $article = ArticleModel::find($id);
        if (null == $article) return Js::error(Lang::get('backend.none-data'));
        return view('backend.blog.create',[
            'data' => $article,
            'formUrl' => route('backend_blog_articles_update'),
            'categorys' => CategoryModel::all(),
            'tags' => TagModel::all(),
        ]);
    }

    /**
     * 动作：新增文章
     *@return Response
     */
    public function createArticle(ArticleRequest $request)
    {
    	$data  = Input::all();
    	$article = ArticleModel::createOneArticle($data);
        $article_id = $article->id;
        $tag_ids = $data['tag_id'];
        $tags = [];
        foreach ($tag_ids as $key => $tag_id) {
            $tags[$key]['article_id'] = $article_id;
            $tags[$key]['tag_id'] = $tag_id;
        }

        ArticleTagModel::insert($tags);

        ActionModel::createOneAction('17',$data['title']);

        return redirect()->route('backend_blog_articles_index');

    }


    /**
     * 动作：修改文章
     * @return Resonpse
     */
    public function _update(ArticleRequest $request)
    {
        $user = Auth::user();

        $data = array_except(Input::all(),'_taken');
        $data['updater'] = $user['realname'] ;
        $article = ArticleModel::find($data['id']);
        $article->update($data);
        $tags = $data['tag_id'];
        $article->tags()->sync($tags);
        ActionModel::createOneAction('18',$article->title);
        return redirect()->route('backend_blog_articles_index');
    }
    /**
    *
    *动作：改变状态
    *@return draft
    */
    public function _changeStatus()
    {
        $id = Input::get('id',false);
        $article = ArticleModel::find($id);
        if (!$article) return Js::response(Lang::get('params.10001'),false);

        $article->draft = $article-> draft ? 0 : 1 ;
        if(!$article->save())
            return Js::response(Lang::get('params.10006'),false);

        $buttonChangeName = Lang::get('backend.button-status.article-status.'.$article->draft);

        ActionModel::createOneAction('19',$article->title);
        return Js::response(null,true,false,$buttonChangeName);
    }


    /**
    *软删除
    *
    */
    public function softdeleteArticle()
    {
        $id = Input::get('id',false);
        $article = ArticleModel::find($id);
        if(!$article)return Js::response(Lang::get('params.10005',false));
        $user = Auth::user();

        $article->update([
            'updater' => $user->realname,
            'draft' => 1,
            'category_id'=>1,
        ]);
        $article->delete();

        ActionModel::createOneAction('20',$article->title);
        return Js::Response(null,true,false);
    }

    /**
     * 动作： 恢复文章
     * @return Response
     */
    public function restoreTrashedArticle()
    {
        $id = Input::get('id',false);
        $article = ArticleModel::withTrashed()->find($id);
        if(!$article)return Js::response(Lang::get('params.10005',false));
        $article->restore();
        //写入操作
        ActionModel::createOneAction('24',$article->title);
        return redirect()->route('backend_blog_articles_index');

    }

          /**
     * 动作：彻底删除文章
     * @return Resonpse
     */
    public function deleteTrashedArticle()
    {
        $id = Input::get('id',false);
        $article = ArticleModel::withTrashed()->find($id);
        if(!$article)return Js::response(Lang::get('params.10005',false));
        $article->forceDelete();
        //写入操作
        ActionModel::createOneAction('25',$article->title);
        return redirect()->route('backend_blog_articles_trashed');
    }



    /**
     * 动作：改变文章排序
     * @return Response
     */
    public function articleSort()
    {

    }





 }
