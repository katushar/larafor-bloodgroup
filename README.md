
# Laravel Blood Group Management

A Laravel package for managing blood groups in your application. This package provides an easy way to handle blood group data, including CRUD operations and relationships with other models.

## Features

- Manage blood groups with ease.
- Simple API for CRUD operations.
- Configurable blood group settings.
- Easy integration with Laravel applications.

## Installation

You can install the package via Composer. Run the following command in your Laravel project directory:

```bash
composer require larafor/bloodgroup
```

## Configuration

After installing the package, you can publish the configuration file using the following command:

```bash
php artisan vendor:publish --provider="Larafor\Bloodgroup\BloodGroupServiceProvider" --tag=bloodgroup-config
```

This will create a `config/bloodgroup.php` file in your application, where you can customize the settings.

## Database Migration

To create the necessary database table for blood groups, run the following command:

```bash
php artisan migrate
```

## Seeding the Database

You can seed the database with initial blood group data by running:

```bash
php artisan db:seed --class=BloodGroupSeeder
```

## Usage

### Retrieving All Blood Groups

You can retrieve all blood groups using the following code:

```php
use Larafor\Bloodgroup\Models\BloodGroup;

$bloodGroups = BloodGroup::all();
```

### Creating a New Blood Group

To create a new blood group, use the following code:

```php
BloodGroup::create(['name' => 'A+', 'is_active' => true]);
```

### Updating a Blood Group

To update an existing blood group, use the following code:

```php
$bloodGroup = BloodGroup::find(1);
$bloodGroup->update(['is_active' => false]);
```

### Deleting a Blood Group

To delete a blood group, use the following code:

```php
$bloodGroup = BloodGroup::find(1);
$bloodGroup->delete();
```

## Routes

The package provides the following routes:

- `GET /bloodgroup`: Retrieve all blood groups.
- `GET /bloodgroup/{id}`: Retrieve a specific blood group by ID.
- `GET /bloodgroup/name/{name}`: Retrieve a blood group by name.
- `GET /bloodgroup/model/{model}`: Retrieve blood groups with related models.

## License

This package is licensed under the MIT License. See the [LICENSE](LICENSE) file for more information.

## Contributing

If you would like to contribute to this package, please fork the repository and submit a pull request. Any contributions are welcome!

## Author

- **KAWSAR AHMED Tushar** - [GitHub Profile](https://github.com/K-A-Tushar)


### উপসংহার

এই `README.md` ফাইলটি আপনার প্যাকেজের জন্য একটি সম্পূর্ণ ডকুমেন্টেশন প্রদান করবে এবং ব্যবহারকারীদের জন্য এটি সহজে ব্যবহারযোগ্য করে তুলবে। আপনি যদি আরও কিছু জানতে চান বা সাহায্য প্রয়োজন হয়, তাহলে জানাবেন!
