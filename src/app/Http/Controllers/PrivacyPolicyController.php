<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PrivacyPolicyController extends Controller
{
  function index() {
    return view('policy.privacy-policy');
  }
}
