 <?php
    require_once 'Bootstrap.php';
    return \Doctrine\ORM\Tools\Console\ConsoleRunner::createHelperSet($entityManager);