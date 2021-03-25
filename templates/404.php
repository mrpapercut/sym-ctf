<?php

http_response_code(404);

include('templates/header.php');
?>
<h2>404 - Page not found</h2>
<div class="content">
<a href="/">Go back home</a>
</div>
<?php
include('templates/footer.php');