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
    $url = "https://api.diengcalderarace.com/peserta";

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    $result = curl_exec($ch);

    curl_close($ch);

    $results = json_decode($result, true)['result'];

    $md5password = md5($password);

    foreach ($results as $user) {
      if ($user['username'] == $username || $user['email'] == $username) {
        if ($user['password'] == $md5password) {
          return response()->json(
            [
              "status" => "success",
              "message" => "login success",
              // "data" => $user,
              "data" => [
                'id' => $user['id_user'],
                'username' => $user['username'],
                'email' => $user['email'],
              ],
            ]
          );
        } else {
          return response()->json([
            "status" => "failed",
            "message" => "Username or password is incorrect",
          ], 400);
        }
      }
    }


    return response()->json([
      "status" => "failed",
      "message" => "User not found, please register first",
    ]);
  }

  public function profile($id)
  {

    $ch = curl_init();
    $url = "https://api.diengcalderarace.com/peserta";

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    $result = curl_exec($ch);

    curl_close($ch);

    $results = json_decode($result, true)['result'];

    // dd($results);

    foreach ($results as $user) {
      if ($user['id_user'] === $id) {
        return response()->json(
          [
            "status" => "success",
            "message" => "user profile found success",
            "data" => $user
          ],
          200
        );
      }
    }

    return response()->json([
      "status" => "failed",
      "message" => "user profile not found",
    ], 404);
  }

  public function getRegisteredUser($userId)
  {
    $ch = curl_init();
    $url = "https://api.diengcalderarace.com/peserta";

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    $result = curl_exec($ch);

    curl_close($ch);

    $results = json_decode($result, true)['result'];

    foreach ($results as $user) {
      if ($user['id_user'] === $userId) {
        return $user;
      }
    }

    return null;
  }
}
