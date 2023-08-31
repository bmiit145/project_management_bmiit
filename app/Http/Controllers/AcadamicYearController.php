<?php

namespace App\Http\Controllers;

use App\Models\academicyear;
use Illuminate\Http\Request;

class AcadamicYearController extends Controller
{
    function viewAllYears()  {

        $years = academicyear::get();


        
        return view('admin.acadamicYears' , compact(['years' => "years"]));
    }
}
