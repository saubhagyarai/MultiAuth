To verify email click here <a
    href="{{route('sendEmailDone', ["email" => $user->email, "verifyToken"=> $user->verifyToken])}}">click here</a>