<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Web-Based Homecare System</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            max-width: 800px;
            margin: auto;
            padding: 20px;
        }
        h1, h2 {
            color: #333;
        }
        ul {
            list-style: none;
            padding: 0;
        }
        ul li::before {
            content: "✅ ";
        }
        code {
            background: #f4f4f4;
            padding: 5px;
            display: block;
            border-left: 3px solid #007BFF;
        }
    </style>
</head>
<body>
    <h1>🏥 Web-Based Homecare System</h1>
    <p>A Laravel-based homecare monitoring system with real-time communication, video calls, and patient management.</p>
    
    <h2>🚀 Features</h2>
    <ul>
        <li>Real-time chat using Pusher.js</li>
        <li>Video calls with Daily.co</li>
        <li>Patient Portal for managing homecare services</li>
        <li>Admin Portal for monitoring patient requests & caregiver activities</li>
        <li>Secure authentication and role-based access</li>
        <li>WAMPServer (MySQL) support for local database simulation</li>
    </ul>
    
    <h2>🛠️ Installation Guide</h2>
    <h3>1. Clone the Repository</h3>
    <code>git clone https://github.com/your-username/WebBasedHomecareSystem.git<br>cd WebBasedHomecareSystem</code>
    
    <h3>2. Install Dependencies</h3>
    <code>composer install<br>npm install</code>
    
    <h3>3. Configure Environment Variables</h3>
    <p>Copy <code>.env.example</code> and rename it to <code>.env</code></p>
    <p>Update database settings in <code>.env</code> (WAMP MySQL)</p>
    <p>Add your <code>Pusher.js</code> and <code>Daily.co</code> credentials</p>
    <code>php artisan key:generate</code>
    
    <h3>4. Database Setup</h3>
    <code>php artisan migrate --seed</code>
    
    <h3>5. Start the Application</h3>
    <code>php artisan serve</code>
    <p>Open <a href="http://127.0.0.1:8000">http://127.0.0.1:8000</a> in your browser.</p>
    
    <h2>📜 Tech Stack</h2>
    <ul>
        <li>Laravel 8 - Backend Framework</li>
        <li>Bootstrap 5 - UI Framework</li>
        <li>MySQL (WAMPServer) - Database</li>
        <li>Pusher.js - Real-time messaging</li>
        <li>Daily.co - Video calls</li>
        <li>JavaScript & jQuery - Frontend interactivity</li>
    </ul>
    
    <h2>📸 Screenshots</h2>
    <p>(Optional: Add images here to showcase UI)</p>
</body>
</html>
