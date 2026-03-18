# FINVESTMART – HOSTINGER SETUP GUIDE
## Step-by-Step Instructions (No Coding Required)

---

## STEP 1: Download Files

After Claude pushes the files to GitHub, download the ZIP:
1. Go to your GitHub repository
2. Click the green "Code" button
3. Click "Download ZIP"
4. Extract the ZIP on your computer

---

## STEP 2: Create MySQL Database on Hostinger

1. Log in to **Hostinger hPanel** at hpanel.hostinger.com
2. Go to **Databases** → **MySQL Databases**
3. Click **"Create Database"**
4. Enter a name (e.g., `finvestmart_db`)
5. Under **"Create MySQL User"**, enter:
   - Username: `finvestmart_user` (or any name)
   - Password: (use a STRONG password, save it!)
6. Under **"Add User to Database"**, select the user and database
7. Check **"All Privileges"** and click **Save**

**Write down:**
- Database name: `_______________`
- Username: `_______________`
- Password: `_______________`

---

## STEP 3: Import Database Schema

1. In hPanel, go to **Databases** → **phpMyAdmin**
2. Click your database name on the left
3. Click the **"Import"** tab at the top
4. Click **"Choose File"**
5. Select the file: `database/finvestmart.sql`
6. Click **"Go"** button
7. Wait for success message ✅

---

## STEP 4: Update Database Config

1. Open file: `config/database.php`
2. Replace these lines with YOUR details:
   ```
   define('DB_HOST', 'localhost');
   define('DB_USER', 'your_db_username');   ← Your username from Step 2
   define('DB_PASS', 'your_db_password');   ← Your password from Step 2
   define('DB_NAME', 'finvestmart_db');     ← Your database name from Step 2
   define('SITE_URL', 'https://yourdomain.com'); ← Your actual domain
   ```
3. Save the file

---

## STEP 5: Upload Files to Hostinger

**Method A: Using File Manager (Recommended)**
1. In hPanel, go to **Files** → **File Manager**
2. Navigate to `public_html` folder
3. Delete any existing `index.html` if present
4. Click **Upload** button
5. Upload ALL files from the extracted ZIP
6. Make sure the files are INSIDE `public_html`, not in a subfolder

**Method B: Using FTP (FileZilla)**
1. In hPanel, go to **Files** → **FTP Accounts**
2. Note the FTP hostname, username, password
3. Open FileZilla
4. Connect using those credentials
5. Navigate to `public_html` on the right side
6. Drag and drop all project files to `public_html`

**File Structure in public_html should look like:**
```
public_html/
├── index.html          ← Homepage
├── login.html
├── register.html
├── dashboard.html
├── .htaccess
├── assets/
│   ├── css/style.css
│   └── js/main.js
├── products/
│   ├── insurance.html
│   ├── personal-loan.html
│   ├── home-loan.html
│   ├── business-loan.html
│   ├── demat.html
│   ├── investments.html
│   └── credit-card.html
├── admin/
│   ├── index.php
│   ├── users.php
│   ├── applications.php
│   └── rewards.php
├── api/
│   ├── auth/
│   ├── applications/
│   └── rewards/
├── config/
│   └── database.php    ← You edited this in Step 4
└── database/
    └── finvestmart.sql
```

---

## STEP 6: Enable SSL Certificate (HTTPS)

1. In hPanel, go to **Security** → **SSL**
2. Select your domain
3. Click **"Install"** for the free SSL
4. Wait 5–10 minutes
5. After SSL is active, open `.htaccess` and uncomment these lines:
   ```
   RewriteCond %{HTTPS} off
   RewriteRule ^(.*)$ https://%{HTTP_HOST}/$1 [R=301,L]
   ```

---

## STEP 7: Test Your Website

Open your browser and visit:
- 🏠 **Homepage:** `https://yourdomain.com`
- 📝 **Register:** `https://yourdomain.com/register.html`
- 🔐 **Login:** `https://yourdomain.com/login.html`
- 📊 **Dashboard:** `https://yourdomain.com/dashboard.html`
- ⚙️ **Admin:** `https://yourdomain.com/admin/index.php`

**Default Admin Login:**
- Email: `admin@finvestmart.com`
- Password: `password` (CHANGE THIS IMMEDIATELY!)

**Test User Login:**
- Email: `rahul@example.com`
- Password: `password`

---

## STEP 8: Change Admin Password

1. Go to `https://yourdomain.com/admin/index.php`
2. Login with default credentials
3. Go to Settings → Change Password
4. Set a STRONG password immediately!

---

## COMMON ISSUES & FIXES

| Problem | Fix |
|---------|-----|
| Blank white page | Check `config/database.php` settings |
| Database error | Verify DB name/user/password in Step 4 |
| 404 on product pages | Make sure `.htaccess` is uploaded |
| API not working | Ensure PHP 7.4+ is enabled in hPanel |
| Admin login fails | Re-run the SQL file to reset seed data |

---

## NEED HELP?

Contact Hostinger Support: **https://support.hostinger.com**
