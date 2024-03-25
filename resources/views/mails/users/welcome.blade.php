<x-mail::message>
# Hey {{ $user->name }},

Thanks for signing up for our Jarvis CRM! You're joining an amazing community of beauty lovers. From now on you'll enjoy:

Find your account details bellow:

<x-mail::table>
| Name              | Email             |
| -------------     | -----------------:|
| {{ $user->name }} | {{ $user->email }}| 
</x-mail::table>

<x-mail::button :url="$url">
Visit For More Info
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
