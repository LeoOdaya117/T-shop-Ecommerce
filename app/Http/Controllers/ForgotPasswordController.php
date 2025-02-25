<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Models\PasswordReset;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ForgotPasswordController extends Controller
{
    // Step 1: Send OTP via Email
    public function sendOTP(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $user = User::where('email', $request->email)->first();
        $otp = rand(100000, 999999); // Generate a 6-digit OTP

        // Store OTP in the database
        PasswordReset::updateOrCreate(
            ['email' => $user->email],
            [
                'token' => $otp,
                'created_at' => Carbon::now(),
            ]
        );

        // Send OTP via email
        Mail::raw("Your OTP for password reset is: $otp", function ($message) use ($user) {
            $message->to($user->email)->subject('Password Reset OTP');
        });

        return response()->json(['message' => 'OTP sent to your email.']);
    }

    // Step 2: Verify OTP
    public function verifyOTP(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'otp' => 'required|integer'
        ]);

        $record = PasswordReset::where('email', $request->email)
            ->where('token', $request->otp)
            ->first();

        if (!$record) {
            return response()->json(['message' => 'Invalid OTP'], 400);
        }

        return response()->json(['message' => 'OTP verified successfully.']);
    }

    // Step 3: Reset Password
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'otp' => 'required|integer',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $record = PasswordReset::where('email', $request->email)
            ->where('token', $request->otp)
            ->first();

        if (!$record) {
            return response()->json(['message' => 'Invalid OTP'], 400);
        }

        // Update user password
        $user = User::where('email', $request->email)->first();
        $user->password = Hash::make($request->password);
        $user->save();

        // Delete OTP record after successful reset
        $record->delete();

        return response()->json(['message' => 'Password has been reset successfully.']);
    }
}
