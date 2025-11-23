<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redirect;

class HomeController extends Controller
{
    public function home()
    {
        return Redirect::to("/app");
    }
}
