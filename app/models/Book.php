<?php

class Book extends Model
{
    protected $table = 'books';
    protected $fillable = ['title', 'author', 'isbn', 'category_id', 'description', 'cover_image', 'quantity', 'available_quantity', 'status'];

    // Relationships and custom methods
}
