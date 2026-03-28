import 'flowbite';

// Function to toggle the sidebar visibility and animation
function toggleSidebar() {
    const sidebar = document.getElementById('sidebar-panel');
    const overlay = document.getElementById('sidebar-overlay');
    
    // Check if the sidebar is currently hidden (-translate-x-full is present)
    const isHidden = sidebar.classList.contains('-translate-x-full');

    if (isHidden) {
        // Open the sidebar
        sidebar.classList.remove('-translate-x-full');
        sidebar.classList.add('translate-x-0');
        overlay.classList.remove('hidden');
        setTimeout(() => overlay.classList.add('opacity-50'), 10); // Add slight delay to trigger transition
    } else {
        // Close the sidebar
        sidebar.classList.remove('translate-x-0');
        sidebar.classList.add('-translate-x-full');
        overlay.classList.remove('opacity-50');
        // Hide the overlay after the transition completes (duration-300 is 300ms)
        setTimeout(() => overlay.classList.add('hidden'), 300); 
    }
}

// Attach the toggle function to the button click event
document.getElementById('menu-button').addEventListener('click', toggleSidebar);
