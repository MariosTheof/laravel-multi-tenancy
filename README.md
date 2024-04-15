# Multi-Tenant SaaS Application

This repository contains a Laravel application developed as part of a technical assessment for a job interview. It demonstrates the implementation of a scalable and secure multi-tenant SaaS platform using Laravel and Livewire.

## Technologies Used

- **Backend**: Laravel 11
- **Frontend**: Livewire, Tailwind CSS
- **Database**: MySQL with tenant isolation using Spatie's Multitenancy
- **Security**: Utilizes Laravel's built-in security features, along with Spatie's Roles & Permissions

## Setup and Local Development

Follow these steps to set up the application on your local machine:

1. **Start the application**:
   ```bash
   sail up -d
   ```
2. **Setup the databases**:
```bash
   ./setup-databases.sh
```
   
3. **Run Tests**:
```bash
    sail pest
```


Features and Assumptions

    Admin Rights: Admins can create, read, update, and delete (CRUD) all entries.
    Moderator Rights: Moderators have CRUD capabilities only on entries they have created.

Focus Areas

    User Interaction: Used Livewire Components instead of traditional controllers to enhance user interaction by allowing instant updates to the UI.
    Multi-Tenancy: Implemented a robust multi-tenancy system using Spatie's Multitenancy package to ensure data isolation and security.
    Testing: Comprehensive testing across the application to ensure functionality and stability.

Future Enhancements

    Search Functionality: Improve the search features to allow more complex queries.
    Modals for Editing: Implement modals for editing entries to enhance user experience.
    Pagination: Add pagination to tables to improve handling of large datasets.

