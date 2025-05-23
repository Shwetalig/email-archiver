
# Email Archiver & Bid Management System

This Laravel-based project integrates G-Suite Gmail API for email archiving and automates bid identification and classification from emails.

## 🚀 Features

### ✅ Assessment 1: Email Archiving with OAuth Integration

- OAuth 2.0 authentication with Gmail (no password storage)
- Archiving all emails (subject, body, metadata, threading)
- Attachments uploaded to Google Drive and linked
- Handles CC, BCC, duplicate detection, and push notification/polling

### ✅ Assessment 2: Bid Identification and Classification

- Detect bid-related emails using keyword rules
- Create and manage bid records linked to emails
- Classify bids by project type, value, and contractor
- Follow-up email linking and contract tracking

## 📦 Requirements

- PHP 8.1+
- Composer
- Laravel 10+
- MySQL / PostgreSQL
- Google Cloud Project with Gmail & Drive API enabled

## 🔧 Setup Instructions

```bash
git clone https://github.com/your-username/email-archiver.git
cd email-archiver
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
```

## 🔐 OAuth Setup

1. Create credentials in Google Cloud Console
2. Set redirect URI and scopes in `.env`:
   ```env
   GOOGLE_CLIENT_ID=your-client-id
   GOOGLE_CLIENT_SECRET=your-secret
   GOOGLE_REDIRECT_URI=http://localhost:8000/google/callback
   ```

3. Run OAuth login:
   ```bash
   php artisan serve
   Visit http://localhost:8000/google/login
   ```

## 🧪 Testing

- Use Postman to test `/api/bids` endpoints.
- Emails can be tested via Gmail push or by seeding the `emails` table.

## 📂 Directory Overview

- `app/Services/BidRecognitionService.php` – Bid recognition logic
- `app/Http/Controllers/Api/BidController.php` – Bid CRUD APIs
- `app/Models/Email.php` – Email model with relationships
- `database/seeders/` – Contains demo data for testing

## 🐘 Database Tables

- `emails`, `bids`, `classifications`, `bid_email`, `bid_keywords`, `contracts`

## ☁️ Deployment

- Push code to GitHub:
  ```bash
  git init
  git remote add origin https://github.com/your-username/email-archiver.git
  git add .
  git commit -m "Initial Commit"
  git push -u origin main
  ```
