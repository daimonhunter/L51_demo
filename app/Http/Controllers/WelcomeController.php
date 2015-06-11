<?php namespace App\Http\Controllers;

use DB;
use Cache;
use League\Flysystem\Exception;
use Session;
use App;
use Illuminate\Http\Request;
use App\Http\Requests\demo\DemoRequest;

class WelcomeController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | Welcome Controller
    |--------------------------------------------------------------------------
    |
    | This controller renders the "marketing page" for the application and
    | is configured to only allow guests. Like most of the other sample
    | controllers, you are free to modify or remove it as you desire.
    |
    */

    /**
     * Create a new controller instance.
     *
     */
    public function __construct()
    {
    }

    /**
     * Show the application welcome screen to the user.
     *
     * @return Response
     */
    public function index()
    {
        return view('welcome');
    }

    public function users()
    {
        return app/User::all();
    }

    public function getCache(Request $request)
    {
        helpEx();
//        dd();
        try {
            //Session and Cache
            if (Session::has('Clients')) {
                $data = Session::get('Clients');
            } else {
                $data = $this->cacheQuery("SELECT * FROM wb_users WHERE `uid` > 0", 30);
                Session::put('Clients', $data);
            }
            $uid = $request->input('uid', 1);
            $userCacheKey = 'users:' . $uid;
            $user = Cache::remember($userCacheKey, 5, function () use ($uid) {
                return App\User::find($uid)->toArray();
            });

        } catch (Exception $e) {
            abort(404);
        }
        var_dump($data);
        var_dump($user);
        echo date('H:i',time());
    }

    public function getBlade()
    {
        return view('/demo/demo');
    }

    public function postValidation(DemoRequest $request)
    {
        echo $request->input('email');
        var_dump(session::all());
    }

    public function getAjaxBlade()
    {
        return view('/demo/ajax_post');
    }
    function cacheQuery($sql, $timeout = 60)
    {
        return Cache::remember(md5($sql), $timeout, function () use ($sql) {
            return DB::select(DB::raw($sql));
        });
    }

}
