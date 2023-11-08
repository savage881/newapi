const admin = require('firebase-admin');
const mysql = require('mysql');

// Initialize Firebase Admin SDK
const serviceAccount = require('./thefooddfonee-firebase-adminsdk-dicqs-2580faac90.json');
admin.initializeApp({
  credential: admin.credential.cert(serviceAccount),
  databaseURL: 'https://thefooddfonee-default-rtdb.firebaseio.com/',
});

// Initialize MySQL connection
const db = mysql.createConnection({
  host: 'localhost',
  user: 'root',
  password: '',
  database: 'google_login',
});

db.connect((err) => {
  if (err) throw err;
  console.log('Connected to MySQL database');
});

function insertDataIntoMySQL() {
  const ref = admin.database().ref('userdata');
  ref.once('value', (snapshot) => {
    const data = snapshot.val();

    Object.keys(data).forEach((UID) => {
      const { name, email, pass1 } = data[UID];

      if (email && name && pass1) {
        db.query(
          'INSERT INTO users (email, first_name, password) VALUES (?, ?, ?)',
          [email, name, pass1],
          (err, results) => {
            if (err) {
              console.log(results);
              console.error(`Error inserting data for UID ${UID} into MySQL:`, err);
            } else {
              console.log(`Data for UID ${UID} successfully inserted into MySQL`);
            }
          }
        );
      } else {
        console.error(`One or more fields are missing for UID ${UID}`);
        if (!name) console.error(`name is missing for UID ${UID}`);
        if (!email) console.error(`email is missing for UID ${UID}`);
        if (!pass1) console.error(`password is missing for UID ${UID}`);
      }
    });
  });
}


setInterval(insertDataIntoMySQL, 10000);
