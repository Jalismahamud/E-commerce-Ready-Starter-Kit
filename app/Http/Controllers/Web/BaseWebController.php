<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;

class BaseWebController extends Controller
{
    protected string $viewPrefix = '';

    protected function view(string $view, array $data = [])
    {
        return view($this->viewPrefix . '.' . $view, $data);
    }

    protected function redirectWithSuccess(string $route, string $message = 'Done successfully')
    {
        return redirect()->route($route)->with('success', $message);
    }

    protected function redirectWithError(string $route, string $message = 'Something went wrong')
    {
        return redirect()->route($route)->with('error', $message);
    }
}
