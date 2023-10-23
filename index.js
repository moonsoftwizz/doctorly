const express = require("express");
const jwt = require('jsonwebtoken');
const app = express();
const { OAuth2Client } = require('google-auth-library');
const cors = require('cors');
const JWT_SEC = "my_jwt_sec";
const connection = require('./db/config');
const PORT = process.env.PORT || 8895;

// importing routes
const loginRouter = require("./routes/login");


app.get("/", (req, resp) => {
  resp.json({
    message: "my json is working",
  });
});
app.use(express.json());
app.use(cors());

app.use('/login', loginRouter);

const client = new OAuth2Client({
  clientId: '587694116558-vrfp6qen3jjrfma0euk7072cfcbht8br.apps.googleusercontent.com',
  redirectUri: 'http://localhost:8895'
});

// Handle user registration or login via Google
app.post('/auth/google-signup', (req, res) => {
  const idToken = req.body.idToken;
  console.log(idToken);

  async function verify() {
    const ticket = await client.verifyIdToken({
      idToken,
      audience: '587694116558-vrfp6qen3jjrfma0euk7072cfcbht8br.apps.googleusercontent.com',
    });
    const payload = ticket.getPayload();
    const userId = payload['sub'];

    const existingUser = await findUserByGoogleId(userId);

    if (existingUser) {
      const token = 'your_generated_jwt_token';
      res.json({ token });
    } else {
      const newUser = await createUserFromGooglePayload(payload);
      const token = 'your_generated_jwt_token';
      res.json({ token });
    }
  }

  verify().catch(console.error);
});

app.post('/auth/google', (req, res) => {
  const idToken = req.body.idToken;

  async function verify() {
    const ticket = await client.verifyIdToken({
      idToken,
      audience: '587694116558-vrfp6qen3jjrfma0euk7072cfcbht8br.apps.googleusercontent.com',
    });
    const payload = ticket.getPayload();
    const userId = payload['sub'];
    res.status(200).json({ message: 'User registered successfully', idToken: req.body.idToken });
  }

  verify().catch(console.error);
});

app.post('/signup', (req, res) => {
  const { fName, lName, user, email, password, experience, selectyourgoals, token } = req.body;

  // Check if the email already exists
  const checkEmailQuery = 'SELECT * FROM user WHERE email = ?';
  connection.query(checkEmailQuery, [email], (err, results) => {
    if (err) {
      console.error('Error checking email:', err);
      return res.status(500).json({ error: 'Error checking email' });
    }

    if (results.length > 0) {
      // Email already exists, throw an error
      return res.status(400).json({ error: 'Email already exists' });
    }

    // Email does not exist, continue with user registration
    // Note: I've removed the bcrypt-related code here
    const insertQuery = 'INSERT INTO user (firstname, lastname, user, email, password, experience, selectyourgoals, token) VALUES (?, ?, ?, ?, ?, ?, ?, ?)';
    const values = [fName, lName, user, email, password, experience, selectyourgoals, token];

    connection.query(insertQuery, values, (err, results) => {
      if (err) {
        console.error('Error inserting data:', err);
        return res.status(500).json({ error: 'Error inserting data' });
      }

      res.status(200).json({ message: 'User registered successfully', token, values });

      console.log('Data inserted successfully');
    });
  });
});



app.listen(PORT);
