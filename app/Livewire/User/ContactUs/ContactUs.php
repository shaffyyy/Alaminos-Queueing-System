<?php

namespace App\Livewire\User\ContactUs;

use App\Mail\ContactUsMail;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class ContactUs extends Component
{
    public $name;
    public $email;
    public $subject;
    public $message;

    protected $rules = [
        'name' => 'required|string|min:3|max:255',
        'email' => 'required|email',
        'subject' => 'required|string|min:3|max:255',
        'message' => 'required|string|min:3|max:1000',
    ];

     public function updated($propertyName){
        $this->validateOnly($propertyName); 
     }

    public function submitContactForm()
    {
        $validateDate = $this->validate();
    
        // Prepare email data
        // $emailData = [
        //     'name' => $this->name,
        //     'email' => $this->email,
        //     'subject' => $this->subject,
        //     'message' => $this->message,
        // ];
    
        // Capture the subject to pass explicitly to the closure
        // $emailSubject = $this->subject;
    
        // Send email
        // Mail::send('emails.contact-mail', $emailData, function ($mail) use ($emailSubject) {
        //     $mail->from(config('mail.from.address'), config('mail.from.name'))
        //         ->to('lattolatto0415@gmail.com') // Replace with the support email address
        //         ->subject($emailSubject); // Use the explicitly passed subject
        // });

        try {
            Mail::to('lattolatto0415@gmail.com')->send(New ContactUsMail($validateDate));
    
            // Show success message and reset form fields
            session()->flash('message', 'Thank you for reaching out. We will get back to you soon!');
            
        } catch (\Throwable $th) {
            session()->flash('error', 'Failed to send message');
        }

            $this->reset();
    }
    

    public function render()
    {
        return view('livewire.user.contact-us.contact-us');
    }
}
