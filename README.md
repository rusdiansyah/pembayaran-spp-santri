# pembayaran-spp-santri
Cara install
- git clone https://github.com/rusdiansyah/pembayaran-spp-santri.git
- cd pembayaran-spp-santri
- composer install
- cp .env.example .env
- php artisan key:generate
- edit file .env (sesuaikan bagian database)
- php artisan migrate --seed
- php artisan serv

