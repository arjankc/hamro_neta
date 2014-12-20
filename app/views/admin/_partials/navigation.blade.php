@if (Sentry::check())
	<ul class="nav">
        <li class="{{ Request::is('admin/posts*') ? 'active' : null }}"><a href="{{ URL::route('admin.posts.index') }}"><i class="icon-book"></i> Pages</a></li>
		<li class="{{ Request::is('admin/candidates*') ? 'active' : null }}"><a href="{{ URL::to('admin/candidates') }}"><i class="icon-book"></i> Edit Candidates Votes</a></li>
		<li><a href="{{ URL::to('users/logout') }}"><i class="icon-lock"></i> Logout</a></li>
	</ul>
@endif
