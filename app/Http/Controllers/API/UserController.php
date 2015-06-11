<?php
/**
 * Created by PhpStorm.
 * User: Daimon
 * Date: 2015/6/11
 * Time: 18:13
 */

class UserController extends BaseController
{
    public function show($id)
    {
        $user = User::findOrFail($id);

        return $this->response->array($user->toArray());
    }
}