{{ Form::open(['url'=>'users/login', 'method'=>'POST'])}}

    {{ Form::text('email', Input::old('email'), ['placeholder' => 'Email Address']) }}

    {{ Form::password('password', ['placeholder' => 'Password']) }}

    {{ Form::submit('Log In', ['id' => 'login']) }}

{{ Form::close() }}
