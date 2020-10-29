<?php

namespace App\Http\Controllers;

use App\Http\Requests\SignUpRequest;
use App\Models\User\Entity\User;
use Illuminate\Http\Request;
use Illuminate\Database\DatabaseManager as DB;

class UserController extends Controller
{

    private $db;

    public function __construct(DB $db)
    {
        $this->db = $db;
    }

    /**
     * Display a sign up form view.
     *
     * @return \Illuminate\Http\Response
     */
    public function signup()
    {
        return view('users.signup');
    }

    /**
     * store a signup data from user
     *
     * @param  App\Http\Requests\SignUpRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(SignUpRequest $request)
    {

        $validated = $request->validated();

        $hashPassword = password_hash($validated['password'], PASSWORD_BCRYPT);

        try {
            $this->db->beginTransaction();

            $user = new User;
            $user->name = $validated['name'];
            $user->password = $hashPassword;
            $user->email = $validated['email'];
            $user->save();

            $this->db->commit();
        } catch (\Exception $e) {
            $this->db->rollBack();
            throw new \Exception($e->getMessage());
        }

        return view('welcome');
    }

}
