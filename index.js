const express = require("express");
const admin = require("firebase-admin");
const mysql = require("mysql");

const app = express();
const port =process.env.port || 3000;
const BASE_URL=process.env.BASE_URL;


const serviceAccount = require("./thefooddfonee-firebase-adminsdk-dicqs-2580faac90.json");
admin.initializeApp({
  credential: admin.credential.cert(serviceAccount),
  databaseURL: "https://thefooddfonee-default-rtdb.firebaseio.com",
});


const mysqlConnection = mysql.createConnection({
  host: "localhost",
  user: "root",
  password: "",
  database: "google_login",
});

mysqlConnection.connect((err) => {
  if (err) {
    console.error("Error connecting to MySQL: ", err);
  } else {
    console.log("Connected to MySQL database");
  }
});


app.get("/combined-data", (req, res) => {
  const combinedData = {};

  
  const firebaseRef = admin.database().ref();
  firebaseRef.once("value", (snapshot) => {
    combinedData.firebaseData = snapshot.val();

   
    const query = "SELECT * FROM users"; 
    mysqlConnection.query(query, (err, results) => {
      if (err) {
        console.error("Error fetching data from MySQL: ", err);
        res.status(500).json({ error: "Internal Server Error" });
      } else {
        combinedData.userdata = results;
        res.json(combinedData);
      }
    });
  });
});

app.listen(port, () => {
  console.log(`Server is running on port ${BASE_URL}`);
});
