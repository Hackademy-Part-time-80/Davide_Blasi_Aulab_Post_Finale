<?php

namespace App\Http\Controllers;

use App\Models\Tag;

class TagController extends CRUDcontroller
{
    protected string $model = Tag::class;
}