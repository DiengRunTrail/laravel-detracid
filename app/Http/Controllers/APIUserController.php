<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserRegistration;
use Detection\MobileDetect;
use Illuminate\Http\Request;

class APIUserController extends Controller
{
  // login
  public function login(Request $request)
  {
    $username = $request->input('username');
    $password = $request->input('password');

    $md5password = md5($password);

    $user = User::where('username', $username)->orWhere('email', $username)->first();
    if (!$user)
    {
      return response()->json([
        "status" => "failed",
        "message" => "Username or Email is not found",
      ], 404);
    }

    if (!$user->password == $md5password) 
    {
      return response()->json([
        "status" => "failed",
        "message" => "Username or password is incorrect",
      ], 400);
    }

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
  }

  public function profile($id)
  {
    $userRegistration = new UserRegistration();
    $user = $userRegistration->findByUid($id);

    if (!$user || count($user) == 0) {
      # code...
      return response()->json([
        "status" => "failed",
        "message" => "User profile not found",
      ], 404);
    }
    
    unset($user[0]["password"]);
    $idUser = $user[0]['id_user'];
    $idCat = $user[0]['id_registration'];
    $user[0]['id_user'] = (string)$idUser;
    $user[0]['id_registration'] = (string)$idCat;

    return response()->json(
      [
        "status" => "success",
        "message" => "User profile found success",
        "data" => $user[0],
      ],
      200
    );
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

  public function downloadApp() 
  {
    $device = new MobileDetect();

    if ($device->isiOS() || $device->isiPad()) {
      # code...
      return redirect()->to('https://testflight.apple.com/join/LCUAQYUv');
    }

    return redirect()->to('https://play.google.com/store/apps/details?id=com.diengcalderarace.dcr_mobile');
  }
}
