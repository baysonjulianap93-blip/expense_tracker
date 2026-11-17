<?php
// Login, register and logout
class AuthController extends Controller
{
    public function login(): void
    {
        // Logged-in users don't need the login page
        if (isset($_SESSION['user_id'])) {
            $this->redirectTo('dashboard');
        }

        $message     = '';
        $messageType = '';
        $email       = '';

        if (isset($_GET['registered'])) {
            $message     = 'Account created successfully! You can now log in.';
            $messageType = 'success';
        }

        if ($this->isPost()) {
            $email    = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            if ($email === '' || $password === '') {
                $message     = 'Please complete all required fields.';
                $messageType = 'warning';
            } else {
                $user = (new User())->findByEmail($email);

                if ($user && password_verify($password, $user['password'])) {
                    // New session id on login prevents session fixation
                    session_regenerate_id(true);

                    $_SESSION['user_id']   = $user['user_id'];
                    $_SESSION['full_name'] = $user['full_name'];
                    $_SESSION['email']     = $user['email'];

                    $this->redirectTo('dashboard');
                }

                $message     = 'Invalid email or password.';
                $messageType = 'error';
            }
        }

        $this->render('login', [
            'message'      => $message,
            'messageType'  => $messageType,
            'message_type' => $messageType,
            'email'        => $email,
            'error'        => $messageType === 'error' ? $message : '',
            'registered'   => isset($_GET['registered']),
        ], false);
    }

    public function register(): void
    {
        $message     = '';
        $messageType = '';
        $fullName    = '';
        $email       = '';

        if ($this->isPost()) {
            $fullName        = trim($_POST['full_name'] ?? '');
            $email           = trim($_POST['email'] ?? '');
            $password        = $_POST['password'] ?? '';
            $confirmPassword = $_POST['confirm_password'] ?? '';

            $users = new User();

            if ($fullName === '' || $email === '' || $password === '' || $confirmPassword === '') {
                $message     = 'Please complete all required fields.';
                $messageType = 'warning';
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $message     = 'Please enter a valid email address.';
                $messageType = 'warning';
            } elseif (strlen($password) < 8) {
                $message     = 'Password must be at least 8 characters.';
                $messageType = 'warning';
            } elseif ($password !== $confirmPassword) {
                $message     = 'Passwords do not match.';
                $messageType = 'warning';
            } elseif ($users->emailExists($email)) {
                $message     = 'This email is already registered.';
                $messageType = 'error';
            } elseif ($users->create($fullName, $email, $password)) {
                $this->redirectTo('login', ['registered' => 1]);
            } else {
                $message     = 'Registration failed. Please try again.';
                $messageType = 'error';
            }
        }

        $this->render('register', [
            'message'      => $message,
            'messageType'  => $messageType,
            'message_type' => $messageType,
            'error'        => $messageType === 'error' ? $message : '',
            'full_name'    => $fullName,
            'email'        => $email,
        ], false);
    }

    // Clear session data, end the session, go back to login
    public function logout(): void
    {
        $_SESSION = [];
        session_destroy();
        $this->redirectTo('login');
    }
}
