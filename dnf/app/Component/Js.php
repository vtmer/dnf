<?php namespace App\Component;

class Js
{
    public static function error($message)
    {
        return redirect()->back()->with(['error' => $message]);
    }
}
