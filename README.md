🏥 Web-Based Homecare System<br>
A Laravel-based homecare monitoring system with real-time communication, video calls, and patient management.

🚀 Features<br>
✅ Real-time chat using Pusher.js<br>
✅ Video calls with Daily.co<br>
✅ Patient Portal for managing homecare services<br>
✅ Admin Portal for monitoring patient requests & caregiver activities<br>
✅ Secure authentication and role-based access<br>
✅ WAMPServer (MySQL) support for local database simulation<br>

🛠️ Installation Guide<br>
1. Clone the Repository<br>
   - git clone https://github.com/kyiiiiiii/WebBasedHomecareSystem.git<br>
   - cd WebBasedHomecareSystem</li><br>
    
2. Install Dependencies<br>
   - composer install<br>
   - npm install<br>

3. Configure Environment Variables<br>
   - Copy .env.example and rename it to .env<br>
   - Update database settings in .env (WAMP MySQL)<br>
   - Add your Pusher.js and Daily.co credentials<br>

4. Database Setup<br>
   - php artisan migrate --seed<br>

5. Start the Application<br>
   - php artisan serve<br>

Open http://127.0.0.1:8000 in your browser.

📜 Tech Stack<br>
🔹 Laravel 8 - Backend Framework<br>
🔹 Bootstrap 5 - UI Framework<br>
🔹 MySQL (WAMPServer) - Database<br>
🔹 Pusher.js - Real-time messaging<br>
🔹 Daily.co - Video calls<br>
🔹 JavaScript & jQuery - Frontend interactivity<br>

📸 Screenshots

## 📸 Screenshots  

<p align="center"> <img src="screenshots/LoginPage.png" width="300"> <img src="screenshots/admin%20dashboard.png" width="300"> <img src="screenshots/appintment.png" width="300"> <img src="screenshots/healthinfo.png" width="300"> <img src="screenshots/message.png" width="300"> <img src="screenshots/patientDashboard.png" width="300"> <img src="screenshots/responsiveness.png" width="300"> <img src="screenshots/services.png" width="300"> <img src="screenshots/services2.png" width="300"> <img src="screenshots/videocall.png" width="300"> </p>

