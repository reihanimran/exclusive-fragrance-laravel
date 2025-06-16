<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\ContactMessage;
use Livewire\Attributes\Validate;

class ContactForm extends Component
{
    #[Validate('required|string|min:2|max:255')]
    public string $name = '';

    #[Validate('required|email|max:255')]
    public string $email = '';

    #[Validate('nullable|string|max:20')]
    public string $phone = '';

    #[Validate('required|string|min:3|max:255')]
    public string $subject = '';

    #[Validate('required|string|min:10|max:2000')]
    public string $message = '';

    public bool $showSuccessMessage = false;

    public function submitForm(): void
    {
        $this->validate();

        try {
            ContactMessage::create([
                'name'    => $this->name,
                'email'   => $this->email,
                'phone'   => $this->phone,
                'subject' => $this->subject,
                'message' => $this->message,
                'status'  => 'pending',
            ]);

            $this->reset(['name', 'email', 'phone', 'subject', 'message']);
            $this->showSuccessMessage = true;

            // Dispatch frontend event to optionally auto-hide success banner
            $this->dispatch('contact-submitted');

        } catch (\Exception $e) {
            $this->addError('form', 'There was an error submitting your message. Please try again.');
            
        }
    }

    public function hideSuccessMessage(): void
    {
        $this->showSuccessMessage = false;
    }

    public function render()
    {
        return view('livewire.contact-form');
    }
}
