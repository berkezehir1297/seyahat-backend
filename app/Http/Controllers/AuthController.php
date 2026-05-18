<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{
    // --- Kayıt Fonksiyonu ---
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json(['message' => 'Kullanıcı başarıyla kaydedildi', 'user' => $user], 201);
    }

    // --- Giriş Fonksiyonu ---
    public function login(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Hatalı e-posta veya şifre'], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Giriş başarılı',
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user
        ]);
    }

    // --- Şifre Sıfırlama Bağlantısı Gönder ---
    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['message' => 'Bu e-posta adresi sistemde kayıtlı değil.'], 404);
        }

        $token = Str::random(64);

        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            [
                'email' => $request->email,
                'token' => $token,
                'created_at' => now()
            ]
        );

        $resetLink = 'https://seyahat-frontend.onrender.com/reset-password?token=' . $token . '&email=' . $request->email;

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . env('BREVO_API_KEY'),
                'Content-Type' => 'application/json',
            ])->post('https://api.brevo.com/v3/smtp/email', [
                'sender' => ['name' => 'Seyahat Planlama', 'email' => 'berkezehir12@gmail.com'],
                'to' => [['email' => $request->email]],
                'subject' => 'Seyahat Planlama - Şifre Sıfırlama Talebi',
                'htmlContent' => "
                    <div style='font-family: Arial, sans-serif; padding: 20px; border: 1px solid #eee;'>
                        <h2 style='color: #0d6efd;'>Şifrenizi Sıfırlayın</h2>
                        <p>Merhaba, şifrenizi sıfırlamak için bir talep aldık. Aşağıdaki butona tıklayarak yeni şifrenizi belirleyebilirsiniz:</p>
                        <a href='{$resetLink}' style='display: inline-block; padding: 10px 20px; background-color: #0d6efd; color: #fff; text-decoration: none; border-radius: 5px; margin-top: 10px;'>Şifremi Sıfırla</a>
                        <p style='margin-top: 20px; font-size: 12px; color: #777;'>Eğer bu talebi siz yapmadıysanız, lütfen bu e-postayı dikkate almayın.</p>
                    </div>
                ",
            ]);

            return response()->json([
                'message' => 'Şifre sıfırlama maili başarıyla gönderildi.',
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Mail gönderilirken bir hata oluştu: ' . $e->getMessage()], 500);
        }
    }

    // --- Yeni Şifreyi Kaydet ---
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
            'token' => 'required'
        ]);

        $resetData = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->where('token', $request->token)
            ->first();

        if (!$resetData) {
            return response()->json(['message' => 'Geçersiz veya süresi dolmuş token.'], 400);
        }

        $user = User::where('email', $request->email)->first();
        if ($user) {
            $user->password = Hash::make($request->password);
            $user->save();

            DB::table('password_reset_tokens')->where('email', $request->email)->delete();

            return response()->json(['message' => 'Şifreniz başarıyla güncellendi. Yeni şifrenizle giriş yapabilirsiniz.']);
        }

        return response()->json(['message' => 'Kullanıcı bulunamadı.'], 404);
    }
}