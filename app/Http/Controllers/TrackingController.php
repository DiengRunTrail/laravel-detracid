<?php

namespace App\Http\Controllers;

use App\Models\UserCheckpoint;
use App\Models\UserLocation;
use Illuminate\Http\Request;

class TrackingController extends Controller
{

  public $model;
  public $checkpointModel;

  public function __construct()
  {
    $this->model = new UserLocation();
    $this->checkpointModel = new UserCheckpoint();
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

    // check if category must be matched with "10_km", "21_km", "42_km" or "75_km"

    $valid_category = ["5_km", "10_km", "21_km", "42_km", "75_km"];

    if (!in_array($category, $valid_category)) {
      return response()->json(
        [
          "success" => false,
          "message" => "Category must be matched with 10_km, 21_km, 42_km or 75_km",
        ],
        400
      );
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

  public function submitCheckpoint(Request $req)
  {
    $category = $req->input('category');
    $user_id = $req->input('user_id');
    $checkpoint_name = $req->input('checkpoint_name');

    $allFields = ['category', 'user_id', 'checkpoint_name'];

    foreach ($allFields as $field) {
      if ($req->input($field) == null) {
        return response()->json(
          [
            'success' => false,
            'message' => 'Field ' . $field . ' is required',
          ],
          401
        );
      }
    }

    $allowed_categories = ["5_km", "42_km", "75_km"];

    // check if category is allowed
    if (!in_array($category, $allowed_categories)) {
      return response()->json(
        [
          "success" => false,
          "message" => "Allowed category that can be use is just 42_km and 75_km",
        ],
        400
      );
    }

    $allowed42kmCheckpoint = ['CP2_Prau'];
    $allowed75kmCheckpoint = ['CP2_P_Bismo', 'CP1_P_Prau', 'CP3_P_G_Kembang'];

    if ($category === '42_km' && !in_array($checkpoint_name, $allowed42kmCheckpoint)) {
      return response()->json(
        [
          "success" => false,
          "message" => "Allowed checkpoint that can be use is just CP2_Prau",
        ],
        400
      );
    }

    if ($category === '75_km' && !in_array($checkpoint_name, $allowed75kmCheckpoint)) {
      return response()->json(
        [
          "success" => false,
          "message" => "Allowed checkpoint that can be use is just CP2_P_Bismo, CP1_P_Prau and CP3_P_G_Kembang",
        ],
        400
      );
    }

    // check if user has registered
    $userController = new APIUserController();
    $user = $userController->getRegisteredUser($user_id);

    if (!$user) {
      return response()->json([
        "success" => false,
        "message" => "User not registered",
      ], 401);
    }

    $submitCheckpoint = $this->checkpointModel->insertCheckpoint($user_id, $checkpoint_name);

    if (!$submitCheckpoint) {
      return response()->json([
        "success" => false,
        "message" => "Failed submitting checkpoint or user already submit this checkpoint",
      ], 400);
    }

    return response()->json([
      "success" => true,
      "message" => "Success submitting checkpoint",
      "data" => $submitCheckpoint,
    ], 201);
  }

  public function getCheckpoints(Request $req)
  {
    $userId = $req->input('user_id');

    $checkpoints = $this->checkpointModel->getUserCheckpoints($userId);

    return response()->json([
      "success" => true,
      "message" => "Success getting checkpoints",
      "data" => $checkpoints,
    ], 200);
  }
}
