
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>My Account | We Shop Smart</title>
</head>
<body>

    <h1>
        Welcome, {{ auth()->user()->name }}!
    </h1>

    <h2>My Account</h2>

    <p>
        Email: {{ auth()->user()->email }}
    </p>

    <p>
        Role: {{ auth()->user()->role }}
    </p>

    <a href="{{ route('storefront.shop') }}">
        Go to Shop
    </a>

    <form action="{{ route('logout') }}" method="POST">
        @csrf

        <button type="submit">
            Logout
        </button>
    </form>

</body>
</html>
