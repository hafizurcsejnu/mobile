Hi,
You are Trying to reset you password for your account "{{$email_data['email']}}".
<br>Please click the below link to reset pasword.
<br><br>
<a href="{{env('APP_URL')}}new-password?code={{$email_data['reset_pass_code']}}">Reset Password Link</a>
<br><br>

Thank you!
<br>
{{env('APP_NAME')}} Team.
