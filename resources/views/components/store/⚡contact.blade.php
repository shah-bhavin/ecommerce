<?php

use Livewire\Attributes\Layout;
use Livewire\Component;

new class extends Component
{
    #[Layout('layouts.store')]
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
                    <form class="space-y-6">
                        <div><label for="name" class="block text-sm font-medium mb-2 tracking-wide" style="font-family: Inter, sans-serif;">NAME</label><input id="name" required="" class="w-full px-6 py-4 border border-[#bcbbb4] bg-transparent text-[#333333] focus:outline-none focus:border-[#333333] transition-colors" type="text" value="" name="name" style="border-radius: 0px; font-family: Inter, sans-serif; font-size: 15px;"></div>
                        <div><label for="email" class="block text-sm font-medium mb-2 tracking-wide" style="font-family: Inter, sans-serif;">EMAIL</label><input id="email" required="" class="w-full px-6 py-4 border border-[#bcbbb4] bg-transparent text-[#333333] focus:outline-none focus:border-[#333333] transition-colors" type="email" value="" name="email" style="border-radius: 0px; font-family: Inter, sans-serif; font-size: 15px;"></div>
                        <div><label for="subject" class="block text-sm font-medium mb-2 tracking-wide" style="font-family: Inter, sans-serif;">SUBJECT</label><input id="subject" required="" class="w-full px-6 py-4 border border-[#bcbbb4] bg-transparent text-[#333333] focus:outline-none focus:border-[#333333] transition-colors" type="text" value="" name="subject" style="border-radius: 0px; font-family: Inter, sans-serif; font-size: 15px;"></div>
                        <div><label for="message" class="block text-sm font-medium mb-2 tracking-wide" style="font-family: Inter, sans-serif;">MESSAGE</label><textarea id="message" name="message" required="" rows="6" class="w-full px-6 py-4 border border-[#bcbbb4] bg-transparent text-[#333333] focus:outline-none focus:border-[#333333] transition-colors resize-none" style="border-radius: 0px; font-family: Inter, sans-serif; font-size: 15px;"></textarea></div><button type="submit" class="btn-primary w-full flex items-center justify-center gap-3"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-send" aria-hidden="true">
                                <path d="M14.536 21.686a.5.5 0 0 0 .937-.024l6.5-19a.496.496 0 0 0-.635-.635l-19 6.5a.5.5 0 0 0-.024.937l7.93 3.18a2 2 0 0 1 1.112 1.11z"></path>
                                <path d="m21.854 2.147-10.94 10.939"></path>
                            </svg>Send Message</button>
                    </form>
                </div>
                <div>
                    <h2 class="heading-2 mb-8">Contact Information</h2>
                    <div class="space-y-8 mb-12">
                        <div class="flex gap-4">
                            <div class="w-12 h-12 flex items-center justify-center border border-[#333333] flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-map-pin text-[#333333]" aria-hidden="true">
                                    <path d="M20 10c0 4.993-5.539 10.193-7.399 11.799a1 1 0 0 1-1.202 0C9.539 20.193 4 14.993 4 10a8 8 0 0 1 16 0"></path>
                                    <circle cx="12" cy="10" r="3"></circle>
                                </svg></div>
                            <div>
                                <h3 class="heading-3 mb-2">Our Locations</h3>
                                <p class="body-regular text-[#666666] mb-3"><strong>Dubai</strong><br>Business Bay, Sheikh Zayed Road<br>Dubai, United Arab Emirates</p>
                                <p class="body-regular text-[#666666]"><strong>London</strong><br>Mayfair, Bond Street<br>London, United Kingdom</p>
                            </div>
                        </div>
                        <div class="flex gap-4">
                            <div class="w-12 h-12 flex items-center justify-center border border-[#333333] flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-mail text-[#333333]" aria-hidden="true">
                                    <path d="m22 7-8.991 5.727a2 2 0 0 1-2.009 0L2 7"></path>
                                    <rect x="2" y="4" width="20" height="16" rx="2"></rect>
                                </svg></div>
                            <div>
                                <h3 class="heading-3 mb-2">Email</h3>
                                <p class="body-regular text-[#666666]">hello@abrarilondon.com</p>
                            </div>
                        </div>
                        <div class="flex gap-4">
                            <div class="w-12 h-12 flex items-center justify-center border border-[#333333] flex-shrink-0"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-phone text-[#333333]" aria-hidden="true">
                                    <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                                </svg></div>
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