const mysql = require('mysql2');

const pool = mysql.createPool({
  host: 'your_db_host',
  user: 'your_db_user',
  password: 'your_db_password',
  database: 'your_db_name',
  waitForConnections: true,
  connectionLimit: 10,
  queueLimit: 0
});

module.exports = pool.promise();
