<?php

namespace App\Http\Controllers;

use App\Models\Category;

class CategoryController extends CRUDcontroller
{
    protected string $model = Category::class;
}