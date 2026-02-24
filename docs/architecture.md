# Architecture Overview

This document serves as a critical, living template designed to equip agents with a rapid and comprehensive understanding of the codebase's architecture, enabling efficient navigation and effective contribution from day one. Update this document as the codebase evolves.

## 1. Project Structure

This section provides a high-level overview of the project's directory and file structure, categorised by architectural layer or major functional area. It is essential for quickly navigating the codebase, locating relevant files, and understanding the overall organization and separation of concerns.

[Project Root]/
├── app/                  # Core Backend & Business Logic
│   ├── Actions/          # [Action Layer] Invokable single-responsibility classes
│   ├── Filament/         # [Admin Layer] Resources, Widgets, and Pages
│   ├── Livewire/         # [Frontend Layer] Component logic and state
│   ├── Mail/             # [Communications] Mailable definitions
│   ├── Models/           # [Domain Layer] Eloquent Database models
│   ├── Policies/         # [Security Layer] Auth-level permission logic
│   └── Providers/        # Bootstrapping and service bindings
├── config/               # System configuration (Mail, DB, Filament)
├── database/             # Schema persistence, seeders, and factories
├── docs/                 # Project documentation (Architecture, ERD)
├── resources/            # Frontend assets and presentation
│   ├── views/            # Blade templates and Livewire components
│   └── css/              # Tailwind CSS and styling
├── routes/               # Web and API route definitions
├── tests/                # Automated testing suite (Pest)
└── README.md             # Project overview and quick start guide

## 2. High-Level System Diagram

The system uses a unified Laravel monolith architecture with a focus on clear separation between the administrative shell (Filament) and the learner-facing reactive frontend (Livewire + Alpine.js).

[User] <--> [Livewire + Alpine.js UI] <--> [Laravel Backend] <--> [MySQL Database]
                                     |
                                     +--> [Action Classes] <--> [Mail/SMTP]
[Admin] <--> [Filament v3 Admin Panel] ---^

## 3. Core Components

### 3.1. Frontend

**Name**: TALL Stack Learner Interface

**Description**: The primary user interface for students to browse courses, watch lessons, and track their progress through a reactive, SPA-like experience.

**Technologies**: Livewire 3, Alpine.js, Tailwind CSS, Plyr.js (Media).

**Deployment**: InfinityFree (Publicly accessible Web Root).

### 3.2. Backend Services

#### 3.2.1. Business Logic Layer (Actions)

**Name**: Invokable Actions Pattern

**Description**: Encapsulates core project workflows (Registration, Enrollment, Completion) into dedicated classes, ensuring high testability and consistent data handling.

**Technologies**: PHP 8.2+, Laravel 11/12.

**Deployment**: On-premise/Shared Hosting (PHP Runtime).

#### 3.2.2. Administrative Panel

**Name**: Filament CMS

**Description**: A powerful, secure back-office for administrators to manage the curriculum (Levels, Courses, Lessons) and monitor student enrollment status in real-time.

**Technologies**: Filament v3 (TALL-based).

**Deployment**: Integrated within the same application shell.

## 4. Data Stores

### 4.1. Relational Database (Main)

**Name**: MySQL LMS Storage

**Type**: MySQL 8.x

**Purpose**: Stores all persistent data including curriculum, user profiles, and granular lesson-by-lesson progress timestamps.

**Key Schemas**: `users`, `courses`, `lessons`, `enrollments`, `lesson_progress`, `course_completions`.

### 4.2. File-Based Persistence

**Name**: Standard Laravel Local Storage

**Type**: Filesystem

**Purpose**: Used for storing logs (`laravel.log`) and local assets if needed.

## 5. External Integrations / APIs

**Service Name 1**: Gmail SMTP (Mail Gateway)

**Purpose**: Delivering critical welcome and course completion notifications.

**Integration Method**: Laravel Mail Driver (SMTP) using Secure App Passwords.

## 6. Deployment & Infrastructure

**Cloud Provider**: InfinityFree (Shared Web Hosting)

**Key Services Used**: PHP 8.2+, MySQL 8.x, Apache/Nginx.

**CI/CD Pipeline**: Manual Git-based deployment or FTP sync.

**Monitoring & Logging**: Standard Laravel Logging (`storage/logs/laravel.log`).

## 7. Security Considerations

**Authentication**: Session-based Laravel Auth for Users; custom Filament Guard for Admins.

**Authorization**: Laravel Policies (`EnrollmentPolicy`, `LessonProgressPolicy`) ensuring Users cannot access or modify others' data.

**Data Encryption**: TLS in transit (SMTP); Bcrypt (Password Hashing); AES-256 for local encryption.

**Key Security Tools/Practices**: `DB::transaction` for consistency; `Atomic Locks` for concurrency management in Auth flows.

## 8. Development & Testing Environment

**Local Setup Instructions**: Clone repo -> `composer install` -> `cp .env.example .env` -> `php artisan migrate --seed`.

**Testing Frameworks**: Pest (for Feature and Unit testing).

**Code Quality Tools**: Laravel Pint (Linting), PSR-12 Standards.

## 9. Future Considerations / Roadmap

* Implement a full Multi-tenant architecture for B2B subdomains.
* Introduce Redis for advanced caching of Dashboard widgets.
* Develop a mobile-first Progressive Web App (PWA) wrapper.

## 10. Project Identification

**Project Name**: Career 180 - Mini-LMS Task

**Repository URL**: [Insert Repository URL]

**Primary Contact/Team**: Omar Ayman Mohamed (Back-End Engineer)

**Date of Last Update**: 2026-02-24

## 11. Glossary / Acronyms

**TALL Stack**: Tailwind, Alpine.js, Laravel, Livewire.

**Action Class**: A single-responsibility class that performs a specific business task.

**Atomic Lock**: A mechanism to ensure that a task (like enrollment) isn't executed twice simultaneously for the same user.
