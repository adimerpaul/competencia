/*
export function someMutation (state) {
}
*/
export function auth_request(state){
  state.status = 'loading'
}
export function verificadotrue(state){
  state.user.verificado=true
}
export function auth_success(state, data){
  state.status = 'success'
  state.token = data.token
  state.user = data.user

  // state.boolmercadocambioactividad=data.user.permisos.find(p=>p.id===1)!=undefined
  // state.boolbuscararchivos=data.user.permisos.find(p=>p.id===2)!=undefined
  // console.log(state.boolmercadocambioactividad)
  // state.boolusuarios=data.user.permisos.find(p=>p.id===2)!=undefined
  // state.booltramite=data.user.permisos.find(p=>p.id===3)!=undefined
  // state.booljuridico=data.user.permisos.find(p=>p.id===4)!=undefined
  // state.boolnatural=data.user.permisos.find(p=>p.id===5)!=undefined
  // state.booldemandado=data.user.permisos.find(p=>p.id===6)!=undefined
  // state.boolcotizacion=data.user.permisos.find(p=>p.id===7)!=undefined
  // state.boolmicotizacion=data.user.permisos.find(p=>p.id===8)!=undefined
  // state.inventario=data.user.permisos.find(p=>p.id===4)!=undefined
  // state.ventadetalle=data.user.permisos.find(p=>p.id===5)!=undefined
  // state.historialventadetalle=data.user.permisos.find(p=>p.id===6)!=undefined
  // state.ventalocal=data.user.permisos.find(p=>p.id===7)!=undefined
  // state.historialventalocal=data.user.permisos.find(p=>p.id===8)!=undefined
  // state.empleados=data.user.permisos.find(p=>p.id===9)!=undefined
  // state.reportes=data.user.permisos.find(p=>p.id===10)!=undefined
  // state.gastos=data.user.permisos.find(p=>p.id===11)!=undefined
  // state.historialprestamo=data.user.permisos.find(p=>p.id===12)!=undefined
  // state.historialventa=data.user.permisos.find(p=>p.id===13)!=undefined
  // state.anular=data.user.permisos.find(p=>p.id===14)!=undefined
}
export function   auth_error(state){
  state.status = 'error'
}
export function salir(state){
  state.status = ''
  state.token = ''
  state.user = {}
  // state.boolmercadocambioactividad=false
  // state.boolbuscararchivos=false
  // state.boolusuarios=false
  // state.booltramite=false
  // state.booljuridico=false
  // state.boolnatural=false
  // state.booldemandado=false
  // state.boolcotizacion=false
  // state.boolmicotizacion=false
  // state.ventadetalle=false
  // state.historialventadetalle=false
  // state.ventalocal=false
  // state.historialventalocal=false
  // state.empleados=false
  // state.reportes=false
  // state.gastos=false
  // state.historialprestamo=false
  // state.historialventa=false
  // state.anular=false
}
