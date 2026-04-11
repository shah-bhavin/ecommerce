<?php
use App\Models\Product;
use Livewire\Attributes\Layout;
use Livewire\Component;


new class extends Component
{
    #[Layout('layouts.store')]
    public function with($orderid) {
        return [
            'featured' => Product::get(),
            'orderid' => $orderid
        ];
    }
};
?>

<!-- <div class="max-w-2xl mx-auto px-6 py-32 text-center space-y-8">
    <flux:icon.check-circle class="mx-auto text-emerald-600 size-16" />
    <h1 class="text-5xl font-serif italic">Thank You for your Order.</h1>
    <p class="text-zinc-500 font-light leading-relaxed">Your order #LS-9823 has been received and is currently being prepared for shipping.</p>
    <flux:button href="/collection" variant="ghost" class="uppercase text-[10px] tracking-widest border border-black px-12 h-14 rounded-none">Continue Shopping</flux:button>
</div> -->


<main class="pt-32 pb-24 px-6 md:px-12 lg:px-24">
    <!-- Success Celebration Hero -->
    <section class="max-w-6xl mx-auto mb-20 text-center">
      <div class="mb-8 inline-block">
        <div class="w-20 h-20 rounded-xl! flex items-center justify-center bg-secondary-fixed! mb-4 mx-auto">
          <span class="material-symbols-outlined text-secondary text-4xl" data-icon="check_circle"
            style="font-variation-settings: 'FILL' 1;">check_circle</span>
        </div>
      </div>
      <h1 class="font-headline text-5xl md:text-7xl text-primary tracking-tight mb-6">Thank You for Your Ritual{{ $orderid }} </h1>
      <p class="font-body text-on-surface-variant max-w-2xl mx-auto text-lg leading-relaxed">
        Your journey towards radiant skin has begun. We are preparing your selection with the utmost care in our Dubai
        atelier.
      </p>
    </section>
    <!-- Content Grid -->
    <div class="max-w-6xl mx-auto grid grid-cols-1 lg:grid-cols-12 gap-12 items-start">
      <!-- Order Details -->
      <div class="lg:col-span-7 space-y-12">
        <!-- Summary Card -->
        <div class="bg-surface-container-low p-8 md:p-12">
          <div class="flex justify-between items-end mb-12">
            <div>
              <p class="font-label text-xs uppercase tracking-[0.2em] text-secondary mb-2">Order Identification</p>
              <h2 class="font-headline text-3xl">#RDNT-9928401</h2>
            </div>
            <div class="text-right">
              <p class="font-label text-xs uppercase tracking-[0.2em] text-on-surface-variant mb-2">Estimated Arrival
              </p>
              <p class="font-headline text-xl">Oct 24 — Oct 26</p>
            </div>
          </div>
          <div class="space-y-8">
            <!-- Item 1 -->
            <div class="flex gap-6 items-center">
              <div class="w-24 h-32 bg-surface-container-highest overflow-hidden">
                <img alt="luxury serum" class="w-full h-full object-cover"
                  data-alt="close-up of a frosted glass luxury serum bottle with gold accents on a clean marble background"
                  src="https://lh3.googleusercontent.com/aida-public/AB6AXuDomgUAiwydC4z416BRPNbVMBPCzZyOpMnvs5fP93QSi7S2kdiAT7SRdq9c6xH0i3-zsb9bLgR332ENdN7f0a3ONSvf04bRg7eZ-a4pljrXn-4IehXaxIcpZivDw0EhKNuFhJA5i4bnl72sAXsG-HamcF74BGKeHyS5djD5yEvhyUFSQhE5muzd03SYgZgLjlhjrWjWI7Z52GZEVOytf1uiMKLVcGF3fNg8DLh1V7lutPoc55ZjH43sFf81Oczb-S25IDMH02dtwzYf" />
              </div>
              <div class="flex-1">
                <h3 class="font-label text-lg font-bold">Midnight Recovery Nectar</h3>
                <p class="text-sm text-on-surface-variant mb-4">50ml • Ritual Edition</p>
                <p class="font-headline text-secondary">AED 450.00</p>
              </div>
            </div>
            <!-- Item 2 -->
            <div class="flex gap-6 items-center">
              <div class="w-24 h-32 bg-surface-container-highest overflow-hidden">
                <img alt="facial cream" class="w-full h-full object-cover"
                  data-alt="high-end white ceramic jar of face cream with minimalist black label on a soft beige background"
                  src="https://lh3.googleusercontent.com/aida-public/AB6AXuDza5j_xw5Y-EqJowj7lrDm9NnWAh7PEfGMaxe0sHev540-Xt54XNxG1ftUUHGLAf62tHCAzP_2KLzK3mELj8oYBUFiEfYJFL0fx7fdA0vPbBZuqBEUnk-zf4j_ZN74WPEPLD7HtdqIFP_hGVHIr6lOhZgEKmEbPFu44vDUECxD74bpjGQkRs4GcgCGZfVWHiIl1X8oETAmdaCBEYgQAro2pWjP-1XmOtEMaJHDDHfx9u5eTiZ2U21cW73JFMqlAFX-MN-u69lEdwxf" />
              </div>
              <div class="flex-1">
                <h3 class="font-label text-lg font-bold">Desert Rose Hydrator</h3>
                <p class="text-sm text-on-surface-variant mb-4">100ml • Core Collection</p>
                <p class="font-headline text-secondary">AED 320.00</p>
              </div>
            </div>
          </div>
          <div class="mt-12 pt-12 border-t border-outline-variant/20">
            <div class="flex justify-between mb-4">
              <span class="font-label text-sm uppercase tracking-wider text-on-surface-variant">Subtotal</span>
              <span class="font-body">AED 770.00</span>
            </div>
            <div class="flex justify-between mb-4">
              <span class="font-label text-sm uppercase tracking-wider text-on-surface-variant">Complimentary
                Shipping</span>
              <span class="font-body">AED 0.00</span>
            </div>
            <div class="flex justify-between pt-4">
              <span class="font-headline text-2xl">Total</span>
              <span class="font-headline text-2xl text-primary">AED 770.00</span>
            </div>
          </div>
        </div>
        <!-- Tracking Visual -->
        <div class="bg-surface-container-lowest p-8 flex flex-col md:flex-row items-center gap-8 shadow-sm">
          <div class="flex-1">
            <h4 class="font-headline text-xl mb-2">Real-Time Ritual Tracking</h4>
            <p class="text-sm text-on-surface-variant">We'll notify you the moment your order departs our sanctuary.</p>
          </div>
          <button
            class="w-full md:w-auto luxury-gradient text-white px-10 py-4 font-label font-bold text-xs uppercase tracking-widest transition-transform hover:scale-105">
            Track Order
          </button>
        </div>
      </div>
      <!-- Editorial/Secondary Info -->
      <div class="lg:col-span-5 space-y-8 lg:sticky lg:top-32">
        <!-- Delivery Detail -->
        <div class="bg-primary-fixed/30 p-8">
          <h4 class="font-label font-extrabold text-xs uppercase tracking-[0.2em] text-on-primary-fixed-variant mb-6">
            Delivery Address</h4>
          <address class="not-italic font-body text-on-surface leading-loose">
            Khalid Al-Mansoori<br />
            Level 42, Burj Daman<br />
            DIFC, Dubai<br />
            United Arab Emirates
          </address>
          <div class="mt-8 flex items-center gap-3 text-on-primary-fixed-variant">
            <span class="material-symbols-outlined" data-icon="local_shipping">local_shipping</span>
            <span class="text-xs font-label font-bold uppercase tracking-widest">White Glove Delivery</span>
          </div>
        </div>
        <!-- Call to Action -->
        <div
          class="relative aspect-[4/5] bg-surface-container-highest overflow-hidden flex flex-col justify-end p-10 group">
          <img alt="skincare ritual"
            class="absolute inset-0 w-full h-full object-cover opacity-80 group-hover:scale-110 transition-transform duration-[2000ms]"
            data-alt="overhead artistic shot of skincare bottles and rose petals on a textured plaster surface with soft afternoon light"
            src="https://lh3.googleusercontent.com/aida-public/AB6AXuDw36aMZhkxHpRzXXVRT6c_H3qJn_fF9nXBrX7dp2PpQG0SafPExuFRn52K8BYDVYJBC_UhQikClJwWHWkDh_VoFI1Pg1pPicgYit1DDDQ1jsrPV6_8zquZeZB83ynJVNu5UMoFCAQWxQzzf53I7WPYppDi59WwFFgG_LiOKNU5MQj9KPsZT-9pktLLgF7F5a8L4BYP6EYLIq51Fld1-NkXP-YVO05c-gUKByfgu94AuPZN6EiW0vl8s-VLcJi7jbDOm11ZS0rDhiYV" />
          <div class="relative z-10">
            <h3 class="font-headline text-3xl text-white mb-6">Complete the Ritual</h3>
            <p class="text-white/80 text-sm mb-8 max-w-xs">Explore our latest collection of sustainable silk accessories
              designed to enhance your nightly glow.</p>
            <a class="inline-block border border-white text-white px-8 py-3 font-label text-xs uppercase tracking-[0.2em] hover:bg-white hover:text-primary transition-colors"
              href="#">
              Continue Exploring
            </a>
          </div>
          <div class="absolute inset-0 bg-gradient-to-t from-primary/80 to-transparent"></div>
        </div>
      </div>
    </div>
  </main>