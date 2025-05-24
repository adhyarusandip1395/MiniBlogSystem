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

# 5. Run the app
php artisan serve





## 🧪 API Testing with Postman

You can test the API using the included Postman collection file.

📁 **File**: `Mini Blog System.postman_collection.json` (located in the project root)

### 🔧 How to Use:
1. Open Postman.
2. Click **Import** → Select the file: `Mini Blog System.postman_collection.json`.
3. Set the base URL to: `http://localhost:8000` or your hosted API URL.
4. For protected routes, add an **Authorization header**:



