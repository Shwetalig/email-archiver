
# Email Archiver 📧 → ☁️

This Laravel application fetches Gmail emails using OAuth 2.0, stores the email data in the database, and uploads attachments to Google Drive.

## 🔧 Setup Instructions

### 1. Clone the Repository

```bash
git clone https://github.com/YOUR_USERNAME/email-archiver.git
cd email-archiver
```

### 2. Install Dependencies

```bash
composer install
```

### 3. Environment Configuration

```bash
cp .env.example .env
```

Update `.env` with:

```dotenv
GOOGLE_CLIENT_ID=your-client-id
GOOGLE_CLIENT_SECRET=your-client-secret
GOOGLE_REDIRECT_URI=http://127.0.0.1:8000/google/callback
GOOGLE_DRIVE_FOLDER_ID=your-folder-id
```

### 4. Generate Application Key

```bash
php artisan key:generate
```

### 5. Run Migrations

```bash
php artisan migrate
```

### 6. Start Local Server

```bash
php artisan serve
```

## 🚀 Usage

### Step 1: Authenticate with Google

Visit:

```
http://127.0.0.1:8000/google/login
```

### Step 2: Fetch Emails

```bash
php artisan fetch:emails
```

## 📁 Attachments

Attachments from emails are uploaded to Google Drive and logged in the `attachments` table with links.

---

## ✅ Features

- OAuth 2.0 Integration with Google
- Fetch Gmail Emails (subject, sender, recipients, body)
- Upload Email Attachments to Google Drive
- Store Data in MySQL

---

## 📜 License

[MIT](LICENSE)
