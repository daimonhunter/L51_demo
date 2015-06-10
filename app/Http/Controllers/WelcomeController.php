<?php namespace App\Http\Controllers;

use DB;
use Cache;
use League\Flysystem\Exception;
use Session;
use App;
use Illuminate\Support\Facades\Request;

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

    public function getCache()
    {
        try {
            //Session and Cache
            if (Session::has('Clients')) {
                $data = Session::get('Clients');
            } else {
                $data = $this->cacheQuery("SELECT * FROM oauth_clients WHERE `id` > 0", 30);
                Session::put('Clients', $data);
            }

            $uid = Request::input('uid', 1);
            $userCacheKey = 'users:' . $uid;
            $user = Cache::remember($userCacheKey, 5, function () use ($uid) {
                return App\User::findOrFail($uid)->toArray();
            });

        } catch (Exception $e) {
            abort(404, $e->getMessage());
        }
        var_dump($data);
        var_dump($user);
        echo date('H:i',time());
    }

    public function getBlade()
    {
        return view('/demo/login');
    }

    function cacheQuery($sql, $timeout = 60)
    {
        return Cache::remember(md5($sql), $timeout, function () use ($sql) {
            return DB::select(DB::raw($sql));
        });
    }

}
