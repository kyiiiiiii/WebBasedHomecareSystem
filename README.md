🏥 Web-Based Homecare System<br>
A Laravel-based homecare monitoring system with real-time communication, video calls, and patient management.<br>

📌 **Final Year Project (FYP)**  <br>
Developed by ME, a Software Engineering student, as part of the final year project to enhance homecare monitoring and patient management.<br>

🚀 Features<br>
✅ Real-time chat using Pusher.js<br>
✅ Video calls with Daily.co<br>
✅ Patient Portal for managing homecare services<br>
✅ Admin Portal for monitoring patient requests & caregiver activities<br>
✅ Secure authentication and role-based access<br>
✅ WAMPServer (MySQL) support for local database simulation<br>

💓 Heartbeat Monitoring with Arduino Uno<br>
This system integrates an Arduino Uno with a heartbeat sensor to measure a patient’s heart rate. The data is processed using Python and sent to a Laravel API, where it is stored and displayed in real-time on the patient dashboard.<br>

🛠️ Hardware Components<br>
= Arduino Uno<br>
= Heartbeat Sensor AD8232 <br>
= USB Cable (for data transmission)<br>
= Jumper Wires<br>

![Hardware](screenshots/arduino.png)

🔗 How It Works<br>
= The heartbeat sensor detects the pulse from the patient’s fingertip.<br>
= The Arduino Uno processes the signal and sends the heart rate data via serial communication.<br>
= The system stores and displays the data in real time on the patient dashboard.<br>

### 🖥️ The result will look like this:
![Heartbeat Monitoring](screenshots/heartbeat.png)



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

###📸 Sample Screenshots

### 🏠 Login Page  
![Login Page](screenshots/LoginPage.png)  

### 🔹 Admin Dashboard  
![Admin Dashboard](screenshots/admin%20dashboard.png)  

### 📅 Appointment  
![Appointment](screenshots/appintment.png)  

### 🏥 Health Info  
![Health Info](screenshots/healthinfo.png)  

### 💬 Messages  
![Messages](screenshots/message.png)  

### 🧑‍⚕️ Patient Dashboard  
![Patient Dashboard](screenshots/patientDashboard.png)  

### 📏 Responsiveness  
![Responsiveness](screenshots/responsiveness.png)  

### 🛠️ Services  
![Services](screenshots/services.png)  

### 🛠️ More Services  
![More Services](screenshots/services2.png)  

### 📞 Video Call  
![Video Call](screenshots/videocall.png)  


