<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Login</title>

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family: 'Segoe UI', sans-serif;
}

body{
    height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
    background: #0f172a;
}

/* card */
.login-box{
    width:360px;
    padding:35px;
    border-radius:16px;
    background: rgba(255,255,255,0.08);
    backdrop-filter: blur(12px);
    border:1px solid rgba(255,255,255,0.15);
    box-shadow: 0 10px 30px rgba(0,0,0,0.4);
    text-align:center;
    animation: fadeIn 0.6s ease;
}

/* animasi masuk */
@keyframes fadeIn{
    from{
        transform: translateY(20px);
        opacity:0;
    }
    to{
        transform: translateY(0);
        opacity:1;
    }
}

/* header */
.header{
    display:flex;
    justify-content:center;
    align-items:center;
    gap:10px;
    margin-bottom:25px;
}

.header h2{
    color:white;
    font-weight:600;
}

/* input */
.input-box{
    position:relative;
    margin:12px 0;
}

.input-box input{
    width:100%;
    padding:12px 12px;
    border:none;
    outline:none;
    border-radius:10px;
    background: rgba(255,255,255,0.1);
    color:white;
    transition:0.3s;
}

.input-box input::placeholder{
    color:#cbd5e1;
}

.input-box input:focus{
    background: rgba(255,255,255,0.2);
    transform: scale(1.02);
}

/* button */
button{
    width:100%;
    padding:12px;
    margin-top:15px;
    border:none;
    border-radius:10px;
    background: linear-gradient(135deg,#4facfe,#00f2fe);
    color:white;
    font-weight:600;
    cursor:pointer;
    transition:0.3s;
}

button:hover{
    transform: scale(1.05);
    box-shadow: 0 8px 20px rgba(79,172,254,0.4);
}

</style>

</head>
<body>

<div class="login-box">
    <form method="POST" action="proses_login.php">

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