<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\AppUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Notifications\VerifyEmailWithOTP;

class AppUserController extends Controller {

  public function show($id) {
    $user = AppUser::find($id);

    if ($user === null) {
      return response()->json(['message' => 'User not found'], 404);
    }

    return response()->json($user);
  }

  public function create(Request $request) {

    $name = $request->name;
    $email = $request->email;
    $password = $request->password;

    if (!$name || !$email || !$password || trim($name) === '') {
      return response()->json([
        'message' => 'Name, email and password are required',
      ], 422); // 422 Unprocessable Entity
    }

    $userExists = AppUser::where('name', $request->name)
      ->orWhere('email', $request->email)
      ->exists();

    if ($userExists) {
      return response()->json([
        'message' => 'User with this name or email already exists',
      ], 409); // 409 Conflict
    }

    $password = Hash::make($request->password);

    $appUser = AppUser::create([
      'name' => $name, 'email' => $email, 'password' => $password,
    ]);

    return response()->json([
      'message' => 'User created successfully',
      'user' => $appUser,
    ], 200);
  }

  public function login(Request $request) {

    $email = $request->email;
    $password = $request->password;

    if (!$email || !$password) {
      return response()->json([
        'message' => 'Email and password are required',
      ], 422); // 422 Unprocessable Entity
    }

    $user = AppUser::where('email', $email)->first();

    if (!$user || !Hash::check($password, $user->password)) {
      return response()->json([
        'message' => 'Invalid email or password',
      ], 401); // 401 Unauthorized
    }

    return response()->json([
      'message' => 'User logged in successfully',
      'user' => $user,
    ], 200); // 200 OK
  }

  public function sendEmailOtp(Request $request) {

    $email = $request->email;

    if (!$email) {
      return response()->json(['message' => 'Email is required.'], 422);
    }

    $user = AppUser::where('email', $request->email)->first();

    if (!$user) {
      return response()->json(['message' => 'User not found.'], 404);
    }

    $otp = random_int(10000, 99999); // Generate OTP

    $user->email_otp = $otp;
    $user->email_otp_expires_at = now()->addMinutes(5); // OTP expires in 5 minutes
    $user->save();

    $user->notify(new VerifyEmailWithOTP($otp));

    return response()->json([
      'message' => 'OTP sent!',
      'user' => $user,
    ], 200);
  }

  public function verifyEmailOtp(Request $request) {
    $otp = $request->otp;
    $email = $request->email;

    if (!$otp) {
      return response()->json(['message' => 'OTP is required.'], 422);
    }

    if (!$email) {
      return response()->json(['message' => 'Email is required.'], 422);
    }

    $user = AppUser::where('email', $request->email)->first();

    if (!$user) {
      return response()->json(['message' => 'User not found.'], 404);
    }

    if ($user->email_otp !== $otp) {
      return response()->json(['message' => 'Invalid OTP.'], 401);
    }

    if ($user->email_otp_expires_at < now()) {
      return response()->json(['message' => 'OTP expired.'], 401);
    }

    $user->email_verified = true;
    $user->save();

    return response()->json([
      'message' => 'Email verified!',
      'user' => $user,
    ], 200);
  }

  public function sendPhoneOtp(Request $request) {
    $email = $request->email;
    $phone_number = $request->phone_number;

    $apiKey = env('VONAGE_API_KEY');
    $apiSecret = env('VONAGE_API_SECRET');

    if (!$email) {
      return response()->json(['message' => 'Email is required.'], 422);
    }

    if (!$phone_number) {
      return response()->json(['message' => 'Phone number is required.'], 422);
    }

    $user = AppUser::where('email', $request->email)->first();

    if (!$user) {
      return response()->json(['message' => 'User not found.'], 404);
    }

    $otp = rand(10000, 99999); // Generate OTP

    $user->phone_otp = $otp;
    $user->phone_otp_expires_at = now()->addMinutes(5); // OTP expires in 5 minutes
    $user->save();

    $basic  = new \Vonage\Client\Credentials\Basic($apiKey, $apiSecret);
    $client = new \Vonage\Client($basic);

    $response = $client->sms()->send(
      new \Vonage\SMS\Message\SMS($phone_number, 'Vonage', 'Your OTP is ' . $otp)
    );

    $message = $response->current();

    if ($message->getStatus() == 0) {
      return response()->json([
        'message' => 'OTP sent!',
        'phone_number' => $phone_number,
        'otp' => $otp,
      ], 200);
    }

    if ($message->getStatus() != 0) {
      return response()->json(['message' => 'OTP not sent!'], 500);
    }
  }

  public function verifyPhoneOtp(Request $request) {
    $otp = $request->otp;
    $email = $request->email;
    $phone_number = $request->phone_number;

    if (!$otp) {
      return response()->json(['message' => 'OTP is required.'], 422);
    }

    if (!$email) {
      return response()->json(['message' => 'Email is required.'], 422);
    }

    if (!$phone_number) {
      return response()->json(['message' => 'Phone number is required.'], 422);
    }

    $user = AppUser::where('email', $request->email)->first();

    if (!$user) {
      return response()->json(['message' => 'User not found.'], 404);
    }

    if ($user->phone_otp !== $otp) {
      return response()->json(['message' => 'Invalid OTP.'], 401);
    }

    if ($user->phone_otp_expires_at < now()) {
      return response()->json(['message' => 'OTP expired.'], 401);
    }

    $user->phone_number = $phone_number;
    $user->phone_verified = true;
    $user->save();

    return response()->json([
      'message' => 'Phone verified!',
      'user' => $user,
    ], 200);
  }

  public function update(Request $request, $id) {

    $name = $request->name;
    $location = $request->location;

    if (!$name && !$location) {
      return response()->json([
        'message' => 'Name or location are required',
      ], 422);
    }

    $user = AppUser::find($id);

    if ($user === null) {
      return response()->json(['message' => 'User not found'], 404);
    }

    $user->name = $name;
    $user->location = $location;
    $user->save();

    return response()->json([
      'message' => 'User updated successfully',
      'user' => $user,
    ], 200);
  }

  public function changePassword(Request $request) {
    $email = $request->email;
    $password = $request->password;

    if (!$email || !$password) {
      return response()->json([
        'message' => 'Email and new password are required',
      ], 422); // 422 Unprocessable Entity
    }

    $user = AppUser::where('email', $email)->first();

    if (!$user) {
      return response()->json([
        'message' => 'Invalid email',
      ], 401); // 401 Unauthorized
    }

    $user->password = Hash::make($password);
    $user->save();

    return response()->json([
      'message' => 'Password changed successfully',
      'user' => $user,
    ], 200); // 200 OK
  }

  public function deleteUser($id) {
    error_log('User ID: ' . $id); // Вывод ID в консоль

    $user = AppUser::find($id);

    if ($user === null) {
      return response()->json(['message' => 'User not found'], 404);
    }

    Order::where('user_id', $id)->delete();

    $user->delete();

    return response()->json(['message' => 'User deleted successfully'], 200);
  }
}
