<?php
namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use App\Events\TestRequestEvent;

class ApiController extends Controller
{
    public function getIndex()
    {
        $data = User::get()->take(2);
        event(new TestRequestEvent($data));
    }
}
