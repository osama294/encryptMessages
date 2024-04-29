## Prerequisites
- PHP >= 7.3
- Composer
- MySQL or another DB system

## Setup Instructions

1. **Clone the repository**
   ```bash
   https://github.com/osama294/encryptMessages.git
   cd encryptMessages

2. **Install Dependencies**
   ```bash
    composer install

3. **Create Environment File**
   ```bash
    cp .env.example .env

4. **Generate Application Key**
   ```bash
    php artisan key:generate

5. **Create a database**
-Make a new database through your database management tool (like MySQL Workbench, phpMyAdmin).
6. **Update .env File**
   Open .env and update the database settings (DB_DATABASE, DB_USERNAME, and DB_PASSWORD) to reflect your database configuration.
7. **Run Migrations**
   ```bash
    php artisan migrate

8. **Start the Development Server**
   ```bash
    php artisan serve

**Message Encryption and Decryption System - README**

This document provides an overview and usage instructions for the Message Encryption and Decryption System.

### Features
1. **Add New Message**
   - **URL**: http://127.0.0.1:8000/messages/create
   - **Steps**:
     1. Enter Recipient Name
     2. Enter Recipient Identifier
     3. Compose Message
     4. Set Expiry Time (in minutes)
   - Upon sending the message, an Encryption Key is generated and displayed in an alert, along with a copy button.
   - Closing the alert will redirect to the Read Message URL.

2. **View Message**
   - **URL**: http://127.0.0.1:8000/messages/read
   - **Steps**:
     1. Enter Recipient Name
     2. Enter Secret Code

### Usage Instructions
1. **Add New Message**
   - Access the provided URL to create a new message.
   - Fill in the recipient's name, identifier, compose the message, and set an expiry time.
   - Upon sending, an alert will display the Encryption Key required to decrypt the message. You can copy this key for future reference.
   - Closing the alert will redirect you to the Read Message URL.

2. **View Message**
   - Navigate to the provided URL to read a message.
   - Enter the recipient's name and the secret code obtained when the message was sent.
   - The system will verify the secret code and recipient's name to display the message.
   - Once displayed, the message will be deleted and won't appear upon reloading.
   - Messages are automatically deleted upon expiry if not viewed within the specified time.

### Notes
- Ensure that the recipient's name, identifier, and secret code are accurately entered to access the message.
- Keep the Encryption Key secure as it is required to decrypt the message.
- Messages are encrypted for privacy and security purposes.
- Regularly check for new messages and ensure to view them within the specified expiry time.


