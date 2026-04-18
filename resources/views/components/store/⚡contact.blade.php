<?php

use App\Models\Contact;
use Livewire\Attributes\Layout;
use Livewire\Component;

new class extends Component
{
    #[Layout('layouts.store')]

    public $name;
    public $email;
    public $contact_number;
    public $subject;
    public $message;

    public function contact() {
        
        $this->validate([
            'name' => 'required',
            'email' => 'required|email',
            'contact_number' => 'required',
            'subject' => 'required',
            'message' => 'required',            
        ]);

        Contact::create([
            'name' => $this->name,
            'email' => $this->email,
            'contact' => $this->contact_number,
            'subject' => $this->subject,
            'message' =>  $this->message,
        ]);
        
        $this->reset();

        $this->dispatch('toast', 
            type: 'success', 
            text: 'Thanks for contacting us. Our Executive will call you soon.'
        );
    }
};
?>

<div class="min-h-screen bg-[#fffef2]">
    <section class="py-16 px-6 bg-[#f6f5e8] text-center">
        <h1 class="hero-medium mb-4">Get in Touch</h1>
        <p class="body-large text-[#666666]">We'd love to hear from you</p>
    </section>
    <section class="py-20 px-6">
        <div class="max-w-[1400px] mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16">
                <div>
                    <h2 class="heading-2 mb-8">Send us a Message</h2>
                    <form class="space-y-6" wire:submit="contact">
                       <div>
                            <label for="name" class="label-theme">NAME</label>
                            <input id="name" name="name" class="input-theme {{ $errors->has('name') ? 'input-error' : 'input-default' }}" type="text" wire:model="name" />
                            @error('name') 
                                <p class="input-error-text">{{ $message }}</p> 
                            @enderror
                        </div>
                        <div>
                            <label for="email" class="label-theme">EMAIL</label>
                            <input id="email" name="email" class="input-theme {{ $errors->has('email') ? 'input-error' : 'input-default' }}" type="email" wire:model="email" />
                            @error('email') 
                                <p class="input-error-text">{{ $message }}</p> 
                            @enderror
                        </div>
                        <div>
                            <label for="contact_number" class="label-theme">CONTACT NUMBER</label>
                            <input id="contact_number" name="contact_number" class="input-theme {{ $errors->has('contact') ? 'input-error' : 'input-default' }}" type="tel" wire:model="contact_number" />
                            @error('contact_number') 
                                <p class="input-error-text">{{ $message }}</p> 
                            @enderror
                        </div>
                        <div>
                            <label for="subject" class="label-theme">SUBJECT</label>
                            <input id="subject" name="subject" class="input-theme {{ $errors->has('subject') ? 'input-error' : 'input-default' }}" type="text" wire:model="subject" />
                            @error('subject') 
                                <p class="input-error-text">{{ $message }}</p> 
                            @enderror
                        </div>
                        <div>
                            <label for="message" class="label-theme">MESSAGE</label>
                            <textarea id="message" name="message" wire:model="message" rows="6" class="input-theme {{ $errors->has('message') ? 'input-error' : 'input-default' }} resize-none"></textarea>
                            @error('message') 
                                <p class="input-error-text">{{ $message }}</p> 
                            @enderror
                        </div>
                        <!-- <button type="submit" class="btn-theme uppercase w-full flex items-center justify-center gap-3"> -->
                        <button type="submit" class="w-full btn-theme uppercase  flex items-center justify-center gap-3">
                            <x-lucide-send class="size-4" />Send Message
                        </button>
                    </form>
                </div>
                <div>
                    <h2 class="heading-2 mb-8">Contact Information</h2>
                    <div class="space-y-8 mb-12">
                        <div class="flex gap-4">
                            <div class="w-12 h-12 flex items-center justify-center border border-[#333333] flex-shrink-0">
                                <x-lucide-map-pin class="size-5"/>
                            </div>
                            <div>
                                <h3 class="heading-3 mb-2">Our Locations</h3>
                                <p class="body-regular text-[#666666] mb-3"><strong>Dubai</strong><br>Business Bay, Sheikh Zayed Road<br>Dubai, United Arab Emirates</p>
                                <p class="body-regular text-[#666666]"><strong>London</strong><br>Mayfair, Bond Street<br>London, United Kingdom</p>
                            </div>
                        </div>
                        <div class="flex gap-4">
                            <div class="w-12 h-12 flex items-center justify-center border border-[#333333] flex-shrink-0">
                                <x-lucide-mail  class="size-5"/>
                            </div>
                            <div>
                                <h3 class="heading-3 mb-2">Email</h3>
                                <p class="body-regular text-[#666666]">hello@abrarilondon.com</p>
                            </div>
                        </div>
                        <div class="flex gap-4">
                            <div class="w-12 h-12 flex items-center justify-center border border-[#333333] flex-shrink-0">
                                <x-lucide-phone class="size-5"/>
                            </div>
                            <div>
                                <h3 class="heading-3 mb-2">Phone</h3>
                                <p class="body-regular text-[#666666]">Dubai: +971 4 XXX XXXX<br>London: +44 20 XXXX XXXX</p>
                            </div>
                        </div>
                    </div>
                    <div class="p-8 bg-[#f6f5e8]">
                        <h3 class="heading-3 mb-6">Business Hours</h3>
                        <div class="space-y-3 body-regular text-[#666666]">
                            <div class="flex justify-between"><span>Monday - Friday</span><span>9:00 AM - 6:00 PM</span></div>
                            <div class="flex justify-between"><span>Saturday</span><span>10:00 AM - 4:00 PM</span></div>
                            <div class="flex justify-between"><span>Sunday</span><span>Closed</span></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="h-[400px] bg-[#ebeade] flex items-center justify-center">
        <p class="body-large text-[#666666]">Map placeholder - Google Maps integration</p>
    </section>
</div>