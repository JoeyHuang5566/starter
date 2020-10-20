<?php

namespace App\Http\Controllers\API;

use App\Exceptions\MyException;
use App\Http\Controllers\Controller;
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function signup(SignUpRequest $request)
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

    	return $this->jsonRenderResultWithSuccess();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
