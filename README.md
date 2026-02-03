# Iseki Feed - Procedure & Upload Management System

## Overview

**Iseki Feed** is a web-based application focused on managing operational procedures and digital assets. It provides a structured hierarchy for organizing procedures by **Tractor** and **Area**, allowing for granular documentation and training resource management.

The system distinguishes between Admin capabilities (full management) and general User access/contribution flows.

## Key Features

### 1. Procedure Management
*   **Hierarchical Structure**: Organize content via Tractor -> Area -> Procedure.
*   **CRUD Operations**: Create, Read, Update, and Delete procedures at every level.
*   **Item & Uploads**: Attach specific items and files to procedures for detailed documentation.

### 2. Digital Asset Management
*   **Upload Controller**: Dedicated functionality for handling file uploads (`UploadController`).
*   **Media Integration**: Manage images/documents associated with procedures.

### 3. User Roles
*   **Admin**:
    *   Secure login via `AuthAdmin` middleware.
    *   User management (Create, Update, Delete users).
    *   Full control over Master Data (Tractors, Areas).
*   **User/General**:
    *   Access to procedure workflows (`UserProcedureController`).
    *   Capability to contribute to procedure creation and updates (depending on configuration).

## Technology Stack

### Backend
*   **Framework**: [Laravel 12.x](https://laravel.com)
*   **Language**: PHP ^8.2
*   **Database**: SQLite (Default)
*   **Authentication**: Custom `AuthAdmin` Middleware

### Frontend
*   **Build Tool**: [Vite](https://vitejs.dev)
*   **Styling**: [Tailwind CSS v4.0](https://tailwindcss.com)
*   **HTTP Client**: Axios

## Installation & Setup

1.  **Clone the Repository**
    ```bash
    git clone <repository-url>
    cd iseki_feed
    ```

2.  **Install Dependencies**
    ```bash
    composer install
    npm install
    ```

3.  **Environment Configuration**
    *   Copy the `.env.example` file:
        ```bash
        cp .env.example .env
        ```
    *   Configure your database settings.

4.  **Database Migration**
    ```bash
    php artisan key:generate
    php artisan migrate
    ```

5.  **Build Assets**
    ```bash
    npm run build
    ```

6.  **Serve Application**
    ```bash
    php artisan serve
    ```
    The application will be accessible at `http://localhost:8000`.

## License

This project is proprietary.
