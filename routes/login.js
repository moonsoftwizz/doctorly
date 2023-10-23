const express = require("express");
const app = express();
const router = express.Router();
const connection = require('./../db/config');


router.post('/', (req, res) => {
    const { email, password } = req.body;
  
    const selectQuery = 'SELECT * FROM user WHERE email = ?';
    connection.query(selectQuery, [email], (err, results) => {
      if (err) {
        console.error('Error querying database:', err);
        return res.status(500).json({ error: 'Error querying database' });
      }
  
      if (results.length === 0) {
        return res.status(401).json({ error: 'User not found' });
      }
  
      const user = results[0];
  
      const token = jwt.sign({ email: user.email }, JWT_SEC, { expiresIn: '1h' });
      res.status(200).json({ message: 'Login successful', token });
    });
    
  });

  module.exports = router;