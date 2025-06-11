# Motivus Database Setup Guide

This guide explains how I set up the database for the Motivus vehicle rental management system.

## Overview

The database schema includes the following tables:
- `roles` - User roles (renter, owner, driver, admin)
- `users` - System users with role-based access
- `vehicles` - Vehicle listings by owners
- `bookings` - Rental bookings by renters
- `payments` - M-PESA payment records
- `delivery_tasks` - Vehicle delivery assignments
- `vehicle_reviews` - Customer reviews for vehicles



## Database Configuration

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=motivus
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

## Setup Steps

### 1. Create Database
First, create the database in MySQL:

```sql
CREATE DATABASE motivus CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 2. Run Migrations
Execute the migrations in the correct order:

```bash
# Run all migrations
php artisan migrate

# Or run them individually in order:
php artisan migrate --path=database/migrations/2024_01_01_000001_create_roles_table.php
php artisan migrate --path=database/migrations/0001_01_01_000000_create_users_table.php
php artisan migrate --path=database/migrations/2024_01_01_000003_create_vehicles_table.php
php artisan migrate --path=database/migrations/2024_01_01_000004_create_bookings_table.php
php artisan migrate --path=database/migrations/2024_01_01_000005_create_payments_table.php
php artisan migrate --path=database/migrations/2024_01_01_000006_create_delivery_tasks_table.php
php artisan migrate --path=database/migrations/2024_01_01_000007_create_vehicle_reviews_table.php
```

### 3. Seed Initial Data
Run the seeders to populate initial roles:

```bash
# Seed roles
php artisan db:seed --class=RoleSeeder

# Or seed all (includes roles)
php artisan db:seed
```

### 4. Verify Setup
Check that all tables were created successfully:

```bash
php artisan tinker
```

Then in tinker:
```php
// Check if roles were created
App\Models\Role::all();

// Check table structure
Schema::getColumnListing('users');
Schema::getColumnListing('vehicles');
Schema::getColumnListing('bookings');
```

## Model Relationships

### User Model Relationships
- `belongsTo(Role::class)` - User belongs to a role
- `hasMany(Vehicle::class, 'owner_id')` - Owner has many vehicles
- `hasMany(Booking::class, 'renter_id')` - Renter has many bookings
- `hasMany(DeliveryTask::class, 'driver_id')` - Driver has many delivery tasks

### Vehicle Model Relationships
- `belongsTo(User::class, 'owner_id')` - Vehicle belongs to an owner
- `hasMany(Booking::class)` - Vehicle has many bookings

### Booking Model Relationships
- `belongsTo(User::class, 'renter_id')` - Booking belongs to a renter
- `belongsTo(Vehicle::class)` - Booking belongs to a vehicle
- `hasOne(Payment::class)` - Booking has one payment
- `hasOne(DeliveryTask::class)` - Booking has one delivery task
- `hasOne(VehicleReview::class)` - Booking has one review

## Available Roles

The system includes four predefined roles:

1. **renter** - Users who can rent vehicles
2. **owner** - Users who own and list vehicles
3. **driver** - Users who deliver vehicles to renters
4. **admin** - System administrators

## Enum Values

### Booking Status
- `pending` - Booking request submitted
- `accepted` - Booking approved by owner
- `completed` - Rental period finished

### Payment Status
- `pending` - Payment initiated but not confirmed
- `success` - Payment completed successfully
- `failed` - Payment failed

### Delivery Task Status
- `assigned` - Task assigned to driver
- `en_route` - Driver is on the way
- `delivered` - Vehicle delivered to renter

## Troubleshooting

### Migration Issues
If you encounter foreign key constraint errors:

```bash
# Reset and re-run migrations
php artisan migrate:reset
php artisan migrate
php artisan db:seed --class=RoleSeeder
```

### Role Constraint Issues
Ensure roles are seeded before creating users:

```bash
php artisan db:seed --class=RoleSeeder
```

### Testing the Setup
Create a test user to verify everything works:

```php
// In tinker (php artisan tinker)
$role = App\Models\Role::where('name', 'renter')->first();
$user = App\Models\User::create([
    'name' => 'Test Renter',
    'email' => 'renter@test.com',
    'password' => bcrypt('password'),
    'phone' => '+254700000000',
    'role_id' => $role->id,
]);

// Test relationships
$user->role; // Should return the renter role
$user->isRenter(); // Should return true
```

## Next Steps

After setting up the database:

1. Update UserFactory to include `role_id` field
2. Create controllers for each model
3. Set up authentication middleware
4. Implement M-PESA integration
5. Create frontend views

## Notes

- All foreign key constraints use `onDelete('cascade')`
- Timestamps are automatically managed by Laravel
- Enum casting is used for status fields
- Proper indexing is applied for performance
- Model scopes are available for common queries
