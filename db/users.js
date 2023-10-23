const connection = require('./config');

const insertQuery = 'INSERT INTO user (user, email) VALUES (?, ?)';
const values = ['John Doe', 'johndoe@example.com'];

connection.query(insertQuery, values, (err, results) => {
    if (err) {
      console.error('Error inserting data:', err);
      return;
    }
    console.log('Data inserted successfully');
  });
