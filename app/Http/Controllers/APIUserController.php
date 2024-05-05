<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class APIUserController extends Controller
{
  // login
  public function login(Request $request)
  {
    $username = $request->input('username');
    $password = $request->input('password');

    $ch = curl_init();
    $url = "https://api.diengcalderarace.com/login";

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    $result = curl_exec($ch);

    curl_close($ch);

    $results = json_decode($result, true)['result'];


    $md5password = md5($password);

    foreach ($results as $user) {
      if ($user['username'] == $username) {
        if ($user['password'] == $md5password) {
          return response()->json(
            [
              "status" => "success",
              "message" => "login success",
              "data" => $user,
            ]
          );
        } else {
          return response()->json([
            "status" => "failed",
            "message" => "username or password is incorrect",
          ]);
        }
      }
    }


    return response()->json([
      "status" => "failed",
      "message" => "User not found, please register first",
    ]);
  }
}
