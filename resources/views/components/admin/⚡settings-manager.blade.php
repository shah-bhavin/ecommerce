<?php

use App\Models\Setting;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Cache;

new class extends Component
{
    use WithFileUploads;

    // Brand Identity
    public $site_name, $brand_tagline, $logo_header, $logo_footer, $favicon;
    // Socials
    public $social_instagram, $social_facebook, $social_x, $social_linkedin, $social_whatsapp;
    // Contact
    public $contact_email, $contact_phone, $contact_address, $contact_maps;
    // SEO & Analytics
    public $seo_suffix, $analytics_ga, $analytics_pixel;
    // Legal
    public $link_privacy, $link_shipping, $link_terms;

    // Upload properties
    public $new_logo_header, $new_logo_footer, $new_favicon;

    public function mount()
    {
        $settings = Setting::all()->pluck('value', 'key');
        foreach ($settings as $key => $value) {
            if (property_exists($this, $key)) { $this->$key = $value; }
        }
    }

    public function save()
    {
        $this->validate([
            'site_name' => 'required|string|max:50',
            'contact_email' => 'required|email',
            'new_logo_header' => 'nullable|image|max:1024',
            'new_logo_footer' => 'nullable|image|max:1024',
            'new_favicon' => 'nullable|image|max:500',
        ]);

        if ($this->new_logo_header) { $this->logo_header = $this->new_logo_header->store('settings', 'public'); }
        if ($this->new_logo_footer) { $this->logo_footer = $this->new_logo_footer->store('settings', 'public'); }
        if ($this->new_favicon) { $this->favicon = $this->new_favicon->store('settings', 'public'); }

        foreach ($this->all() as $key => $value) {
            if (str_starts_with($key, 'new_')) continue;
            
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
            Cache::forget("setting.{$key}"); // Clear cache for frontend
        }

        $this->dispatch('toast', text: 'Brand configurations updated.', type: 'success');
    }
}; ?>

<div class="max-w-4xl mx-auto pb-32 pt-12 px-4">
    <header class="mb-12">
        <flux:heading size="xl" level="1">Store Settings</flux:heading>
        <flux:subheading>Configure your global brand identity and technical integrations.</flux:subheading>
    </header>

    <form wire:submit="save" class="space-y-12">
        
        {{-- Section: Brand Identity --}}
        <section class="space-y-6">
            <div class="flex items-center gap-2 mb-4">
                <flux:heading size="lg">Brand Identity</flux:heading>
                <flux:separator class="flex-1" />
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <flux:input wire:model="site_name" label="Site Name" />
                <flux:input wire:model="brand_tagline" label="Brand Tagline" placeholder="Luxury Clinical Skincare" />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 p-6 bg-zinc-50 rounded-xl border border-zinc-200">
                <div class="space-y-3">
                    <flux:label>Header Logo</flux:label>
                    <div class="h-20 flex items-center justify-center border-2 border-dashed border-zinc-300 rounded-lg bg-white overflow-hidden">
                        @if($new_logo_header) <img src="{{ $new_logo_header->temporaryUrl() }}" class="max-h-full">
                        @elseif($logo_header) <img src="{{ asset('storage/'.$logo_header) }}" class="max-h-full">
                        @else <span class="text-xs text-zinc-400">No Image</span> @endif
                    </div>
                    <flux:input type="file" wire:model="new_logo_header" variant="outline" />
                </div>

                <div class="space-y-3">
                    <flux:label>Footer Logo</flux:label>
                    <div class="h-20 flex items-center justify-center border-2 border-dashed border-zinc-300 rounded-lg bg-white overflow-hidden">
                        @if($new_logo_footer) <img src="{{ $new_logo_footer->temporaryUrl() }}" class="max-h-full">
                        @elseif($logo_footer) <img src="{{ asset('storage/'.$logo_footer) }}" class="max-h-full">
                        @else <span class="text-xs text-zinc-400">No Image</span> @endif
                    </div>
                    <flux:input type="file" wire:model="new_logo_footer" variant="outline" />
                </div>

                <div class="space-y-3">
                    <flux:label>Favicon (32x32)</flux:label>
                    <div class="h-20 flex items-center justify-center border-2 border-dashed border-zinc-300 rounded-lg bg-white overflow-hidden">
                        @if($new_favicon) <img src="{{ $new_favicon->temporaryUrl() }}" class="h-8">
                        @elseif($favicon) <img src="{{ asset('storage/'.$favicon) }}" class="h-8">
                        @else <span class="text-xs text-zinc-400">No Image</span> @endif
                    </div>
                    <flux:input type="file" wire:model="new_favicon" variant="outline" />
                </div>
            </div>
        </section>

        {{-- Section: Social Connectivity --}}
        <section class="space-y-6">
            <div class="flex items-center gap-2 mb-4">
                <flux:heading size="lg">Social Connectivity</flux:heading>
                <flux:separator class="flex-1" />
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <flux:input wire:model="social_instagram" label="Instagram URL" />
                <flux:input wire:model="social_facebook" label="Facebook URL" />
                <flux:input wire:model="social_x" label="X (Twitter) URL" />
                <flux:input wire:model="social_linkedin" label="LinkedIn URL" />
                <flux:input wire:model="social_whatsapp" label="WhatsApp Link" placeholder="https://wa.me/..." />
            </div>
        </section>

        {{-- Section: Contact Information --}}
        <section class="space-y-6">
            <div class="flex items-center gap-2 mb-4">
                <flux:heading size="lg">Contact & Studio Info</flux:heading>
                <flux:separator class="flex-1" />
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <flux:input wire:model="contact_email" label="Support Email" icon="envelope" />
                <flux:input wire:model="contact_phone" label="Concierge Phone" icon="phone" />
            </div>
            <flux:textarea wire:model="contact_address" label="Physical Address" rows="2" />
            <flux:input wire:model="contact_maps" label="Google Maps Share Link" />
        </section>

        {{-- Section: SEO & Analytics --}}
        <section class="space-y-6">
            <div class="flex items-center gap-2 mb-4">
                <flux:heading size="lg">SEO & Analytics</flux:heading>
                <flux:separator class="flex-1" />
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <flux:input wire:model="seo_suffix" label="Title Suffix" placeholder="| Abrari" />
                <flux:input wire:model="analytics_ga" label="Google Analytics ID" />
                <flux:input wire:model="analytics_pixel" label="Facebook Pixel ID" />
            </div>
        </section>

        {{-- Section: Legal --}}
        <section class="space-y-6">
            <div class="flex items-center gap-2 mb-4">
                <flux:heading size="lg">Legal Policies</flux:heading>
                <flux:separator class="flex-1" />
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <flux:input wire:model="link_privacy" label="Privacy Policy URL" />
                <flux:input wire:model="link_shipping" label="Shipping Policy URL" />
                <flux:input wire:model="link_terms" label="Terms & Conditions URL" />
            </div>
        </section>

        {{-- Premium Sticky Save Bar --}}
        <section class="max-w-4xl mx-auto flex items-center justify-between">
            <p class="text-sm text-zinc-500 hidden md:block">Last updated: {{ now()->format('M d, Y') }}</p>
            <flux:button type="submit" variant="primary" class="w-full md:w-auto bg-black! text-white!">
                Save All Settings
            </flux:button>
        </section>

    </form>
</div>