<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LinksController extends Controller
{
    public function index(Request $request)
    {
        if ('/'==$request->path()) {

            return view('index');

        } elseif (preg_match('/^[0-9A-Za-z]{8}$/',$request->path())) {

            $links = DB::table('links')
                ->where('shortlink', '=', $request->path())
                ->get();
            $sourceLink = $links[0]->sourcelink;
            $counter = $links[0]->counter;
            $lifeTime = $links[0]->lifetime;

            if (sizeof($links)) {

                if ($counter<0) {
                    abort(404);
                } elseif ($lifeTime<date('Y-m-d H:i:s')) {
                    abort(404);
                } else {
                    if ($counter>0) {
                        $counter=($counter>1)?--$counter:-1;
                        DB::table('links')
                            ->where('shortlink', '=', $request->path())
                            ->update([ 'counter' => $counter ]);
                    }
                    header('Location: '.$sourceLink);
                }
                exit();

            } else {
                abort(404);
            }

        } else {
            abort(404);
        }
    }

    public function post(Request $request)
    {
        $sourceLink = $request->input('sourcelink');
        $counter = $request->input('counter');
        $lifeTime = $request->input('lifetime');
        $lifeTime=date('Y-m-d H:i:s',time()+$lifeTime*3600);
        $shortLink = $this->getShortLink();

        $sourceLinks = DB::table('links')
            ->where('sourcelink', '=', $sourceLink)
            ->get();

        $shortLinks = DB::table('links')
            ->where('shortlink', '=', $shortLink)
            ->get();

        if (sizeof($sourceLinks)) {

            DB::table('links')
                ->where('sourcelink', $sourceLink)
                ->update([
                    'counter' => $counter
//                    'lifetime' => $lifeTime
                ]);
            $shortLink=$request->url().'/'.$sourceLinks[0]->shortlink;

            return view('post', [ 'result' => 'update', 'sourceLink' => $sourceLink, 'shortLink' => $shortLink ]);

        } elseif (sizeof($shortLinks)) {

            $shortLink=$request->url().'/'.$shortLink;

            return view('post', [ 'result' => 'collision', 'sourceLink' => $sourceLink, 'shortLink' => $shortLink, 'sourceLinkForm' => $sourceLink ]);

        } else {

            DB::table('links')
                ->insert([
                    'sourcelink' => $sourceLink,
                    'shortlink' => $shortLink,
                    'counter' => $counter,
                    'lifetime' => $lifeTime
                ]);

            $shortLink=$request->url().'/'.$shortLink;

            return view('post', ['result' => 'insert', 'sourceLink' => $sourceLink, 'shortLink' => $shortLink ]);

        }
            
    }

    private function getShortLink()
    {
        $short='';
        for ($i=0; $i<8; ++$i) {
            if (rand(0,1))
                $ch=chr(rand(0x30,0x39));
            elseif (rand(0,1))
                $ch=chr(rand(0x41,0x5a));
            else
                $ch=chr(rand(0x61,0x7a));
            $short.=$ch;
        }
        return $short;
    }

}
