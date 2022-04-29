<template>
<q-page class="q-pa-xs">
  <div class="row">
    <div class="col-12">
      <q-form >
        <div class="row">
          <div class="col-6">
            <q-select @update:model-value="consulta" dense  outlined label="evento" :options="eventos" v-model="evento" />
<!--            <pre>{{evento}}</pre>-->
          </div>
<!--          <div class="col-6">-->
<!--            <q-select dense outlined label="edad" :options="edades" v-model="edad"/>-->
<!--          </div>-->
          <div class="col-6">
            <q-input type="date" dense outlined label="fecha"  v-model="fecha"/>
          </div>
<!--          <div class="col-6">-->
<!--            <q-btn type="submit" icon="search" color="info" label="consultar" class="full-width"/>-->
<!--          </div>-->
          <div class="col-12">
            <q-btn type="button" @click="imprimir" icon="print" color="positive" label="imprimir" class="full-width"/>
          </div>
        </div>
      </q-form>
    </div>
    <div class="col-12">
      <q-table :title="'Evento '+evento.label"  :columns="columsregistro" :rows="histories" :filter="filter" dense>
        <template v-slot:body-cell-opcion="props">
          <q-td auto-width :props="props">
            <q-btn flat  round icon="add_circle" @click="dialogtiempos=true;registro=props.row" color="positive" />
          </q-td>
        </template>
        <template v-slot:body-cell-nombre="props">
          <q-td auto-width :props="props">
            <div class="text-body2">{{props.row.num}} {{props.row.user.paterno}} <br> {{props.row.user.materno}}<br>{{props.row.user.nombres}}</div>
          </q-td>
        </template>
        <template v-slot:body-cell-tiempo="props">
          <q-td auto-width :props="props">
            <div class="text-subtitle2" v-if="props.row.evento.tipo=='PISTA'">
              {{props.row.minutos}}m {{props.row.segundos}}s {{props.row.milisegundos}}ms
            </div>
            <div class="text-subtitle2" v-if="props.row.evento.tipo=='CAMPO'">
              {{props.row.metros1}}m {{props.row.centimetros1}}cn <br>
              {{props.row.metros2}}m {{props.row.centimetros2}}cn <br>
              {{props.row.metros3}}m {{props.row.centimetros3}}cn <br>
              {{props.row.metros4}}m {{props.row.centimetros4}}cn <br>
              {{props.row.metros5}}m {{props.row.centimetros5}}cn <br>
            </div>
          </q-td>
        </template>
<!--        <template v-slot:body-cell-posicion="props">-->
<!--          <q-td auto-width :props="props">-->
<!--            <q-badge :label="props.pageIndex+1" color="positive"/>-->
<!--          </q-td>-->
<!--        </template>-->
        <template v-slot:top-right>
          <q-btn label="Registrar" icon="add_circle" color="primary" @click="dialogregistro=true" />
          <q-input dense outlined v-model="filter" placeholder="Buscar"/>
        </template>
      </q-table>
    </div>
  </div>
<!--  <q-dialog full-width v-model="dialogtiempos">-->
<!--    <q-card>-->
<!--      <q-card-section class="text-h6">Puntos {{registro.nombre}}</q-card-section>-->
<!--      <q-separator/>-->
<!--      <q-card-section>-->
<!--        <q-form>-->
<!--          <div class="row">-->
<!--            <div class="col-12">-->
<!--              <q-input dense step="1" type="time" outlined @update:model-value="updateRegistro1" label="dato1" v-model="registro.dato1" />-->
<!--              <q-input dense step="1" type="time" outlined @update:model-value="updateRegistro2" label="dato2" v-model="registro.dato2" />-->
<!--              <q-input dense step="1" type="time" outlined @update:model-value="updateRegistro3" label="dato3" v-model="registro.dato3" />-->
<!--              <q-input dense step="1" type="time" outlined @update:model-value="updateRegistro4" label="dato4" v-model="registro.dato4" />-->
<!--              <q-input dense step="1" type="time" outlined @update:model-value="updateRegistro5" label="dato5" v-model="registro.dato5" />-->
<!--            </div>-->
<!--          </div>-->
<!--        </q-form>-->
<!--      </q-card-section>-->
<!--    </q-card>-->
<!--  </q-dialog>-->
  <q-dialog full-width v-model="dialogregistro">
    <q-card>
      <q-card-section class="text-subtitle2">
        <div class="row">
          <div class="col-12 text-center">Registro de datos</div>
<!--          <div class="col-6 text-center">Fecha={{fecha}}</div>-->
        </div>

<!--        Edad={{edad}}-->

      </q-card-section>
      <q-separator/>
      <q-card-section>
<!--        <q-form @submit="createRegistro">-->
          <div class="row">
            <div class="col-12">
              <q-select @update:model-value="tiporegistro" outlined use-input dense label="Jugador" :options="registros" v-model="registro" @filter="filterFn" >
                <template v-slot:no-option>
                  <q-item>
                    <q-item-section class="text-grey">
                      No resultados
                    </q-item-section>
                  </q-item>
                </template>
              </q-select>
            </div>
            <div class="col-12" v-if="tipo=='PISTA'">
              <q-form @submit.prevent="createhistory">
              <div class="row">
<!--                <div class="col-3">-->
<!--                  <q-input type="number" dense outlined v-model="horas" label="horas"/>-->
<!--                </div>-->
                <div class="col-4">
                  <q-input type="number" dense outlined v-model="minutos" label="minutos"/>
                </div>
                <div class="col-4">
                  <q-input type="number" dense outlined v-model="segundos" label="segundos"/>
                </div>
                <div class="col-4">
                  <q-input type="number" dense outlined v-model="milisegundos" label="milisegundos"/>
                </div>
                <div class="col-12">
                  <q-btn color="positive" icon="add_circle" label="Registrar" type="submit" class="full-width" />
                </div>
              </div>
              </q-form>
            </div>
            <div class="col-12" v-if="tipo=='CAMPO'">
              <q-form @submit.prevent="createhistory">
                <div class="row">
                  <div class="col-6">
                    <q-input type="number" dense outlined v-model="metros1" label="metros1"/>
                  </div>
                  <div class="col-6">
                    <q-input type="number" dense outlined v-model="centimetros1" label="centimetros1"/>
                  </div>
                  <div class="col-6">
                    <q-input type="number" dense outlined v-model="metros2" label="metros2"/>
                  </div>
                  <div class="col-6">
                    <q-input type="number" dense outlined v-model="centimetros2" label="centimetros2"/>
                  </div>
                  <div class="col-6">
                    <q-input type="number" dense outlined v-model="metros3" label="metros3"/>
                  </div>
                  <div class="col-6">
                    <q-input type="number" dense outlined v-model="centimetros3" label="centimetros3"/>
                  </div>
                  <div class="col-6">
                    <q-input type="number" dense outlined v-model="metros4" label="metros4"/>
                  </div>
                  <div class="col-6">
                    <q-input type="number" dense outlined v-model="centimetros4" label="centimetros4"/>
                  </div>
                  <div class="col-6">
                    <q-input type="number" dense outlined v-model="metros5" label="metros5"/>
                  </div>
                  <div class="col-6">
                    <q-input type="number" dense outlined v-model="centimetros5" label="centimetros5"/>
                  </div>
                  <div class="col-12">
                    <q-btn color="positive" icon="add_circle" label="Registrar" type="submit" class="full-width" />
                  </div>
                </div>
              </q-form>
            </div>
          </div>
<!--        </q-form>-->
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
      tipo:'',
      dialogregistro:false,
      dialogtiempos:false,
      filter:'',
      horas:'',
      minutos:'',
      segundos:'',
      milisegundos:'',
      metros1:'',
      centimetros1:'',
      metros2:'',
      centimetros2:'',
      metros3:'',
      centimetros3:'',
      metros4:'',
      centimetros4:'',
      metros5:'',
      centimetros5:'',
      columsregistro:[
        // {name:'opcion',field:'opcion',label:'opcion'},
        // {name:'num',field:'num',label:'num'},
        {name:'nombre',field:'nombre',label:'nombre',align:'left'},
        {name:'categoria',field:'categoria',label:'categoria'},
        {name:'tiempo',field:'tiempo',label:'tiempos',align:'left'},
        // {name:'posicion',field:'posicion',label:'posicion'},
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
      registros2:[],
      registro:{},
      history:{},
      histories:[],
    }
  },
  created() {
    // this.$q.loading.show()
    // this.$api.get('player').then(res=>{
    //   this.players=[]
    //   res.data.forEach(r=>{
    //     let nacimiento=moment(r.fechanac);
    //     let hoy=moment();
    //     let anios=hoy.diff(nacimiento,"years");
    //     r.label=anios+' '+r.paterno+' '+r.materno+' '+r.nombres
    //     this.players.push(r)
    //   })
    //   this.players2=this.players
    //   this.player=this.players[0]
    // })
    this.$q.loading.show()
    this.$api.get('evento').then(res=>{
      this.eventos=[]
      res.data.forEach(r=>{
        r.label=r.nombre
        this.eventos.push(r)
      })
      this.evento=this.eventos[0]
      this.consulta(this.evento)
      this.consultacombo()
    })

    // this.consulta()
  },
  methods:{
    consultacombo(){
      this.$api.get('registro').then(res=>{
        // this.$q.loading.hide()
        this.registros=[{'label':''}]
        res.data.forEach(r=>{
          if (r.evento_id==this.evento.id){
            let nacimiento=moment(r.user.fechanac)
            let hoy=moment()
            let anios=hoy.diff(nacimiento,"years")
            r.label=anios+' '+r.user.paterno+' '+r.user.materno+' '+r.user.nombres+' '+r.evento.nombre
            this.registros.push(r)
          }
        })
        this.registros2=this.registros
        this.registro=this.registros[0]
      })
    },
    imprimir(){
      // this.$q.loading.show()
      // this.$axios.post(process.env.URL + '/reportemes',{inicio:this.fecha,fin:this.fecha2}).then(res=>{
      //   this.miscomprobantestotales=res.data


        // let y=0
        // let sumtotal=0
        // let con=0

        // this.histories.sort(function (a, b) {
        //   if (a.categoria > b.categoria) {
        //     return 1;
        //   }
        //   if (a.categoria < b.categoria) {
        //     return -1;
        //   }
        //   // a must be equal to b
        //   return 0;
        // })
        // console.log(this.histories)
      let d10_14=[]
      let d15_19=[]
      let d20_24=[]
      let d25_29=[]
      let d30_34=[]
      let d35_39=[]
      let d40_44=[]
      let d45_49=[]
      let d50_54=[]
      let d55_59=[]
      let d60_64=[]
      let d65_69=[]
      let d70_74=[]
      let d75_79=[]
      let d80_84=[]
      let d85_89=[]
      let d90_94=[]
      let d95_99=[]
        this.histories.forEach((r,i)=>{
        //   console.log(r)
        //   // if (this.r="15-19"){
        //   //   doc.addPage();
        //   //   heade""ha)
        //   //   y+=0.4
        //   //   con++
        //   //   // doc.text(1, y+3, r.num.toString())
        //   //   // doc.text(1.5, y+3, r.nombre)
        //   //   // doc.text(8.0, y+3, this.evento.label)
        //   //   // doc.setFontSize(7);
        //   //   // doc.text(10.5, y+3, r.dato1+' '+r.dato2+' '+r.dato3+' '+r.dato4+' '+r.dato5)
        //   //   // doc.setFontSize(9);
        //   //   // doc.text(18, y+3, r.tiempomin)
        //   //   // doc.text(20.5, y+3, con.toString(),'center')
        //   //   // doc.text(16, y+3, r.total)
        //   //   // sumtotal+=parseInt(r.total)
        //   //   // console.log(r.total)
        //   //   // doc.text(18, y+3, r.user.codigo )
        //   //   if (con==55){
        //   //     con=0
        //   //     doc.addPage();
        //   //     //h//eader(this.fecha)
        //   //     y=0
        //   //   }
        //   // }else
        //   console.log(i)
          if (r.categoria=="10-14"){
            //doc.addPage();
            d10_14.push(r)
            // r.categoria="10-14"
          } else if (r.categoria=="15-19"){
            //doc.addPage();
            d15_19.push(r)
            // r.categoria="20-24"
          }else if (r.categoria=="20-24"){
            //doc.addPage();
            d20_24.push(r)
            // r.categoria="20-24"
          }else if (r.categoria=="25-29"){
            //doc.addPage();
            d25_29.push(r)
            // r.categoria="25-29"
          }else if (r.categoria=="30-34"){
            //doc.addPage();
            d30_34.push(r)
            // r.categoria="30-34"
          }else if (r.categoria=="35-39"){
            //doc.addPage();
            d35_39.push(r)
            // r.categoria="35-39"
          }else if (r.categoria=="40-44"){
            //doc.addPage();
            d40_44.push(r)
            // r.categoria="40-44"
          }else if (r.categoria=="45-49"){
            //doc.addPage();
            d45_49.push(r)
            // r.categoria="45-49"
          }else if (r.categoria=="50-54"){
            //doc.addPage();
            d50_54.push(r)
            // r.categoria="50-54"
          }else if (r.categoria=="55-59"){
            //doc.addPage();
            d55_59.push(r)
            // r.categoria="55-59"
          }else if (r.categoria=="60-64"){
            //doc.addPage();
            d60_64.push(r)
            // r.categoria="60-64"
          }else if (r.categoria=="65-69"){
            //doc.addPage();
            d65_69.push(r)
            // r.categoria="25-29"
          }else if (r.categoria=="70-74"){
            //doc.addPage();
            d70_74.push(r)
            // r.categoria="70-74"
          }else if (r.categoria=="75-79"){
            //doc.addPage();
            d75_79.push(r)
            // r.categoria="75-79"
          }else if (r.categoria=="80-84"){
            //doc.addPage();
            d80_84.push(r)
            // r.categoria="80-84"
          }else if (r.categoria=="85-89"){
            //doc.addPage();
            d85_89.push(r)
            // r.categoria="85-89"
          }else if (r.categoria=="90-94"){
            //doc.addPage();
            d90_94.push(r)
            // r.categoria="90-94"
          }else if (r.categoria=="95-99"){
            //doc.addPage();
            d95_99.push(r)
            // r.categoria="95-99"
          }
        })
      let cm=this;
      function print(datos){
        if (datos.length==0){
          return false
        }
        var doc = new jsPDF('p','cm','letter')
        doc.setFont("courier");
        doc.setFontSize(9);
        var img = new Image()
        img.src = 'logo.png'
        doc.addImage(img, 'png', 0.5, 0.5, 2, 2)
        doc.setFont(undefined,'bold')
        doc.text(5, 1, 'REGISTRO DE PLANILLA '+cm.evento.label+' '+cm.evento.tipo)
        doc.text(5, 1.5, 'DE FECHA '+cm.fecha+'   EVENTO '+cm.evento.label)
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

        let y=0.4
        let con=0
        datos.forEach(d=>{
          con++
          doc.text(1, y+3, con.toString())
          doc.text(1.5, y+3, d.user.paterno+' '+d.user.materno+' '+d.user.nombres)
          doc.text(8.0, y+3, d.categoria)
          // console.log()
          if (d.mstotales!="0"){
            doc.text(10.5, y+3, d.minutos+'m '+d.segundos+'s '+d.milisegundos+'ms')
            doc.text(18, y+3, d.mstotales.toString())
          }else{
            doc.text(10.5, y+3, d.metros1+'m '+d.centimetros1+'cn ')
            doc.text(18, y+3, d.cntotales.toString())
          }
          doc.text(19.5, y+3, con.toString())
          y+=0.4
        })
        doc.setFont(undefined,'bold')
        doc.text(3, y+3.5, 'SON: '+con+' PARTICIPANTES')
        // doc.text(12, y+3.5, 'TOTAL RECAUDADCION: ')
        doc.text(1.8, y+5, '_____________________          _____________________________       _________________________')
        doc.text(2, y+5.3, 'FIRMA SELLO DIRECTOR')
        doc.text(8, y+5.3, 'FIRMA SELLO INTRESADO1')
        doc.text(15, y+5.3, 'FIRMA SELLO INTRESADO2')
        window.open(doc.output('bloburl'), '_blank');
      }
      if (this.evento.tipo=='PISTA'){
        d10_14.sort(function(a, b) {
          return parseFloat(a.mstotales) - parseFloat(b.mstotales);
        });
        print(d10_14)
        d15_19.sort(function(a, b) {
          return parseFloat(a.mstotales) - parseFloat(b.mstotales);
        });
        print(d15_19)
        d20_24.sort(function(a, b) {
          return parseFloat(a.mstotales) - parseFloat(b.mstotales);
        });
        print(d20_24)
        d25_29.sort(function(a, b) {
          return parseFloat(a.mstotales) - parseFloat(b.mstotales);
        });
        print(d25_29)
        d30_34.sort(function(a, b) {
          return parseFloat(a.mstotales) - parseFloat(b.mstotales);
        });
        print(d30_34)
        d35_39.sort(function(a, b) {
          return parseFloat(a.mstotales) - parseFloat(b.mstotales);
        });
        print(d35_39)
        d40_44.sort(function(a, b) {
          return parseFloat(a.mstotales) - parseFloat(b.mstotales);
        });
        print(d40_44)
        d45_49.sort(function(a, b) {
          return parseFloat(a.mstotales) - parseFloat(b.mstotales);
        });
        print(d45_49)
        d50_54.sort(function(a, b) {
          return parseFloat(a.mstotales) - parseFloat(b.mstotales);
        });
        print(d50_54)
        d55_59.sort(function(a, b) {
          return parseFloat(a.mstotales) - parseFloat(b.mstotales);
        });
        print(d55_59)
        d60_64.sort(function(a, b) {
          return parseFloat(a.mstotales) - parseFloat(b.mstotales);
        });
        print(d60_64)
        d65_69.sort(function(a, b) {
          return parseFloat(a.mstotales) - parseFloat(b.mstotales);
        });
        print(d65_69)
        d70_74.sort(function(a, b) {
          return parseFloat(a.mstotales) - parseFloat(b.mstotales);
        });
        print(d70_74)
        d75_79.sort(function(a, b) {
          return parseFloat(a.mstotales) - parseFloat(b.mstotales);
        });
        print(d75_79)
        d80_84.sort(function(a, b) {
          return parseFloat(a.mstotales) - parseFloat(b.mstotales);
        });
        print(d80_84)
        d85_89.sort(function(a, b) {
          return parseFloat(a.mstotales) - parseFloat(b.mstotales);
        });
        print(d85_89)
        d90_94.sort(function(a, b) {
          return parseFloat(a.mstotales) - parseFloat(b.mstotales);
        });
        print(d90_94)
        d95_99.sort(function(a, b) {
          return parseFloat(a.mstotales) - parseFloat(b.mstotales);
        });
        print(d95_99)
      }else{
        {
          d10_14.sort(function(a, b) {
            return parseFloat(a.cntotales) - parseFloat(b.cntotales);
          });
          print(d10_14)
          d15_19.sort(function(a, b) {
            return parseFloat(a.cntotales) - parseFloat(b.cntotales);
          });
          print(d15_19)
          d20_24.sort(function(a, b) {
            return parseFloat(a.cntotales) - parseFloat(b.cntotales);
          });
          print(d20_24)
          d25_29.sort(function(a, b) {
            return parseFloat(a.cntotales) - parseFloat(b.cntotales);
          });
          print(d25_29)
          d30_34.sort(function(a, b) {
            return parseFloat(a.cntotales) - parseFloat(b.cntotales);
          });
          print(d30_34)
          d35_39.sort(function(a, b) {
            return parseFloat(a.cntotales) - parseFloat(b.cntotales);
          });
          print(d35_39)
          d40_44.sort(function(a, b) {
            return parseFloat(a.cntotales) - parseFloat(b.cntotales);
          });
          print(d40_44)
          d45_49.sort(function(a, b) {
            return parseFloat(a.cntotales) - parseFloat(b.cntotales);
          });
          print(d45_49)
          d50_54.sort(function(a, b) {
            return parseFloat(a.cntotales) - parseFloat(b.cntotales);
          });
          print(d50_54)
          d55_59.sort(function(a, b) {
            return parseFloat(a.cntotales) - parseFloat(b.cntotales);
          });
          print(d55_59)
          d60_64.sort(function(a, b) {
            return parseFloat(a.cntotales) - parseFloat(b.cntotales);
          });
          print(d60_64)
          d65_69.sort(function(a, b) {
            return parseFloat(a.cntotales) - parseFloat(b.cntotales);
          });
          print(d65_69)
          d70_74.sort(function(a, b) {
            return parseFloat(a.cntotales) - parseFloat(b.cntotales);
          });
          print(d70_74)
          d75_79.sort(function(a, b) {
            return parseFloat(a.cntotales) - parseFloat(b.cntotales);
          });
          print(d75_79)
          d80_84.sort(function(a, b) {
            return parseFloat(a.cntotales) - parseFloat(b.cntotales);
          });
          print(d80_84)
          d85_89.sort(function(a, b) {
            return parseFloat(a.cntotales) - parseFloat(b.cntotales);
          });
          print(d85_89)
          d90_94.sort(function(a, b) {
            return parseFloat(a.cntotales) - parseFloat(b.cntotales);
          });
          print(d90_94)
          d95_99.sort(function(a, b) {
            return parseFloat(a.cntotales) - parseFloat(b.cntotales);
          });
          print(d95_99)
        }
      }

      // console.log(d10_14)
      // d15_19
      // d20_24
      // d25_29
      // d30_34
      // d35_39
      // d40_44
      // d45_49
      // d50_54
      // d55_59
      // d60_64
      // d65_69
      // d70_74
      // d75_79
      // d80_84
      // d85_89
      // d90_94
      // d95_99


      // doc.setFont(undefined,'normal')
      // doc.text(18, y+3.5, sumtotal+ ' Bs')
      // const conversor = require('conversor-numero-a-letras-es-ar');
      // let ClaseConversor = conversor.conversorNumerosALetras;
      // let miConversor = new ClaseConversor();
      // var a = miConversor.convertToText(sumtotal);
      // doc.text(1, y+4, 'SON: '+ a.toUpperCase()+' BS')
      // doc.save("Pago"+date.formatDate(Date.now(),'DD-MM-YYYY')+".pdf");
        // console.log(res.data)
      //   this.$q.loading.hide()
      // })
    },
    filterFn (val, update) {
      if (val === '') {
        update(() => {
          this.registros = this.registros2
          // here you have access to "ref" which
          // is the Vue reference of the QSelect
        })
        return
      }

      update(() => {
        const needle = val.toLowerCase()
        this.registros = this.registros2.filter(v => v.label.toLowerCase().indexOf(needle) > -1)
      })
    },
    tiporegistro(registro){
      // console.log(registro)
      this.horas=''
      this.minutos=''
      this.segundos=''
      this.milisegundos=''
      this.metros1=''
      this.centimetros1=''
      this.metros2=''
      this.centimetros2=''
      this.metros3=''
      this.centimetros3=''
      this.metros4=''
      this.centimetros4=''
      this.metros5=''
      this.centimetros5=''
      this.tipo=registro.evento.tipo
      this.registro=registro
    },
    createhistory(){
      this.$q.dialog({
        title:"Seguro de registrar?",
        message:"registro de datos",
        persistent:true,
        cancel:true
      }).onOk(()=>{
        this.$q.loading.show()
        let cn1=parseInt(this.metros1*100)+parseInt(this.centimetros1)
        let cn2=parseInt(this.metros2*100)+parseInt(this.centimetros2)
        let cn3=parseInt(this.metros3*100)+parseInt(this.centimetros3)
        let cn4=parseInt(this.metros4*100)+parseInt(this.centimetros4)
        let cn5=parseInt(this.metros5*100)+parseInt(this.centimetros5)
        // console.log(cn1,cn2,cn3,cn4,cn5)
        // console.log(Math.max(cn1,cn2,cn3,cn4,cn5))
          this.$api.post('history',{
            'fecha':date.formatDate(new Date(),'YYYY-MM-DD'),
            'hora':date.formatDate(new Date(),'HH:mm:ss'),
            'categoria':this.registro.categoria,
            // 'horas':this.horas==''?0:this.horas,
            'minutos':this.minutos==''?0:this.minutos,
            'segundos':this.segundos==''?0:this.segundos,
            'milisegundos':this.milisegundos==''?0:this.milisegundos,
            'metros1':this.metros1==''?0:this.metros1,
            'centimetros1':this.centimetros1==''?0:this.centimetros1,
            'metros2':this.metros2==''?0:this.metros2,
            'centimetros2':this.centimetros2==''?0:this.centimetros2,
            'metros3':this.metros3==''?0:this.metros3,
            'centimetros3':this.centimetros3==''?0:this.centimetros3,
            'metros4':this.metros4==''?0:this.metros4,
            'centimetros4':this.centimetros4==''?0:this.centimetros4,
            'metros5':this.metros5==''?0:this.metros5,
            'centimetros5':this.centimetros5==''?0:this.centimetros5,
            'mstotales':this.segundos*1000+this.minutos*1000*60+this.milisegundos,
            'cntotales':Math.max(cn1,cn2,cn3,cn4,cn5),
            'user_id':this.registro.user_id,
            'evento_id':this.registro.evento_id,
            'registro_id':this.registro.id,
          }).then(res=>{
            // console.log(res.data)
            this.dialogregistro=false
            this.consulta(this.evento)
            // this.consultacombo()
          })
      })
    },
    // createRegistro(){
    //   this.$q.loading.show()
    //   this.$api.post('registro',{
    //     fecha:this.fecha,
    //     edad:this.edad,
    //     dato1:"00:00:00",
    //     dato2:"00:00:00",
    //     dato3:"00:00:00",
    //     dato4:"00:00:00",
    //     dato5:"00:00:00",
    //     evento_id:this.evento.id,
    //     player_id:this.player.id,
    //   }).then(res=>{
    //     this.consulta()
    //     this.dialogregistro=false
    //   })
    // },
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
        // this.miconsulta(res)
      })
    },
    consulta(evento){
      console.log(evento)
      // console.log({fecha:this.fecha,evento_id:this.evento.id})
      this.$q.loading.show()
      this.consultacombo()
      this.$api.post('consulta',{fecha:this.fecha,evento_id:evento.id}).then(res=>{
        // this.miconsulta(res)
        // console.log(res.data)
        this.histories=res.data
        this.$q.loading.hide()
      })
    },
    // miconsulta(res){
    //   this.registros=[]
    //   let c=1
    //   res.data.forEach(r=>{
    //     let tiempomin=moment('23:59:59', "HH:mm:ss")
    //     if (moment(r.dato1, "HH:mm:ss")<=tiempomin && r.dato1!="00:00:00"){
    //       tiempomin=moment(r.dato1, "HH:mm:ss")
    //     }
    //     if (moment(r.dato2, "HH:mm:ss")<=tiempomin && r.dato2!="00:00:00"){
    //       tiempomin=moment(r.dato2, "HH:mm:ss")
    //     }
    //     if (moment(r.dato3, "HH:mm:ss")<=tiempomin && r.dato3!="00:00:00"){
    //       tiempomin=moment(r.dato3, "HH:mm:ss")
    //     }
    //     if (moment(r.dato4, "HH:mm:ss")<=tiempomin && r.dato4!="00:00:00"){
    //       tiempomin=moment(r.dato4, "HH:mm:ss")
    //     }
    //     if (moment(r.dato5, "HH:mm:ss")<=tiempomin && r.dato5!="00:00:00"){
    //       tiempomin=moment(r.dato5, "HH:mm:ss")
    //     }
    //     r.tiempomin=tiempomin.format('HH:mm:ss')
    //     // r.segundos=moment.utc(secs*1000).format('HH:mm:ss');
    //     let s = moment(r.tiempomin, 'HH:mm:ss').diff(moment().startOf('day'), 'seconds');
    //     // console.log(s)
    //     r.num=c
    //     r.segundos=s
    //     r.nombre=r.player.paterno+' '+r.player.materno+' '+r.player.nombres
    //     r.categoria=r.evento.nombre
    //     c++
    //     this.registros.push(r)
    //   })
    //   for (let k = 1; k < res.data.length; k++) {
    //     for (let i = 0; i < (res.data.length - k); i++) {
    //       if (this.registros[i].segundos > this.registros[i + 1].segundos) {
    //         // this.registros[i+1].posicion=i+1
    //         let aux = this.registros[i];
    //         this.registros[i] = this.registros[i + 1];
    //         this.registros[i + 1] = aux;
    //       }
    //     }
    //   }
    //   // let tiempo=moment('23:59:59', "HH:mm:ss")
    //   // let posicion=1
    //   // this.registros.forEach(re=>{
    //   //   if (moment(re.tiempomin, "HH:mm:ss")<tiempo){
    //   //     // let auxi=
    //   //     re.posicion=posicion
    //   //     tiempo=moment(re.tiempomin, "HH:mm:ss")
    //   //   }else{
    //   //     re.posicion=posicion
    //   //   }
    //   //   posicion++
    //   // })
    // }

  },
  computed:{
  }
}
</script>

<style scoped>

</style>
