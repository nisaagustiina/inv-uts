</div><!-- end page-content -->
</div><!-- end main-wrapper -->

<script src="assets/bootstrap-5.3.8-dist/js/bootstrap.bundle.min.js"></script>
<script>
    (function() {
        var sidebar = document.getElementById('sidebar');
        var overlay = document.getElementById('sidebarOverlay');
        var toggle = document.getElementById('sidebarToggle');
        var closeBtn = document.getElementById('sidebarClose');

        function openSidebar() {
            sidebar.classList.add('open');
            overlay.style.display = 'block';
            requestAnimationFrame(function() {
                overlay.classList.add('show');
            });
            document.body.style.overflow = 'hidden';
        }

        function closeSidebar() {
            sidebar.classList.remove('open');
            overlay.classList.remove('show');
            document.body.style.overflow = '';
            overlay.addEventListener('transitionend', function hide() {
                overlay.style.display = 'none';
                overlay.removeEventListener('transitionend', hide);
            });
        }

        if (toggle) toggle.addEventListener('click', openSidebar);
        if (closeBtn) closeBtn.addEventListener('click', closeSidebar);
        if (overlay) overlay.addEventListener('click', closeSidebar);

        // close didebar
        var navLinks = sidebar ? sidebar.querySelectorAll('.sidebar-nav a') : [];
        navLinks.forEach(function(link) {
            link.addEventListener('click', function() {
                if (window.innerWidth < 768) closeSidebar();
            });
        });

        window.addEventListener('resize', function() {
            if (window.innerWidth >= 768) closeSidebar();
        });
    })();

    document.getElementById('price').addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');

        e.target.value = new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0
        }).format(value || 0);
    });
</script>
</body>

</html>