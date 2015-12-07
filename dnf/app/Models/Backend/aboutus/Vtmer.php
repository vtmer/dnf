<?php namespace App\Models\Backend\aboutus;

use Auth;
use Illuminate\Database\Eloquent\Model;
use App\Models\Backend\BaseModel;
use App\Models\Backend\User;
use App\Models\Backend\aboutus\Vtmer;
use Illuminate\Database\Eloquent\SoftDeletes;


class Vtmer extends BaseModel{

    use SoftDeletes;

    protected $table = 'aboutus';

    protected $fillable = ['name','time','img_URL','creator','introduction','blog','email','updater','update_at','create_at'];

    public static function createOneVtmer($data)
      {
          return static::create([
              'name' => $data['name'],
              'time' => $data['time'],
              'img_URL'=>$data['img_URL'],
              'creator'=>$data['creator'],
              'updater'=> $data['updater'],
              'introduction'=>$data['introduction'],
              'email'=> $data['email'],
              'blog'=>$data['blog'],
              'created_at'=> time(),
              'updated_at'=> time(),
          ]);
      }
}
