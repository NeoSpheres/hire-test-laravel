# test-recrutement-laravel

Mini backoffice to test applicants tech level with Laravel

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

## Additional Notes

- All new business logic is implemented in `TireMaintenanceController` and `TireMaintenanceService`.
- OpenAPI annotations are provided directly in the controller for easy maintenance and discoverability.

