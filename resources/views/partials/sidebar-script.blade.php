{{-- Include this once in <head> or right before Alpine loads, on every page that uses <x-sidebar>/<x-topbar> --}}
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.store('sidebar', {
            open: false,

            toggle() {
                this.open = !this.open;
                document.body.classList.toggle('overflow-hidden', this.open);
            },

            close() {
                this.open = false;
                document.body.classList.remove('overflow-hidden');
            },
        });
    });
</script>
