<div class="w-full grid grid-cols-3 gap-4">
  <div class="p-4 gap-4">
    <h3 class="text-[18px] uppercase font-bold mb-4">Details</h3>
    <div class="grid gap-2">
        <h4 class="capitalize text-[14px]"><b>Name: </b>{{ $user->name }}</h4>
        <h4 class="text-[14px]"><b>Email: </b>{{ $user->email }}</h4>
        <h4 class="capitalize text-[14px]"><b>Phone: </b>{{ $user->phone }}</h4>
    </div>
  </div>
  <div class="p-4 col-span-2">
    <h3>Orders</h3>
    <h5 class="text-[12px] text-zinc-400 uppercase tracking-widest">
        {{ $orderscount ? 'Total Orders: ' .$orderscount : 'No Orders Yet...' }} 
    </h5>

  </div>
</div>
