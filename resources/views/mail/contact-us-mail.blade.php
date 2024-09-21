@component('mail::message')
    # New Contact Us Message

    You have received a new message from your website's contact form.

    **Name:** {{ $senderName }}

    **Email:** {{ $senderEmail }}

    **Subject:** {{ $senderSubject }}

    **Message:**
    {{ $message }}

@endcomponent
