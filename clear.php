<?php

setCookie('secret', '', time() + 15 * 3600 * 24);
header("Location: index.php");
