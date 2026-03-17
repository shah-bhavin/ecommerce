<?php
use App\Models\Review;
use Livewire\Component;

new class extends Component
{
    public function toggleStatus($id) {
        $review = Review::findOrFail($id);
        $review->update(['is_active' => !$review->is_active]);
        
        session()->flash('message', 'Review status updated!');
    }

    public function deleteReview($id) {
        Review::destroy($id);
        session()->flash('message', 'Review deleted successfully.');
    }
};
?>

<div>
    <flux:heading size="xl" class="mb-6">Customer Reviews & Ratings</flux:heading>

    <flux:table>
        <flux:table.columns>
            <flux:table.column>Product</flux:table.column>
            <flux:table.column>Rating</flux:table.column>
            <flux:table.column>Comment</flux:table.column>
            <flux:table.column>Verified</flux:table.column>
            <flux:table.column>Approved</flux:table.column>
            <flux:table.column>Action</flux:table.column>
        </flux:table.columns>

        <flux:table.rows>
            @foreach(Review::with(['user:id,name', 'product:id,name'])->latest()->get() as $review)
                <flux:table.row>
                    <flux:table.cell class="font-medium">{{ $review->product->name }}</flux:table.cell>
                    <flux:table.cell>
                        <div class="flex text-yellow-400">
                            @for($i = 1; $i <= 5; $i++)
                                <flux:icon.star variant="{{ $i <= $review->rating ? 'solid' : 'outline' }}" class="w-3 h-3" />
                            @endfor
                        </div>
                    </flux:table.cell>
                    <flux:table.cell>
                        <div class="text-xs text-zinc-500 italic">"{{ Str::limit($review->comment, 40) }}"</div>
                        <div class="text-[10px]">- {{ $review['user']->name }}</div>
                    </flux:table.cell>
                    <flux:table.cell>
                        @if($review->is_verified_purchase)
                            <flux:badge size="sm" color="green" variant="pill">Yes</flux:badge>
                        @endif
                    </flux:table.cell>
                    <flux:table.cell>
                        <flux:switch wire:click="toggleStatus({{ $review->id }})" :checked="$review->is_active" color="green" />
                    </flux:table.cell>
                    <flux:table.cell>
                        <flux:button wire:click="deleteReview({{ $review->id }})" wire:confirm="Permanently delete this review?" variant="ghost" size="sm" icon="trash" color="danger" />
                    </flux:table.cell>
                </flux:table.row>
            @endforeach
        </flux:table.rows>
    </flux:table>
</div>