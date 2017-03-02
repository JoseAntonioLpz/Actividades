//
//  ViewController.swift
//  ProyectoIOS
//
//  Created by dam on 26/1/17.
//  Copyright © 2017 dam. All rights reserved.
//

import UIKit

class ActividadViewController: UIViewController, UIPickerViewDelegate, UIPickerViewDataSource, RestResponseReceiver, UIImagePickerControllerDelegate, UINavigationControllerDelegate {

    
    @IBOutlet weak var desCorta: UITextField!
    
    @IBOutlet weak var desLarga: UITextView!
    
    @IBOutlet weak var grupo: UIPickerView!
    
    @IBOutlet weak var profesor: UIPickerView!
    
    @IBOutlet weak var fecha: UIDatePicker!
    
    @IBOutlet weak var lugar: UITextField!
    
    @IBOutlet weak var horaInicio: UIDatePicker!
    
    @IBOutlet weak var horaFin: UIDatePicker!
    
    @IBOutlet weak var foto: UIImageView!
    
    @IBOutlet weak var btnGuardar: UIBarButtonItem!
    
    var act: Actividad? = Actividad()
    
    var grupos: [Grupo] = []
    var profesores: [Profesor] = []
    var datoapasar: [Actividad] = []
    
    override func viewDidLoad() {
        super.viewDidLoad()
        // Do any additional setup after loading the view, typically from a nib.
        
        guard let clienteProfesor = ClienteRest(target: "profesor", responseObject: self) else {
            return
        }
        clienteProfesor.request()
        
        guard let clienteGrupo = ClienteRest(target: "grupo", responseObject: self) else {
            return
        }
        clienteGrupo.request()
        
        grupo.delegate = self
        grupo.dataSource = self
        profesor.delegate = self
        
        if (act?.getId())! > 0 {
            
            desCorta.text = act!.getDescCorta()
            desLarga.text = act!.getDescLarga()
            lugar.text = act!.getLugar()
            
            let fe = DateFormatter()
            fe.dateFormat = "yyyy-MM-dd"
            let f = fe.date(from: act!.getFecha())
            fecha.date = f!
            
            let hInicio = DateFormatter()
            hInicio.dateFormat = "HH:mm:ss"
            hInicio.timeZone = TimeZone(abbreviation: "es_ES")
            let horaInicial = hInicio.date(from: act!.getHoraInicio())
            if(horaInicial != nil){
                horaInicio.date = horaInicial!
            }
            
            
            let hFin = DateFormatter()
            hFin.dateFormat = "HH:mm:ss"
            hFin.timeZone = TimeZone(abbreviation: "es_ES")
            let horaFinal = hInicio.date(from: act!.getHoraFin())
            if(horaFinal != nil){
                horaFin.date = horaFinal!
            }
            //print(act!.getFoto())
            let url = URL(string: (act!.getFoto()))
            let data = try? Data(contentsOf: url!)
            if (data != nil){
                foto.image = UIImage(data: data!)
            }
        }else {
            act!.setIdProfesor(idProfesor: 1)
            act!.setIdGrupo(idGrupo: 1)
        }
        
    }

    override func didReceiveMemoryWarning() {
        super.didReceiveMemoryWarning()
        // Dispose of any resources that can be recreated.
    }
 
    @IBAction func cancelar(_ sender: UIBarButtonItem) {
        let isPresentingInAddActMode = presentingViewController is UINavigationController
        
        if isPresentingInAddActMode {
            dismiss(animated: true, completion: nil)
        }
        else if let owningNavigationController = navigationController {
            owningNavigationController.popViewController(animated: true)
        }
        else {
            fatalError("The ActividadViewController is not inside a navigation controller.")
        }
    }
    
    @IBAction func guardar(_ sender: UIBarButtonItem) {
        act!.setDescCorta(descCorta: desCorta.text!)
        act!.setDescLarga(descLarga: desLarga.text!)
        
        let date = DateFormatter()
        date.dateFormat = "yyyy-MM-dd"
        
        let horas = DateFormatter()
        horas.timeZone = TimeZone(abbreviation: "es_ES")
        horas.dateFormat = "HH:mm:ss"
        
        var cadenaFecha : String
        var fecha2 = Date()
        fecha2 = fecha.date
        cadenaFecha = date.string(from: fecha2)
        
        var cadenaHoraInicio : String
        var hInicio = Date()
        hInicio = horaInicio.date
        cadenaHoraInicio = horas.string(from: hInicio)
        
        var cadenaHoraFin : String
        var hFin = Date()
        hFin = horaFin.date
        cadenaHoraFin = horas.string(from: hFin)
        
        let img: UIImage = foto.image!
        let imageData:Data = UIImagePNGRepresentation(img)! as Data
        let strBase64 = imageData.base64EncodedString()
        
        act!.setFecha(fecha: cadenaFecha)
        act!.setLugar(lugar: lugar.text!)
        act!.setHoraInicio(horaInicio: cadenaHoraInicio)
        act!.setHoraFin(horaFin: cadenaHoraFin)
        act!.setFoto(foto: strBase64)
        
        let conversor = Conversion()
        
        let datos = conversor.actividadToDiccionario(actividad: act!)
        
        if(act!.getId() == 0){
            guard let cliente = ClienteRest(target: "actividad", responseObject: self, "POST", datos) else {
                return
            }
            cliente.request()
            
        }else {
            guard let cliente = ClienteRest(target: "actividad", responseObject: self, "PUT", datos) else {
                return
            }
            cliente.request()
        }
    }
    
    override func prepare(for segue: UIStoryboardSegue, sender: Any?) {
        
        super.prepare(for: segue, sender: sender)
        
        // Configure the destination view controller only when the save button is pressed.
        guard let button = sender as? ActividadViewController else {
            return
        }
        
        let destino = segue.destination as! ActividadTableViewController
        
        destino.actividades = datoapasar
        
    }
    
    func onDataReceived(data:Data , target: String){
        switch target {
        case "grupo":
            let con = Conversion()
            let grupos = Conversion.deserializacion(json: data)!
            let arrayGrupo: [Grupo]? = con.getGrupos(grupos: grupos)
            for grupo in arrayGrupo! {
                self.grupos.append(grupo)
            }
            DispatchQueue.main.async {
                self.grupo.reloadAllComponents()
            }
            return
        case "profesor":
            let con = Conversion()
            let profesores = Conversion.deserializacion(json: data)!
            let arrayProfesor: [Profesor]? = con.getProfesores(profesores: profesores)
            for profesor in arrayProfesor! {
                self.profesores.append(profesor)
            }
            DispatchQueue.main.async {
                self.profesor.reloadAllComponents()
            }
            return
        default:
            //cerrar
            let con = Conversion()
            let actividades = Conversion.deserializacion(json: data)!
            let arrayActividades: [Actividad]? = con.getActividades(actividades: actividades)
            datoapasar = arrayActividades!
            self.performSegue(withIdentifier: "segueVolver", sender: self)
            //dismiss(animated: true, completion: nil)
            return
        }
    }
    
    func onErrorReceivingData(message:String){
        print(message)
    }
    
    //MARK: PickerView
    
    func numberOfComponents(in pickerView: UIPickerView) -> Int {
        return 1
    }
    
    func pickerView(_ pickerView: UIPickerView, numberOfRowsInComponent component: Int) -> Int {
        switch pickerView {
        case grupo:
            return grupos.count
        case profesor:
            return profesores.count
        default:
            return 0
        }
    }
    
    func pickerView(_ pickerView: UIPickerView, didSelectRow row: Int, inComponent component: Int) {
        
        switch pickerView {
            
        case grupo:
            act!.setIdGrupo(idGrupo: grupos[row].getId())

        case profesor:
            act!.setIdProfesor(idProfesor: profesores[row].getId())
            
        default: return
        }
    }
    
    func pickerView(_ pickerView: UIPickerView, titleForRow row: Int, forComponent component: Int) -> String? {
        
        switch pickerView {
            
        case grupo:
            return grupos[row].getNombre()
            
        case profesor:
            return profesores[row].getNombre()
            
        default: return ""
        }
    }
    
    //MARK: UIImagePickerDelegate
    func imagePickerControllerDidCancel(_ picker: UIImagePickerController) {
        dismiss(animated: true, completion: nil)
    }
    
    func imagePickerController(_ picker: UIImagePickerController, didFinishPickingMediaWithInfo info: [String : Any]) {
        
        // The info dictionary may contain multiple representations of the image. You want to use the original.
        guard let selectedImage = info[UIImagePickerControllerOriginalImage] as? UIImage else {
            fatalError("Expected a dictionary containing an image, but was provided the following: \(info)")
        }
        
        // Set photoImageView to display the selected image.
        foto.image = selectedImage
        
        // Dismiss the picker.
        dismiss(animated: true, completion: nil)
    }
    
    @IBAction func seleccionarImagen(_ sender: UITapGestureRecognizer) {
        foto.resignFirstResponder()
        
        let imagePickerController = UIImagePickerController()
        
        imagePickerController.sourceType = .photoLibrary
        
        imagePickerController.delegate = self
        
        present(imagePickerController, animated: true, completion: nil)
    }
}

