<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Admin — DIANCA ATELIER</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Lato:wght@300;400;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
  <style>
    body { background: linear-gradient(135deg, #1A1A1A 0%, #2D1A14 50%, #1A1A1A 100%); min-height:100vh; display:flex; align-items:center; justify-content:center; }
    .login-card { background:#fff; border-radius:24px; padding:48px; width:100%; max-width:440px; box-shadow: 0 24px 80px rgba(0,0,0,0.4); }
    .login-logo { text-align:center; margin-bottom:32px; }
    .login-logo .brand { font-family:'Playfair Display',serif; font-size:2rem; color:#1A1A1A; }
    .login-logo .brand span { color:#C9956C; }
    .login-logo .sub { font-size:0.78rem; letter-spacing:0.2em; text-transform:uppercase; color:#6B6B6B; margin-top:4px; }
    .login-divider { width:50px; height:2px; background:linear-gradient(90deg,#C9956C,#E8C4A0); margin:20px auto; border-radius:2px; }
    .btn-login { width:100%; padding:14px; border-radius:10px; background:linear-gradient(135deg,#C9956C,#A87550); color:#fff; font-family:'Lato',sans-serif; font-size:1rem; font-weight:700; border:none; cursor:pointer; transition:all 0.3s; margin-top:8px; }
    .btn-login:hover { transform:translateY(-2px); box-shadow:0 8px 24px rgba(201,149,108,0.4); }
    .back-link { display:block; text-align:center; margin-top:20px; font-size:0.85rem; color:#6B6B6B; }
    .back-link a { color:#C9956C; font-weight:700; }
  </style>
</head>
<body>
<div class="login-card">
  <div class="login-logo">
    <div class="brand">✦ <span>Butik</span> Elegan</div>
    <div class="sub">Admin Panel</div>
    <div class="login-divider"></div>
  </div>

  <h2 style="text-align:center;font-size:1.3rem;margin-bottom:8px;font-family:'Playfair Display',serif;">Selamat Datang</h2>
  <p style="text-align:center;color:#6B6B6B;font-size:0.88rem;margin-bottom:28px;">Masuk ke panel admin untuk mengelola toko</p>

  @if(session('success'))
    <div class="alert alert-success">✅ {{ session('success') }}</div>
  @endif
  @if(session('error'))
    <div class="alert alert-danger">❌ {{ session('error') }}</div>
  @endif
  @if($errors->any())
    <div class="alert alert-danger">❌ {{ $errors->first() }}</div>
  @endif

  <form action="{{ route('admin.login.post') }}" method="POST">
    @csrf
    <div class="form-group">
      <label class="form-label">Email</label>
      <input type="email" name="email" class="form-control" value="{{ old('email','admin@butik.com') }}" required autofocus placeholder="admin@butik.com">
    </div>
    <div class="form-group">
      <label class="form-label">Password</label>
      <input type="password" name="password" class="form-control" required placeholder="••••••••">
    </div>
    <div style="display:flex;align-items:center;gap:8px;margin-bottom:20px;">
      <input type="checkbox" name="remember" id="remember" style="accent-color:#C9956C;width:16px;height:16px;">
      <label for="remember" style="font-size:0.85rem;color:#6B6B6B;cursor:pointer;">Ingat saya</label>
    </div>
    <button type="submit" class="btn-login">🔐 Masuk ke Dashboard</button>
  </form>

  <div class="back-link">
    <a href="{{ route('home') }}">← Kembali ke Website</a>
  </div>

  <div style="margin-top:24px;padding:14px;background:#FBF7F2;border-radius:10px;text-align:center;">
    <p style="font-size:0.78rem;color:#A87550;">Default: <strong>admin@butik.com</strong> / <strong>admin123</strong></p>
  </div>
</div>
</body>
</html>
