<?php

namespace App\Http\Controllers;

class PrivacyPolicyController extends Controller
{
  function index() {
    return view('policy.privacy-policy');
  }
}
