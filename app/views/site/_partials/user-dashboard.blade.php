<div id="page-title" style="display:none">{{ $title }}</div>


<div id="profile_update">

    <div>
        <h2>User Profile</h2>
    </div>

    <div class="floatLeft picture_update">
        {{ HTML::image(Profile::photo()) }}<br> <br>
    </div>

    <div class="floatLeft profile_update">
        {{ Form::label('First Name: ') }}
        {{ (isset($user->first_name)) ? $user->first_name : 'Unspecified' }}<br><br>

        {{ Form::label('Last Name: ') }}
        {{ (isset($user->last_name)) ? $user->last_name : 'Unspecified' }}<br><br>

        {{ Form::label('Username: ') }}
        {{ (isset($user->username)) ? $user->username : 'Unspecified' }}<br><br>

        {{ Form::label('Email: ') }}
        {{ (isset($user->email)) ? $user->email : 'Unspecified' }}<br><br>

        <div class="ajax">
            {{ HTML::link(URL::to('users/profile'), 'Edit Profile') }}
        </div>
        {{ HTML::link(URL::to('users/logout'), 'Logout') }}
    </div>

    <div class="clearBoth"></div>

    <div>
        <h2>User Voting Log</h2>
    </div>
    <div id="page-title" style="display:none">{{ $title }}</div>

    @if (!$votes)
        <p>You have not voted for anybody yet.</p>
    @endif
    @if ($votes)
        @foreach ($votes as $vote)
            <p class="ajax log">
                You voted for {{ HTML::link(URL::to('candidates/' . $vote->leader_id), Candidate::name($vote->leader_id)) }} <span class="date-time">{{ $vote->created_at }}</span>
                <?php $value_this = str_replace("-", "", substr($vote->created_at->toDateTimeString(), 0, 10)); ?>
            </p>
        @endforeach
    @endif

    <div class="clearBoth"></div>

</div>


