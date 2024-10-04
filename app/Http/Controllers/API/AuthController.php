<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Register a new user.
     *
     * This function handles the registration of a new user. It validates the incoming request,
     * checks for required fields and matching passwords, and then stores the new user's
     * details in the database if validation passes. If validation fails, it returns
     * a JSON response with the validation errors.
     *
     * @param  \Illuminate\Http\Request  $request  The incoming HTTP request containing user registration data.
     * @return \Illuminate\Http\JsonResponse  A JSON response indicating the success or failure of the registration process.
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "name" => "required",
            "email" => "required|email",
            "password" => "required",
            "confirm_password" => "required|same:password",
        ]);

        // If validation fails, return a response with the errors
        if ($validator->fails()) {
            return response()->json([
                "success" => false,
                "message" => "Register failed",
                "data" => $validator->errors()
            ], 422); // HTTP 422 Unprocessable Entity for validation errors
        }

        // Check if the email is already registered
        if (User::where('email', $request->email)->exists()) {
            return response()->json([
                "success" => false,
                "message" => "Email already registered",
                "data" => [
                    "email" => ["The email address is already in use."]
                ]
            ], 409); // HTTP 409 Conflict for resource conflict
        }

        // Hash the password before storing in the database
        $hashedPassword = Hash::make($request->password);

        // Create a new user record in the database
        $user = User::create([
            "name" => $request->name,
            "email" => $request->email,
            "password" => $hashedPassword,
        ]);

        // Generate a personal access token for the user (using Laravel Passport or Sanctum)
        $token = $user->createToken('Personal Access Token')->plainTextToken;

        // Return success response with the user data (name and email) and token
        return response()->json([
            "success" => true,
            "message" => "Register successful",
            "data" => [
                'name' => $user->name,
                'email' => $user->email,
                'token' => $token
            ]
        ], 201); // HTTP 201 Created for successful creation
    }

    /**
     * User login.
     *
     * This function handles user login. It validates the email and password
     * from the incoming request, checks the credentials, and if valid, 
     * generates a plain access token and returns it along with the user's name and email.
     * If the login fails due to invalid credentials, it will return a JSON response
     * indicating the failure.
     *
     * @param  \Illuminate\Http\Request  $request  The incoming HTTP request containing user login credentials.
     * @return \Illuminate\Http\JsonResponse  A JSON response indicating the success or failure of the login attempt,
     *                                        including the user's name, email, and access token if successful.
     */
    public function login(Request $request)
    {
        // Validate the incoming request data
        $validator = Validator::make($request->all(), [
            "email" => "required|email",
            "password" => "required|string",
        ]);

        // If validation fails, return a response with the errors
        if ($validator->fails()) {
            return response()->json([
                "success" => false,
                "message" => "Login failed",
                "data" => $validator->errors()
            ], 422); // HTTP 422 Unprocessable Entity for validation errors
        }

        // Attempt to log in with the provided credentials
        if (!Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            // If authentication fails, return a response indicating incorrect credentials
            return response()->json([
                "success" => false,
                "message" => "Invalid email or password",
            ], 401); // HTTP 401 Unauthorized for invalid credentials
        }

        // Get the authenticated user
        $user = Auth::user();

        // Generate a plain access token for the user
        $token = $user->createToken('Personal Access Token')->plainTextToken;

        // Return success response with user data (name, email) and the plain token
        return response()->json([
            "success" => true,
            "message" => "Login successful",
            "data" => [
                'name' => $user->name,
                'email' => $user->email,
                'token' => $token
            ]
        ], 200); // HTTP 200 OK for successful login
    }

    /**
     * Delete the authenticated user.
     *
     * This function handles the deletion of an authenticated user's account. It validates
     * the request to ensure the user's password is correct. If the password is correct and
     * the user is authenticated via a token, the account will be deleted from the database.
     * Otherwise, a failure response will be returned.
     *
     * Upon successful deletion, the user's name and email will be included in the response.
     *
     * @param  \Illuminate\Http\Request  $request  The incoming HTTP request containing the user's password for confirmation.
     * @return \Illuminate\Http\JsonResponse  A JSON response indicating the success or failure of the deletion attempt.
     */
    public function deleteUser(Request $request)
    {
        // Validate the incoming request data
        $validator = Validator::make($request->all(), [
            "password" => "required|string",
        ]);

        // If validation fails, return a response with the errors
        if ($validator->fails()) {
            return response()->json([
                "success" => false,
                "message" => "Password confirmation failed",
                "data" => $validator->errors()
            ], 422); // HTTP 422 Unprocessable Entity for validation errors
        }

        // Get the authenticated user
        $user = Auth::user();

        // Check if the provided password matches the user's current password
        if (!Hash::check($request->password, $user->password)) {
            // If password doesn't match, return a response indicating incorrect password
            return response()->json([
                "success" => false,
                "message" => "Incorrect password",
            ], 401); // HTTP 401 Unauthorized for invalid password
        }

        // Revoke all tokens for the user (optional: helpful for security before deleting the account)
        $user->tokens()->delete();

        // Store user's name and email before deletion for the response
        $deletedUserName = $user->name;
        $deletedUserEmail = $user->email;

        // Delete the user's account from the database
        $user->delete();

        // Return success response after user deletion with name and email
        return response()->json([
            "success" => true,
            "message" => "User account deleted successfully",
            "data" => [
                'name' => $deletedUserName,
                'email' => $deletedUserEmail,
            ]
        ], 200); // HTTP 200 OK for successful deletion
    }
}
