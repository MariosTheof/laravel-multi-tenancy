#!/bin/bash

# Exit script on error
set -e

# Function to handle errors
error_handling() {
  echo "Error occurred at $(date) when executing the command: $1"
  exit 1
}

# Defining a function for logging
log_success() {
  echo "$1 completed successfully at $(date)"
}

# Path to the sail script
SAIL_CMD="./vendor/bin/sail"

# Running migration for the landlord database
echo "Starting landlord database migration..."
$SAIL_CMD artisan migrate --database=landlord --path=database/migrations/landlord || error_handling "landlord migration"
log_success "Landlord migration"

# Seeding the TenantsSeeder
echo "Starting database seeding with TenantsSeeder..."
$SAIL_CMD artisan db:seed TenantsSeeder || error_handling "TenantsSeeder seeding"
log_success "TenantsSeeder seeding"

# Migrating and seeding tenant 2
echo "Starting migration for tenant 2..."
$SAIL_CMD artisan tenants:artisan "migrate:fresh --path=database/migrations/tenant" --tenant=2 || error_handling "tenant 2 migration"
log_success "Tenant 2 migration"

echo "Starting seeding for tenant 2..."
$SAIL_CMD artisan tenants:artisan "db:seed" --tenant=2 || error_handling "tenant 2 seeding"
log_success "Tenant 2 seeding"

# Migrating and seeding tenant 1
echo "Starting migration for tenant 1..."
$SAIL_CMD artisan tenants:artisan "migrate:fresh --path=database/migrations/tenant" --tenant=1 || error_handling "tenant 1 migration"
log_success "Tenant 1 migration"

echo "Starting seeding for tenant 1..."
$SAIL_CMD artisan tenants:artisan "db:seed" --tenant=1 || error_handling "tenant 1 seeding"
log_success "Tenant 1 seeding"

echo "All tasks completed successfully!"
