<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Database\DatabaseManager as DB;

class UserDuplicate implements Rule
{

    private $db;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(DB $db)
    {
        $this->db = $db;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $user = $this->db->table('users')
            ->where('email', $value)
            ->first();

        return is_null($user);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The email is registered.';
    }
}
