<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Template;
use Illuminate\Support\Facades\DB;

class StaticPagesController extends Controller
{
    public function home(Request $action) {
        if (array_key_exists('id', $action->all())) {
            return view('home/office', ['id' => $action->all()['id']]);
        }
    }

    public function get(Template $template, Request $action) {
        if (array_key_exists('id', $action->all())) {
            return view('home/get', ['template' => $template->find($action->all()['id'])->hash]);
        }
    }

    public function set(Request $action) {
        if (array_key_exists('id', $action->all())) {
            DB::table('templates')->where('id', $action->all()['id']) -> update(['hash' => $action->all()['hash']]);
        }
        // return view('home/set');
    }
}
