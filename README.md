🏥 Web-Based Homecare System
A Laravel-based homecare monitoring system with real-time communication, video calls, and patient management.

🚀 Features
<p>✅ Real-time chat using Pusher.js</p><br>
<p>✅ Video calls with Daily.co</p><br>
<p>✅ Patient Portal for managing homecare services</p><br>
<p>✅ Admin Portal for monitoring patient requests & caregiver activities</p><br>
<p>✅ Secure authentication and role-based access</p><br>
<p>✅ WAMPServer (MySQL) support for local database simulation</p><br>

🛠️ Installation Guide

1. Clone the Repository
git clone https://github.com/kyiiiiiii/WebBasedHomecareSystem.git
cd WebBasedHomecareSystem

2. Install Dependencies
composer install
npm install

3. Configure Environment Variables
Copy .env.example and rename it to .env
Update database settings in .env (WAMP MySQL)
Add your Pusher.js and Daily.co credentials

4. Database Setup
php artisan migrate --seed

5. Start the Application
php artisan serve

Open http://127.0.0.1:8000 in your browser.

📜 Tech Stack
🔹 Laravel 8 - Backend Framework
🔹 Bootstrap 5 - UI Framework
🔹 MySQL (WAMPServer) - Database
🔹 Pusher.js - Real-time messaging
🔹 Daily.co - Video calls
🔹 JavaScript & jQuery - Frontend interactivity

📸 Screenshots 
