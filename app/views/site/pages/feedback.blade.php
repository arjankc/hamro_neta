<div id="terms_conditions">
    <h1>Provide Us Feedback</h1>
    <div id="page-title" style="display:none">{{ $title }}</div>

    <div id="feedback">
        <?php
            $user = (Sentry::check()) ? Sentry::getUser() : null;
            if ($user) {
                $user->name = $user->first_name . ' ' . $user->last_name;
            }
        ?>
        {{ Form::open(['pages/feedback', 'POST', 'id' => 'feedback']) }}

            <label>Name:</label>
            {{ Form::text('name', (isset($user->name)) ? $user->name : Input::old('name')) }}

            <label>Address:</label>
            {{ Form::text('address', Input::old('address')) }}

            <label>Email:</label>
            {{ Form::text('email', (isset($user->email)) ? $user->email : Input::old('email')) }}

            <label>Phone Number:</label>
            {{ Form::text('phone', Input::old('phone')) }}

            <label>Queries:</label>
            {{ Form::textarea('queries', '') }}

            {{ Form::Submit('Submit Feedback') }}
        {{ Form::close() }}
    </div>

</div>
