<?php

namespace Herode\Amana\Http\Controllers;

use Herode\Amana\Traits\ResponseTrait;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use ResponseTrait;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }
}
