//
//  Conexion.swift
//  ProyectoIOS
//
//  Created by dam on 2/2/17.
//  Copyright © 2017 dam. All rights reserved.
//

import Foundation

class Conexion {
    
    static func connectToServer ( urlStr: String, method: String, data: [String : Any] = [:] ) {
        
        //Comprobamos que la URL generada sea correcta
        
        if let url = NSURL(string: urlStr) {
            
            //Creamos la peticion
            let request = NSMutableURLRequest(url: url as URL)
            
            //Indicamos el tipo de metodo utilizado para conectarnos con el servidor
            request.httpMethod = method
            
            //Comprobamos si el metodo es PUT o POST para introducir correctamente el parámetro json
            switch method {
                
            case "POST", "PUT":
                
                if let jsonData = try? JSONSerialization.data(withJSONObject: data, options: .prettyPrinted) {
                    
                    request.addValue("application/json", forHTTPHeaderField: "Content-Type")
                    request.httpBody = jsonData
                }
                
            default: break
            }
            
            
            //Creamos la conexion
            let task = URLSession.shared.dataTask(with: request as URLRequest){
                
                (data,response,error) -> Void in
                
                if error != nil{
                    
                    print(error!.localizedDescription)
                    return
                }
                
                if let conn = String(data: data!, encoding: .utf8) {
                    
                    DispatchQueue.main.async{
                        
                        print(conn)
                    }
                    
                }
            }
            
            task.resume()
            
        }
    }

}
