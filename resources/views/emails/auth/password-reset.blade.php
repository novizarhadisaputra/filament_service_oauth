<x-mail::message>
    # Permintaan Atur Ulang Kata Sandi

    Halo,

    Kami menerima permintaan untuk mengatur ulang kata sandi akun Anda di **Portal Layanan Kesehatan Digital**. Hal ini
    diperlukan untuk memastikan keamanan akses data kesehatan Anda tetap terlindungi.

    Silakan klik tombol di bawah ini untuk melanjutkan proses pemulihan akun Anda:

    <x-mail::button :url="url(config('app.url') . route('password.reset', ['token' => $token, 'email' => $email], false))">
        Atur Ulang Kata Sandi
    </x-mail::button>

    **Tautan ini akan kedaluwarsa dalam 60 menit.**

    Jika Anda tidak merasa melakukan permintaan ini, abaikan email ini. Kata sandi Anda tetap aman dan tidak akan
    berubah.

    Salam hangat,<br>
    **Tim IT Layanan Kesehatan Digital**

    <x-mail::panel>
        Jika Anda mengalami kendala saat mengklik tombol, Anda dapat menyalin tautan berikut ke browser Anda:
        [{{ url(config('app.url') . route('password.reset', ['token' => $token, 'email' => $email], false)) }}]({{ url(config('app.url') . route('password.reset', ['token' => $token, 'email' => $email], false)) }})
    </x-mail::panel>

    &copy; {{ date('Y') }} Layanan Kesehatan Terpadu. Kerahasiaan data pasien adalah prioritas kami.
</x-mail::message>
