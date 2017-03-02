//
//  Conversion.swift
//  ProyectoIOS
//
//  Created by Jose Antonio on 02/02/2017.
//  Copyright © 2017 dam. All rights reserved.
//
import Foundation


class Conversion{
    
    init() {
        
    }
    
    func getActividades(actividades: [[String: Any]]) -> [Actividad]? {
        var act = [] as [Actividad]
        for actividad in actividades {
            let a = self.diccionarioToActividad(actividad : actividad)
            act.append(a!)
        }
        return act
    }
    
    func getGrupos(grupos: [[String:Any]]) -> [Grupo]?{
        var gru = [] as [Grupo]
        for grupo in grupos {
            let g = self.diccionarioToGrupo(grupo: grupo)
            gru.append(g!)
        }
        return gru
    }
    
    func getProfesores(profesores: [[String:Any]]) -> [Profesor]?{
        var pro = [] as [Profesor]
        for profesor in profesores {
            let p = self.diccionarioToProfesor(profesor: profesor)
            pro.append(p!)
        }
        return pro
    }
    
    static func serializacion(actividad : [String:Any])->Data?{
        if let json = try? JSONSerialization.data(withJSONObject: actividad, options: []){
            return json
        }
        
        return nil
    }
    
    static func deserializacion(json: Data)->[[String:Any]]? {
        if let dic = try? JSONSerialization.jsonObject(with: json, options: .allowFragments) as? [[String:Any]]{
            return dic
        }
        return nil
    }
    
    func diccionarioToActividad(actividad : [String:Any])->Actividad?{
        let act = Actividad()
        
        if let id = actividad["id"] as! Int? {
            act.setId(id: id)
        }
        
        if let lugar = actividad["lugar"] as! String?{
            act.setLugar(lugar: lugar)
        }
        
        if let descripcionCorta = actividad["descripcionCorta"] as? String{
            act.setDescCorta(descCorta: descripcionCorta)
        }
        
        if let descripcionLarga = actividad["descripcionLarga"] as? String{
            act.setDescLarga(descLarga: descripcionLarga)
        }
        
        if let idProfesor = actividad["idProfesor"] as! Int?{
            act.setIdProfesor(idProfesor: idProfesor)
        }
        
        if let idGrupo = actividad["idGrupo"] as! Int?{
            act.setIdGrupo(idGrupo: idGrupo)
        }
        
        if let horaInicio = actividad["horaInicial"] as! String?{
            act.setHoraInicio(horaInicio: horaInicio)
        }
        
        if let horaFin = actividad["horaFin"] as! String?{
            act.setHoraFin(horaFin: horaFin)
        }
        
        if let fecha = actividad["fecha"] as! String?{
            act.setFecha(fecha: fecha)
        }
        
        if let foto = actividad["fotoExcursion"] as! String?{
            act.setFoto(foto: foto)
        }
        
        return act
    }
    
    func actividadToDiccionario(actividad : Actividad)->[String : Any]{
        let id = actividad.getId()
        let lugar = actividad.getLugar()
        let descCorta = actividad.getDescCorta()
        let descLarga = actividad.getDescLarga()
        let idProfesor = actividad.getIdProfesor()
        let idGrupo = actividad.getIdGrupo()
        let horaInicial = actividad.getHoraInicio()
        let horaFin = actividad.getHoraFin()
        let fecha = actividad.getFecha()
        let foto = actividad.getFoto()
        
        return ["id" : id , "lugar" : lugar, "descripcionCorta" : descCorta , "descripcionLarga" : descLarga, "idProfesor" : idProfesor, "idGrupo" : idGrupo , "horaInicial" : horaInicial, "horaFin" : horaFin , "fecha" : fecha, "fotoExcursion" : foto]
    }
    
    func diccionarioToGrupo(grupo : [String:Any])->Grupo?{
        let gru = Grupo()
        
        if let id = grupo["id"] as! Int? {
            gru.setId(id: id)
        }
        
        if let nombre = grupo["nombre"] as! String?{
            gru.setNombre(nombre: nombre)
        }
        
        return gru
    }
    
    func diccionarioToProfesor(profesor : [String:Any])->Profesor?{
        let pro = Profesor()
        
        if let id = profesor["id"] as! Int? {
            pro.setId(id: id)
        }
        
        if let nombre = profesor["nombre"] as! String?{
            pro.setNombre(nombre: nombre)
        }
        
        return pro
    }
}
