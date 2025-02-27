        </main>
    </div>
    <script>
        // Common admin panel JavaScript functionality
        document.addEventListener('DOMContentLoaded', function() {
            // Add active class to current nav item
            const currentPage = window.location.pathname.split('/').pop();
            document.querySelectorAll('.sidebar nav a').forEach(link => {
                if (link.getAttribute('href').includes(currentPage)) {
                    link.parentElement.classList.add('active');
                }
            });

            // Initialize tooltips
            const tooltips = document.querySelectorAll('[data-tooltip]');
            tooltips.forEach(el => {
                el.addEventListener('mouseover', e => {
                    const tooltip = document.createElement('div');
                    tooltip.className = 'tooltip';
                    tooltip.textContent = el.dataset.tooltip;
                    document.body.appendChild(tooltip);
                    
                    const rect = el.getBoundingClientRect();
                    tooltip.style.top = rect.bottom + 5 + 'px';
                    tooltip.style.left = rect.left + (rect.width - tooltip.offsetWidth) / 2 + 'px';
                });

                el.addEventListener('mouseout', () => {
                    const tooltip = document.querySelector('.tooltip');
                    if (tooltip) tooltip.remove();
                });
            });
        });
    </script>
</body>
</html>
