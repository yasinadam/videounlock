<?php if(isset($_SESSION["logged"]) === true){ ?>
<p class="alert alert-info">Welcome to dashboard!</p>
<?php } else {
    http_response_code(403);
} ?>