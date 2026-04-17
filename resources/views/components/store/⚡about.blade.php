<?php

use Livewire\Attributes\Layout;
use Livewire\Component;

new class extends Component
{
    #[Layout('layouts.store')]
};
?>

<div class="min-h-screen bg-[#fffef2]">
    <section class="relative h-[60vh] min-h-[500px] overflow-hidden"><img alt="About Abrari London" class="w-full h-full object-cover" src="https://images.unsplash.com/photo-1657928198258-1db7e50e2fd9">
        <div class="absolute inset-0 bg-black/30 flex items-center justify-center">
            <div class="text-center px-6">
                <h1 class="hero-large mb-4 text-white">Our Story</h1>
                <p class="body-large text-white">Where luxury meets precision</p>
            </div>
        </div>
    </section>
    <section class="py-20 px-6">
        <div class="max-w-4xl mx-auto text-center">
            <h2 class="hero-medium mb-8">A Vision of Timeless Elegance</h2>
            <p class="body-large text-[#666666] leading-relaxed mb-12">Abrari London was born from a vision to create beauty that transcends trends. Rooted in the finest traditions of luxury craftsmanship and powered by innovative formulations, we bring you products that celebrate confidence, sophistication, and the art of being beautifully yourself. From Dubai to London, our global perspective ensures every creation meets the highest standards of excellence.</p>
            <p class="body-large text-[#666666] leading-relaxed">Every Abrari London product is crafted with precision and care, using the finest ingredients sourced globally. We believe in the transformative power of beauty—not just in how you look, but in how you feel. Our formulations are designed to deliver visible results while providing a luxurious sensory experience that elevates your daily ritual.</p>
        </div>
    </section>
    <section class="py-20 px-6 bg-[#f6f5e8]">
        <div class="max-w-[1400px] mx-auto">
            <div class="text-center mb-16">
                <h2 class="hero-medium mb-4">Our Values</h2>
                <p class="body-large text-[#666666]">The principles that guide everything we do</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                <div class="text-center">
                    <div class="w-20 h-20 mx-auto mb-6 flex items-center justify-center text-[#333333]"><svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-sparkles" aria-hidden="true">
                            <path d="M9.937 15.5A2 2 0 0 0 8.5 14.063l-6.135-1.582a.5.5 0 0 1 0-.962L8.5 9.936A2 2 0 0 0 9.937 8.5l1.582-6.135a.5.5 0 0 1 .963 0L14.063 8.5A2 2 0 0 0 15.5 9.937l6.135 1.581a.5.5 0 0 1 0 .964L15.5 14.063a2 2 0 0 0-1.437 1.437l-1.582 6.135a.5.5 0 0 1-.963 0z"></path>
                            <path d="M20 3v4"></path>
                            <path d="M22 5h-4"></path>
                            <path d="M4 17v2"></path>
                            <path d="M5 18H3"></path>
                        </svg></div>
                    <h3 class="heading-3 mb-4">Luxury Craftsmanship</h3>
                    <p class="body-regular text-[#666666] max-w-md mx-auto">Every product is a testament to exceptional quality and meticulous attention to detail, created in world-class laboratories.</p>
                </div>
                <div class="text-center">
                    <div class="w-20 h-20 mx-auto mb-6 flex items-center justify-center text-[#333333]"><svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-globe" aria-hidden="true">
                            <circle cx="12" cy="12" r="10"></circle>
                            <path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"></path>
                            <path d="M2 12h20"></path>
                        </svg></div>
                    <h3 class="heading-3 mb-4">Global Perspective</h3>
                    <p class="body-regular text-[#666666] max-w-md mx-auto">Inspired by the cosmopolitan elegance of Dubai and London, we bring international beauty standards to every formulation.</p>
                </div>
                <div class="text-center">
                    <div class="w-20 h-20 mx-auto mb-6 flex items-center justify-center text-[#333333]"><svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-heart" aria-hidden="true">
                            <path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"></path>
                        </svg></div>
                    <h3 class="heading-3 mb-4">Confidence &amp; Empowerment</h3>
                    <p class="body-regular text-[#666666] max-w-md mx-auto">We believe beauty is about celebrating your unique self and feeling empowered in your own skin.</p>
                </div>
                <div class="text-center">
                    <div class="w-20 h-20 mx-auto mb-6 flex items-center justify-center text-[#333333]"><svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-award" aria-hidden="true">
                            <path d="m15.477 12.89 1.515 8.526a.5.5 0 0 1-.81.47l-3.58-2.687a1 1 0 0 0-1.197 0l-3.586 2.686a.5.5 0 0 1-.81-.469l1.514-8.526"></path>
                            <circle cx="12" cy="8" r="6"></circle>
                        </svg></div>
                    <h3 class="heading-3 mb-4">Excellence Uncompromised</h3>
                    <p class="body-regular text-[#666666] max-w-md mx-auto">From sourcing premium ingredients to final packaging, we never compromise on quality or performance.</p>
                </div>
            </div>
        </div>
    </section>
    <section class="py-20 px-6">
        <div class="max-w-[1400px] mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                <div>
                    <h2 class="hero-medium mb-6">Our Commitment to You</h2>
                    <div class="space-y-6">
                        <div>
                            <h3 class="heading-3 mb-3">Ingredient Integrity</h3>
                            <p class="body-regular text-[#666666]">We carefully select every ingredient for its proven efficacy, purity, and ethical sourcing. Our formulations are free from harmful additives and tested to the highest international standards.</p>
                        </div>
                        <div>
                            <h3 class="heading-3 mb-3">Sustainable Luxury</h3>
                            <p class="body-regular text-[#666666]">Luxury and responsibility go hand in hand. We're committed to sustainable practices, from eco-conscious packaging to supporting ethical supply chains.</p>
                        </div>
                        <div>
                            <h3 class="heading-3 mb-3">Innovation &amp; Tradition</h3>
                            <p class="body-regular text-[#666666]">We honor time-tested beauty wisdom while embracing cutting-edge skincare science, ensuring our products deliver both immediate and long-term results.</p>
                        </div>
                    </div>
                </div>
                <div><img alt="Abrari London Products" class="w-full h-[600px] object-cover hover-lift" src="https://images.unsplash.com/photo-1622618991227-412b19e4fef9"></div>
            </div>
        </div>
    </section>
    <section class="py-20 px-6 bg-[#f6f5e8] text-center">
        <div class="max-w-3xl mx-auto">
            <h2 class="hero-medium mb-6">Experience the Difference</h2>
            <p class="body-large text-[#666666] mb-10">Discover why discerning individuals around the world choose Abrari London for their beauty rituals</p><a href="/shop" class="btn-primary">Explore Our Collection</a>
        </div>
    </section>
</div>