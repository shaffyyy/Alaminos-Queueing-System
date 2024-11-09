<?php

namespace App\Livewire\User\ContactUs;

use Livewire\Component;

class ContactUs extends Component
{
    public $name;
    public $email;
    public $subject;
    public $message;

    protected $rules = [
        'name' => 'required|min:3',
        'email' => 'required|email',
        'subject' => 'required|min:3',
        'message' => 'required|min:10',
    ];

    public function submitContactForm()
    {
        $this->validate();

        // Process form data (e.g., send email)
        // Mail::to('support@yourdomain.com')->send(new ContactMail($this->name, $this->email, $this->subject, $this->message));

        session()->flash('message', 'Thank you for reaching out. We will get back to you soon!');
        $this->reset();
    }
    public function render()
    {
        return view('livewire.user.contact-us.contact-us');
    }
}
