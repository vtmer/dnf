<?php namespace App\Http\Controllers\Backend\Course;

use App\Models\Backend\course\CourseArticle as CourseArticleModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Backend\course\Course as CourseModel;
use App\Models\Backend\User as UserModel;
use App\Models\Backend\System\Action as ActionModel;
use Request;
use Input;
use Auth;
use Lang;
use App\Component\Js;
use App\Component\Acl;
use App\Http\Requests\CourseArticleRequest;
use App\Http\Controllers\Backend\BaseController;

class CourseArticleController extends BaseController{


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
        $datas = CourseArticleModel::all();
 	    return view('backend.course.index',compact('datas'));
    }
    /**
     * 页面 ：文章添加页面
     * @return Response
     */
    public function _create()
    {
        return  view('backend.course.create',[
         'formUrl'=>route('backend_course_articles_create'),
         'courses' => CourseModel::all(),
     ]);
    }

        /**
     * 页面：文章编辑页面
     * @return Response
     */
    public function update()
    {
          $id = Request::get('id',false);

           $article = CourseArticleModel::find($id);
           if (null == $article) return Js::error(Lang::get('backend.none-data'));
           return view('backend.course.create',[
            'data' => $article,
            'formUrl' => route('backend_course_articles_update'),
            'courses' => CourseModel::all(),
        ]);
    }
     /**
     * 页面：回收站文章列表
     * @return Response
     */

    public function getTrashedArticles()
    {
        $datas = CourseArticleModel::onlyTrashed()->get();
        $course = CourseModel::withTrashed()->get();
        return view('backend.course.trashed',[
            'datas' => $datas,
            'courses'=> $course,
            ]);
    }
    /**
     * 动作：新增文章
     *@return Response
     */
    public function createArticle(CourseArticleRequest $request)
    {
        $data  = Input::all();
        $article = CourseArticleModel::createOneArticle($data);
        $article_id = $article->id;

        //写入操作
        ActionModel::createOneAction('29',$data['title']);

        return redirect()->route('backend_course_articles_index');

    }

    /**
     * 动作：修改文章
     * @return Resonpse
     */
    public function _update(CourseArticleRequest $request)
    {
        $user = Auth::user();

        $data = array_except(Input::all(),'_token');
        $data['updater'] = $user['realname'] ;
        $article = CourseArticleModel::find($data['id']);
        $article->update($data);
        ActionModel::createOneAction('30',$article->title);
        return redirect()->route('backend_course_articles_index');
    }

    /**
    *软删除
    *@return Resonpse
    */
        public function softdeleteArticle()
            {
                $id = Input::get('id',false);
                $article = CourseArticleModel::find($id);
                if(!$article)return Js::response(Lang::get('params.10005',false));
                $user = Auth::user();

                $article->update([
                    'updater' => $user->realname,
                    'draft' => 1,
                    'course_id'=>1,
                ]);
                $article->delete();

                ActionModel::createOneAction('32',$article->title);
                return Js::Response(null,true,false);
            }


    /**
     * 动作： 恢复文章
     * @return Response
     */
    public function restoreTrashedArticle()
    {
        $data = Input::all();
        $id = $data['id'];
        $course = CourseModel::withTrashed()->find($data['course_id']);
        $course->restore();
        $article = CourseArticleModel::withTrashed()->find($id);
        if(!$article)return Js::response(Lang::get('params.10005',false));
        $article->restore();
        //写入操作
        ActionModel::createOneAction('33',$article->title);
        return redirect()->route('backend_course_articles_index');
     }

    /**
     * 动作：彻底删除文章
     * @return Resonpse
     */
    public function deleteTrashedArticle()
    {
        $id = Input::get('id',false);
        $article = CourseArticleModel::withTrashed()->find($id);
        if(!$article)return Js::response(Lang::get('params.10005',false));
        $article->forceDelete();
        //写入操作
        ActionModel::createOneAction('34',$article->title);
        return redirect()->route('backend_course_articles_trashed');
    }

     /**
    *
    *动作：改变状态
    *@return draft
    */
    public function _changeStatus()
    {
        $id = Input::get('id',false);
        $article = CourseArticleModel::find($id);
        if (!$article) return Js::response(Lang::get('params.10001'),false);

        $article->draft = $article-> draft ? 0 : 1 ;
        if(!$article->save())
            return Js::response(Lang::get('params.10006'),false);

        $buttonChangeName = Lang::get('backend.button-status.article-status.'.$article->draft);

        ActionModel::createOneAction('30',$article->title);
        return Js::response(null,true,false,$buttonChangeName);
    }

  }
