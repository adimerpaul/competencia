<template>
<q-page class="q-pa-xs">
  <div class="row">
    <div class="col-12">
      <q-form @submit.prevent="consulta">
        <div class="row">
          <div class="col-4">
            <q-select dense  outlined label="evento" :options="eventos" v-model="evento" />
          </div>
          <div class="col-4">
            <q-select dense outlined label="edad" :options="edades" v-model="edad"/>
          </div>
          <div class="col-4">
            <q-input type="date" dense outlined label="fecha"  v-model="fecha"/>
          </div>
          <div class="col-6">
            <q-btn type="submit" icon="search" color="info" label="consultar" class="full-width"/>
          </div>
          <div class="col-6">
            <q-btn type="button" @click="imprimir" icon="print" color="positive" label="imprimir" class="full-width"/>
          </div>
        </div>
      </q-form>
    </div>
    <div class="col-12">
      <q-table   :columns="columsregistro" :rows="registros" :filter="filter" dense>
        <template v-slot:body-cell-opcion="props">
          <q-td auto-width :props="props">
            <q-btn flat  round icon="add_circle" @click="dialogtiempos=true;registro=props.row" color="positive" />
          </q-td>
        </template>
        <template v-slot:body-cell-nombre="props">
          <q-td auto-width :props="props">
            <div class="text-body2">{{props.row.num}} {{props.row.player.paterno}} <br> {{props.row.player.materno}}<br>{{props.row.player.nombres}}</div>
          </q-td>
        </template>
        <template v-slot:body-cell-tiempo="props">
          <q-td auto-width :props="props">
            <div class="text-body2">
              {{props.row.dato1}} <q-badge v-if="props.row.dato1==props.row.tiempomin"  label="M" />   <br>
              {{props.row.dato2}} <q-badge v-if="props.row.dato2==props.row.tiempomin"  label="M" />   <br>
              {{props.row.dato3}} <q-badge v-if="props.row.dato3==props.row.tiempomin"  label="M" />   <br>
              {{props.row.dato4}} <q-badge v-if="props.row.dato4==props.row.tiempomin"  label="M" />   <br>
              {{props.row.dato5}} <q-badge v-if="props.row.dato5==props.row.tiempomin"  label="M" />   <br>
<!--              <q-badge v-if="esmin(props.row.dato1,props.row.tiempomin)=='M'"  :label="esmin(props.row.dato1,props.row.tiempomin)" />-->
<!--              <q-badge v-if="esmin(props.row.dato2,props.row.tiempomin)=='M'"  :label="esmin(props.row.dato2,props.row.tiempomin)" />-->
<!--              <q-badge v-if="esmin(props.row.dato3,props.row.tiempomin)=='M'"  :label="esmin(props.row.dato3,props.row.tiempomin)" />-->
<!--              <q-badge v-if="esmin(props.row.dato4,props.row.tiempomin)=='M'"  :label="esmin(props.row.dato4,props.row.tiempomin)" />-->
<!--              <q-badge v-if="esmin(props.row.dato5,props.row.tiempomin)=='M'"  :label="esmin(props.row.dato5,props.row.tiempomin)" />-->
<!--              <pre>{{props.row}}</pre>-->
            </div>
          </q-td>
        </template>
        <template v-slot:body-cell-posicion="props">
          <q-td auto-width :props="props">
            <q-badge :label="props.pageIndex+1" color="positive"/>
          </q-td>
        </template>
        <template v-slot:top-right>
          <q-btn label="Registrar" icon="add_circle" color="primary" @click="dialogregistro=true" />
          <q-input dense outlined v-model="filter" placeholder="Buscar"/>
        </template>
      </q-table>
    </div>
  </div>
  <q-dialog full-width v-model="dialogtiempos">
    <q-card>
      <q-card-section class="text-h6">Puntos {{registro.nombre}}</q-card-section>
      <q-separator/>
      <q-card-section>
        <q-form>
          <div class="row">
            <div class="col-12">
              <q-input dense step="1" type="time" outlined @update:model-value="updateRegistro1" label="dato1" v-model="registro.dato1" />
              <q-input dense step="1" type="time" outlined @update:model-value="updateRegistro2" label="dato2" v-model="registro.dato2" />
              <q-input dense step="1" type="time" outlined @update:model-value="updateRegistro3" label="dato3" v-model="registro.dato3" />
              <q-input dense step="1" type="time" outlined @update:model-value="updateRegistro4" label="dato4" v-model="registro.dato4" />
              <q-input dense step="1" type="time" outlined @update:model-value="updateRegistro5" label="dato5" v-model="registro.dato5" />
            </div>
          </div>
        </q-form>
      </q-card-section>
    </q-card>
  </q-dialog>
  <q-dialog full-width v-model="dialogregistro">
    <q-card>
      <q-card-section class="text-subtitle2">
        Evento={{evento.label}}
        Edad={{edad}}
        Fecha={{fecha}}
      </q-card-section>
      <q-separator/>
      <q-card-section>
        <q-form @submit="createRegistro">
          <div class="row">
            <div class="col-12">
              <q-select outlined use-input dense label="Jugador" :options="players" v-model="player" @filter="filterFn" >
                <template v-slot:no-option>
                  <q-item>
                    <q-item-section class="text-grey">
                      No resultados
                    </q-item-section>
                  </q-item>
                </template>
              </q-select>
            </div>
            <div class="col-12">
              <q-btn color="positive" icon="add_circle" label="Registrar" type="submit" class="full-width" />
            </div>
          </div>
        </q-form>
      </q-card-section>
    </q-card>
  </q-dialog>
</q-page>
</template>

<script>
import moment from "moment"
import {date} from "quasar"
import {jsPDF} from "jspdf"
export default {
  name: `Registro`,
  data(){
    return{
      dialogregistro:false,
      dialogtiempos:false,
      filter:'',
      columsregistro:[
        {name:'opcion',field:'opcion',label:'opcion'},
        // {name:'num',field:'num',label:'num'},
        {name:'nombre',field:'nombre',label:'nombre',align:'left'},
        {name:'categoria',field:'categoria',label:'categoria'},
        {name:'tiempo',field:'tiempo',label:'tiempo',align:'left'},
        {name:'posicion',field:'posicion',label:'posicion'},
      ],
      fecha:date.formatDate(new Date(),'YYYY-MM-DD'),
      edades:[
        "30-34",
        "35-39",
        "40-44",
        "45-49",
        "50-54",
        "55-59",
        "60-64",
        "65-69",
        "70-74",
        "75-79",
        "80-84",
        "85-89",
      ],
      edad:'30-34',
      eventos:[],
      evento:{},
      players:[],
      players2:[],
      player:{},
      registros:[],
      registro:{},
    }
  },
  created() {
    this.$q.loading.show()
    this.$api.get('player').then(res=>{
      this.players=[]
      res.data.forEach(r=>{
        let nacimiento=moment(r.fechanac);
        let hoy=moment();
        let anios=hoy.diff(nacimiento,"years");
        r.label=anios+' '+r.paterno+' '+r.materno+' '+r.nombres
        this.players.push(r)
      })
      this.players2=this.players
      this.player=this.players[0]
    })
    this.$api.get('evento').then(res=>{
      this.eventos=[]
      res.data.forEach(r=>{
        r.label=r.nombre
        this.eventos.push(r)
      })
      this.evento=this.eventos[0]
      this.consulta()
    })
  },
  methods:{
    imprimir(){
      // this.$q.loading.show()
      // this.$axios.post(process.env.URL + '/reportemes',{inicio:this.fecha,fin:this.fecha2}).then(res=>{
      //   this.miscomprobantestotales=res.data
        let cm=this;
        function header(fecha){
          var img = new Image()
          img.src = 'logo.png'
          doc.addImage(img, 'png', 0.5, 0.5, 2, 2)
          doc.setFont(undefined,'bold')
          doc.text(5, 1, 'REGISTRO DE PLANILLA '+cm.evento.label+' '+cm.evento.tipo)
          doc.text(5, 1.5, 'DE FECHA '+cm.fecha)
          doc.text(1, 3, '________________________________________________________________________________________________________')
          doc.text(1, 3, 'N')
          doc.text(1.5, 3, 'NOMBRE')
          doc.text(8.0, 3, 'CATEGORIA')
          doc.text(10.5, 3, 'TIEMPOS')
          doc.text(18, 3, 'MARCA')
          doc.text(19.5, 3, 'POSICION')
          // doc.text(16, 3, 'MONTO BS.')
          // doc.text(18, 3, 'OPERADOR')
          doc.setFont(undefined,'normal')
        }
        var doc = new jsPDF('p','cm','letter')
        doc.setFont("courier");
        doc.setFontSize(9);
        header(this.fecha)
        let y=0
        let sumtotal=0
        let con=0
        this.registros.forEach(r=>{
          if (r.nrocomprobante!=''){
            y+=0.4
            con++
            doc.text(1, y+3, r.num.toString())
            doc.text(1.5, y+3, r.nombre)
            doc.text(8.0, y+3, this.evento.label)
            doc.setFontSize(7);
            doc.text(10.5, y+3, r.dato1+' '+r.dato2+' '+r.dato3+' '+r.dato4+' '+r.dato5)
            doc.setFontSize(9);
            doc.text(18, y+3, r.tiempomin)
            doc.text(20.5, y+3, con.toString(),'center')
            // doc.text(16, y+3, r.total)
            // sumtotal+=parseInt(r.total)
            // console.log(r.total)
            // doc.text(18, y+3, r.user.codigo )
            if (con==55){
              con=0
              doc.addPage();
              header(this.fecha)
              y=0
            }
          }
        })
        doc.setFont(undefined,'bold')
        doc.text(3, y+3.5, 'SON: '+con+' PARTICIPANTES')
        // doc.text(12, y+3.5, 'TOTAL RECAUDADCION: ')
        doc.text(1.8, y+5, '_____________________          _____________________________       _________________________')
        doc.text(2, y+5.3, 'FIRMA SELLO DIRECTOR')
        doc.text(8, y+5.3, 'FIRMA SELLO INTRESADO1')
        doc.text(15, y+5.3, 'FIRMA SELLO INTRESADO2')
        // doc.setFont(undefined,'normal')
        // doc.text(18, y+3.5, sumtotal+ ' Bs')
        // const conversor = require('conversor-numero-a-letras-es-ar');
        // let ClaseConversor = conversor.conversorNumerosALetras;
        // let miConversor = new ClaseConversor();
        // var a = miConversor.convertToText(sumtotal);
        // doc.text(1, y+4, 'SON: '+ a.toUpperCase()+' BS')
        // doc.save("Pago"+date.formatDate(Date.now(),'DD-MM-YYYY')+".pdf");
        window.open(doc.output('bloburl'), '_blank');
        // console.log(res.data)
      //   this.$q.loading.hide()
      // })
    },
    filterFn (val, update) {
      if (val === '') {
        update(() => {
          this.players = this.players2
          // here you have access to "ref" which
          // is the Vue reference of the QSelect
        })
        return
      }

      update(() => {
        const needle = val.toLowerCase()
        this.players = this.players2.filter(v => v.label.toLowerCase().indexOf(needle) > -1)
      })
    },
    createRegistro(){
      this.$q.loading.show()
      this.$api.post('registro',{
        fecha:this.fecha,
        edad:this.edad,
        dato1:"00:00:00",
        dato2:"00:00:00",
        dato3:"00:00:00",
        dato4:"00:00:00",
        dato5:"00:00:00",
        evento_id:this.evento.id,
        player_id:this.player.id,
      }).then(res=>{
        this.consulta()
        this.dialogregistro=false
      })
    },
    updateRegistro1(dato){
      this.$api.put('registro/'+this.registro.id,{
        // fecha:this.fecha,
        // edad:this.edad,
        dato1:dato,
        dato2:this.registro.dato2,
        dato3:this.registro.dato3,
        dato4:this.registro.dato4,
        dato5:this.registro.dato5,
        // evento_id:this.evento.id,
        // player_id:this.player.id,
      }).then(res=>{
        // console.log(res.data)
        // this.consulta()
        this.consultasinloading()
      })
    },
    updateRegistro2(dato){
      this.$api.put('registro/'+this.registro.id,{
        // fecha:this.fecha,
        // edad:this.edad,
        dato1:this.registro.dato1,
        dato2:dato,
        dato3:this.registro.dato3,
        dato4:this.registro.dato4,
        dato5:this.registro.dato5,
        // evento_id:this.evento.id,
        // player_id:this.player.id,
      }).then(res=>{
        // console.log(res.data)
        // this.consulta()
        this.consultasinloading()
      })
    },
    updateRegistro3(dato){
      this.$api.put('registro/'+this.registro.id,{
        // fecha:this.fecha,
        // edad:this.edad,
        dato1:this.registro.dato1,
        dato2:this.registro.dato2,
        dato3:dato,
        dato4:this.registro.dato4,
        dato5:this.registro.dato5,
        // evento_id:this.evento.id,
        // player_id:this.player.id,
      }).then(res=>{
        // console.log(res.data)
        // this.consulta()
        this.consultasinloading()
      })
    },
    updateRegistro4(dato){
      this.$api.put('registro/'+this.registro.id,{
        // fecha:this.fecha,
        // edad:this.edad,
        dato1:this.registro.dato1,
        dato2:this.registro.dato2,
        dato3:this.registro.dato3,
        dato4:dato,
        dato5:this.registro.dato5,
        // evento_id:this.evento.id,
        // player_id:this.player.id,
      }).then(res=>{
        // console.log(res.data)
        // this.consulta()
        this.consultasinloading()
      })
    },
    updateRegistro5(dato){
      this.$api.put('registro/'+this.registro.id,{
        // fecha:this.fecha,
        // edad:this.edad,
        dato1:this.registro.dato1,
        dato2:this.registro.dato2,
        dato3:this.registro.dato3,
        dato4:this.registro.dato4,
        dato5:dato,
        // evento_id:this.evento.id,
        // player_id:this.player.id,
      }).then(res=>{
        // console.log(res.data)
        // this.consulta()
        this.consultasinloading()
      })
    },
    consultasinloading(){
      this.$api.post('consulta',{fecha:this.fecha,evento_id:this.evento.id,edad:this.edad}).then(res=>{
        this.miconsulta(res)
      })
    },
    consulta(){
      this.$q.loading.show()
      this.$api.post('consulta',{fecha:this.fecha,evento_id:this.evento.id,edad:this.edad}).then(res=>{
        this.miconsulta(res)
        this.$q.loading.hide()
      })
    },
    miconsulta(res){
      this.registros=[]
      let c=1
      res.data.forEach(r=>{
        let tiempomin=moment('23:59:59', "HH:mm:ss")
        if (moment(r.dato1, "HH:mm:ss")<=tiempomin && r.dato1!="00:00:00"){
          tiempomin=moment(r.dato1, "HH:mm:ss")
        }
        if (moment(r.dato2, "HH:mm:ss")<=tiempomin && r.dato2!="00:00:00"){
          tiempomin=moment(r.dato2, "HH:mm:ss")
        }
        if (moment(r.dato3, "HH:mm:ss")<=tiempomin && r.dato3!="00:00:00"){
          tiempomin=moment(r.dato3, "HH:mm:ss")
        }
        if (moment(r.dato4, "HH:mm:ss")<=tiempomin && r.dato4!="00:00:00"){
          tiempomin=moment(r.dato4, "HH:mm:ss")
        }
        if (moment(r.dato5, "HH:mm:ss")<=tiempomin && r.dato5!="00:00:00"){
          tiempomin=moment(r.dato5, "HH:mm:ss")
        }
        r.tiempomin=tiempomin.format('HH:mm:ss')
        // r.segundos=moment.utc(secs*1000).format('HH:mm:ss');
        let s = moment(r.tiempomin, 'HH:mm:ss').diff(moment().startOf('day'), 'seconds');
        // console.log(s)
        r.num=c
        r.segundos=s
        r.nombre=r.player.paterno+' '+r.player.materno+' '+r.player.nombres
        r.categoria=r.evento.nombre
        c++
        this.registros.push(r)
      })
      for (let k = 1; k < res.data.length; k++) {
        for (let i = 0; i < (res.data.length - k); i++) {
          if (this.registros[i].segundos > this.registros[i + 1].segundos) {
            // this.registros[i+1].posicion=i+1
            let aux = this.registros[i];
            this.registros[i] = this.registros[i + 1];
            this.registros[i + 1] = aux;
          }
        }
      }
      // let tiempo=moment('23:59:59', "HH:mm:ss")
      // let posicion=1
      // this.registros.forEach(re=>{
      //   if (moment(re.tiempomin, "HH:mm:ss")<tiempo){
      //     // let auxi=
      //     re.posicion=posicion
      //     tiempo=moment(re.tiempomin, "HH:mm:ss")
      //   }else{
      //     re.posicion=posicion
      //   }
      //   posicion++
      // })
    }

  },
  computed:{
  }
}
</script>

<style scoped>

</style>
