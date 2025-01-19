<?php

namespace App\Http\Controllers;

use App\Mail\VerificationMail;
use App\Mail\ForgotPassMail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Models\User;


class AuthController extends Controller
{
    private function clearAuthSessions($cacheKey = null)
    {
        session()->forget([
            'registration_session',
            'login_session',
            'reset_session'
        ]);
    }
    public function showResetPassword(Request $request)
    {
        session([
            'reset_session' => [
                'token' => $request->token,
                'email' => $request->email
            ]
        ]);

        return view('auth.resetPassword', [
            'token' => $request->token,
            'email' => $request->email
        ]);
    }
    public function showForgetPassword()
    {
        return view('auth.forgetPassword');
    }
    public function showLogin()
    {
        $this->clearAuthSessions();
        return view('auth.login');
    }
    public function showVerifyLogin()
    {
        $login_session = session('login_session');
        if (!session('login_session')) {
            return redirect()->route('auth.login')
                ->with('error', 'Please login first.');
        }
        $email = $login_session['email'];
        return view('auth.loginVerify',compact('email'));
    }
    public function showRegister()
    {
        //3232323
        session()->forget('registration_complete');
        return view('auth.register');
    }
    public function showeVerify()
    {
        if (!session('registration_session')) {
            return redirect()->route('register')
                ->with('error', 'Please complete registration first.');
        }
        return view('auth.eVerify');
    }
    public function showVerifySuccess()
    {
        if (!session('registration_session.verified')) {
            return redirect()->route('auth.login')
                ->with('error', 'Please verify your email first.');
        }
        return view('auth.registerSuccess');
    }
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
            'terms_accepted' => 'required|accepted',
        ], [
            'email.required' => 'Email address is required',
            'email.email' => 'Please enter a valid email address',
            'password.required' => 'Password is required',
            'terms_accepted.required' => 'You must accept the terms and conditions',
            'terms_accepted.accepted' => 'You must accept the terms and conditions',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Check if user exists and credentials are correct
        if (!Auth::validate(['email' => $request->email, 'password' => $request->password])) {
            return redirect()->back()
                ->withErrors(['credentials' => 'Invalid email or password. Please try again.'])
                ->withInput();
        }

        try {
            $user = User::where('email', $request->email)->first();
            // Generate verification code
            $verificationCode = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);

            // Prepare user data for cache
            $userData = [
                'first_name' => $request->first_name,
                'email' => $request->email,
                'password' => $request->password, // Store original password for re-authentication
                'verification_code' => $verificationCode,
                'verification_expires_at' => now()->addMinutes(15)
            ];

            Cache::put('verify_login_' . $request->email, $userData, now()->addMinutes(15));

            session([
                'login_session' => [
                    'email' => $request->email,
                    'expires_at' => now()->addMinutes(15)
                ]
            ]);
            // Send verification email
            Mail::to($request->email)->send(new VerificationMail($verificationCode, $user->first_name,));

            return redirect()->route('auth.verifyLogin')
                ->with('success', 'Please check your email for the verification code.');

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to process login. Please try again.'
            ], 500);
        }
    }
    public function verifyLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|numeric|digits:6',
        ], [
            'code.required' => 'The verification code is required.',
            'code.numeric' => 'The verification code must be a number.',
            'code.digits' => 'The verification code must be 6 digits.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // Get email from session
        $email = session('login_session.email');
        if (!$email) {
            return response()->json([
                'success' => false,
                'message' => 'Login session expired.'
            ], 400);
        }

        // Get cached data
        $cacheKey = 'verify_user_' . $email;
        $userData = Cache::get('verify_login_' . $email);

        if (!$userData) {
            return response()->json([
                'success' => false,
                'message' => 'Verification session expired. Please login again.'
            ], 400);
        }

        // Verify code hasn't expired
        $expiresAt = Carbon::parse($userData['verification_expires_at']);
        if (now()->gt($expiresAt)) {
            $this->clearAuthSessions($cacheKey);
            return response()->json([
                'success' => false,
                'message' => 'Verification code has expired. Please login again.'
            ], 400);
        }

        // Verify code matches
        if ($userData['verification_code'] === $request->code) {
            if (Auth::attempt(['email' => $userData['email'], 'password' => $userData['password']])) {
                Cache::forget('verify_login_' . $email);
                $this->clearAuthSessions();

                return response()->json([
                    'success' => true,
                    'redirect' => route('dashboard')
                ]);
            }
        }

        return response()->json([
            'success' => false,
            'message' => 'Invalid verification code.'
        ], 400);
    }
    public function resendVerificationLogin(Request $request)
    {
        $email = session('registration_complete');
        if (!$email) {
            return response()->json([
                'success' => false,
                'message' => 'Session expired. Please login again.'
            ], 400);
        }

        try {
            $verificationCode = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);

            // Update cached data with new code
            $cacheKey = 'verify_user_' . $email;
            $userData = Cache::get($cacheKey);

            if (!$userData) {
                return response()->json([
                    'success' => false,
                    'message' => 'Session expired. Please login again.'
                ], 400);
            }

            $userData['verification_code'] = $verificationCode;
            $userData['verification_expires_at'] = now()->addMinutes(15);

            Cache::put($cacheKey, $userData, now()->addMinutes(15));

            // Send new verification email
            Mail::to($email)->send(new VerificationMail($verificationCode, $request->first_name));

            return response()->json([
                'success' => true,
                'message' => 'New verification code sent to your email.'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to resend verification code. Please try again.'
            ], 500);
        }
    }
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        $this->clearAuthSessions();
        return redirect()->route('auth.login');
    }
    public function register(Request $request)
    {
        // Validation (existing code remains the same)
        $validator = Validator::make($request->all(), [
            'first_name' => ['regex:/\S/', 'required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255', 'regex:/\S/'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                'unique:users,email',
                'regex:/^[\w.+-]+@gmail\.com$/'
            ],
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]+$/'
            ],
        ], [
            // Custom error messages
            'first_name.required' => 'First name is required.',
            'first_name.string' => 'First name must be a valid string.',
            'first_name.max' => 'First name may not exceed 255 characters.',
            'first_name.regex' => 'First name must not be empty.',

            'last_name.required' => 'Last name is required.',
            'last_name.string' => 'Last name must be a valid string.',
            'last_name.max' => 'Last name may not exceed 255 characters.',
            'last_name.regex' => 'Last name must not be empty.',

            'email.required' => 'Email is required.',
            'email.string' => 'Email must be a valid string.',
            'email.email' => 'Please provide a valid email address.',
            'email.max' => 'Email may not exceed 255 characters.',
            'email.unique' => 'This email is already registered.',
            'email.regex' => 'Please use a Gmail address (e.g., example@gmail.com).',

            'password.required' => 'Password is required.',
            'password.string' => 'Password must be a valid string.',
            'password.min' => 'Password must be at least 8 characters long.',
            'password.confirmed' => 'Passwords do not match.',
            'password.regex' => 'Password must contain at least 1 uppercase letter, 1 lowercase letter, 1 number, and 1 special character (e.g., !@#$%^&*).',
        ]);

        // Check validation
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator) // Adds errors to the session
                ->withInput();          // Retains the input data
        }
        // Generate verification code
        $verificationCode = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);

        // Prepare user data for temporary storage
        $userData = [
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'verification_code' => $verificationCode,
            'verification_expires_at' => now()->addMinutes(15)
        ];

        // Temporarily store user data using the email as a unique key
        $cacheKey = 'verify_user_' . $request->email;
        Cache::put($cacheKey, $userData, now()->addMinutes(15));

        session([
            'registration_session' => [
                'email' => $request->email,
                'verified' => false,
                'expires_at' => now()->addMinutes(15)
            ]
        ]);
        // Send verification email
        Mail::to($request->email)->send(new VerificationMail($verificationCode, $request->first_name));

        return redirect()->route('auth.eVerifyget')
            ->with('success', 'Please check your email for the verification code.');

    }
    public function verify(Request $request)
    {
        // Validate the verification code input
        $validator = Validator::make($request->all(), [
            'code' => 'required|numeric|digits:6',
        ], [
            'code.required' => 'The verification code is required.',
            'code.numeric' => 'The verification code must be a number.',
            'code.digits' => 'The verification code must be 6 digits.',
        ]);

        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $email = session('registration_session.email');
        if (!$email) {
            return response()->json([
                'success' => false,
                'message' => 'Registration session expired.'
            ], 400);
        }

        // Retrieve cached user data
        $cacheKey = 'verify_user_' . $email;
        $userData = Cache::get('verify_user_' . $email);

        if (!$userData) {
            return response()->json([
                'success' => false,
                'message' => 'Verification session expired. Please register again.'
            ], 400);
        }

        // Check if user data exists and is not expired
        $expiresAt = Carbon::parse($userData['verification_expires_at']);
        if (now()->gt($expiresAt)) {
            // Clear the session
            session()->forget('registration_complete');
            Cache::forget($cacheKey);

            return response()->json([
                'success' => false,
                'message' => 'Verification code has expired. Please register again.'
            ], 400);
        }

        // Verify the code
        if ($userData['verification_code'] === $request->code) {
            $user = User::create([
                'first_name' => $userData['first_name'],
                'last_name' => $userData['last_name'],
                'email' => $userData['email'],
                'password' => $userData['password'],
                'email_verified_at' => now()
            ]);

            Cache::forget('verify_user_' . $email);

            session([
                'registration_session.verified' => true
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Verification successful.',
                'redirect' => route('auth.registerSuccess')
            ]);
        }
        return response()->json([
            'success' => false,
            'message' => 'Invalid verification code.'
        ], 400);
    }
    public function resendVerification()
    {
        $email = session('registration_complete');
        if (!$email) {
            return response()->json([
                'success' => false,
                'message' => 'No pending verification found.'
            ], 400);
        }

        $userData = Cache::get('verify_user_' . $email);
        if (!$userData) {
            return response()->json([
                'success' => false,
                'message' => 'Verification session expired. Please register again.'
            ], 400);
        }

        // Generate new verification code
        $newVerificationCode = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);

        // Update cached data with new code
        $userData['verification_code'] = $newVerificationCode;
        $userData['verification_expires_at'] = now()->addMinutes(15);

        Cache::put('verify_user_' . $email, $userData, now()->addMinutes(15));

        // Send new verification email
        Mail::to($email)->send(new VerificationMail($newVerificationCode, $userData['first_name']));

        return response()->json([
            'success' => true,
            'message' => 'New verification code sent to your email.'
        ]);
    }
    public function showResetSuccess()
    {
        if (!session('reset_session.completed')) {
            return redirect()->route('forgot.password');
        }
        return view('auth.resetsuccess');
    }
    public function forgotPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|regex:/^[\w.+-]+@gmail\.com$/',
        ], [
            'email.required' => 'Email address is required',
            'email.email' => 'Please enter a valid email address',
            'email.regex' => 'Please use a Gmail address (e.g., example@gmail.com).',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Check if the user exists
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return redirect()->back()
                ->withErrors(['email' => 'No account found with this email address.'])
                ->withInput();
        }

        try {
            // Generate a unique token
            Log::info('Generating password reset token');
            $token = \Illuminate\Support\Str::random(60);

            // Save the token in the `password_resets` table
            DB::table('password_resets')->updateOrInsert(
                ['email' => $request->email],
                [
                    'token' => Hash::make($token),
                    'created_at' => now(),
                ]
            );

            // Generate the password reset link
            $resetLink = route('reset.password', ['token' => $token, 'email' => $request->email]);

            Mail::to($request->email)->send(new ForgotPassMail($resetLink));

            session(['password_reset_email' => $request->email]);
            // Redirect with success message
            return redirect()->route('auth.login')
                ->with('success', 'Password reset link has been sent to your email.');

        } catch (\Exception $e) {
            Log::error('Password reset error: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Failed to send reset link. Please try again.');
        }
    }
    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'token' => 'required',
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]+$/'
            ],
        ], [
            'email.required' => 'Email address is required',
            'email.email' => 'Please enter a valid email address',
            'token.required' => 'Invalid password reset link',
            'password.required' => 'Password is required',
            'password.string' => 'Password must be a valid string',
            'password.min' => 'Password must be at least 8 characters long',
            'password.confirmed' => 'Passwords do not match',
            'password.regex' => 'Password must contain at least 1 uppercase letter, 1 lowercase letter, 1 number, and 1 special character (e.g., !@#$%^&*)',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return redirect()->back()
                ->withErrors(['email' => 'No account found with this email address.'])
                ->withInput();
        }

        $token = DB::table('password_resets')
            ->where('email', $request->email)
            ->first();

        if (!$token || !Hash::check($request->token, $token->token)) {
            return redirect()->back()
                ->withErrors(['token' => 'Invalid reset link.']);
        }

        $expiresAt = Carbon::parse($token->created_at)->addMinutes(60);
        if (now()->gt($expiresAt)) {
            return redirect()->back()
                ->withErrors(['token' => 'Password reset link has expired. Please request a new one.'])
                ->withInput();
        }

        $user->update(['password' => Hash::make($request->password)]);

        DB::table('password_resets')
            ->where('email', $request->email)
            ->delete();

        session(['password_resets.completed' => true]);

        return redirect()->route('auth.resetSuccess');
    }
}

