<?php namespace App\Http\Controllers\Backend\Aboutus;

use App\Models\Backend\aboutus\Vtmer as VtmerModel;
use App\Models\Backend\System\Action as ActionModel;
use App\Models\Backend\System\user;
use App\Http\Controllers\Backend\BaseController;
use Auth;
use Input;
use Request;
use Lang;
use App\Http\Requests\VtmerRequest;
use App\Component\Js;
use App\Component\Acl;
use Illuminate\Database\Eloquent\SoftDeletes;

class VtmerController extends BaseController {


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
     * 页面：Vtmer个人信息列表
     * @return Response
     */
     public function showVtmer()
     {
        $datas = VtmerModel::all();
        return view('backend.aboutus.vtmer', [
            'datas' => $datas,
        ]);
     }

         /**
     * 页面 ：Vtmer个人信息添加页面
     * @return Response
     */
    public function _create()
    {
        return  view('backend.aboutus.create',[
         'formUrl'=>route('backend_aboutus_vtmer_create'),
     ]);
    }

    /**
     * 页面：回收站文章列表
     * @return Response
     */

    public function getTrashedVtmer()
    {
        $datas = VtmerModel::onlyTrashed()->get();
        return view('backend.aboutus.trashed',compact('datas'));
    }


        /**
     * 页面：Vtmer个人信息编辑页面
     * @return Response
     */
    public function update()
    {
        $id = Request::get('id',false);

        $vtmer = VtmerModel::find($id);
        if (null == $vtmer) return Js::error(Lang::get('backend.none-data'));
        return view('backend.aboutus.create',[
            'data' => $vtmer,
            'formUrl' => route('backend_aboutus_vtmer_update'),
        ]);
    }

     /**
     * 动作：新增Vtmer个人信息
     *@return Response
     */
    public function createVtmer(VtmerRequest $request)
    {
        $data  = Input::all();
        $user = Auth::user();
        $data['creator']=$user->realname;
        $vtmer = VtmerModel::createOneVtmer($data);
        //写入操作
        ActionModel::createOneAction('40',$vtmer->name);
        return redirect()->route('backend_aboutus_vtmer_index');
        }

      /**
     * 动作：修改Vtmer个人信息
     * @return Resonpse
     */
    public function _update(VtmerRequest $request)
    {
        $user = Auth::user();

        $data = array_except(Input::all(),'_token');
        $data['updater'] = $user['realname'] ;
        $vtmer = VtmerModel::find($data['id']);
        $vtmer->update($data);
        //写入操作
        ActionModel::createOneAction('41',$vtmer->name);
        return redirect()->route('backend_aboutus_vtmer_index');
    }      

     /**
    *软删除  Vtmer个人信息
    *
    */
    public function softdeleteVtmer()
    {
        $id = Input::get('id',false);
        $vtmer = VtmerModel::find($id);
     
        $user = Auth::user();

        $vtmer->update([
            'updater' => $user->realname,
        ]);
        $vtmer->delete();

        ActionModel::createOneAction('42',$vtmer->name);
        return Js::Response(null,true,false);
    }

    /**
     * 动作： 恢复Vtmer个人信息
     * @return Response
     */
    public function restoreTrashedVtmer()
    {
        $id = Input::get('id',false);
        $vtmer = VtmerModel::withTrashed()->find($id);
        if(!$vtmer)return Js::response(Lang::get('params.10005',false));
        $vtmer->restore();
        //写入操作
        ActionModel::createOneAction('43',$vtmer->name);
        return redirect()->route('backend_aboutus_vtmer_index');

    }


          /**
     * 动作：彻底删除Vtmer个人信息
     * @return Resonpse
     */
    public function deleteTrashedVtmer()
    {
        $id = Input::get('id',false);
        $vtmer = VtmerModel::withTrashed()->find($id);
        if(!$vtmer)return Js::response(Lang::get('params.10005',false));
        $vtmer->forceDelete();
        //写入操作
        ActionModel::createOneAction('44',$vtmer->name);
        return redirect()->route('backend_aboutus_vtmer_trashed');
    }




}
