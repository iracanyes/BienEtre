/**
 *
 */
import mysql from "mysql";
import dotenv from "dotenv";

class Connexion{

    private conn;

    constructor(){
        dotenv.config();
        this.conn = mysql.createConnection({
            host : process.env.DATABASE_HOST,
            port : process.env.DATABASE_PORT,
            user : process.env.DATABASE_USER,
            password : process.env.DATABASE_PASSWORD,
            database : process.env.DATABASE_NAME,
            charset : process.env.DATABASE_CHARSET,
        });


    };

    public get getConn(){
        return this.conn.connect(function(err){
            if(err) throw err;
            console.log("Connection réussi!");
        });
    };

    public isConnected(){
        this.conn.connect(function(err){
            if(err) throw err;
            console.log("Connection réussi!");
            return true;
        });
    }

    public endConn(){
        this.conn.end();
    }
}

export default Connexion;