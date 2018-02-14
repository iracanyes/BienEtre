/**
 *
 */
import Connexion from "../Security/Connexion";

class Locality extends Connexion{
    constructor(){
        this.localities = this.allNames();


    }

    get allNames():void
    {
        let query = "SELECT locality FROM be_locality ";

        // Requête
        try{
            this.getConn().query(query, function (error, result, fields) {
                if(error) throw error;
                console.log(result);
                return result;
            })
        }catch(error){
            console.log(error.message);
        }
    }

    get
}