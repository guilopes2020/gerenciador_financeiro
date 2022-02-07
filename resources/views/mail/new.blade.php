<ul>
    @foreach ($users as $user )
        <li>email: {{$user->email}}</li>
    @endforeach
</ul>
