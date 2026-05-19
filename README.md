# Platform Undangan Digital Premium

Platform undangan pernikahan online yang premium, modern, elegan, dan siap dijadikan bisnis SaaS.

## Tech Stack

- **Backend:** Laravel 12 (PHP 8.3+)
- **Database:** MySQL
- **Frontend:** Blade + Tailwind CSS + Alpine.js
- **Auth:** Laravel Breeze + Socialite (Google OAuth)
- **Payment:** Midtrans
- **Queue:** Laravel Queue (Database driver)
- **File Storage:** Laravel Storage (local/S3)

## Fitur Utama

- Authentication (Login, Register, OTP Email, Google OAuth, Forgot Password)
- Multi-role (Super Admin & Customer)
- Customer Dashboard (CRUD Undangan, Kelola Tamu, Gallery, RSVP)
- Admin Panel (Users, Undangan, Templates, Payments, Analytics)
- 5 Template Premium (Elegant Gold, Minimal White, Luxury Black, Floral Romantic, Islamic Elegant)
- Sistem Pembayaran Midtrans (3 Paket: Basic, Premium, Exclusive)
- RSVP & Guest Management
- Buku Tamu dengan Anti-spam
- Galeri Foto Multi-upload
- Music Player (Background Music)
- Countdown Timer
- Google Maps Integration
- Amplop Digital (QRIS + Bank Transfer)
- Love Story Timeline
- Personal URL per tamu (domain.com/slug?to=NamaTamu)
- Rate Limiter & OTP Protection
- Premium UI/UX (Mobile-first, Responsive)

## Instalasi

### Requirements

- PHP 8.3+
- Composer
- Node.js 18+
- MySQL 8.0+

### Steps

```bash
# 1. Clone repository
git clone <repository-url>
cd undangan-app

# 2. Install PHP dependencies
composer install

# 3. Install Node dependencies
npm install

# 4. Copy environment file
cp .env.example .env

# 5. Generate app key
php artisan key:generate

# 6. Configure .env (database, mail, Google OAuth, Midtrans)
# Edit .env file with your credentials

# 7. Create database
mysql -u root -e "CREATE DATABASE undangan_digital"

# 8. Run migrations
php artisan migrate

# 9. Seed database (admin, packages, templates)
php artisan db:seed

# 10. Create storage link
php artisan storage:link

# 11. Build frontend assets
npm run build

# 12. Start queue worker (for OTP emails)
php artisan queue:work

# 13. Start development server
php artisan serve
```

### Default Admin Login

- Email: `admin@undangandigital.com`
- Password: `password`

## Environment Configuration

### Google OAuth
```env
GOOGLE_CLIENT_ID=your-client-id
GOOGLE_CLIENT_SECRET=your-client-secret
GOOGLE_REDIRECT_URI="${APP_URL}/auth/google/callback"
```

### Midtrans
```env
MIDTRANS_SERVER_KEY=your-server-key
MIDTRANS_CLIENT_KEY=your-client-key
MIDTRANS_IS_PRODUCTION=false
```

### Mail (for OTP)
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
```

## Struktur Project

```
app/
├── Enums/              # Status enums (UserRole, InvitationStatus, etc)
├── Http/
│   ├── Controllers/
│   │   ├── Auth/       # Authentication controllers
│   │   ├── Admin/      # Admin panel controllers
│   │   └── Customer/   # Customer dashboard controllers
│   ├── Middleware/      # Admin, Customer, OTP verification
│   └── Requests/       # Form request validation
├── Jobs/               # Queue jobs (SendOtpEmail)
├── Models/             # Eloquent models
├── Notifications/      # Email notifications
├── Policies/           # Authorization policies
└── Services/           # Business logic (OTP, Payment, Invitation)

database/
├── migrations/         # All table schemas
└── seeders/            # Admin, Packages, Templates

resources/views/
├── auth/               # Login, Register, OTP, Password Reset
├── admin/              # Admin panel pages
├── customer/           # Customer dashboard pages
├── layouts/            # App, Dashboard, Auth layouts
└── templates/          # 5 Invitation templates
```

## Paket & Harga

| Paket | Harga | Fitur |
|-------|-------|-------|
| Basic | Rp 99.000 | 5 foto, 1 template, buku tamu, galeri, countdown, maps |
| Premium | Rp 199.000 | Unlimited foto, 3 template, RSVP, musik, love story, amplop digital |
| Exclusive | Rp 399.000 | Semua fitur, QR check-in, custom domain, WhatsApp blast, analytics |

## Production Deployment

1. Set `APP_ENV=production` dan `APP_DEBUG=false`
2. Jalankan `php artisan config:cache`
3. Jalankan `php artisan route:cache`
4. Jalankan `php artisan view:cache`
5. Setup supervisor untuk queue worker
6. Configure HTTPS
7. Setup MySQL dengan proper credentials
8. Configure Midtrans production keys

## License

Proprietary - All rights reserved.
