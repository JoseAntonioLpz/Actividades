//
//  Profesor.swift
//  ProyectoIOS
//
//  Created by dam on 27/1/17.
//  Copyright © 2017 dam. All rights reserved.
//

import Foundation

class Profesor{
    private var id: Int
    private var nombre: String
    
    init(id:Int , nombre:String) {
        self.id =  id
        self.nombre = nombre
    }
    
    init() {
        self.id =  0
        self.nombre = ""
    }
    
    func getId()->Int{
        return self.id
    }
    
    func setId(id:Int){
        self.id = id
    }
    
    func getNombre()->String{
        return self.nombre
    }
    
    func setNombre(nombre:String){
        self.nombre = nombre
    }
}
