<?php

# Start the session only once. Most pages have access to it.
session_start();

# Include the basic methods and libraries needed by the app to run.
require 'constants.php';
require 'core/model.php';
require 'core/controller.php';
require 'core/view.php';
require 'core/slug.php';
require 'core/page.php';
require 'core/response.php';
require 'core/router.php';

# Include the core database file and create a global database object.
require 'core/database.php';
$carmdb = new \Database\Core(MYSQL_DATABASE);

# Require all the models.

# Require all controllers.

# Begin to route traffic.
require 'routes.php';

?>
