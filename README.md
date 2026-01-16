

```markdown
# FitTrack - Mobile Application Setup Guide

This guide explains how to set up the **FitTrack** backend and frontend on a Windows machine using XAMPP, and how to run the mobile application on a real Android device.

## 📋 Prerequisites
1.  **XAMPP** installed on your computer.
2.  **Android Phone** and **Computer** connected to the **SAME Wi-Fi network**.
3.  **USB Cable** (optional, for debugging).

---

## 🚀 Step 1: Start the Server
1.  Open **XAMPP Control Panel**.
2.  Click **Start** next to **Apache**.
3.  Click **Start** next to **MySQL**.
4.  Ensure both turn **Green**.

---

## 🗄️ Step 2: Database Setup
1.  Open your browser and go to: [http://localhost/phpmyadmin](http://localhost/phpmyadmin)
2.  Click **New** (left sidebar).
3.  Create a database named: `fittrack`
4.  Click on the `fittrack` database to select it.
5.  Click the **SQL** tab at the top.
6.  Copy and paste the following SQL code to create the table and the image column:

```sql
CREATE TABLE `activities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `activity_date` date NOT NULL,
  `activity_type` varchar(50) NOT NULL,
  `duration` int(11) NOT NULL,
  `calories` int(11) NOT NULL,
  `water_intake` int(11) NOT NULL,
  `mood` varchar(50) NOT NULL,
  `notes` text DEFAULT NULL,
  `image` LONGTEXT DEFAULT NULL, -- This is crucial for photo saving
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

```

7. Click **Go**.

---

## 📂 Step 3: Backend Setup

1. Navigate to your XAMPP installation folder (usually `C:\xampp\htdocs\`).
2. Create a new folder named exactly: **`fittrack_api`**
3. Copy all your PHP files (`create_activity.php`, `db_connect.php`, `get_activities.php`, etc.) into this folder.
4. **Important:** Ensure your `db_connect.php` contains the CORS headers at the top:
```php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");

```



---

## 🌐 Step 4: Find Your IP Address

1. On your computer, press `Windows Key + R`.
2. Type `cmd` and press **Enter**.
3. Type `ipconfig` and press **Enter**.
4. Look for **IPv4 Address**. It will look like `192.168.0.x` (e.g., `192.168.0.12`).
5. **Write this down.**

---

## 📱 Step 5: Configure the Frontend

1. Open your `index.html` file in your code editor.
2. Scroll to the bottom `<script>` section.
3. Find the `BASE_URL` constant.
4. Update it with **YOUR** computer's IPv4 address:

```javascript
// REPLACE '192.168.0.12' with YOUR IPv4 Address from Step 4
const BASE_URL = "[http://192.168.0.12/fittrack_api](http://192.168.0.12/fittrack_api)";

```

5. Save the file.

---

## 🔌 Step 6: Connect & Test

### Option A: Test on Browser

1. Open Chrome on your computer.
2. Go to `http://localhost/fittrack_api/get_activities.php`
3. If you see JSON text (e.g., `{"status":"success"...}`), the backend is working.

### Option B: Run on Android Phone

1. **Turn OFF Windows Firewall** (Temporarily for testing):
* Search "Windows Defender Firewall" -> "Turn Windows Defender Firewall on or off" -> Select **Turn Off**.


2. Send the `index.html` file to your phone (or host it).
3. Alternatively, connect your phone via USB and run via Android Studio if using WebView.
4. **Test:** Open Chrome on your phone and type: `http://192.168.0.x/fittrack_api/get_activities.php` (replace `x` with your IP).
5. If that loads, open your App and try to **Save an Activity**.

---

## 🛠️ Troubleshooting

* **"Connection Failed"**:
* Is your Firewall off?
* Are both devices on the same Wi-Fi?
* Did your IP address change? (Run `ipconfig` again).


* **"Server Error" / Syntax Error**:
* Did you create the `image` column in the database (Step 2)?
* Is the photo too large? (XAMPP default limit is 2MB).



```
```
