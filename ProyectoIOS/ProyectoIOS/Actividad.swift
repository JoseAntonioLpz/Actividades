//
//  Actividad.swift
//  ProyectoIOS
//
//  Created by dam on 27/1/17.
//  Copyright © 2017 dam. All rights reserved.
//
import Foundation

class Actividad{
    
    private var id:Int
    private var lugar:String
    private var descripcionCorta:String
    private var descripcionLarga:String
    private var idProfesor:Int
    private var idGrupo:Int
    private var horaInicio:String
    private var horaFin:String
    private var fecha:String
    private var foto:String
    
    init(id:Int, lugar:String , descripcionCorta:String , descripcionLarga:String , idProfesor:Int, idGrupo:Int, horaInicio:String , horaFin:String , fecha:String, foto:String) {
        self.id = id
        self.lugar = lugar
        self.descripcionCorta = descripcionCorta
        self.descripcionLarga = descripcionLarga
        self.idProfesor = idProfesor
        self.idGrupo = idGrupo
        self.horaInicio = horaInicio
        self.horaFin = horaFin
        self.fecha = fecha
        self.foto = foto
    }
    
    init(){
        self.id = 0
        self.lugar = ""
        self.descripcionCorta = ""
        self.descripcionLarga = ""
        self.idProfesor = 0
        self.idGrupo = 0
        self.horaInicio = ""
        self.horaFin = ""
        self.fecha = ""
        self.foto = ""
    }
    
    func getId()->Int{
        return self.id
    }
    
    func setId(id:Int){
        self.id = id
    }
    
    func getLugar()->String{
        return self.lugar
    }
    
    func setLugar(lugar:String){
        self.lugar = lugar
    }
    
    func getDescCorta()->String{
        return self.descripcionCorta
    }
    
    func setDescCorta(descCorta:String){
        self.descripcionCorta = descCorta
    }
    
    func getDescLarga()->String{
        return self.descripcionLarga
    }
    
    func setDescLarga(descLarga:String){
        self.descripcionLarga = descLarga
    }
    
    func getIdProfesor()->Int{
        return self.idProfesor
    }
    
    func setIdProfesor(idProfesor:Int){
        self.idProfesor = idProfesor
    }
    
    func getIdGrupo()->Int{
        return self.idGrupo
    }
    
    func setIdGrupo(idGrupo:Int){
        self.idGrupo = idGrupo
    }
    
    func getHoraInicio()->String{
        return self.horaInicio
    }
    
    func setHoraInicio(horaInicio:String){
        self.horaInicio = horaInicio
    }
    
    func getHoraFin()->String{
        return self.horaFin
    }
    
    func setHoraFin(horaFin:String){
        self.horaFin = horaFin
    }
    
    func getFecha()->String{
        return self.fecha
    }
    
    func setFecha(fecha:String){
        self.fecha = fecha
    }
    
    func getFoto()->String{
        return self.foto
    }
    
    func setFoto(foto:String){
        self.foto = foto
    }
}
