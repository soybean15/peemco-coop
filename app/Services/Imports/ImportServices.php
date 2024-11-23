<?php

namespace App\Services\Imports;

use App\Contracts\HasImport;

class ImportServices{

    protected $handler;

    public function __construct(HasImport $handler){

        $this->handler=$handler;

    }



    public function store($data,$jobProcess=null){
        return $this->handler->store($data,$jobProcess);
    }





}
