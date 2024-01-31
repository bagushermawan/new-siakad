<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ErrorTestController extends Controller
{
    public function show404()
    {
        abort(404);
    }

    public function show419()
    {
        abort(419);
    }

    public function show500()
    {
        abort(500);
    }

    public function show403()
    {
        abort(403, 'Unauthorized action.');
    }

    public function test()
    {
        return view('test.test2');
    }
}
