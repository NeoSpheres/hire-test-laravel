# test-recrutement-laravel

[![Laravel 11](https://img.shields.io/badge/Laravel-11.x-red?logo=laravel)](https://laravel.com/docs/11.x)
[![Docker](https://img.shields.io/badge/Docker-ready-blue?logo=docker)](https://www.docker.com/)
[![PostgreSQL](https://img.shields.io/badge/PostgreSQL-14%2B-blue?logo=postgresql)](https://www.postgresql.org/)
[![PHP 8.2](https://img.shields.io/badge/PHP-8.2-blueviolet?logo=php)](https://www.php.net/releases/8.2/)

Mini backoffice to test applicants tech level with Laravel

---

## Notes to Reviewers

- **Task conditions:** It was unclear whether scheduling a tire maintenance request should be per car or per user. Since each `Car` is linked to a `User`, the `User` should never be missing. I expect `user_id` as a parameter, and if missing, I get the user from the car relation. This could be improved.
- **Tire replacement records:** I used a different name for these records, referencing `tire_maintenance_requests`. I add tire records when the maintenance request is submitted (not after approval), so I can track requests and prevent duplicate pending/processing requests for the same tire. The `Tire` model has a relation to completed maintenance requests.
- **Stock management:** The task mentioned `implementing underlying stock management`, but I didn't find such a feature in the existing repo. I added a simple `quantity` column to the `Tire` model for this purpose.
- **RabbitMQ:** Jobs are dispatched on each request status change to the `database` connection. If RabbitMQ is set up, it's easy to switch the connection and dispatch there.
- **Job payloads:** Jobs receive plain object IDs, not whole objects, to avoid issues with message size limits in RabbitMQ (and similar systems).
- **Database optimization:** I only added indices to the new tables I created, not the previous schema. This should be sufficient for a proof of concept.
- **Feedback:** Let me know when we can discuss the code. I'd be happy to hear your thoughts!
- **I'm sure I'm forgetting something :D**

---

## Prerequisites

- PHP
- Composer

## Installation

1. **Environment**
   - Copy `.env.default` to `.env`

2. **Dependencies & Migrations**
   - `docker-compose exec app composer update`
   - `docker-compose exec app php artisan migrate`

## Start

Visit: [http://localhost:14200/](http://localhost:14200/)

---

## 🚗 Tire Maintenance Request API

### Overview

This branch introduces a comprehensive Tire Maintenance Request management API, with endpoints for creating, listing, and processing maintenance requests for car tires. All endpoints are documented with OpenAPI (Swagger) using l5-swagger.

### API Endpoints

All endpoints are prefixed with `/api/tire-maintenance`:

- `GET /api/tire-maintenance`  
  List all tire maintenance requests. Supports optional filtering by car model, brand, plate number, and username.

- `POST /api/tire-maintenance`  
  Create a new tire maintenance request.  
  **Request body:**
  ```json
  {
    "car_id": 1,
    "user_id": 2,
    "maintenance_scheduled_at": "2024-07-20T10:00:00Z",
    "tires": [
      { "tire_id": 5, "position": "front_left" },
      { "tire_id": 6, "position": "front_right" }
    ]
  }
  ```

- `PUT /api/tire-maintenance/process/{request_id}`  
  Update the status of a maintenance request.  
  **Request body:**
  ```json
  {
    "status": "completed"
  }
  ```

### Business Rules & Logic

- **Conflict Prevention:**
  - Only one `PENDING` or `IN_PROGRESS` request per car/user/tire combination is allowed. If a conflict is detected, a `StateConflictException` (HTTP 409) is thrown.
- **Stock Checking:**
  - Tire stock is checked before creating a request. If insufficient, the request is rejected.
- **Status Transitions:**
  - Requests can be moved between `PENDING`, `IN_PROGRESS`, `COMPLETED`, and `CANCELLED` with strict transition rules.
  - Cancelling a request restores tire stock.

### Implementation Details

- **Routes:** Defined in `routes/api.php` using a controller group for `TireMaintenanceController`.
- **Controller:** `TireMaintenanceController` handles all API logic, request validation, and delegates business logic to the service layer.
- **Service:** `TireMaintenanceService` implements all business rules, including conflict detection, stock management, and status transitions.
- **Validation:** Request validation is handled by `TireMaintenanceRequest` and `TireMaintenanceProcessRequest`.

### OpenAPI Documentation

Interactive API documentation is generated with **l5-swagger** and available at:

- [http://localhost:14200/api/documentation](http://localhost:14200/api/documentation)

The documentation includes:
- All endpoints, parameters, and request/response schemas
- Business rules and error responses
- Schema definitions for Tire Maintenance Requests and Tires

---

## 🛠️ Makefile Commands

The project provides a Makefile with helpful commands for development and maintenance:

- `make docs` — Generates the OpenAPI documentation using l5-swagger (`php artisan l5-swagger:generate`).
- `make work-queues` — Starts the Laravel queue worker (`php artisan queue:work`).
- `make clear-logs` — Clears the application log file (`echo "" > storage/logs/laravel.log`).

These commands simplify common tasks and are especially useful in development and CI environments.

---

## 🐚 .psysh.php (Tinker Autoload Helper)

The `.psysh.php` file is a custom configuration for Laravel Tinker (PsySH) that:

- Automatically creates class aliases for all classes, interfaces, traits, and enums in the `app/` directory.
- Allows you to use class names directly in Tinker without specifying their full namespace (e.g., `User` instead of `App\Models\User`).
- Handles naming conflicts by prefixing the alias with the parent directory name and notifies you in the Tinker session if any aliases were prefixed.

This makes interactive debugging and experimentation in Tinker much more convenient and productive.

---

## Additional Notes

- All new business logic is implemented in `TireMaintenanceController` and `TireMaintenanceService`.
- OpenAPI annotations are provided directly in the controller for easy maintenance and discoverability.

