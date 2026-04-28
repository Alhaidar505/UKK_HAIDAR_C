<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login</title>

<style>
/* =========================
   RESET
========================= */
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Segoe UI', sans-serif;
}

/* =========================
   BODY
========================= */
body{
    min-height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
    background:#0f172a;
    padding:20px;
}

/* =========================
   LOGIN BOX
========================= */
.login-box{
    width:100%;
    max-width:380px;
    padding:35px;
    border-radius:16px;
    background:rgba(255,255,255,0.08);
    backdrop-filter:blur(12px);
    border:1px solid rgba(255,255,255,0.15);
    box-shadow:0 10px 30px rgba(0,0,0,0.4);
    text-align:center;
    animation:fadeIn 0.6s ease;
    transition:0.3s;
}

.login-box:hover{
    transform:translateY(-5px);
}

/* =========================
   ANIMATION
========================= */
@keyframes fadeIn{
    from{
        transform:translateY(20px);
        opacity:0;
    }
    to{
        transform:translateY(0);
        opacity:1;
    }
}

/* =========================
   HEADER
========================= */
.header h2{
    color:#fff;
    font-weight:600;
    margin-bottom:20px;
}

/* =========================
   INPUT
========================= */
.input-box{
    margin:12px 0;
}

.input-box input{
    width:100%;
    padding:12px;
    border:none;
    outline:none;
    border-radius:10px;
    background:rgba(255,255,255,0.1);
    color:#fff;
    font-size:14px;
    transition:0.3s;
}

.input-box input::placeholder{
    color:#cbd5e1;
}

.input-box input:focus{
    background:rgba(255,255,255,0.2);
    transform:scale(1.02);
}

/* =========================
   BUTTON
========================= */
button{
    width:100%;
    padding:12px;
    margin-top:15px;
    border:none;
    border-radius:10px;
    background:linear-gradient(135deg,#4facfe,#00f2fe);
    color:#fff;
    font-weight:600;
    cursor:pointer;
    transition:0.3s;
}

button:hover{
    transform:scale(1.05);
    box-shadow:0 8px 20px rgba(79,172,254,0.4);
}

button:active{
    transform:scale(0.98);
}

/* =========================
   RESPONSIVE
========================= */
@media (max-width:768px){
    .login-box{
        max-width:340px;
        padding:30px;
    }

    button{
        font-size:14px;
    }
}

@media (max-width:480px){
    .login-box{
        padding:25px;
        border-radius:12px;
    }

    .input-box input,
    button{
        font-size:13px;
        padding:11px;
    }
}

@media (max-width:360px){
    .login-box{
        padding:20px;
    }

    .header h2{
        font-size:18px;
    }
}
</style>

</head>
<body>

<div class="login-box">
    <form method="POST" action="proses_login.php">

        <div class="header">
            <h2>Login Sistem</h2>
        </div>

        <div class="input-box">
            <input type="text" name="username" placeholder="Username" required>
        </div>

        <div class="input-box">
            <input type="password" name="password" placeholder="Password" required>
        </div>

        <button type="submit">Masuk</button>

    </form>
</div>

</body>
</html>