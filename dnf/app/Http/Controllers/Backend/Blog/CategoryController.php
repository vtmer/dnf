<?php namespace App\Http\Controllers\Backend\Blog;

use App\Models\Backend\blog\Category as CategoryModel;
use App\Models\Backend\System\Action as ActionModel;
use App\Models\Backend\System\user;
use App\Models\Backend\blog\Article as ArticleModel;
use App\Http\Controllers\Backend\BaseController;
use Auth;
use Input;
use Request;
use Lang;
use App\Http\Requests\CategoryRequest;
use App\Component\Js;
use App\Component\Acl;
use Illuminate\Database\Eloquent\SoftDeletes;

class CategoryController extends BaseController {


    /**
     * 页面：栏目列表
     * @return Response
     */
     public function showCategory()
     {
        $datas = CategoryModel::all();
        return view('backend.blog.category', [
            'datas' => $datas,
        ]);
     }


    /**
     * 动作：新建栏目
     * @return Response
     */
     public function createCategory(CategoryRequest $request)
     {
	    $data = array_except(Input::all(),'_token');
        CategoryModel::createOneCategory($data);

        //写入操作
        ActionModel::createOneAction('14',$data['category']);
        return redirect()->route('backend_blog_category_index');
     }

    /**
     * 动作：修改栏目
     * @return Response
     */
    public function updateCategory(CategoryRequest $request)
    {
        $data = array_except(Input::all(),'_token');
        $category = CategoryModel::where('id', '=', $data['id']);
        if (!$category) return Js::error(Lang::get('backend.none-data'));

        $user = Auth::user();
        $category->update([
            'updater' => $user->realname,
            'category'=> $data['category'],
            'updated_at'=> time(),
        ]);

        ActionModel::createOneAction('15',$data['category']);
        return redirect()->route('backend_blog_category_index');
    }

    /**
     * 动作：删除栏目,同时软删除该栏目下所有文章
     * @return Response
     */
     public function deleteCategory()
     {
        $id = Input::get('id',false);
        $category = CategoryModel::find($id);
        if(!$category)return Js::response(Lang::get('params.10005',false));
        $article_ids = [];
        $article_ids = ArticleModel::where('category_id','=',$id)->lists('id');
        $article = ArticleModel::where('category_id','=',$id);
        //修改栏目为默认，更新状态为草稿
        $article->update([
            'category_id'=> 1,
            'draft'=> 1,
        ]);
        //软删除该栏目下所有文章
        foreach($article_ids as $article_id){
            $article = ArticleModel::where('id','=',$article_id)->delete();
        };
        CategoryModel::deleteById($id);
        ActionModel::createOneAction('16',$category->category);
        return Js::response(null,true,false);
     }
}

