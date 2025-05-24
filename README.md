## ⚙️ Installation

```bash

# 1. Install dependencies
composer install

# 2. Set up environment
cp .env.example .env
php artisan key:generate

# 3. Configure your .env (DB credentials etc.)

# 4. Run migrations
php artisan migrate