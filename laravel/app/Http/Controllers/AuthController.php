<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\VerifyRequest;
use App\Repositories\UserRepository;
use App\Services\NotificationService;
use App\Services\VerificationService;

class AuthController extends Controller
{
    private UserRepository $userRepository;
    private VerificationService $verificationService;
    private NotificationService $notificationService;

    public function __construct(UserRepository      $userRepository,
                                VerificationService $verificationService,
                                NotificationService $notificationService)
    {
        $this->userRepository = $userRepository;
        $this->verificationService = $verificationService;
        $this->notificationService = $notificationService;
    }

    public function loginForm()
    {
        return view('auth.login');
    }

    public function login(LoginRequest $request)
    {
        $identity = $request->validated()['identity'];
        if ($this->verificationService->hasRecentVerificationCode($identity) && !$this->verificationService->canRequestAgain($identity)) {
            return back()->withErrors(['message' => 'A verification code was sent recently. Please wait before requesting another.']);
        }

        $verificationCode = $this->verificationService->generateVerificationCode();

        $userData = [];
        if (filter_var($identity, FILTER_VALIDATE_EMAIL)) {
            $userData['email'] = $identity;
        } elseif (preg_match("/^\+?[1-9]\d{1,14}$/", $identity)) {
            $userData['mobile'] = $identity;
        } elseif (preg_match("/^@[a-zA-Z0-9_]+$/", $identity)) {
            $userData['telegram'] = $identity;
        }
        $user = $this->userRepository->findByIdentity($identity);
        if ($user) {
            $user->update($userData);
        } else {
            $this->userRepository->create($userData);
        }

        $notificationMethod = $this->getNotificationMethod($identity);
        $this->notificationService->sendVerificationNotification($notificationMethod, $identity, $verificationCode);
        $this->verificationService->cacheVerificationCode($identity, $verificationCode);

        return redirect()->route('verify.form')->with(['identity' => $identity, 'message' => 'Verification code sent successfully. Please enter the code to verify your account.']);
    }

    public function verifyForm()
    {
        $identity = session('identity');
        return view('auth.verify', compact('identity'));
    }

    public function verify(VerifyRequest $request)
    {
        $identity = $request->identity ?? session('identity');
        if (!$identity) {
            return redirect()->back()->withErrors(['identity' => 'The identity field is required.']);
        }

        $otpCode = $request->otp_code;
        if (!$this->verificationService->verifyCode($identity, $otpCode)) {
            return redirect()->back()->withErrors(['otp_code' => 'Invalid verification code or code does not match for the provided identity.']);
        }

        $this->verificationService->clearVerificationCode($identity);

        $user = $this->userRepository->findByIdentity($identity);
        if (!$user) {
            return redirect()->route('login.form')->withErrors(['identity' => 'User not found.']);
        }
        return redirect()->route('dashboard')->with(['message' => 'Welcome back to the dashboard.']);
    }

    private function getNotificationMethod(string $identity): string
    {
        if (filter_var($identity, FILTER_VALIDATE_EMAIL)) {
            return 'mail';
        } elseif (preg_match("/^\+?[1-9]\d{1,14}$/", $identity)) {
            return 'sms';
        } elseif (preg_match("/^@[a-zA-Z0-9_]+$/", $identity)) {
            return 'telegram';
        } else {
            throw new \InvalidArgumentException("Unsupported input type");
        }
    }

}
