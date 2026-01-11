<?php

class User extends Model
{
    protected $table = 'users';
    protected $fillable = ['name', 'email', 'password', 'phone', 'address', 'role', 'status'];

    // Relationships and custom methods
}
