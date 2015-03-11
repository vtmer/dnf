<?php namespace App\Component;

class Js
{
    public static function error($message)
    {
        return redirect()->back()->with(['error' => $message]);
    }

    /**
     * ajax result
     *
     * @param string $message reason
     * @param boolean $status ajax status
     * @return json
     */
    public static function response($message = '', $status = true, $refresh = true, $data = '')
    {
        $status = $status ? 'success' : 'failed';

        return json_encode([
            'status' => $status,
            'message' => $message,
            'refresh' => $refresh,
            'data' => $data,
        ]);
    }

}
