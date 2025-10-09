<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 30px;">
    <div style="max-width: 600px; margin: 0 auto; background: #ffffff; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
        <h1 style="color: #007bff; border-bottom: 2px solid #007bff; padding-bottom: 10px;">
            Selamat Datang di Dashboard ADMIN!
        </h1>
        
        <p>Anda telah berhasil **Login**.</p>
        
        <p>Detail Akun:</p>
        <ul>
            <li>**Nama:** {{ Auth::user()->nama }}</li>
            <li>**Email:** {{ Auth::user()->email }}</li>
            <li>**Status:** {{ Auth::user()->status }}</li>
        </ul>

        <hr>

        <form method="POST" action="{{ url('/logout') }}">
            @csrf
            <button type="submit" 
                style="background-color: #dc3545; color: white; padding: 10px 15px; border: none; border-radius: 5px; cursor: pointer;">
                Logout
            </button>
        </form>
    </div>
</body>
</html>