//
//  TableViewCell.swift
//  ProyectoIOS
//
//  Created by dam on 1/2/17.
//  Copyright © 2017 dam. All rights reserved.
//

import UIKit

class ActividadTableViewCell: UITableViewCell {
    
    //MARK: Propiedades
    
    @IBOutlet weak var imagen: UIImageView!
    @IBOutlet weak var actividad: UILabel!
    @IBOutlet weak var profesor: UILabel!
    @IBOutlet weak var fechaActividad: UILabel!

    override func awakeFromNib() {
        super.awakeFromNib()
        // Initialization code
    }

    override func setSelected(_ selected: Bool, animated: Bool) {
        super.setSelected(selected, animated: animated)

        // Configure the view for the selected state
    }

}
