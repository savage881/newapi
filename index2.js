const admin = require('firebase-admin');
const mysql = require('mysql');


const serviceAccount = require('./thefooddfonee-firebase-adminsdk-dicqs-2580faac90.json'); 
admin.initializeApp({
  credential: admin.credential.cert(serviceAccount),
  databaseURL: 'https://thefooddfonee-default-rtdb.firebaseio.com/',
});


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

db.query('SELECT * FROM users', (err, results) => {
  if (err) throw err;

  results.forEach((row) => {
    const {uid, first_name, email, password } = row;

    if (first_name !== undefined && email !== undefined && password !== undefined) {
      const uuid = `${uid}`;
      const name=`${first_name}`;
      admin.auth().createUser({
        uuid,
        email,
        password: password,
        displayName: name,
      })
      .then((userRecord) => {
        console.log(`Successfully created user: ${userRecord.uuid}`);
       
        ref.child(userRecord.uid).set({ name, email, password }, (error) => {
          if (error) {
            console.error(`Error writing data for ID ${userRecord.uid} to Firebase:`, error);
          } else {
            console.log(`Data with ID ${userRecord.uid} successfully written to Firebase`);
          }
        });
      })
      .catch((error) => {
        console.error('Error creating user:', error);
      });
    } else {
      console.error(`One or more fields are undefined `);
    }
  });

  db.end();
});
}
setInterval(insertDataIntoMySQL, 5000);