@switch($user->locale)
    @case('nl')
Hallo {{ $user->name }},

Vergeet je niet om de top 10 voor de {{ $race->name }} door te geven?

Je hebt nog {{ $race->weekend_start->diffInHours() }} uur om dit te doen!
    @break

    @case('en')
    @default
Hi {{ $user->name }},

This is a friendly reminder that you haven't picked yet for the {{ $race->name }}.

You have less then {{ $race->weekend_start->diffInHours() }} hours to do so!
    @break
@endswitch
