<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
  <style>
    body {
      background: linear-gradient(135deg, #2b0a3d, #1a0123);
      color: white;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      font-family: 'Poppins', sans-serif;
    }
    .card-custom {
      background: rgba(255, 255, 255, 0.05);
      backdrop-filter: blur(10px);
      border-radius: 15px;
      padding: 2rem;
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
    }
    .btn-gradient {
      background: linear-gradient(90deg, #ff7e5f, #feb47b);
      border: none;
      color: white;
      font-weight: 600;
      transition: 0.3s;
    }
    .btn-gradient:hover {
      opacity: 0.9;
    }
    .welcome-box {
      text-align: left;
    }
    @media (max-width: 768px) {
      .welcome-box {
        text-align: center;
        margin-bottom: 1.5rem;
      }
    }
  </style>
</head>
<body>

  <div class="container">
    <div class="row justify-content-center align-items-center">
      
      <!-- Welcome Section -->
      <div class="col-md-6 welcome-box">
        <h1 class="fw-bold">Welcome!</h1>
        <p>Silakan login untuk masuk ke dashboard admin.</p>
      </div>

      <!-- Login Card -->
      <div class="col-md-5">
        <div class="card-custom">
          <h3 class="text-center mb-4">Sign In</h3>
          
          @if ($errors->any())
            <div class="alert alert-danger">
              {{ $errors->first() }}
            </div>
          @endif

          <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-3">
              <label class="form-label">Email</label>
              <input type="email" name="email" class="form-control bg-dark text-white border-0" required autofocus>
            </div>
            <div class="mb-3">
              <label class="form-label">Password</label>
              <input type="password" name="password" class="form-control bg-dark text-white border-0" required>
            </div>
            <button type="submit" class="btn btn-gradient w-100">Login</button>
          </form>

          <div class="text-center mt-3">
            <a href="{{ route('password.request') }}" class="text-decoration-none text-light">Forgot Password?</a>
          </div>
        </div>
      </div>

    </div>
  </div>

</body>
</html>