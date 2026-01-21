<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit Contact</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/public/css/login.css">
</head>

<body>
<div class="container">
    <div class="text-center mb-4">
        <img src="/public/images/logo.jpg" class="logo">
        <h5 class="fw-bold">LIBRARY MANAGEMENT SYSTEM</h5>
    </div>

   <form action="/public/user/profile/edit" method="post">


        <div class="mb-3">
            <label>Full Name</label>
            <input type="text" class="form-control" name="full_name"  placeholder="Full name" required>             
                   
        </div>

        <div class="mb-3">
            <label>Phone</label>
            <input type="text" class="form-control" name="phone"  placeholder="Enter phone number" required> 
                
        </div>

        <button class="btn btn-primary w-100">
            UPDATE
        </button>
    </form>
</div>
</body>
</html>
