<x-mail::message>
# New Contact Form

## Name: {{ $contactData['name']}}
## Email: {{ $contactData['email']}}
## Subject: {{ $contactData['subject']}}
## Message
 {{ $contactData['message']}}

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
