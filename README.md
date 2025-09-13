# 🖥️ Activity Monitor

A Laravel-based activity monitoring system with idle session detection, modal warnings, and configurable settings.

# Database diagram

https://dbdiagram.io/d/68c5b239841b2935a66ac0fa

---

## 📦 Installation

Clone the repository:

```bash

git clone https://github.com/HishamAtef55/activity-monitor.git

cd activity-monitor

composer install

npm install

npm run build

cp .env.example .env

php artisan key:generate

php artisan migrate --seed
