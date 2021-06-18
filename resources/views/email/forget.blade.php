<style>
h1 {
    color: red;
    text-align: center
}
</style>

<h1>Your Masterkey Password Reset Link</h1>
<p>Please click the link below to reset your password</p>
<a href="{{ url('resetpassword/' . $token) }}">Reset Password</a>