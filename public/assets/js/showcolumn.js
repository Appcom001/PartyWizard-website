    // Toggle the columns menu
    document.getElementById('show-columns-btn').addEventListener('click', function() {
        const menu = document.getElementById('columns-menu');
        menu.classList.toggle('hidden');
    });

    // Hide menu when clicking outside
    document.addEventListener('click', function(event) {
        const menu = document.getElementById('columns-menu');
        const button = document.getElementById('show-columns-btn');
        if (!button.contains(event.target) && !menu.contains(event.target)) {
            menu.classList.add('hidden');
        }
    });