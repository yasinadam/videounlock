<?php
session_destroy();
redirect(config("url") . "/admin");