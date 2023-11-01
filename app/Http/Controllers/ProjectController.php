<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function ViewAllProjects()
    {
        return view('admin.addProject');
    }
}
