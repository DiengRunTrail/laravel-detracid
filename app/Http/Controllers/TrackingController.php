<?php

namespace App\Http\Controllers;

use App\Models\UserLocation;
use Illuminate\Http\Request;

class TrackingController extends Controller
{

  public $model;

  public function __construct()
  {
    $this->model = new UserLocation();
  }

  public function index(Request $req)
  {
    $category = $req->query->get("category");
    if ($category) {
      $locations = $this->model->findByCategory($category);
    } else {
      $locations = UserLocation::all();
    }
    return response()->json(
      [
        'success' => true,
        'data' => $locations,
      ]
    );
  }

  public function submit(Request $req)
  {
    $uid = $req->input('uid');
    $latitude = $req->input('latitude');
    $longitude = $req->input('longitude');
    $altitude = $req->input('altitude');
    $category = $req->input('category');
    $email = $req->input('email');
    $fullname = $req->input('fullname');

    $allFields = ['latitude', 'longitude', 'altitude', 'category', 'email', 'fullname', 'uid'];

    foreach ($allFields as $field) {
      if ($req->input($field) == null) {
        return response()->json(
          [
            'success' => false,
            'message' => 'Field ' . $field . ' is required',
          ],
          400
        );
      }
    }

    $user = $this->model->findByEmail($email);

    if ($user) {
      $res = $user->update([
        'latitude' => $latitude,
        'longitude' => $longitude,
        'altitude' => $altitude,
        'category' => $category,
        'email' => $email,
        'fullname' => $fullname,
        'uid' => $uid,
      ]);

      if ($res) {
        return response()->json(
          [
            'success' => true,
            'message' => 'Success update user location',
            'data' => $this->model->findByEmail($email),
          ]
        );
      } else {
        return response()->json(
          [
            'success' => false,
            'message' => 'Failed update user location',
          ],
          400
        );
      }
    } else {
      $res = $this->model->create([
        'latitude' => $latitude,
        'longitude' => $longitude,
        'altitude' => $altitude,
        'category' => $category,
        'email' => $email,
        'fullname' => $fullname,
        'uid' => $uid,
      ]);

      if ($res) {
        return response()->json(
          [
            'success' => true,
            'message' => 'Success submitting user location',
            'data' => $this->model->findByEmail($email),
          ]
        );
      } else {
        return response()->json(
          [
            'success' => false,
            'message' => 'Failed submitting user location',
          ],
          400
        );
      }
    }
  }
}
