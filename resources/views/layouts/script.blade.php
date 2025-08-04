<script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>
<script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/js/feather.min.js') }}"></script>
<script src="{{ asset('assets/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>
<script src="{{ asset('assets/plugins/timeline/horizontal-timeline.js') }}"></script>
<script src="{{ asset('assets/plugins/twitter-bootstrap-wizard/jquery.bootstrap.wizard.min.js') }}"></script>
<script src="{{ asset('assets/plugins/twitter-bootstrap-wizard/prettify.js') }}"></script>
<script src="{{ asset('assets/plugins/twitter-bootstrap-wizard/form-wizard.js') }}"></script>
<script src="{{ asset('assets/js/script.js') }}"></script>
<script>
    document.addEventListener('input', function() {
        const rows = document.querySelectorAll('.row.mb-3.pb-3');
        rows.forEach(row => {
            const hargaInput = row.querySelector('.harga');
            const jumlahInput = row.querySelector('.jumlah');
            const totalInput = row.querySelector('.total');

            const harga = parseInt(hargaInput?.value || 0);
            const jumlah = parseInt(jumlahInput?.value || 0);
            totalInput.value = harga * jumlah;


        });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const select = document.getElementById('jenis-bendahara')
        const other = document.getElementById('other')

        function toggleInput() {
            if (select.value == 'Other') {
                other.style.display = 'block'
            } else {
                other.style.display = 'none'
            }
        }

        toggleInput()

        select.addEventListener('change', toggleInput)
    })
</script>
