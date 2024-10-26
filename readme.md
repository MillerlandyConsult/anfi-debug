# Custom Debugging Solution for Laravel Octane

This guide will help you create a custom debugging solution for your Laravel project running with Octane. Since traditional debugging tools like Xdebug might not be available, we'll create a package that allows you to cache variables and view them in a modern, user-friendly web interface that updates every 5 seconds.

## Table of Contents

- [Introduction](#introduction)
- [Features](#features)
- [1. Create a Helper to Store Variables in Cache](#1-create-a-helper-to-store-variables-in-cache)
- [2. Create a Route and Controller to Display the Variables](#2-create-a-route-and-controller-to-display-the-variables)
- [3. Create the Blade View with an Attractive Design](#3-create-the-blade-view-with-an-attractive-design)
- [4. Update Variables Every 5 Seconds](#4-update-variables-every-5-seconds)
- [5. Package with Composer](#5-package-with-composer)
- [Conclusion](#conclusion)
- [Additional Tips](#additional-tips)
- [License](#license)
- [Contributing](#contributing)
- [Contact](#contact)

---

## Introduction

This package provides a custom debugging solution for Laravel applications running with Octane, where traditional debugging tools like Xdebug might not be available. It allows developers to cache variables and view them in a modern, user-friendly web interface that updates every 5 seconds.

## Features

- **Cache Variables:** Store any variables for debugging purposes.
- **Web Interface:** View cached variables in a modern, user-friendly interface.
- **Automatic Refresh:** The interface updates every 5 seconds to display the latest values.
- **Easy Installation:** Installable via Composer.
- **Laravel Compatibility:** Supports Laravel 8.x, 9.x, and 10.x.

---

## 1. Create a Helper to Store Variables in Cache

We need a helper function that allows us to store variables in the cache with a specific key.

### Step 1: Create the Helper File

Create a helper file if you don't have one already. For example:

```
app/Helpers/DebugHelper.php
```

### Step 2: Add the Debug Function

Add the following function to the helper:

```php
<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Cache;

class DebugHelper
{
    public static function debug(array $variables, $key = null)
    {
        $key = $key ?? 'debug-' . uniqid();
        Cache::put($key, $variables, now()->addMinutes(10)); // Adjust expiration time as needed

        return $key;
    }
}
```

### Step 3: Autoload the Helper

Ensure Laravel loads your helpers. In `composer.json`, add:

```json
"autoload": {
    "files": [
        "app/Helpers/DebugHelper.php"
    ]
}
```

Then run:

```bash
composer dump-autoload
```

### Usage of the Helper

Import and use the helper in your code:

```php
use App\Helpers\DebugHelper;

$key = DebugHelper::debug([
    'variable1' => $value1,
    'variable2' => $value2,
    // Add as many variables as you need
]);
```

---

## 2. Create a Route and Controller to Display the Variables

### Step 1: Add the Route

Add a route in `routes/web.php`:

```php
Route::get('/debug/{key}', [App\Http\Controllers\DebugController::class, 'showDebug']);
```

### Step 2: Create the Controller

Create the controller `DebugController`:

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cache;

class DebugController extends Controller
{
    public function showDebug($key)
    {
        $variables = Cache::get($key, []);

        return view('debug.view', compact('variables', 'key'));
    }
}
```

---

## 3. Create the Blade View with an Attractive Design

### Step 1: Create the Main View

Create the view file `resources/views/debug/view.blade.php`:

```blade
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Debug Variables</title>
    <link rel="stylesheet" href="{{ asset('css/debug.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
</head>
<body>
    <div class="container">
        <h1>Debug Variables</h1>
        <div id="variables-container">
            @include('debug.partials.variables', ['variables' => $variables])
        </div>
    </div>

    <script>
        setInterval(function() {
            axios.get('{{ url("/debug/{$key}") }}')
                .then(function (response) {
                    document.getElementById('variables-container').innerHTML = response.data;
                });
        }, 5000);
    </script>
</body>
</html>
```

### Step 2: Create the Partial View

Create the partial view `resources/views/debug/partials/variables.blade.php`:

```blade
@foreach($variables as $name => $value)
    <div class="variable">
        <h2>{{ $name }}</h2>
        <pre>@dump($value)</pre>
    </div>
@endforeach
```

Using the `@dump` directive provides a cleaner and more readable output.

### Step 3: Create the CSS File

Create the CSS file `public/css/debug.css`:

```css
body {
    font-family: Arial, sans-serif;
    background-color: #f0f0f0;
}

.container {
    width: 80%;
    margin: 50px auto;
    background: #fff;
    padding: 20px;
    border-radius: 8px;
}

.variable {
    margin-bottom: 20px;
}

.variable h2 {
    background-color: #007BFF;
    color: #fff;
    padding: 10px;
    border-radius: 4px;
}

.variable pre {
    background-color: #e9ecef;
    padding: 15px;
    border-radius: 4px;
    overflow-x: auto;
}
```

---

## 4. Update Variables Every 5 Seconds

To refresh the variables display every 5 seconds, we need to adjust the controller and JavaScript.

### Update the Controller Method

Modify the `showDebug` method in `DebugController`:

```php
public function showDebug($key)
{
    $variables = Cache::get($key, []);

    if (request()->ajax()) {
        return view('debug.partials.variables', compact('variables'))->render();
    }

    return view('debug.view', compact('variables', 'key'));
}
```

### Update the JavaScript

Modify the script in `view.blade.php`:

```html
<script>
    setInterval(function() {
        axios.get('{{ url("/debug/{$key}") }}')
            .then(function (response) {
                document.getElementById('variables-container').innerHTML = response.data;
            });
    }, 5000);
</script>
```

---

## 5. Package with Composer

To make this solution installable via Composer, we'll create a package.

### Step 1: Create a New Repository

Create a new repository for your package, e.g., `MillerlandyConsult/debug-package`.

### Step 2: Set Up Directory Structure

```
debug-package/
├── src/
│   ├── DebugHelper.php
│   └── DebugController.php
├── resources/
│   └── views/
│       ├── view.blade.php
│       └── partials/
│           └── variables.blade.php
├── public/
│   └── css/
│       └── debug.css
├── composer.json
```

### Step 3: Configure `composer.json`

```json
{
    "name": "MillerlandyConsult/debug-package",
    "description": "A Laravel package for caching and viewing debug variables in Octane apps.",
    "type": "library",
    "autoload": {
        "psr-4": {
        },
        "files": [
            "src/DebugHelper.php"
        ]
    },
    "extra": {
        "laravel": {
            "providers": [
            ]
        }
    },
    "require": {
        "php": ">=7.4",
        "illuminate/support": "^8.0|^9.0|^10.0"
    }
}
```

### Step 4: Create the Service Provider

Create `src/DebugServiceProvider.php`:

```php
<?php

use Illuminate\Support\ServiceProvider;

class DebugServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'debug-package');

        $this->publishes([
            __DIR__.'/../public/css' => public_path('vendor/debug-package/css'),
        ], 'public');

        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/debug-package'),
        ], 'views');

        $this->loadRoutesFrom(__DIR__.'/routes.php');
    }

    public function register()
    {
        //
    }
}
```

### Step 5: Define the Routes

Create `src/routes.php`:

```php
<?php

use Illuminate\Support\Facades\Route

Route::get('/debug/{key}', [DebugController::class, 'showDebug']);
```

### Step 6: Update Controller and Helper Namespaces

**`src/DebugController.php`:**

```php
<?php

use Illuminate\Support\Facades\Cache;

class DebugController extends \App\Http\Controllers\Controller
{
    public function showDebug($key)
    {
        $variables = Cache::get($key, []);

        if (request()->ajax()) {
            return view('debug-package::partials.variables', compact('variables'))->render();
        }

        return view('debug-package::view', compact('variables', 'key'));
    }
}
```

**`src/DebugHelper.php`:**

```php
<?php

use Illuminate\Support\Facades\Cache;

class DebugHelper
{
    public static function debug(array $variables, $key = null)
    {
        $key = $key ?? 'debug-' . uniqid();
        Cache::put($key, $variables, now()->addMinutes(10));

        return $key;
    }
}
```

### Step 7: Adjust the Views

**`resources/views/view.blade.php`:**

```blade
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Debug Variables</title>
    <link rel="stylesheet" href="{{ asset('vendor/debug-package/css/debug.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
</head>
<body>
    <div class="container">
        <h1>Debug Variables</h1>
        <div id="variables-container">
            @include('debug-package::partials.variables', ['variables' => $variables])
        </div>
    </div>

    <script>
        setInterval(function() {
            axios.get('{{ url("/debug/{$key}") }}')
                .then(function (response) {
                    document.getElementById('variables-container').innerHTML = response.data;
                });
        }, 5000);
    </script>
</body>
</html>
```

**`resources/views/partials/variables.blade.php`:**

```blade
@foreach($variables as $name => $value)
    <div class="variable">
        <h2>{{ $name }}</h2>
        <pre>@dump($value)</pre>
    </div>
@endforeach
```

### Step 8: Publish the Package

Publish your package to GitHub or another accessible repository.

### Step 9: Install the Package via Composer

1. Add the repository to your project's `composer.json`:

    ```json
    "repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/MillerlandyConsult/debug-package"
        }
    ],
    ```

2. Require the package:

    ```bash
    composer require MillerlandyConsult/debug-package
    ```

3. Publish the assets:

    ```bash
    ```

---

## Conclusion

With these steps, you've created a custom debugging solution that:

- **Stores Variables in Cache:** Easily cache any variables you need to debug.
- **Displays Variables in Web Interface:** View the variables in a modern, user-friendly interface.
- **Automatic Updates:** The interface refreshes every 5 seconds to show the latest data.
- **Composer Package:** Packaged for easy installation and reuse in other projects.

---

## Additional Tips

- **Customization:** Modify the CSS or views to better suit your preferences or integrate with your application's design.
- **Security Considerations:**
  - Ensure that the debug routes are not accessible in production environments.
  - Protect the routes with authentication or IP restrictions if necessary.
- **Extensibility:** Add features like variable filtering, searching, or grouping for better data management.

---

## License

This package is open-sourced software licensed under the [MIT license](LICENSE).

---

## Contributing

Contributions are welcome! Please submit a pull request or open an issue to discuss changes.

---

## Contact

If you have any questions or need support, please open an issue on the [GitHub repository](https://github.com/MillerlandyConsult/debug-package).

---