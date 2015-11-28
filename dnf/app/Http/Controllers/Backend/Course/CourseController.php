<?php namespace App\Http\Controllers\Backend\Course;

use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Backend\course\Course as CourseModel;
use App\Models\Backend\System\Action as ActionModel;
use App\Models\Backend\System\user;
use App\Models\Backend\course\CourseArticle as CourseArticleModel;
use App\Http\Controllers\Backend\BaseController;
use Auth;
use Input;
use Request;
use Lang;
use App\Http\Requests\CourseRequest;
use App\Component\Js;
use App\Component\Acl;

class CourseController extends BaseController {


    /**
     * 页面：教程列表
     * @return Response
     */
     public function showCourse()
     {
        $datas = CourseModel::all();
        return view('backend.course.course', [
            'datas' => $datas,
        ]);
     }


    /**
     * 动作：新建教程
     * @return Response
     */
     public function createCourse(CourseRequest $request)
     {
        $data = array_except(Input::all(),'_token');
        CourseModel::createOneCourse($data);

        //写入操作
        ActionModel::createOneAction('27',$data['name']);
        return redirect()->route('backend_course_course_index');
     }

   /**
     * 动作：在文章编辑页面直接创建教程
     * @return Response
     */
     public function createCourseInIndex(CourseRequest $request)
     {
        $data = array_except(Input::all(),'_token');
        CourseModel::createOneCourse($data);

        //写入操作
        ActionModel::createOneAction('27',$data['name']);
        return redirect()->route('backend_course_articles_create');
     }

    /**
     * 动作：修改教程名
     * @return Response
     */
    public function updateCourse(CourseRequest $request)
    {
        $data = array_except(Input::all(),'_token');
        $course = CourseModel::where('id', '=', $data['id']);
        if (!$course) return Js::error(Lang::get('backend.none-data'));

        $user = Auth::user();
        $course->update([
            'updater' => $user->realname,
            'name'=> $data['name'],
            'updated_at'=> time(),
        ]);

        ActionModel::createOneAction('28',$data['name']);
        return redirect()->route('backend_course_course_index');
    }

    /**
     * 动作：软删除教程,同时软删除该教程下所有文章
     * @return Response
     */
     public function SoftdeleteCourse()
     {
        $id = Input::get('id',false);
        if($id==1)return Js::error(Lang::get('params.10007'));

        $course = CourseModel::find($id);
        if(!$course)return Js::response(Lang::get('params.10005',false));
        $article_ids = [];
        $article_ids = CourseArticleModel::where('course_id','=',$id)->lists('id');
        $article = CourseArticleModel::where('course_id','=',$id);
        //修改栏目为默认，更新状态为草稿
        $article->update([
            'draft'=> 1,
        ]);
        //软删除该教程下所有文章
        foreach($article_ids as $article_id){
            $article = CourseArticleModel::where('id','=',$article_id)->delete();
        };
        $course->delete();
        ActionModel::createOneAction('16',$course->name);
        return Js::response(null,true,false);
     }
}

