<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>nShell Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/xterm/5.5.0/xterm.min.css" />
    <link rel="stylesheet" href="/apps/nshell/css/admin.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xterm/5.5.0/xterm.min.js"></script>
</head>
<body>
    <div id="nshell-admin">
        <h1>nShell Administration</h1>

        <h2>Admin Terminal</h2>
        <div id="nshell-terminal" style="height: 50vh; border: 1px solid #ccc; margin-bottom: 20px;"></div>

        <form id="nshell-admin-form" method="post">
            <h2>User Access Control</h2>

            <div class="setting">
                <label for="allowed_group">Allowed Group for Users</label>
                <select id="allowed_group" name="allowedGroup">
                    <option value="">-- No group allowed (Admins only) --</option>
                    <?php foreach ($_['groups'] as $group): ?>
                        <option value="<?php p($group); ?>" <?php if ($_['current_allowed_group'] === $group) p('selected'); ?>>
                            <?php p($group); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <p class="note">Select a group whose members will have access to the restricted terminal. Admins always have access.</p>
            </div>

            <button type="submit">Save Settings</button>
        </form>
    </div>

    <script src="/apps/nshell/js/terminal.js"></script>
    <script src="/apps/nshell/js/admin.js"></script>
</body>
</html>
