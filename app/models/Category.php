<?php

class Category extends Model
{
    protected $table = 'categories';
    protected $fillable = ['name', 'description', 'status'];

    // Relationships and custom methods
}
