<?php

namespace App\Http\Controllers;

use App\Models\Category;

class CategoryController extends CRUDController
{
    protected string $model = Category::class;
    protected string $label = 'Categorie';
}
