<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DeleteController extends Controller
{
    public function delete()
    {
        if (file_exists('Upload.xlsx'))
        {
            unlink('Upload.xlsx');
            return redirect()->route('showForm')->with('status', 'Файл видалено');
        }
    }
}
