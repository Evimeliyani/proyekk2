{{-- resources/views/login.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Presensi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            height: 100vh;
            background-color: #A3C9C6; /* Warna latar belakang umum */
        }
        .left-panel {
            flex: 1;
            /* Ganti dengan URL gambar latar belakang Anda */
            background-image: url('images/evi.jpg'); 
            background-size: cover;
            background-position: center;
            position: relative;
            /* Bentuk melengkung (dapat disesuaikan) */
            clip-path: polygon(0 0, 75% 0, 100% 50%, 85% 100%, 0 100%); 
        }
        .right-panel {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .login-box {
            background-color: transparent;
            padding: 40px;
            width: 300px;
            text-align: center;
        }
        .input-field {
            width: 100%;
            padding: 15px;
            margin-bottom: 20px;
            border: none;
            border-radius: 5px;
            box-sizing: border-box;
            background-color: rgba(140, 178, 174, 0.8);
            color: #fff;
            font-size: 16px;
            text-align: left;
            padding-left: 15px;
        }
        .input-field::placeholder {
            color: rgba(255, 255, 255, 0.8);
        }
        .login-button {
            width: 100%;
            padding: 15px;
            border: none;
            border-radius: 5px;
            background-color: #6C928E;
            color: white;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .login-button:hover {
            background-color: #5A7E7A;
        }
        .error-message {
            color: red;
            margin-top: 10px;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="left-panel">
        {{-- Area untuk gambar latar belakang --}}
    </div>
    <div class="right-panel">
        <div class="login-box">
            {{-- Pastikan action mengarah ke rute POST login --}}
            <form method="POST" action="{{ url('/login-presensi') }}">
                @csrf
                
                {{-- Input Name (Hanya untuk tampilan, tidak digunakan untuk Auth di Controller) --}}
                <input type="text" name="name_tampilan" class="input-field" placeholder="Name" required autofocus>
                
                {{-- Input Email (Digunakan untuk Auth) --}}
                <input type="email" name="email" class="input-field" placeholder="Email" required>
                
                {{-- Input Password (Digunakan untuk Auth) --}}
                <input type="password" name="password" class="input-field" placeholder="Password" required>
                
                <button type="submit" class="login-button">
                    Login
                </button>
                
                @error('email')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </form>
        </div>
    </div>
</body>
</html>