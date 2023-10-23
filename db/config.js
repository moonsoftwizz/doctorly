const mysql = require('mysql2');

const connection = mysql.createConnection({
  host: "localhost",
  user: "root",
  password: "",
  database: "vine_project",
});

connection.connect(function(err) {
  if (err) throw err;
  console.log("Connected!");
});


module.exports = connection;
