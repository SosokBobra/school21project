<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IndexPage extends Controller
{
    public function show($mode = '')
    {
        if (file_exists('Upload.xlsx')) {
            return redirect()->route('results', ['mode' => 0]);
        } else {
            return view('form.index');
        }
    }
}
