<?php namespace App\Models\Backend\Inbox;

use Illuminate\Database\Eloquent\Model;
use App\Models\Backend\BaseModel;

class Mail extends BaseModel {

    protected $table = "admin_mail";

    protected $fillable = ['sender_id', 'receiver_id', 'content', 'sender_name',
                            'receiver_name', 'created_at', 'updated_at'];

    /**
     * 关闭日期转换
     */
    public function getDates()
    {
        return array();
    }

    /**
     * 获取站内信
     *
     * @return array
     */
    public static function getMailBySRAndLimit($receiver = 0, $sender = 0, $limit = 0, $flag = 0)
    {
        $query = static::select('*')->where('flag', $flag);
        if ($receiver) $query->where('receiver_id', $receiver);
        if ($sender) $query->where('sender_id', $sender);
        $query->orderBy('created_at', SORT_DESC);
        if ($limit) $query->limit($limit);

        return $query->get();
    }

    /**
     * 分页获取站内信
     *
     * @return array
     */
    public static function getMailBySR($receiver = 0, $sender = 0, $flag = 0)
    {
        $query = static::select('*');
        if (false !== $flag) $query->where('flag', $flag);
        if ($receiver) $query->where('receiver_id', $receiver);
        if ($sender) $query->where('sender_id', $sender);
        $query->orderBy('created_at', SORT_DESC);

        return $query;
    }

    /**
     * 根据receiver_id获取最新的mail的id
     *
     * @return int
     */
    public static function getIdByReceiverId($receiver_id)
    {
        return static::select('id')
            ->where('receiver_id', $receiver_id)
            ->orderBy('id', SORT_DESC)
            ->first();
    }


    /**
     * 保存站内信
     *
     * @return boolean
     */
    public static function mPush($data = null, $sender)
    {
        if (!$data) return false;
        foreach ($data['receiver'] as $key => $receiver) {
            $datas[] = [
                'sender_id' => $sender->id,
                'sender_name' => $sender->name,
                'receiver_id' => $receiver->id,
                'receiver_name' => $receiver->name,
                'content' => $data['content'],
                'updated_at' => time(),
                'created_at' => time(),
            ];
        }

        static::insert($datas);
        return true;
    }

}
