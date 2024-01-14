<?php

namespace App\Http\Controllers;
class PolicyController extends Controller
{
    function index() {
      return view('policy.rule');
    }
}
