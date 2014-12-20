{{ Form::open(['url'=>'users/signup', 'method'=>'POST'])}}

    {{ Form::text('email', Input::old('email'), ['placeholder' => 'Email Address']) }}

    {{ Form::password('password', ['placeholder' => 'Password']) }}

    {{ Form::password('password-re', ['placeholder' => 'Confirm Password']) }}

    {{ Form::submit('Sign Up', ['id' => 'register']) }}

{{ Form::close() }}
