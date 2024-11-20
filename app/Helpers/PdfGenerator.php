<?php

namespace App\Helpers;

use Barryvdh\DomPDF\Facade\Pdf;

class PdfGenerator{



    public $pdf;
    public $data;
    public function __construct($view,$data=[]){
        $this->pdf = Pdf::loadView($view, $data);

    }

    public function stream(){

        return $this->pdf->stream();
    }
    public function download(){
        return response()->streamDownload(function () {
            echo $this->pdf->stream();
            }, 'name.pdf');
    }
}
