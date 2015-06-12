<?php  namespace App\Http\Controllers;
/**
 * Created by PhpStorm.
 * User: Daimon
 * Date: 2015/6/11
 * Time: 18:13
 */
use App\User as User;
class UsersController extends Controller
{
    public function index()
    {
        return User::all();
    }

    public function show($id)
    {
        return User::find($id);
    }
}