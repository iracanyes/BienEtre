// Chargement des variables d'environnement
require("dotenv").config();

// Chargement composant MySQL
let mysql = require("mysql");

let connection = mysql.createConnection({
    host: process.env.DB_HOST,
    user: process.env.DB_USER,
    password: process.env.DB_PASSWORD,
    database: process.env.DB_DATABASE,
    port: process.env.DB_PORT
});

connection.connect();

function findby({locality: String, township: String, postalCode: int}){

}