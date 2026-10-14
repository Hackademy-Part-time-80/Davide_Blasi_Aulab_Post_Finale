<?php

namespace App\Http\Controllers;

use App\Models\Tag;

class TagController extends CRUDController
{
    protected string $model = Tag::class;
    protected string $label = 'Tag';
}
