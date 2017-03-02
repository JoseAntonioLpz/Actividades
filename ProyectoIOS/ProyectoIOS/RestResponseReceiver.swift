//
//  RestResponseReceiver.swift
//  ProyectoIOS
//
//  Created by dam on 8/2/17.
//  Copyright © 2017 dam. All rights reserved.
//

import Foundation

protocol RestResponseReceiver {
    func onDataReceived(data:Data, target: String)
    func onErrorReceivingData(message:String)
}
