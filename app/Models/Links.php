<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Links extends Model
{
    public function decrementCounter() {
        $this->counter=($this->counter>1)?--$this->counter:-1;
        $this->save();
        return $this->counter;
    }
    public function isUpdated() {
        if ( $uplink = Links::where('sourcelink', $this->sourcelink)->first() ) {
            $uplink->counter=$this->counter;
            $uplink->lifetime=$this->lifetime;
            $uplink->save();
            $this->shortlink=$uplink->shortlink;
            return true;
        }
        return false;
    }
    public function isCollision() {
        if ( Links::where('shortlink', $this->shortlink)->first() ) {
            return true;
        }
        return false;
    }
    public function isInserted() {
        if ( ! Links::where('sourcelink', $this->sourcelink)->orWhere('shortlink', $this->shortlink)->first() ) {
            $this->save();
            return true;
        }
        return false;
    }
}
