<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scan QRIS - Riels Coffee</title>
    <link rel="icon" href="{{ asset('images/logo.png') }}" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { background: #1a1a1a; font-family: 'Plus Jakarta Sans', sans-serif; color: white; }
        .qris-card { background: white; border-radius: 20px; padding: 30px; text-align: center; color: #333; max-width: 400px; margin: 0 auto; position: relative; overflow: hidden; }
        .qris-img { width: 100%; max-width: 250px; mix-blend-mode: multiply; }
        
        /* Font Monospace biar angkanya gak goyang pas jalan */
        .timer-text { font-family: 'Courier New', monospace; letter-spacing: 2px; }
        
        /* Animasi kedip kalau waktu tinggal dikit */
        .blinking { animation: blinker 1s linear infinite; color: red !important; }
        @keyframes blinker { 50% { opacity: 0; } }
    </style>
</head>
<body class="d-flex align-items-center justify-content-center min-vh-100 p-3">

    <div class="container text-center">
        <h4 class="fw-bold mb-4 text-white">Pembayaran QRIS</h4>

        <div class="qris-card shadow-lg">
            <div class="mb-3 p-2 bg-light rounded-3 border">
                <small class="text-muted fw-bold d-block mb-1" style="font-size: 10px;">SISA WAKTU BAYAR</small>
                <h2 id="timer" class="fw-bold text-danger mb-0 timer-text">05:00</h2>
            </div>

            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/d/d0/QR_code_for_mobile_English_Wikipedia.svg/1200px-QR_code_for_mobile_English_Wikipedia.svg.png" class="qris-img mb-3" alt="QRIS Code">
            
            <p class="mb-1 text-muted small text-uppercase fw-bold">Total Tagihan</p>
            <h2 class="fw-bold text-dark mb-4">Rp {{ number_format($order->TOTAL_BAYAR, 0, ',', '.') }}</h2>

            <div class="alert alert-warning border-0 small text-start d-flex gap-2">
                <i class="bi bi-info-circle-fill mt-1"></i>
                <div>Silakan scan QR di atas menggunakan GoPay, OVO, Dana, atau Mobile Banking Anda.</div>
            </div>

            <form action="{{ route('customer.qris.confirm', $order->ID_PESANAN) }}" method="POST">
                @csrf
                <button id="btnBayar" class="btn btn-success w-100 rounded-pill py-3 fw-bold shadow">
                    <i class="bi bi-check-lg me-1"></i> Saya Sudah Bayar
                </button>
            </form>
        </div>
        
        <p class="mt-4 text-white-50 small">Order ID: #{{ $order->ID_PESANAN }}</p>
    </div>

    <script>
        // Set waktu 5 menit (5 * 60 = 300 detik)
        let timeLeft = 300; 
        const timerElem = document.getElementById('timer');
        const btnBayar = document.getElementById('btnBayar');

        const countdown = setInterval(() => {
            const minutes = Math.floor(timeLeft / 60);
            let seconds = timeLeft % 60;

            // Tambah angka 0 di depan jika detik < 10 (biar jadi 05:09)
            seconds = seconds < 10 ? '0' + seconds : seconds;

            timerElem.innerHTML = `0${minutes}:${seconds}`;

            // Kalau waktu kurang dari 1 menit, kasih efek kedip merah
            if (timeLeft < 60) {
                timerElem.classList.add('blinking');
            }

            // Kalau waktu habis (00:00)
            if (timeLeft <= 0) {
                clearInterval(countdown);
                timerElem.innerHTML = "WAKTU HABIS";
                timerElem.classList.remove('blinking');
                
                // Matikan Tombol
                btnBayar.disabled = true;
                btnBayar.classList.remove('btn-success');
                btnBayar.classList.add('btn-secondary');
                btnBayar.innerText = "Waktu Habis - Silakan Pesan Ulang";

                // (Opsional) Redirect otomatis balik ke menu setelah 3 detik
                setTimeout(() => {
                    window.location.href = "{{ route('customer.menu') }}";
                }, 3000);
            }

            timeLeft--;
        }, 1000);
    </script>

</body>
</html>