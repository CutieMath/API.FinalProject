<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    private $id;
    private $title;
    private $first_name;
    private $last_name;

    public function __construct($title, $first_name, $last_name)
    {
    	$this->title = $title;
    	$this->first_name = $first_name;
    	$this->last_name = $last_name;
    
    }


}
