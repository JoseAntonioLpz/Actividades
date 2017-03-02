//
//  ActividadTableViewController.swift
//  ProyectoIOS
//
//  Created by dam on 1/2/17.
//  Copyright © 2017 dam. All rights reserved.
//

import UIKit
import os.log

class ActividadTableViewController: UITableViewController, RestResponseReceiver {
    
    //MARK: Propiedades
    
    var actividades = [Actividad]()
    var profesores = [Profesor]()
    var actividadesFiltradas = [Actividad]()
    var actividadViewController: ActividadViewController? = nil
    let searchController = UISearchController(searchResultsController: nil)
    
    var actividad: Actividad? = Actividad()
    var acts : [Actividad] = []
    
    override func viewDidLoad() {
        super.viewDidLoad()
        
        navigationItem.leftBarButtonItem = editButtonItem
        searchController.searchResultsUpdater = self
        searchController.searchBar.delegate = self
        definesPresentationContext = true
        searchController.dimsBackgroundDuringPresentation = false
        
        searchController.searchBar.scopeButtonTitles = ["All", "Profesores", "Fecha"]
        tableView.tableHeaderView = searchController.searchBar
        
        guard let clienteProfesor = ClienteRest(target: "profesor", responseObject: self) else {
            return
        }
        clienteProfesor.request()
        
        guard let cliente = ClienteRest(target: "actividad", responseObject: self) else {
            return
        }
        cliente.request()
        
        self.tableView.rowHeight = 100
        
        if let splitViewController = splitViewController{
            let controllers = splitViewController.viewControllers
            actividadViewController = (controllers[controllers.count-1] as! UINavigationController).topViewController as? ActividadViewController
        }
    }
    
    override func didReceiveMemoryWarning() {
        super.didReceiveMemoryWarning()
        // Dispose of any resources that can be recreated.
    }
    
    override func viewWillAppear(_ animated: Bool) {
        //clearsSelectionOnViewWillAppear = splitViewController!.isCollapsed
        super.viewWillAppear(animated)
    }
    
    //MARK: Funciones
    
    private func cargarActividades(actividad : [Actividad]?) {
        
        for act in actividad! {
            actividades += [act]
        }
        
    }
    
    // MARK: - Table view data source
    
    override func numberOfSections(in tableView: UITableView) -> Int {
        // #warning Incomplete implementation, return the number of sections
        return 1
    }
    
    override func tableView(_ tableView: UITableView, numberOfRowsInSection section: Int) -> Int {
        // #warning Incomplete implementation, return the number of rows
        if searchController.isActive && searchController.searchBar.text != ""{
            return actividadesFiltradas.count
        }
        return actividades.count
        
    }
    
    
    override func tableView(_ tableView: UITableView, cellForRowAt indexPath: IndexPath) -> UITableViewCell {
        
        let cellIdentifier = "ActividadTableViewCell"
        guard let cell = tableView.dequeueReusableCell(withIdentifier: cellIdentifier, for: indexPath) as? ActividadTableViewCell  else {
            fatalError("The dequeued cell is not an instance of ActividadTableViewCell.")
        }
        let act: Actividad
        
        if searchController.isActive && searchController.searchBar.text != ""{
            act = actividadesFiltradas[indexPath.row]
        }else{
            act = actividades[indexPath.row]
        }
        
        cell.actividad.text = act.getDescCorta()
        cell.fechaActividad.text = act.getFecha()
        for p in profesores {
            if(act.getIdProfesor() == p.getId()){
                cell.profesor.text = p.getNombre()
            }
        }
        
        print("pre data")
        let url = URL(string: (act.getFoto()))
        let data = try? Data(contentsOf: url!)
        if(data != nil){
            print("data image")
            cell.imagen.image = UIImage(data: data!)
        }
        
        /*if(dato != nil){
            cell.imagen.image = dato
            dato = nil
        }*/
        
        return cell
    }
    
    func onDataReceived(data:Data, target: String){
        
        switch target {
        case "actividad":
            let con = Conversion()
            let actividades = Conversion.deserializacion(json: data)!
            let arrayActividades: [Actividad]? = con.getActividades(actividades: actividades)
            cargarActividades(actividad: arrayActividades)
            DispatchQueue.main.async {
                self.tableView.reloadData()
            }
            return
        case "profesor":
            let con = Conversion()
            let profesores = Conversion.deserializacion(json: data)!
            let arrayProfesor: [Profesor]? = con.getProfesores(profesores: profesores)
            for profesor in arrayProfesor! {
                self.profesores.append(profesor)
            }
            return
        default:
            print("ERROR")
        }
    }
    
    func onErrorReceivingData(message:String){
        print(message)
    }
    
    override func prepare(for segue: UIStoryboardSegue, sender: Any?) {
        super.prepare(for: segue, sender: sender)
        
        switch(segue.identifier ?? "") {
            
        case "AddAct":
            os_log("Añadiendo nueva actividad.", log: OSLog.default, type: .debug)
            
        case "MostrarDetalle":
            guard let actDetailViewController = segue.destination as? ActividadViewController else {
                fatalError("Unexpected destination: \(segue.destination)")
            }
            
            guard let selectedMealCell = sender as? ActividadTableViewCell else {
                fatalError("Unexpected sender: \(sender)")
            }
            
            guard let indexPath = tableView.indexPath(for: selectedMealCell) else {
                fatalError("The selected cell is not being displayed by the table")
            }
            
            if let IndexPath = tableView.indexPathForSelectedRow {
                if searchController.isActive && searchController.searchBar.text != "" {
                    let selectedAct = actividadesFiltradas[IndexPath.row]
                    actDetailViewController.act = selectedAct

                }else{
                    let selectedAct = actividades[indexPath.row]
                    print("index\(IndexPath)")
                    actDetailViewController.act = selectedAct
                }
            }
            
        default:
            fatalError("Unexpected Segue Identifier; \(segue.identifier)")
        }
    }
    
    @IBAction func unwindToActividadList(sender: UIStoryboardSegue) {
        if let sourceViewController = sender.source as? ActividadViewController, let act = sourceViewController.act {
            if let source = sourceViewController as? ActividadViewController {
                //acts = source.datoapasar
                if source.datoapasar.count != 0 {
                    actividades.removeAll()
                    actividades = source.datoapasar
                }
            }
            /*if let selectedIndexPath = tableView.indexPathForSelectedRow {
                actividades[selectedIndexPath.row] = act
                tableView.reloadRows(at: [selectedIndexPath], with: .none)
                
            } else {
                let newIndexPath = IndexPath(row: actividades.count, section: 0)
                actividades.append(act)
                tableView.insertRows(at: [newIndexPath], with: .automatic)
            }*/
            DispatchQueue.main.async {
                self.tableView.reloadData()
            }
        }
        
    }
    
    // Override to support editing the table view.
    override func tableView(_ tableView: UITableView, commit editingStyle: UITableViewCellEditingStyle, forRowAt indexPath: IndexPath) {
        if editingStyle == .delete {
            let con = Conversion()
            // Delete the row from the data source
            actividad = actividades[indexPath.row]
            let datos = con.actividadToDiccionario(actividad: actividad!)
            actividades.remove(at: indexPath.row)
            guard let cliente = ClienteRest(target: "actividad", responseObject: self, "DELETE", datos) else {
                return
            }
            cliente.request()
            tableView.deleteRows(at: [indexPath], with: .fade)
        } else if editingStyle == .insert {
            // Create a new instance of the appropriate class, insert it into the array, and add a new row to the table view
        }
    }
    
    // Override to support conditional editing of the table view.
    override func tableView(_ tableView: UITableView, canEditRowAt indexPath: IndexPath) -> Bool {
        // Return false if you do not want the specified item to be editable.
        return true
    }
    
    /*
     // Override to support rearranging the table view.
     override func tableView(_ tableView: UITableView, moveRowAt fromIndexPath: IndexPath, to: IndexPath) {
     
     }
     */
    
    /*
     // Override to support conditional rearranging of the table view.
     override func tableView(_ tableView: UITableView, canMoveRowAt indexPath: IndexPath) -> Bool {
     // Return false if you do not want the item to be re-orderable.
     return true
     }
     */
    
    func filterContentForSearchText(_ searchText: String, scope: String = "All"){
        switch scope {
        case "All":
            actividadesFiltradas = actividades.filter({(actividad : Actividad)-> Bool in
                for profe in profesores {
                    let categoryMatch = (scope == "All") || (actividad.getDescCorta() == scope) || (actividad.getFecha() == scope) || (profe.getNombre() == scope)
                    if profe.getId() == actividad.getIdProfesor() {
                        return categoryMatch && actividad.getDescCorta().lowercased().contains(searchText.lowercased()) || actividad.getFecha().lowercased().contains(searchText.lowercased()) || profe.getNombre().lowercased().contains(searchText.lowercased())
                    }
                }
                return true
            })
        case "Profesores":
            actividadesFiltradas = actividades.filter({(actividad : Actividad)-> Bool in
                for profe in profesores {
                    let categoryMatch = (scope == "Profesores") || (profe.getNombre() == scope)
                    if profe.getId() == actividad.getIdProfesor() {
                        return categoryMatch && profe.getNombre().lowercased().contains(searchText.lowercased())
                    }
                }
                return true
            })
            
        case "Fecha":
            actividadesFiltradas = actividades.filter({(actividad : Actividad)-> Bool in
                let categoryMatch = (scope == "Fecha") || (actividad.getFecha() == scope)
                return categoryMatch && actividad.getFecha().lowercased().contains(searchText.lowercased())
            })
            
        default:
            return
        }
        
        tableView.reloadData()
    }
    
}

extension ActividadTableViewController : UISearchBarDelegate{
    func searchBar(_ searchBar: UISearchBar, selectedScopeButtonIndexDidChange selectedScope: Int){
        filterContentForSearchText(searchBar.text!, scope: searchBar.scopeButtonTitles![selectedScope])
    }
}

extension ActividadTableViewController : UISearchResultsUpdating{
    func updateSearchResults(for searchController: UISearchController) {
        let searchBar = searchController.searchBar
        let scope = searchBar.scopeButtonTitles![searchBar.selectedScopeButtonIndex]
        filterContentForSearchText(searchController.searchBar.text!, scope: scope)
    }
}
