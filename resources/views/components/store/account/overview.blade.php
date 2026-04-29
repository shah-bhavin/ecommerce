<div class="w-full grid grid-cols-3 gap-4">
  <div class="p-4 gap-4">
    <h3 class="text-[18px] uppercase font-bold mb-4">Details</h3>
    <div class="grid gap-2">
      <p class="body-text"><b>Name: </b>{{ $user->name }}</p>
      <p class="body-text"><b>Email: </b>{{ $user->email }}</p>
      <p class="body-text"><b>Phone: </b>{{ $user->phone }}</p>
    </div>
  </div>
  <div class="p-4 col-span-2">
    <h3 class="text-[18px] uppercase font-bold mb-4">Orders</h3>
    <p class="body-text">
      {{ $orderscount ? 'Total Orders: ' .$orderscount : 'No Orders Yet...' }}
    </p>
  </div>
</div>