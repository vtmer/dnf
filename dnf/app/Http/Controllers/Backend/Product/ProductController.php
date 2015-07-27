<?php namespace App\Http\Controllers\Backend\Product;

use App\Models\Backend\product\Product as ProductModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Backend\User as UserModel;
use App\Models\Backend\System\Action as ActionModel;
use Request;
use Input;
use Auth;
use Lang;
use App\Component\Js;
use App\Component\Acl;
use App\Http\Requests\ProductRequest;
use App\Http\Controllers\Backend\BaseController;

class ProductController extends BaseController{


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
     * 页面 ：产品添加页面
     * @return Response
     */
    public function _create()
    {
        return  view('backend.product.create',[
        'formUrl'=>route('backend_product_product_create'),

     ]);
    }

    /**
     *页面：产品案例编辑页面
     *@return Response
     */
    public function update()
    {
        $id = Request::get('id',false);
        $product = ProductModel::find($id);
        if (null == $product) return Js::error(Lang::get('backend.none-data'));
        return view('backend.product.edit',[
                'data'=>$product,
                'formUrl'=> route('backend_product_product_update'),
        ]);
    }



    /**
     * 页面：产品列表
     * @return Response
     */
     public function getProduct()
     {
        $datas = ProductModel::all();

        return view('backend.product.index', [
            'datas' => $datas,
        ]);
     }




    /**
     * 动作：新建产品
     * @return Response
     */
     public function createProduct (ProductRequest $request)
     {
        $data = array_except(Input::all(),'_token');
        $img_URLs = [];
        //把图片url的数组分离出来
       $img_URLs = array_except($data, ['id', 'updater', 'name','holder','url','description']);
       //把数组压缩为一维数组
        $img_URLs = array_flatten($img_URLs);

      // 图片url组成一维数组
           $temp = array_reduce($img_URLs,function($v1,$v2)
            {
               return $v1 . "," . $v2;
            });

        $data['img_URL'] = $temp;

        ProductModel::create($data);

        //写入操作
        ActionModel::createOneAction('50',$data['name']);
        return redirect()->route('backend_product_product_index');
     }

    /**
     *动作：修改产品案例
     *@return Response
     */

    public function _update(ProductRequest $request)
    {
        $data = array_except(Input::all(),'_token');
        $img_URLs = [];
        //把图片url的数组分离出来
       $img_URLs = array_except($data, ['id', 'updater', 'name','holder','url','description']);
       //把数组压缩为一维数组
        $img_URLs = array_flatten($img_URLs);

      // 图片url组成一维数组
           $temp = array_reduce($img_URLs,function($v1,$v2)
            {
               return $v1 . "," . $v2;
            });
        $data['img_URL'] = $temp;
        $product = ProductModel::find($data['id']);
        $product->update($data);
        ActionModel::createOneAction('52',$product->name);
        return redirect()->route('backend_product_product_index');

    }

   /**
     * 动作：彻底删除产品
     * @return Resonpse
     */
    public function deleteProduct()
    {
        $data = array_except(Input::all(),'_token');
        $id = $data['id'];
        $img_URLs = [];
        $product = ProductModel::find($id);
        if(!$product)return Js::response(Lang::get('params.10005',false));
        $product->forceDelete();
        //写入操作
        ActionModel::createOneAction('51',$product->name);
        //return redirect()->route('backend_product_product_index');
    }



}


