<?php if (isset($_SESSION["logged"]) === true) { ?>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="header">
                    <h4 class="title">About</h4>
                </div>
                <div class="content">
                    <strong>Version</strong>
                    <pre><?php echo decode_version(config("version")); ?></pre>
                    <strong>Build Number</strong>
                    <pre><?php config("version", true); ?></pre>
                    <strong>Installation Fingerprint</strong>
                    <pre><?php config("fingerprint", true); ?></pre>
                    <strong>Checksum</strong>
                    <pre><?php echo sha1_file(__DIR__ . "/../../system/action.php"); ?></pre>
                    <strong>PHP Version</strong>
                    <pre><?php echo phpversion(); ?></pre>
                    <strong>cURL Version</strong>
                    <pre><?php echo curl_version()["version"]; ?></pre>
                    <strong>Web Server</strong>
                    <pre><?php echo $_SERVER["SERVER_SOFTWARE"]; ?></pre>
                    <strong>Server IP</strong>
                    <pre><?php echo $_SERVER["SERVER_ADDR"]; ?></pre>
                    <strong>Operating System</strong>
                    <pre><?php echo php_uname(); ?></pre>
                </div>
            </div>
        </div>
    </div>
<?php } else {
    http_response_code(403);
} ?>