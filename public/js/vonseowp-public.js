/**
 * VonSEO Public JS
 */
document.addEventListener('DOMContentLoaded', function() {
    const toggles = document.querySelectorAll('.vonseo-toc-toggle');
    
    toggles.forEach(toggle => {
        toggle.addEventListener('click', function() {
            const container = this.closest('.vonseo-toc-container');
            const list = container.querySelector('.vonseo-toc-list');
            const isExpanded = this.getAttribute('aria-expanded') === 'true';
            
            if (isExpanded) {
                list.style.display = 'none';
                this.setAttribute('aria-expanded', 'false');
                this.textContent = '[show]';
            } else {
                list.style.display = 'block';
                this.setAttribute('aria-expanded', 'true');
                this.textContent = '[hide]';
            }
        });
    });
});
