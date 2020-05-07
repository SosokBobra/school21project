<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use function GuzzleHttp\Psr7\mimetype_from_filename;
use Illuminate\Support\Facades\Validator;

class FormController extends Controller
{
    public function send(Request $request)
    {
        $rules = [
            'file' => 'required'
        ];

        $messages = [
            'file.required' => 'Будь ласка, вставте файл'
        ];

        $this->validate($request, $rules, $messages);

        $file = $request->file('file');

        $fileMimeType = $file->getMimeType();

        if ($fileMimeType == 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet') {
            $file->move('.', 'Upload.xlsx');
            return redirect()->route('results');
        } else {
            return redirect()->back()->with('status', 'Файл повинен мати розширення xlsx');
        }
    }

}
