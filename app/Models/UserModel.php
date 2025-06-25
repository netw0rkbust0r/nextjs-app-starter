<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'account';
    protected $primaryKey = 'c_id';
    protected $allowedFields = ['c_id', 'username', 'password_hash', 'verified', 'status', 'grade'];

    public function getUserByUsername(string $username)
    {
        return $this->asArray()
                    ->where('c_id', $username)
                    ->first();
    }
}
