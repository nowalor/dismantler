@component('mail::message')
    # New Contact Us Message

    You have received a new message from your website's contact form.

    **Name:** {{ $senderName }}

    **Email:** {{ $senderEmail }}

    **Subject:** {{ $senderSubject }}

    **Phone:** {{ $phone }}

    **Number plate:** {{ $plate }}

    **Phone:** {{ $vin }}

    **Message:**
    {{ $message }}

@endcomponent
