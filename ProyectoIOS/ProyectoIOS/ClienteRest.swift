//
//  ClienteRest.swift
//  ProyectoIOS
//
//  Created by dam on 8/2/17.
//  Copyright © 2017 dam. All rights reserved.
//

import Foundation

class ClienteRest{
    
    let urlApi: String = "http://192.168.208.18:8181/ws/ios/" //"https://proyecto-ios-toniarcogarcia.c9users.io/ios/"
    let respuesta: RestResponseReceiver
    let sesion: URLSession
    var urlPeticion: URLRequest
    let target: String
    
    init?(target: String, responseObject: RestResponseReceiver, _ method: String = "GET", _ data : [String:Any] = [:]) {
        guard let url = URL(string: self.urlApi + target) else {
            return nil
        }
        self.target = target
        self.respuesta = responseObject
        self.sesion = URLSession(configuration: URLSessionConfiguration.default)
        self.urlPeticion = URLRequest(url: url)
        self.urlPeticion.httpMethod = method
        if method != "GET" && data.count > 0 {
            guard let json = Conversion.serializacion(actividad: data) else {
                return nil
            }
            self.urlPeticion.addValue("application/json", forHTTPHeaderField: "Content-Type")
            self.urlPeticion.httpBody = json
        }
    }
    
    func request() {
        let task = self.sesion.dataTask(with: self.urlPeticion,
                                        completionHandler: self.callBack)
        task.resume()
    }
    
    private func callBack(_ data: Data?, _ respuesta: URLResponse?, _ error: Error?) {
        DispatchQueue.main.async{
            guard error == nil else {
                self.respuesta.onErrorReceivingData(message: "error")
                return
            }
            guard let datos = data else {
                self.respuesta.onErrorReceivingData(message: "error datos")
                return
            }
            if (self.urlPeticion.httpMethod == "GET" || self.urlPeticion.httpMethod == "POST" || self.urlPeticion.httpMethod == "PUT") {

                self.respuesta.onDataReceived(data: datos, target: self.target)
            }
        }
    }
}
