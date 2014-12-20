<div id="leaders" class="ajax-replace">
    <div id="page-title" style="display:none">{{ $title }}</div>
    <div id="profile_update">
        <div>
            <h1>User Profile</h1>
        </div>
        {{ Form::open(['url'=>'users/profile', 'method'=>'POST', 'files'=>true, 'class'=>'no-ajax']) }}
        <div class="clearBoth"></div>
        <div class="floatLeft picture_update">
            {{ HTML::image(Profile::photo()) }} <br> <br>
            {{ Form::label('image', 'Change Picture: ') }}
            {{ Form::file('image') }}<br><br>
        </div>

        <div class="floatLeft profile_update">
            {{ Form::label('First Name: ') }}
            {{ Form::text('first_name', (isset($user->first_name)) ? $user->first_name : Input::old('first_name')) }}<br><br>

            {{ Form::label('Last Name: ') }}
            {{ Form::text('last_name', (isset($user->last_name)) ? $user->last_name : Input::old('last_name')) }}<br><br>

            {{ Form::label('Username: ') }}
            {{ Form::text('username', (isset($user->username)) ? $user->username : Input::old('username')) }}<br><br>

            @if (isset($user->id) && $user->uid == 0)
                {{ Form::label('Password: ') }}
                {{ Form::password('password') }}<br><br>

                {{ Form::label('Re-enter Password: ') }}
                {{ Form::password('password-re') }}<br><br>
            @endif

            {{ Form::hidden('email', $user->email) }}

            {{ Form::Submit('Save') }}
            <a href="{{URL::to('users/me')}}">Cancel</a>
        </div>
        <div class="clearBoth"></div>
    </div>
        {{ Form::close() }}

    <div class="clearBoth"></div>
</div>
