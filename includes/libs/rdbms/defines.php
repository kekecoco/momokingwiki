<?php

use Wikimedia\Rdbms\IDatabase;
use Wikimedia\Rdbms\ILoadBalancer;

/** @{
 * Database related constants
 */
define('DBO_DEBUG', IDatabase::DBO_DEBUG);
define('DBO_NOBUFFER', IDatabase::DBO_NOBUFFER);
define('DBO_IGNORE', IDatabase::DBO_IGNORE);
define('DBO_TRX', IDatabase::DBO_TRX);
define('DBO_DEFAULT', IDatabase::DBO_DEFAULT);
define('DBO_PERSISTENT', IDatabase::DBO_PERSISTENT);
define('DBO_SYSDBA', IDatabase::DBO_SYSDBA);
define('DBO_DDLMODE', IDatabase::DBO_DDLMODE);
/** @deprecated since 1.39, use the "ssl" parameter */
define('DBO_SSL', IDatabase::DBO_SSL);
define('DBO_COMPRESS', IDatabase::DBO_COMPRESS);
/** @} */

/** @{
 * Valid database indexes
 * Operation-based indexes
 */
define('DB_REPLICA', ILoadBalancer::DB_REPLICA);
/** @since 1.36 */
define('DB_PRIMARY', ILoadBalancer::DB_PRIMARY);
/** @deprecated since 1.36, Use DB_PRIMARY instead */
define('DB_MASTER', ILoadBalancer::DB_PRIMARY);
/** @} */
