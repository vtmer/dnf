<?php namespace App\Http\Controllers\Backend\Blog;

use App\Models\Backend\blog\Tag as TagModel;
use App\Models\Backend\System\Action as ActionModel;
use App\Models\Backend\blog\ArticleTag as ArticleTagModel;
use App\Models\Backend\System\user;
use App\Http\Controllers\Backend\BaseController;
use Auth;
use Input;
use Request;
use Lang;
use App\Http\Requests\TagRequest;
use App\Component\Js;
use App\Component\Acl;

class TagController extends BaseController {


    /**
     * 页面：标签列表
     * @return Response
     */
     public function showTag()
     {
        $datas = TagModel::all();
        return view('backend.blog.tag', compact('datas'));
     }


    /**
     * 动作：新建标签
     * @return Response
     */
     public function createTag(TagRequest $request)
     {
	 $data = array_except(Input::all(),'_token');
         TagModel::createOneTag($data);

        //写入操作
        ActionModel::createOneAction('21',$data['tag']);
        return redirect()->route('backend_blog_articles_create');
     }

    /**
     * 动作：修改标签
     * @return Response
     */
    public function updateTag(TagRequest $request)
    {
        $data = array_except(Input::all(),'_token');
        $tag = TagModel::where('id', '=', $data['id']);
        if (!$tag) return Js::error(Lang::get('backend.none-data'));

        $user = Auth::user();
        $tag->update([
            'updater' => $user->realname,
            'tag'=> $data['tag'],
            'updated_at'=> time(),
        ]);

        //写入操作
        ActionModel::createOneAction('22',$data['tag']);
        return redirect()->route('backend_blog_tag_index');
    }

    /**
     * 动作：删除标签
     * @return Response
     */
     public function deleteTag()
     {
    	$id = Input::get('id',false);
        $tag = TagModel::find($id);
        if(!$tag)return Js::response(Lang::get('params.10005',false));
        $articleId = [];
        $articleId = ArticleTagModel::where('tag_id','=',$id)->lists('article_id');

        $tag->articles()->detach($articleId);
        TagModel::deleteById($id);
        ActionModel::createOneAction('16',$tag->tag);
        return Js::response(null,true,false);
     }
}

