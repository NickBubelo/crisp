<?php

namespace App\Http\Controllers;

use Carbon\Carbon;

use Illuminate\Http\Request;
//use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

use App\Models\Links;

class LinksController extends Controller
{
    
    public function link(Links $links)
    {
        if ($links->counter<0) {
            abort(404);
        } elseif ($links->lifetime < Carbon::now()->format('Y-m-d H:i:s')) {
            abort(404);
        } else {
            if ($links->counter>0) {
                $links->decrementCounter();
            }
            return redirect($links->sourcelink);
        }
    }

    public function post(Request $request)
    {
        $links = new Links();

        $links->sourcelink = $request->input('sourcelink');
        $links->counter = (int)$request->input('counter');
        $lifetime = Carbon::now()->addHours((int)$request->input('lifetime'));
        $links->lifetime = $lifetime->format('Y-m-d H:i:s');
        $links->shortlink = Str::random(8);

        if ($links->isUpdated()) {
            return view('post', [ 'result' => 'update', 'sourcelink' => $links->sourcelink, 'shortlink' => $request->url().'/'.$links->shortlink ]);
        } elseif ($links->isCollision()) {
            return view('post', [ 'result' => 'collision', 'sourcelink' => $links->sourcelink, 'shortlink' => $request->url().'/'.$links->shortlink, 'sourceLinkForm' => $links->sourcelink ]);
        } elseif ($links->isInserted()) {
            return view('post', [ 'result' => 'insert', 'sourcelink' => $links->sourcelink, 'shortlink' => $request->url().'/'.$links->shortlink ]);
        } else {
            return view('index', [ 'sourceLinkForm' => $links->sourcelink ]);
        }
    }

}
